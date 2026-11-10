import argparse
import os
import sys
from datetime import datetime

import joblib
import numpy as np
import pandas as pd
from sqlalchemy import create_engine, text
from sqlalchemy.engine import URL

# tipe_konten yang termasuk nonfiksi.
# Harus sama dengan aturan di form upload Laravel dan di skrip training.
NONFIKSI_TIPE = {"tugas akhir", "karya ilmiah", "jurnal", "skripsi"}

SELESAI = "Selesai Dibaca"   # nilai reading_histories.status untuk buku yang sudah selesai

# ---------------------------------------------------------------- kurikulum
# Topik (genre buku) yang relevan untuk tiap jurusan dan semester -> fitur `topik_sesuai_kurikulum`.
# !!! ISI DI BAWAH HANYA CONTOH. Ganti dengan kurikulum kampusmu. !!!
#   - Nama jurusan harus sama dengan isi kolom users.jurusan (huruf besar/kecil dan spasi pinggir tidak masalah).
#   - Nama topik harus sama dengan isi kolom books.genre.
#   - Tiap jurusan berisi daftar (semester_min, semester_maks, [topik, ...]).
# Ini satu-satunya tempat daftar kurikulum. buat_dataset_dummy.py mengambilnya dari sini.
# Setelah diubah: buat ulang dataset, latih ulang (train_model.py), lalu jalankan predict_batch.py.
KURIKULUM = {
    "Sistem Informasi": [(1, 2, ["Pemrograman", "Sistem Informasi"]),
                         (3, 4, ["Basis Data", "Jaringan", "Sistem Informasi"]),
                         (5, 6, ["Sistem Informasi", "Kecerdasan Buatan", "Basis Data"]),
                         (7, 8, ["Sistem Informasi", "Kecerdasan Buatan", "Pemrograman"])],
    "Informatika": [(1, 2, ["Pemrograman"]),
                    (3, 4, ["Basis Data", "Jaringan", "Pemrograman"]),
                    (5, 6, ["Kecerdasan Buatan", "Jaringan", "Basis Data"]),
                    (7, 8, ["Kecerdasan Buatan", "Pemrograman", "Jaringan"])],
    "Ekonomi": [(1, 4, ["Ekonomi"]), (5, 8, ["Ekonomi", "Sistem Informasi"])],
    "Hukum": [(1, 8, ["Hukum"])],
    "Kesehatan": [(1, 8, ["Kesehatan", "Psikologi"])],
    "Psikologi": [(1, 8, ["Psikologi", "Kesehatan", "Pendidikan"])],
    "Pendidikan": [(1, 8, ["Pendidikan", "Psikologi"])],
}

_NAMA = {k.strip().lower(): k for k in KURIKULUM}


def genre_kurikulum(jurusan, semester):
    """Daftar topik yang relevan untuk jurusan dan semester ini ([] kalau profil kosong / tidak dikenal)."""
    if jurusan is None or semester is None or pd.isna(jurusan) or pd.isna(semester):
        return []
    kunci = _NAMA.get(str(jurusan).strip().lower())
    if kunci is None:
        return []
    for lo, hi, topik in KURIKULUM[kunci]:
        if lo <= semester <= hi:
            return topik
    return []


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
    # hanya buku yang sudah disetujui admin
    books = q("""SELECT id AS book_id, genre AS kategori_topik, jenis_buku, tipe_konten,
                        jumlah_halaman, is_premium AS status_premium, reader_count
                 FROM books WHERE status = 'approved'""")
    hist = q("SELECT user_id, book_id, status FROM reading_histories")
    dur = q("SELECT user_id, book_id, SUM(duration) AS durasi FROM reading_progress GROUP BY user_id, book_id")
    fav = q("SELECT DISTINCT user_id, book_id, 1 AS fav FROM favorite_books")
    resume = q("SELECT user_id, COUNT(*) AS total_resume FROM book_resumes GROUP BY user_id")
    dur["durasi"] = dur["durasi"] / durasi_bagi
    return users, books, hist, dur, fav, resume


def clean_inputs(users, books):
    """Isi nilai kosong dengan default yang wajar, dan laporkan jumlahnya."""
    n = {}
    n["jurusan kosong"] = int(users.jurusan.isna().sum())
    # sama dengan dataset training: profil belum diisi -> "Tidak diketahui"
    users["jurusan"] = users.jurusan.fillna("Tidak diketahui")
    # semester dibiarkan kosong (NaN); di model, nilai kosong diisi 0 oleh imputer
    users["semester"] = pd.to_numeric(users.semester, errors="coerce")
    n["semester kosong"] = int(users.semester.isna().sum())

    # jenis_buku kosong -> turunkan dari tipe_konten (tugas akhir/skripsi/karya ilmiah/jurnal = nonfiksi)
    n["jenis_buku kosong"] = int(books.jenis_buku.isna().sum())
    tipe = books.tipe_konten.fillna("").str.strip().str.lower()
    kosong_jenis = books.jenis_buku.isna()
    books.loc[kosong_jenis, "jenis_buku"] = np.where(
        tipe[kosong_jenis].isin(NONFIKSI_TIPE), "nonfiksi", "fiksi")

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
def _campur(pribadi, cadangan, m, k):
    """Geser dari nilai cadangan ke nilai pribadi: bobot pribadi = m / (m + k).
    m = 0 (belum ada riwayat) -> sepenuhnya nilai cadangan."""
    return (m * pribadi + k * cadangan) / (m + k)


def _riwayat_baca(users, books, hist, dur, fav):
    """Satu baris per (pengguna, buku yang sudah dibaca) beserta durasi, favorit, dan status selesai."""
    # buku yang sudah dibaca = ada di reading_histories ATAU reading_progress
    read = pd.concat([hist[["user_id", "book_id"]], dur[["user_id", "book_id"]]]).drop_duplicates()
    read = read.merge(dur, on=["user_id", "book_id"], how="left").merge(fav, on=["user_id", "book_id"], how="left")
    sel = hist[hist.status == SELESAI][["user_id", "book_id"]].drop_duplicates().assign(selesai=1)
    read = read.merge(sel, on=["user_id", "book_id"], how="left")
    read["durasi"] = read.durasi.fillna(0.0).astype(float)
    read["fav"] = read.fav.fillna(0).astype(float)
    read["selesai"] = read.selesai.fillna(0).astype(float)
    read = read.merge(books[["book_id", "kategori_topik", "jenis_buku"]], on="book_id", how="inner")
    return read.merge(users[["user_id", "jurusan", "semester"]], on="user_id", how="inner")


def _kelompok_cadangan(read, user_id, jurusan, semester, min_users):
    """Data pengguna LAIN untuk nilai cadangan: jurusan+semester sama -> jurusan sama -> semua pengguna.
    Sebuah kelompok dipakai kalau berisi minimal `min_users` pengguna lain yang punya riwayat."""
    lain = read[read.user_id != user_id]
    if jurusan != "Tidak diketahui":
        if pd.notna(semester):
            sub = lain[(lain.jurusan == jurusan) & (lain.semester == semester)]
            if sub.user_id.nunique() >= min_users:
                return sub
        sub = lain[lain.jurusan == jurusan]
        if sub.user_id.nunique() >= min_users:
            return sub
    return lain


def build_candidates(users, books, hist, dur, fav, resume, k=5, min_users=10):
    """Satu baris per (pengguna, buku BELUM dibaca), dengan fitur yang sama seperti di dataset training.
    Pengguna tanpa riwayat juga dinilai: fiturnya diisi rata-rata kelompok/global (lihat _kelompok_cadangan)."""
    read = _riwayat_baca(users, books, hist, dur, fav)
    n_resume = resume.set_index("user_id").total_resume if len(resume) else pd.Series(dtype=float)
    hasil = []

    for u in users.itertuples(index=False):
        mine = read[read.user_id == u.user_id]
        n = len(mine)
        pop = _kelompok_cadangan(read, u.user_id, u.jurusan, u.semester, min_users)

        # --- nilai pribadi (0 kalau belum ada riwayat) dan nilai cadangan (rata-rata kelompok) ---
        dur_lain = _campur(mine.durasi.mean() if n else 0.0, pop.durasi.mean() if len(pop) else 0.0, n, k)
        fav_lain = _campur(mine.fav.mean() if n else 0.0, pop.fav.mean() if len(pop) else 0.0, n, k)
        selesai = _campur(mine.selesai.mean() if n else 0.0, pop.selesai.mean() if len(pop) else 0.0, n, k)

        cand = books[~books.book_id.isin(mine.book_id)].copy()
        if cand.empty:
            continue

        # per genre / per jenis: jumlah dan rata-rata durasi buku yang sudah dibaca pengguna ini
        g = mine.groupby("kategori_topik").durasi.agg(["count", "mean"])
        j = mine.groupby("jenis_buku").book_id.count()
        pg = pop.kategori_topik.value_counts(normalize=True) if len(pop) else pd.Series(dtype=float)
        pj = pop.jenis_buku.value_counts(normalize=True) if len(pop) else pd.Series(dtype=float)

        n_g = g["count"].reindex(cand.kategori_topik).fillna(0).to_numpy()
        d_g = g["mean"].reindex(cand.kategori_topik).fillna(0).to_numpy()
        n_j = j.reindex(cand.jenis_buku).fillna(0).to_numpy()
        cad_g = pg.reindex(cand.kategori_topik).fillna(0).to_numpy()
        cad_j = pj.reindex(cand.jenis_buku).fillna(0).to_numpy()

        cand["user_id"] = u.user_id
        cand["jurusan"] = u.jurusan
        cand["semester"] = u.semester
        cand["jumlah_buku_lain"] = n
        cand["pengguna_baru"] = int(n == 0)
        cand["rata_durasi_lain"] = dur_lain
        cand["rasio_favorit_lain"] = fav_lain
        cand["rasio_selesai"] = selesai
        cand["total_menit_dibaca"] = float(mine.durasi.sum())
        cand["total_resume"] = float(n_resume.get(u.user_id, 0))
        cand["topik_sesuai_kurikulum"] = cand.kategori_topik.isin(genre_kurikulum(u.jurusan, u.semester)).astype(int)
        cand["porsi_genre_dibaca"] = _campur((n_g / n) if n else 0.0, cad_g, n, k)
        cand["porsi_jenis_dibaca"] = _campur((n_j / n) if n else 0.0, cad_j, n, k)
        # durasi pada buku lain di genre YANG SAMA dengan buku target; kalau belum ada -> rata_durasi_lain
        cand["rata_durasi_genre_lain"] = _campur(d_g, dur_lain, n_g, k)
        hasil.append(cand)

    return pd.concat(hasil, ignore_index=True) if hasil else pd.DataFrame()


def score(model, X):
    try:
        return model.predict_proba(X)[:, 1]
    except (AttributeError, ValueError):
        # SVM tanpa probability=True: pakai jarak ke batas keputusan -> 0..1 lewat sigmoid
        s = model.decision_function(X)
        return 1 / (1 + np.exp(-s))


# ---------------------------------------------------------------- main
def main():
    ap = argparse.ArgumentParser()
    ap.add_argument("--env", help="path file .env Laravel")
    ap.add_argument("--db-url", help="URL SQLAlchemy (alternatif dari --env)")
    ap.add_argument("--model", default="models/model.joblib")
    # default dinaikkan dari 20 -> 1000 supaya halaman "selesai membaca" punya cukup kandidat
    # untuk disaring per genre/jenis buku yang baru selesai dibaca.
    ap.add_argument("--top", type=int, default=1000,
                    help="jumlah rekomendasi tersimpan per pengguna (besar = lebih banyak kandidat per genre)")
    ap.add_argument("--durasi-bagi", type=float, default=1.0,
                    help="bagi duration DB dengan angka ini (60 jika disimpan dalam detik)")
    ap.add_argument("--dry-run", action="store_true")
    args = ap.parse_args()

    bundle = joblib.load(args.model)
    model, cat_cols, num_cols = bundle["model"], bundle["cat_cols"], bundle["num_cols"]
    k_blend = bundle.get("k_blend", 5)
    min_users = bundle.get("min_users_group", 10)
    print(f"Model: {bundle['model_name']} (dilatih {bundle['dilatih_pada']})")

    engine = make_engine(args)
    users, books, hist, dur, fav, resume = load_data(engine, args.durasi_bagi)
    users, books = clean_inputs(users, books)
    print(f"Pengguna: {len(users)} | Buku approved: {len(books)}")

    # Diagnosis: nilai kategori di DB yang tidak pernah dilihat model saat training
    # (OneHotEncoder handle_unknown="ignore" mengubahnya jadi vektor nol tanpa error).
    try:
        enc = model.named_steps["prep"].named_transformers_["kat"]
        for kol in ("kategori_topik", "tipe_konten", "jenis_buku", "jurusan"):
            dikenal = set(enc.categories_[cat_cols.index(kol)])
            sumber = users if kol == "jurusan" else books
            asing = sorted(set(sumber[kol].dropna()) - dikenal)
            print(f"{kol} di DB yang TIDAK dikenal model: {asing if asing else 'tidak ada'}")
        print("Distribusi genre di DB:", books.kategori_topik.value_counts().to_dict())
    except Exception as ex:
        print("(diagnosis kategori dilewati:", ex, ")")

    cand = build_candidates(users, books, hist, dur, fav, resume, k=k_blend, min_users=min_users)
    if cand.empty:
        print("Tidak ada kandidat (belum ada pengguna atau buku approved). Tidak ada yang ditulis.")
        return
    baru = cand.loc[cand.pengguna_baru == 1, "user_id"].nunique()
    print(f"Pengguna dinilai: {cand.user_id.nunique()} (tanpa riwayat: {baru}) | Pasangan dinilai: {len(cand)}")

    cand["skor"] = score(model, cand[cat_cols + num_cols])

    # Diagnosis: Decision Tree menghasilkan sedikit nilai skor unik, jadi banyak buku berskor sama (ties).
    print(f"Skor unik: {cand.skor.round(4).nunique()} dari {len(cand)} pasangan")
    print("Skor paling sering muncul:")
    print(cand.skor.round(4).value_counts().head(5).to_string())

    # Pemecah ties: skor model -> kedekatan genre dengan bacaan user -> popularitas buku.
    # mergesort = stabil, jadi hasilnya konsisten antar-run.
    top = (cand.sort_values(
                ["user_id", "skor", "porsi_genre_dibaca", "reader_count"],
                ascending=[True, False, False, False], kind="mergesort")
               .groupby("user_id").head(args.top)[["user_id", "book_id", "skor"]].copy())
    top["skor"] = top.skor.round(4)
    now = datetime.now().strftime("%Y-%m-%d %H:%M:%S")
    top["created_at"] = now
    top["updated_at"] = now

    if args.dry_run:
        print("\n[dry-run] contoh hasil:")
        demo = top.merge(books[["book_id", "kategori_topik", "jenis_buku", "tipe_konten"]], on="book_id", how="left")
        print(demo.drop(columns=["created_at", "updated_at"]).head(15).to_string(index=False))
        return

    # ganti isi tabel dalam satu transaksi: kalau gagal, data lama tetap aman
    with engine.begin() as conn:
        conn.execute(text("DELETE FROM book_recommendations"))
        top.to_sql("book_recommendations", conn, if_exists="append", index=False, chunksize=1000)
    print(f"Selesai: {len(top)} rekomendasi untuk {top.user_id.nunique()} pengguna ditulis ke book_recommendations.")


if __name__ == "__main__":
    main()