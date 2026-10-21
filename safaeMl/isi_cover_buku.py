import argparse
import os
import re
import sys
import time
from datetime import datetime
 
import requests
from sqlalchemy import text
 
from import_books_api import TIPE_NONFIKSI, make_engine, panggil
 
 
def norm(s):
    return re.sub(r"\s+", " ", (s or "").strip().lower())
 
 
def cari_cover(judul, api_key):
    """Kembalikan URL thumbnail untuk buku berjudul persis `judul`, atau None."""
    params = {"q": 'intitle:"%s"' % judul.replace('"', " "), "maxResults": 5, "printType": "books"}
    if api_key:
        params["key"] = api_key
    items = panggil(params).get("items", [])
    if not items:
        return None, "API tidak menemukan judul ini"
    sama = [it for it in items if norm(it.get("volumeInfo", {}).get("title")) == norm(judul)]
    if not sama:
        return None, "judul beda, API mengembalikan: " + str(items[0].get("volumeInfo", {}).get("title"))[:50]
    for it in sama:
        links = it.get("volumeInfo", {}).get("imageLinks", {})
        url = links.get("thumbnail") or links.get("smallThumbnail")
        if url:
            return url.replace("http://", "https://").replace("&edge=curl", ""), None
    return None, "buku ada di API tapi tanpa gambar sampul"
 
 
def unduh(url, tujuan):
    r = requests.get(url, timeout=20)
    ct = r.headers.get("Content-Type", "")
    if r.status_code != 200 or not ct.startswith("image/") or len(r.content) < 1000:
        return False
    with open(tujuan, "wb") as f:
        f.write(r.content)
    return True
 
 
def main():
    ap = argparse.ArgumentParser()
    ap.add_argument("--env", help="path file .env Laravel")
    ap.add_argument("--db-url", help="URL SQLAlchemy (alternatif dari --env)")
    ap.add_argument("--api-key", default=os.environ.get("GOOGLE_BOOKS_API_KEY", ""),
                    help="API key Google Books (atau set env GOOGLE_BOOKS_API_KEY)")
    ap.add_argument("--storage-dir",
                    help="folder tujuan gambar (default: <folder .env>/storage/app/public/covers)")
    ap.add_argument("--path-prefix", default="/storage/covers/",
                    help="awalan path yang ditulis ke image_path (pakai 'covers/' kalau view-mu "
                         "membentuk URL dengan asset('storage/' . image_path))")
    ap.add_argument("--dry-run", action="store_true", help="hanya cek buku mana yang ketemu covernya")
    args = ap.parse_args()
 
    root = os.path.dirname(os.path.abspath(args.env)) if args.env else None
    if args.storage_dir:
        folder = args.storage_dir
    elif root:
        folder = os.path.join(root, "storage", "app", "public", "covers")
    else:
        sys.exit("Isi --storage-dir (folder storage/app/public/covers milik Laravel).")
    if root and not os.path.exists(os.path.join(root, "public", "storage")):
        print("PERINGATAN: public/storage belum ada. Jalankan 'php artisan storage:link' "
              "di folder Laravel supaya gambar bisa diakses dari browser.")
 
    engine = make_engine(args)
    with engine.connect() as conn:
        rows = conn.execute(text(
            "SELECT id, title, tipe_konten FROM books "
            "WHERE (image_path IS NULL OR image_path = '') AND user_id IS NULL"
        )).fetchall()
    rows = [r for r in rows if (r.tipe_konten or "").strip().lower() in TIPE_NONFIKSI]
    print(f"Buku dummy tanpa cover: {len(rows)}")
    if not rows:
        return
 
    if not args.dry_run:
        os.makedirs(folder, exist_ok=True)
    now = datetime.now().strftime("%Y-%m-%d %H:%M:%S")
 
    ok, gagal = 0, []
    for r in rows:
        url, alasan = cari_cover(r.title, args.api_key)
        time.sleep(0.3)
        if not url:
            gagal.append(f"{r.title[:60]}  [{alasan}]")
            continue
        nama = f"book_{r.id}.jpg"
        if args.dry_run:
            print(f"[dry-run] ketemu: {r.title[:60]} -> {nama}")
            ok += 1
            continue
        if not unduh(url, os.path.join(folder, nama)):
            gagal.append(f"{r.title[:60]}  [gambar gagal diunduh]")
            continue
        with engine.begin() as conn:
            conn.execute(text("UPDATE books SET image_path = :p, updated_at = :t WHERE id = :i"),
                         {"p": args.path_prefix + nama, "t": now, "i": r.id})
        ok += 1
        print(f"OK  {r.title[:60]}")
 
    print(f"\nSelesai: {ok} cover {'ditemukan' if args.dry_run else 'terisi'}, {len(gagal)} tidak ada.")
    if gagal:
        print("Tidak ketemu / gagal diunduh (tetap tanpa cover):")
        for t in gagal:
            print("  -", t)
 
 
if __name__ == "__main__":
    main()