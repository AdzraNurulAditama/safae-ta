import argparse
import json
import os
import random
import re
import sys
import time
from datetime import datetime
 
import pandas as pd
import requests
from sqlalchemy import create_engine, text
from sqlalchemy.engine import URL
 
API_URL = "https://www.googleapis.com/books/v1/volumes"
 
# genre Safae -> kata kunci pencarian.
# Genre diambil dari sini (bukan dari kategori API yang berantakan).
GENRE_QUERY = {
    "Pemrograman": ["pemrograman", "algoritma dan struktur data", "pemrograman web"],
    "Basis Data": ["basis data", "sistem basis data", "SQL database"],
    "Jaringan": ["jaringan komputer", "keamanan jaringan"],
    "Kecerdasan Buatan": ["kecerdasan buatan", "machine learning", "data mining"],
    "Sistem Informasi": ["sistem informasi", "analisis dan perancangan sistem", "rekayasa perangkat lunak"],
    "Ekonomi": ["ekonomi", "manajemen", "akuntansi"],
    "Kesehatan": ["kesehatan", "keperawatan", "gizi"],
    "Pendidikan": ["pendidikan", "metode pembelajaran"],
    "Hukum": ["hukum", "hukum bisnis"],
    "Psikologi": ["psikologi", "psikologi pendidikan"],
}
 
# bentuk dokumen untuk nonfiksi; API tidak punya, jadi dipilih acak (dummy)
TIPE_NONFIKSI = ["tugas akhir", "skripsi", "karya ilmiah", "jurnal"]
 
 
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
 
 
# ---------------------------------------------------------------- API
def panggil(params, coba=3):
    r = None
    for i in range(coba):
        r = requests.get(API_URL, params=params, timeout=20)
        if r.status_code == 200:
            return r.json()
        if r.status_code in (429, 503):
            time.sleep(2 * (i + 1))
            continue
        sys.exit(f"API error {r.status_code}: {r.text[:300]}")
    sys.exit(f"API kena batas kuota / tidak merespons (HTTP {r.status_code}).\n"
             f"{r.text[:300]}\n"
             "Buat API key sendiri (Google Cloud Console > aktifkan Books API > buat API key), "
             "lalu jalankan dengan --api-key atau set env GOOGLE_BOOKS_API_KEY.")
 
 
def url_cover(v):
    """URL thumbnail dari volumeInfo, atau None kalau buku tidak punya sampul."""
    links = v.get("imageLinks", {})
    url = links.get("thumbnail") or links.get("smallThumbnail")
    return url.replace("http://", "https://").replace("&edge=curl", "") if url else None
 
 
def unduh(url, tujuan):
    r = requests.get(url, timeout=20)
    ct = r.headers.get("Content-Type", "")
    if r.status_code != 200 or not ct.startswith("image/") or len(r.content) < 1000:
        return False
    with open(tujuan, "wb") as f:
        f.write(r.content)
    return True
 
 
def tarik_genre(genre, kata_kunci, args, sudah, rng, now, target=None):
    target = target or args.per_genre
    hasil = []
    for start in range(0, 40 * args.pages, 40):   # tiap halaman hasil pencarian = 40 buku
        params = {"q": kata_kunci, "maxResults": 40, "startIndex": start, "printType": "books"}
        if args.lang:
            params["langRestrict"] = args.lang
        if args.api_key:
            params["key"] = args.api_key
        items = panggil(params).get("items", [])
        if not items:
            break
        for it in items:
            v = it.get("volumeInfo", {})
            judul = (v.get("title") or "").strip()
            hal = v.get("pageCount") or 0
            if not judul or not (args.min_pages <= hal <= args.max_pages):
                continue
            penulis = ", ".join(v.get("authors") or []) or "Anonim"
            kunci = (judul.lower(), penulis.lower())
            if kunci in sudah:
                continue
 
            gambar = None
            if args.cover:
                url = url_cover(v)
                if not url:
                    continue                     # hanya ambil buku yang punya sampul
                nama = f"gb_{it.get('id', '')}.jpg"
                if not args.dry_run and not unduh(url, os.path.join(args.folder, nama)):
                    continue
                gambar = args.path_prefix + nama
            sudah.add(kunci)
 
            m = re.match(r"(\d{4})", v.get("publishedDate") or "")
            tahun = int(m.group(1)) if m else datetime.now().year
            desk = re.sub(r"<[^>]+>", " ", v.get("description") or "").strip() or None
 
            hasil.append({
                "user_id": args.user_id,
                "title": judul[:255],
                "author": penulis[:255],
                "genre": genre,
                "jenis_buku": "nonfiksi",
                "tipe_konten": rng.choice(TIPE_NONFIKSI),
                "year": tahun,
                "description": desk,
                "content": (desk or f"{judul} - {penulis}. Konten dummy untuk pengujian sistem rekomendasi.")
                           if args.isi_konten else None,
                "status": args.status,
                "image_path": gambar,
                "jumlah_halaman": int(hal),
                "reader_count": 0,
                "is_premium": 0,
                "created_at": now,
                "updated_at": now,
            })
            if len(hasil) >= target:
                return hasil
        time.sleep(0.5)
    return hasil
 
 
# ---------------------------------------------------------------- main
def main():
    ap = argparse.ArgumentParser()
    ap.add_argument("--env", help="path file .env Laravel")
    ap.add_argument("--db-url", help="URL SQLAlchemy (alternatif dari --env)")
    ap.add_argument("--per-genre", type=int, default=8, help="jumlah buku per genre")
    ap.add_argument("--min-pages", type=int, default=30)
    ap.add_argument("--max-pages", type=int, default=150, help="batas halaman (buku tipis)")
    ap.add_argument("--lang", default="", help="batasi bahasa, mis. id atau en (kosong = semua)")
    ap.add_argument("--api-key", default=os.environ.get("GOOGLE_BOOKS_API_KEY", ""),
                    help="API key Google Books (atau set env GOOGLE_BOOKS_API_KEY)")
    ap.add_argument("--status", default="pending",
                    help="nilai kolom status; 'pending' = menunggu validasi admin (muncul di halaman Validasi), "
                         "'approved' = tampil di daftar user dan ikut direkomendasikan model")
    ap.add_argument("--user-id", type=int, default=None, help="user_id penulis (kosong = NULL)")
    ap.add_argument("--isi-konten", action=argparse.BooleanOptionalAction, default=True,
                    help="isi kolom content dengan deskripsi buku agar halaman baca tidak kosong")
    ap.add_argument("--out", help="simpan hasil tarikan ke file JSON (mis. books_dummy.json)")
    ap.add_argument("--genre", action="append",
                    help="hanya isi genre ini (boleh diulang), mis. --genre \"Basis Data\" --genre Jaringan")
    ap.add_argument("--pages", type=int, default=3,
                    help="berapa halaman hasil pencarian (40 buku/halaman) yang diperiksa per kata kunci")
    ap.add_argument("--cover", action=argparse.BooleanOptionalAction, default=True,
                    help="hanya ambil buku yang punya sampul dan unduh sampulnya (--no-cover untuk mematikan)")
    ap.add_argument("--storage-dir",
                    help="folder tujuan gambar (default: <folder .env>/storage/app/public/covers)")
    ap.add_argument("--path-prefix", default="/storage/covers/",
                    help="awalan path yang ditulis ke image_path (pakai 'covers/' kalau view membentuk URL "
                         "dengan asset('storage/' . image_path))")
    ap.add_argument("--dry-run", action="store_true", help="tampilkan saja, jangan menulis ke database")
    args = ap.parse_args()
 
    if args.cover:
        if args.storage_dir:
            args.folder = args.storage_dir
        elif args.env:
            args.folder = os.path.join(os.path.dirname(os.path.abspath(args.env)),
                                       "storage", "app", "public", "covers")
        else:
            sys.exit("Isi --storage-dir (folder storage/app/public/covers Laravel), atau pakai --no-cover.")
        if not args.dry_run:
            os.makedirs(args.folder, exist_ok=True)
 
    engine = make_engine(args)
    with engine.connect() as conn:
        ada = pd.read_sql(text("SELECT title, author FROM books"), conn)
    sudah = {(str(t).lower(), str(a).lower()) for t, a in zip(ada.title, ada.author)}
 
    rng = random.Random(42)                 # supaya pembagian tipe_konten bisa diulang
    now = datetime.now().strftime("%Y-%m-%d %H:%M:%S")
 
    semua = []
    for genre, kata_list in GENRE_QUERY.items():
        if args.genre and genre not in args.genre:
            continue
        got = []
        for kata in kata_list:
            if len(got) >= args.per_genre:
                break
            got += tarik_genre(genre, kata, args, sudah, rng, now, target=args.per_genre - len(got))
        print(f"{genre:20s} {len(got)}/{args.per_genre} buku baru")
        if len(got) < args.per_genre:
            print("   PERINGATAN: kurang dari target. Longgarkan --max-pages atau hapus --lang.")
        semua.extend(got)
 
    if not semua:
        sys.exit("Tidak ada buku yang lolos filter.")
    df = pd.DataFrame(semua)
 
    if args.out:
        with open(args.out, "w", encoding="utf-8") as f:
            json.dump(semua, f, ensure_ascii=False, indent=2)
        print(f"Disimpan ke {args.out}")
 
    if args.dry_run:
        print("\n[dry-run] contoh hasil:")
        print(df[["title", "genre", "tipe_konten", "jumlah_halaman", "year"]].head(15).to_string(index=False))
        return
 
    with engine.begin() as conn:
        df.to_sql("books", conn, if_exists="append", index=False, chunksize=200)
    print(f"Selesai: {len(df)} buku nonfiksi dimasukkan ke tabel books (status='{args.status}').")
    if args.status != "approved":
        print(f"Catatan: buku berstatus '{args.status}'. Setujui lewat halaman Validasi admin "
              "agar tampil di daftar user dan ikut direkomendasikan model.")
 
 
if __name__ == "__main__":
    main()