import argparse
import os
 
import numpy as np
import pandas as pd
 
# ------------------------------------------------------------------ konfigurasi
# Samakan dengan nilai di database (SELECT DISTINCT genre FROM books; ...).
FIKSI = ["Novel", "Romance", "Action", "Horror"]
NONFIKSI = ["Pemrograman", "Basis Data", "Jaringan", "Kecerdasan Buatan",
            "Sistem Informasi", "Ekonomi", "Kesehatan",
            "Hobi"]  # hapus "Hobi" kalau genre ini dibuang dari database
TIPE_AKADEMIK = ["tugas akhir", "karya ilmiah", "jurnal", "skripsi"]
HALAMAN_AKADEMIK = {"tugas akhir": (60, 160), "skripsi": (60, 160),
                    "karya ilmiah": (15, 80), "jurnal": (8, 25)}
 
JUMLAH_BUKU_FIKSI = 14       # per genre
JUMLAH_BUKU_NONFIKSI = 12    # per genre
 
# Samakan dengan SELECT DISTINCT jurusan FROM users. Jurusan yang tidak ada di sini
# tetap aman: model memperlakukannya sebagai tidak dikenal.
JURUSAN = {
    "Informatika":           (0.30, ["Pemrograman", "Basis Data", "Jaringan", "Kecerdasan Buatan"]),
    "Sistem Informasi":      (0.25, ["Sistem Informasi", "Basis Data", "Pemrograman", "Ekonomi"]),
    "Teknik Komputer":       (0.10, ["Jaringan", "Pemrograman", "Kecerdasan Buatan"]),
    "Manajemen":             (0.12, ["Ekonomi", "Sistem Informasi"]),
    "Akuntansi":             (0.08, ["Ekonomi"]),
    "Kesehatan Masyarakat":  (0.07, ["Kesehatan"]),
    "Desain Komunikasi Visual": (0.05, ["Hobi", "Novel"]),
    "Lainnya":               (0.03, []),
}
 
KEKUATAN_JURUSAN = 1.2   # seberapa kuat jurusan memengaruhi minat genre
KEKUATAN_SELERA = 1.8    # seberapa kuat selera genre menentukan label cocok
 
 
def sigmoid(x):
    return 1.0 / (1.0 + np.exp(-x))
 
 
# ------------------------------------------------------------------ katalog
def make_catalog(rng):
    rows, bid = [], 1
    for g in FIKSI:
        for _ in range(JUMLAH_BUKU_FIKSI):
            rows.append(dict(book_id=bid, kategori_topik=g, jenis_buku="fiksi",
                             tipe_konten="novel",
                             jumlah_halaman=int(rng.integers(120, 450)),
                             status_premium=int(rng.random() < 0.20)))
            bid += 1
    for g in NONFIKSI:
        for _ in range(JUMLAH_BUKU_NONFIKSI):
            if g == "Hobi":
                tipe, (lo, hi) = "buku", (80, 300)
            else:
                tipe = str(rng.choice(TIPE_AKADEMIK))
                lo, hi = HALAMAN_AKADEMIK[tipe]
            rows.append(dict(book_id=bid, kategori_topik=g, jenis_buku="nonfiksi",
                             tipe_konten=tipe,
                             jumlah_halaman=int(rng.integers(lo, hi + 1)),
                             status_premium=int(rng.random() < 0.10)))
            bid += 1
    return pd.DataFrame(rows)
 
 
# ------------------------------------------------------------------ pengguna
def make_affinity(rng, jurusan, genres):
    aff = {g: rng.normal(0, 0.6) for g in genres}           # selera pribadi
    for g in JURUSAN[jurusan][1]:                            # dorongan dari jurusan
        aff[g] += KEKUATAN_JURUSAN
    pref_fiksi = rng.normal(0, 0.7)                          # suka fiksi vs nonfiksi
    for g in FIKSI:
        aff[g] += pref_fiksi
    return aff
 
 
def simulate(n_users, bias, seed):
    rng = np.random.default_rng(seed)
    books = make_catalog(rng)
    genres = FIKSI + NONFIKSI
    nama_jurusan = list(JURUSAN)
    p_jurusan = np.array([JURUSAN[j][0] for j in nama_jurusan])
    p_jurusan = p_jurusan / p_jurusan.sum()
 
    rows = []
    for uid in range(1, n_users + 1):
        jurusan = str(rng.choice(nama_jurusan, p=p_jurusan))
        semester = int(rng.integers(1, 9))
        aff = make_affinity(rng, jurusan, genres)
 
        # pilih buku yang dibaca: genre yang disukai lebih sering terpilih
        w = np.exp(0.9 * books.kategori_topik.map(aff).to_numpy())
        n = int(rng.integers(6, 26))
        idx = rng.choice(len(books), size=min(n, len(books)), replace=False, p=w / w.sum())
        baca = books.iloc[idx].reset_index(drop=True)
        n = len(baca)
 
        # label cocok + durasi baca + favorit per buku
        p = sigmoid(KEKUATAN_SELERA * baca.kategori_topik.map(aff).to_numpy()
                    + rng.normal(0, 0.4, n) + bias)
        cocok = (rng.random(n) < p).astype(int)
        durasi = np.round(np.maximum(1.0, baca.jumlah_halaman.to_numpy() * rng.uniform(0.5, 1.5, n)
                                     * np.where(cocok == 1, 1.0, 0.45)), 1)
        fav = (rng.random(n) < np.where(cocok == 1, 0.55, 0.08)).astype(int)
 
        g_arr = baca.kategori_topik.to_numpy()
        j_arr = baca.jenis_buku.to_numpy()
        ids = np.arange(n)
 
        # fitur "_lain": dihitung dari buku LAIN milik pengguna ini
        for i in range(n):
            lain = ids != i
            sama_g = lain & (g_arr == g_arr[i])
            sama_j = lain & (j_arr == j_arr[i])
            rata_durasi = float(durasi[lain].mean())
            rows.append(dict(
                user_id=uid, book_id=int(baca.book_id[i]),
                jurusan=jurusan,
                jenis_buku=j_arr[i],
                kategori_topik=g_arr[i],
                tipe_konten=baca.tipe_konten[i],
                semester=semester,
                jumlah_halaman=int(baca.jumlah_halaman[i]),
                status_premium=int(baca.status_premium[i]),
                rata_durasi_lain=round(rata_durasi, 3),
                rasio_favorit_lain=round(float(fav[lain].mean()), 3),
                jumlah_buku_lain=n - 1,
                porsi_genre_dibaca=round(float(sama_g.sum()) / (n - 1), 3),
                porsi_jenis_dibaca=round(float(sama_j.sum()) / (n - 1), 3),
                rata_durasi_genre_lain=round(float(durasi[sama_g].mean()) if sama_g.any() else rata_durasi, 3),
                cocok=int(cocok[i]),
            ))
    return pd.DataFrame(rows)
 
 
def main():
    ap = argparse.ArgumentParser()
    ap.add_argument("--out", default="data/dataset_dummy_safae.csv")
    ap.add_argument("--users", type=int, default=200)
    ap.add_argument("--bias", type=float, default=-0.6,
                    help="geser proporsi cocok=1; makin kecil makin sedikit yang cocok")
    ap.add_argument("--seed", type=int, default=42)
    args = ap.parse_args()
 
    df = simulate(args.users, args.bias, args.seed)
    os.makedirs(os.path.dirname(args.out) or ".", exist_ok=True)
    df.to_csv(args.out, index=False)
 
    print(f"Tersimpan: {args.out} | {len(df)} baris | {df.user_id.nunique()} pengguna")
    print(f"Proporsi cocok=1: {df.cocok.mean():.1%}")
    print("Per jenis buku:", df.groupby("jenis_buku").cocok.mean().round(3).to_dict())
    print("Per genre:")
    print(df.groupby("kategori_topik").cocok.agg(["mean", "count"]).round(3).to_string())
 
 
if __name__ == "__main__":
    main()