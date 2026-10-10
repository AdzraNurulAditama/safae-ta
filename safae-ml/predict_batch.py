import argparse
import os
import sys
from datetime import datetime
 
import joblib
import numpy as np
import pandas as pd
from sqlalchemy import create_engine, text
from sqlalchemy.engine import URL
 
NONFIKSI = {"Pemrograman", "Hobi"}   # genre lain dianggap fiksi (harus sama dengan pengisian kolom jenis_buku)
 
 
# ---------------------------------------------------------------- koneksi DB
def parse_env(path):
    env = {}
    with open(path, encoding="utf-8") as f:
        for line in f:
            line = line.strip()
            if not line or line.startswith("#") or "=" not in line:
                continue
            k, v = line.split("=", 1)
            env[k.strip()] = v.strip().strip('"').strip("'")
    return env
 
 
def make_engine(args):
    if args.db_url:
        return create_engine(args.db_url)
    if not args.env:
        sys.exit("Isi --env (path ke .env Laravel) atau --db-url.")
    e = parse_env(args.env)
    url = URL.create(
        "mysql+pymysql",
        username=e.get("DB_USERNAME", "root"),
        password=e.get("DB_PASSWORD", ""),
        host=e.get("DB_HOST", "127.0.0.1"),
        port=int(e.get("DB_PORT", 3306)),
        database=e.get("DB_DATABASE"),
    )
    return create_engine(url)
 
 
# ---------------------------------------------------------------- data
def load_data(engine, durasi_bagi):
    q = lambda sql: pd.read_sql(text(sql), engine)
    users = q("SELECT id AS user_id, jurusan, semester FROM users")
    books = q("""SELECT id AS book_id, genre AS kategori_topik, jenis_buku, tipe_konten,
                        jumlah_halaman, is_premium AS status_premium, reader_count
                 FROM books WHERE status = 'published'""")
    hist = q("SELECT user_id, book_id FROM reading_histories")
    dur = q("SELECT user_id, book_id, SUM(duration) AS durasi FROM reading_progress GROUP BY user_id, book_id")
    fav = q("SELECT DISTINCT user_id, book_id, 1 AS fav FROM favorite_books")
    dur["durasi"] = dur["durasi"] / durasi_bagi
    return users, books, hist, dur, fav
 
 
def clean_inputs(users, books):
    """Isi nilai kosong dengan default yang wajar, dan laporkan jumlahnya."""
    n = {}
    n["jurusan kosong"] = int(users.jurusan.isna().sum())
    users["jurusan"] = users.jurusan.fillna("Lainnya")
    n["semester kosong"] = int(users.semester.isna().sum())
    users["semester"] = users.semester.fillna(users.semester.median() if users.semester.notna().any() else 1)
 
    n["jenis_buku kosong"] = int(books.jenis_buku.isna().sum())
    books["jenis_buku"] = books.jenis_buku.fillna(
        books.kategori_topik.map(lambda g: "nonfiksi" if g in NONFIKSI else "fiksi"))
    n["tipe_konten kosong"] = int(books.tipe_konten.isna().sum())
    books["tipe_konten"] = books.tipe_konten.fillna(books.jenis_buku.map({"fiksi": "novel", "nonfiksi": "buku"}))
    n["jumlah_halaman kosong"] = int(books.jumlah_halaman.isna().sum())
    med = books.jumlah_halaman.median() if books.jumlah_halaman.notna().any() else 200
    books["jumlah_halaman"] = books.jumlah_halaman.fillna(med)
    kosong = {k: v for k, v in n.items() if v}
    if kosong:
        print("PERINGATAN - nilai kosong diisi default:", kosong)
        print("  Lengkapi kolom itu di database agar rekomendasi lebih akurat.")
    return users, books
 
 
# ---------------------------------------------------------------- fitur
def build_candidates(users, books, hist, dur, fav):
    """Satu baris per (pengguna, buku BELUM dibaca), dengan fitur yang sama seperti saat training."""
    # buku yang sudah dibaca = ada di reading_histories ATAU reading_progress
    read = pd.concat([hist[["user_id", "book_id"]], dur[["user_id", "book_id"]]]).drop_duplicates()
    read = read.merge(dur, on=["user_id", "book_id"], how="left").merge(fav, on=["user_id", "book_id"], how="left")
    read["durasi"] = read.durasi.fillna(0.0)
    read["fav"] = read.fav.fillna(0)
    read = read.merge(books[["book_id", "kategori_topik", "jenis_buku"]], on="book_id", how="inner")
 
    g = read.groupby("user_id")
    prof = pd.DataFrame({
        "jumlah_buku_lain": g.book_id.count(),
        "rata_durasi_lain": g.durasi.mean(),
        "rasio_favorit_lain": g.fav.mean(),
    })
    genre_cnt = read.groupby(["user_id", "kategori_topik"]).agg(n_g=("book_id", "count"), d_g=("durasi", "mean")).reset_index()
    jenis_cnt = read.groupby(["user_id", "jenis_buku"]).agg(n_j=("book_id", "count")).reset_index()
 
    # semua kombinasi pengguna-berpengalaman x buku, lalu buang yang sudah dibaca
    prof = prof.reset_index()
    cand = prof.merge(books, how="cross")
    cand = cand.merge(read[["user_id", "book_id"]].assign(sudah=1), on=["user_id", "book_id"], how="left")
    cand = cand[cand.sudah.isna()].drop(columns="sudah")
    cand = cand.merge(users, on="user_id", how="left")
    cand = cand.merge(genre_cnt, on=["user_id", "kategori_topik"], how="left")
    cand = cand.merge(jenis_cnt, on=["user_id", "jenis_buku"], how="left")
 
    cand["porsi_genre_dibaca"] = cand.n_g.fillna(0) / cand.jumlah_buku_lain
    cand["porsi_jenis_dibaca"] = cand.n_j.fillna(0) / cand.jumlah_buku_lain
    cand["rata_durasi_genre_lain"] = cand.d_g.fillna(cand.rata_durasi_lain)   # cadangan sama seperti training
    return cand
 
 
def score(model, X):
    if hasattr(model, "predict_proba"):
        return model.predict_proba(X)[:, 1]
    s = model.decision_function(X)           # SVM: jarak ke batas keputusan -> 0..1 lewat sigmoid
    return 1 / (1 + np.exp(-s))
 
 
# ---------------------------------------------------------------- main
def main():
    ap = argparse.ArgumentParser()
    ap.add_argument("--env", help="path file .env Laravel")
    ap.add_argument("--db-url", help="URL SQLAlchemy (alternatif dari --env)")
    ap.add_argument("--model", default="models/model.joblib")
    ap.add_argument("--top", type=int, default=20)
    ap.add_argument("--durasi-bagi", type=float, default=1.0,
                    help="bagi duration DB dengan angka ini (60 jika disimpan dalam detik)")
    ap.add_argument("--dry-run", action="store_true")
    args = ap.parse_args()
 
    bundle = joblib.load(args.model)
    model, cat_cols, num_cols = bundle["model"], bundle["cat_cols"], bundle["num_cols"]
    print(f"Model: {bundle['model_name']} (dilatih {bundle['dilatih_pada']})")
 
    engine = make_engine(args)
    users, books, hist, dur, fav = load_data(engine, args.durasi_bagi)
    users, books = clean_inputs(users, books)
    print(f"Pengguna: {len(users)} | Buku terbit: {len(books)}")
 
    cand = build_candidates(users, books, hist, dur, fav)
    if cand.empty:
        print("Tidak ada kandidat (belum ada pengguna dengan riwayat baca). Tidak ada yang ditulis.")
        return
    print(f"Pengguna dengan riwayat: {cand.user_id.nunique()} | Pasangan dinilai: {len(cand)}")
 
    cand["skor"] = score(model, cand[cat_cols + num_cols])
    top = (cand.sort_values(["user_id", "skor"], ascending=[True, False])
               .groupby("user_id").head(args.top)[["user_id", "book_id", "skor"]].copy())
    top["skor"] = top.skor.round(4)
    now = datetime.now().strftime("%Y-%m-%d %H:%M:%S")
    top["created_at"] = now
    top["updated_at"] = now
 
    if args.dry_run:
        print("\n[dry-run] contoh hasil:")
        print(top.head(10).to_string(index=False))
        return
 
    # ganti isi tabel dalam satu transaksi: kalau gagal, data lama tetap aman
    with engine.begin() as conn:
        conn.execute(text("DELETE FROM book_recommendations"))
        top.to_sql("book_recommendations", conn, if_exists="append", index=False, chunksize=1000)
    print(f"Selesai: {len(top)} rekomendasi untuk {top.user_id.nunique()} pengguna ditulis ke book_recommendations.")
 
 
if __name__ == "__main__":
    main()