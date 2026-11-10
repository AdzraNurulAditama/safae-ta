import os
from pathlib import Path

import numpy as np
import pandas as pd
import pymysql

# ==========================================
# KONFIGURASI
# ==========================================

RANDOM_STATE = 42
JUMLAH_PENGGUNA = 100
JUMLAH_DATA_PER_PENGGUNA = 10

BASE_DIR = Path(__file__).resolve().parent
FILE_GABUNGAN = BASE_DIR / "data" / "dataset_safae_gabungan.csv"

rng = np.random.default_rng(RANDOM_STATE)

KOLOM_DATASET = [
    "user_id",
    "book_id",
    "jurusan",
    "semester",
    "jenis_buku",
    "kategori_topik",
    "tipe_konten",
    "jumlah_halaman",
    "status_premium",
    "rata_durasi_lain",
    "rasio_favorit_lain",
    "jumlah_buku_lain",
    "porsi_genre_dibaca",
    "porsi_jenis_dibaca",
    "rata_durasi_genre_lain",
    "rasio_selesai",
    "total_menit_dibaca",
    "total_resume",
    "pengguna_baru",
    "umpan_balik",
    "sumber_data",
]

# ==========================================
# PILIHAN DATA SIMULASI (TETAP SEPERTI SCRIPT LAMA)
# ==========================================

GENRE_FIKSI = [
    "Romance",
    "Fantasy",
    "Thriller",
    "Science Fiction",
    "Mystery",
    "Horror",
]

GENRE_NONFIKSI = [
    "Bisnis",
    "Sains",
    "Teknologi",
    "Sejarah",
    "Pendidikan",
    "Self Improvement",
]

JURUSAN = [
    "Sistem Informasi",
    "Informatika",
    "Teknik Industri",
    "Manajemen",
    "Akuntansi",
    "Ilmu Komunikasi",
]

# ==========================================
# MEMBACA KONFIGURASI DATABASE DARI .ENV
# ==========================================

def baca_env():
    kemungkinan_env = [
        BASE_DIR / ".env",
        BASE_DIR.parent / ".env",
        BASE_DIR.parent / "safaeLaravel" / ".env",
        Path.cwd() / ".env",
    ]

    file_env = next((path for path in kemungkinan_env if path.exists()), None)

    if file_env is None:
        raise FileNotFoundError(
            "File .env tidak ditemukan. Letakkan script di folder proyek "
            "Laravel yang memiliki file .env."
        )

    env = {}
    with open(file_env, "r", encoding="utf-8") as file:
        for baris in file:
            baris = baris.strip()
            if not baris or baris.startswith("#") or "=" not in baris:
                continue

            kunci, nilai = baris.split("=", 1)
            nilai = nilai.strip().strip('"').strip("'")
            env[kunci.strip()] = nilai

    wajib = ["DB_DATABASE", "DB_USERNAME"]
    belum_ada = [kunci for kunci in wajib if not env.get(kunci)]
    if belum_ada:
        raise ValueError(
            "Konfigurasi .env belum lengkap: " + ", ".join(belum_ada)
        )

    return env


def koneksi_database():
    env = baca_env()

    return pymysql.connect(
        host=env.get("DB_HOST", "127.0.0.1"),
        port=int(env.get("DB_PORT", 3306)),
        user=env["DB_USERNAME"],
        password=env.get("DB_PASSWORD", ""),
        database=env["DB_DATABASE"],
        charset="utf8mb4",
        cursorclass=pymysql.cursors.DictCursor,
    )


# ==========================================
# AMBIL DATA DARI DATABASE SAFAE
# ==========================================

def ambil_data_database():
    print("Menghubungkan ke database SAFAE...")

    koneksi = koneksi_database()

    try:
        with koneksi.cursor() as cursor:
            print("Mengambil feedback, pengguna, dan buku...")

            cursor.execute("""
                SELECT
                    bf.user_id,
                    bf.book_id,
                    u.jurusan,
                    u.semester,
                    b.jenis_buku,
                    b.genre AS kategori_topik,
                    b.tipe_konten,
                    b.jumlah_halaman,
                    b.is_premium AS status_premium,
                    bf.cocok AS umpan_balik
                FROM book_feedbacks bf
                INNER JOIN books b ON b.id = bf.book_id
                INNER JOIN users u ON u.id = bf.user_id
                ORDER BY bf.user_id, bf.book_id
            """)
            feedback = pd.DataFrame(cursor.fetchall())

            print("Mengambil riwayat membaca...")
            cursor.execute("""
                SELECT
                    rh.user_id,
                    rh.book_id,
                    rh.progress_percentage,
                    b.genre AS kategori_topik,
                    b.jenis_buku
                FROM reading_histories rh
                INNER JOIN books b ON b.id = rh.book_id
            """)
            riwayat = pd.DataFrame(cursor.fetchall())

            print("Mengambil durasi membaca...")
            cursor.execute("""
                SELECT user_id, book_id, duration
                FROM reading_progress
            """)
            durasi = pd.DataFrame(
    cursor.fetchall(),
    columns=["user_id", "book_id", "duration"]
)

            print("Mengambil buku favorit...")
            cursor.execute("""
                SELECT user_id, book_id
                FROM favorite_books
            """)
            favorit = pd.DataFrame(cursor.fetchall())

        if feedback.empty:
            raise ValueError(
                "Tidak ditemukan data feedback. Pastikan tabel book_feedbacks "
                "memiliki data dan relasi user_id/book_id valid."
            )

        # Normalisasi tipe data agar pencocokan ID konsisten.
        for df in (feedback, riwayat, durasi, favorit):
            for kolom in ("user_id", "book_id"):
                if kolom in df.columns:
                    df[kolom] = pd.to_numeric(df[kolom], errors="coerce")

        for kolom in ("progress_percentage",):
            if kolom in riwayat.columns:
                riwayat[kolom] = pd.to_numeric(
                    riwayat[kolom], errors="coerce"
                ).fillna(0)

        if "duration" in durasi.columns:
            durasi["duration"] = pd.to_numeric(
                durasi["duration"], errors="coerce"
            ).fillna(0)

        # Asumsi duration tersimpan dalam detik, lalu dikonversi ke menit.
        # Jika aplikasi menyimpan duration dalam menit, hapus pembagian 60 di
        # bagian perhitungan fitur durasi di bawah.
        hasil = []

        for _, baris in feedback.iterrows():
            user_id = baris["user_id"]
            book_id = baris["book_id"]
            genre_target = baris["kategori_topik"]
            jenis_target = baris["jenis_buku"]

            # Semua fitur aktivitas dihitung dari buku selain buku target,
            # agar informasi target tidak bocor ke fitur model.
            riwayat_user = riwayat[
                (riwayat["user_id"] == user_id)
                & (riwayat["book_id"] != book_id)
            ].copy()

            jumlah_buku_lain = int(riwayat_user["book_id"].nunique())
            pengguna_baru = int(jumlah_buku_lain == 0)

            if jumlah_buku_lain > 0:
                porsi_genre = (
                    riwayat_user.loc[
                        riwayat_user["kategori_topik"] == genre_target,
                        "book_id",
                    ].nunique() / jumlah_buku_lain
                )
                porsi_jenis = (
                    riwayat_user.loc[
                        riwayat_user["jenis_buku"] == jenis_target,
                        "book_id",
                    ].nunique() / jumlah_buku_lain
                )
                rasio_selesai = (
                    riwayat_user.groupby("book_id")["progress_percentage"]
                    .max()
                    .fillna(0)
                    .clip(0, 100)
                    .div(100)
                    .mean()
                )
            else:
                porsi_genre = 0.0
                porsi_jenis = 0.0
                rasio_selesai = 0.0

            durasi_user = durasi[
                (durasi["user_id"] == user_id)
                & (durasi["book_id"] != book_id)
            ].copy()

            # Satu total durasi per buku agar beberapa catatan progres
            # untuk buku yang sama tidak dihitung sebagai buku berbeda.
            if not durasi_user.empty:
                durasi_per_buku = (
                    durasi_user.groupby("book_id")["duration"].sum()
                )
                total_detik = float(durasi_per_buku.sum())
                rata_durasi = (
                    float(durasi_per_buku.mean()) / 60
                    if len(durasi_per_buku) else 0.0
                )
            else:
                durasi_per_buku = pd.Series(dtype=float)
                total_detik = 0.0
                rata_durasi = 0.0

            buku_genre_lain = set(
                riwayat_user.loc[
                    riwayat_user["kategori_topik"] == genre_target,
                    "book_id",
                ].dropna().tolist()
            )
            durasi_genre = durasi_user[
                durasi_user["book_id"].isin(buku_genre_lain)
            ]

            if not durasi_genre.empty:
                durasi_genre_per_buku = (
                    durasi_genre.groupby("book_id")["duration"].sum()
                )
                rata_durasi_genre = (
                    float(durasi_genre_per_buku.mean()) / 60
                )
            else:
                rata_durasi_genre = 0.0

            jumlah_favorit = favorit[
                (favorit["user_id"] == user_id)
                & (favorit["book_id"] != book_id)
            ]["book_id"].nunique()

            rasio_favorit = (
                min(jumlah_favorit / jumlah_buku_lain, 1.0)
                if jumlah_buku_lain > 0 else 0.0
            )

            hasil.append({
                "user_id": int(user_id),
                "book_id": int(book_id),
                "jurusan": baris["jurusan"] or "Tidak diketahui",
                "semester": baris["semester"],
                "jenis_buku": baris["jenis_buku"],
                "kategori_topik": baris["kategori_topik"],
                "tipe_konten": baris["tipe_konten"],
                "jumlah_halaman": baris["jumlah_halaman"],
                "status_premium": baris["status_premium"],
                "rata_durasi_lain": round(rata_durasi, 2),
                "rasio_favorit_lain": round(rasio_favorit, 4),
                "jumlah_buku_lain": jumlah_buku_lain,
                "porsi_genre_dibaca": round(float(porsi_genre), 4),
                "porsi_jenis_dibaca": round(float(porsi_jenis), 4),
                "rata_durasi_genre_lain": round(rata_durasi_genre, 2),
                "rasio_selesai": round(float(rasio_selesai), 4),
                "total_menit_dibaca": round(total_detik / 60, 2),
                # Belum dihitung karena struktur tabel book_resumes belum
                # dipetakan. Tidak mengarang jumlah resume pengguna.
                "total_resume": 0,
                "pengguna_baru": pengguna_baru,
                "umpan_balik": int(baris["umpan_balik"]),
                "sumber_data": "asli",
            })

        df_asli = pd.DataFrame(hasil, columns=KOLOM_DATASET)
        return df_asli

    finally:
        koneksi.close()


# ==========================================
# MEMBUAT PROFIL PENGGUNA DUMMY
# (LOGIKA AKTIF DARI SCRIPT LAMA DIPERTAHANKAN)
# ==========================================

def buat_profil_pengguna(user_id):
    jenis_favorit = rng.choice(["fiksi", "nonfiksi"])
    semua_genre = GENRE_FIKSI + GENRE_NONFIKSI

    if jenis_favorit == "fiksi":
        genre_favorit = rng.choice(GENRE_FIKSI)
    else:
        genre_favorit = rng.choice(GENRE_NONFIKSI)

    bobot_genre = {}
    for genre in semua_genre:
        if genre == genre_favorit:
            bobot_genre[genre] = rng.uniform(5, 8)
        elif genre in (
            GENRE_FIKSI if jenis_favorit == "fiksi" else GENRE_NONFIKSI
        ):
            bobot_genre[genre] = rng.uniform(1, 3)
        else:
            bobot_genre[genre] = rng.uniform(0.2, 1)

    total_bobot = sum(bobot_genre.values())
    riwayat_genre = {
        genre: bobot / total_bobot
        for genre, bobot in bobot_genre.items()
    }

    porsi_jenis_favorit = rng.uniform(0.65, 0.90)
    riwayat_jenis = {
        jenis_favorit: porsi_jenis_favorit,
        "nonfiksi" if jenis_favorit == "fiksi" else "fiksi":
            1 - porsi_jenis_favorit,
    }

    return {
        "user_id": -user_id,
        "jurusan": rng.choice(JURUSAN),
        "semester": int(rng.integers(1, 9)),
        "jenis_favorit": jenis_favorit,
        "genre_favorit": genre_favorit,
        "riwayat_genre": riwayat_genre,
        "riwayat_jenis": riwayat_jenis,
        "rata_durasi": float(rng.uniform(15, 90)),
        "rasio_favorit": float(rng.uniform(0.05, 0.45)),
        "jumlah_buku": int(rng.integers(3, 21)),
        "rata_durasi_genre": float(rng.uniform(15, 90)),
        "rasio_selesai": float(rng.uniform(0.35, 0.95)),
        "total_resume": int(rng.integers(0, 6)),
    }


# ==========================================
# MEMBUAT SATU DATA BUKU DUMMY
# (LOGIKA AKTIF DARI SCRIPT LAMA DIPERTAHANKAN)
# ==========================================

def buat_data_buku(profil, nomor):
    jenis_buku = rng.choice(["fiksi", "nonfiksi"])

    if jenis_buku == "fiksi":
        kategori = rng.choice(GENRE_FIKSI)
        tipe_konten = "novel"
    else:
        kategori = rng.choice(GENRE_NONFIKSI)
        tipe_konten = rng.choice([
            "buku",
            "jurnal",
            "karya ilmiah",
            "skripsi",
            "tugas akhir",
        ])

    porsi_genre = profil["riwayat_genre"].get(kategori, 0)
    porsi_jenis = profil["riwayat_jenis"].get(jenis_buku, 0)

    skor = (
        0.50 * porsi_genre
        + 0.35 * porsi_jenis
        + 0.15 * rng.random()
    )

    peluang_cocok = np.clip(0.10 + skor, 0.10, 0.90)
    umpan_balik = int(rng.random() < peluang_cocok)

    jumlah_halaman = int(rng.integers(30, 401))
    status_premium = int(rng.random() < 0.25)

    return {
        "user_id": profil["user_id"],
        "book_id": -user_id_book_id(profil, nomor),
        "jurusan": profil["jurusan"],
        "semester": profil["semester"],
        "jenis_buku": jenis_buku,
        "kategori_topik": kategori,
        "tipe_konten": tipe_konten,
        "jumlah_halaman": jumlah_halaman,
        "status_premium": status_premium,
        "rata_durasi_lain": round(profil["rata_durasi"], 2),
        "rasio_favorit_lain": round(profil["rasio_favorit"], 4),
        "jumlah_buku_lain": profil["jumlah_buku"],
        "porsi_genre_dibaca": round(porsi_genre, 4),
        "porsi_jenis_dibaca": round(porsi_jenis, 4),
        "rata_durasi_genre_lain": round(profil["rata_durasi_genre"], 2),
        "rasio_selesai": round(profil["rasio_selesai"], 4),
        "total_menit_dibaca": round(
            profil["rata_durasi"] * profil["jumlah_buku"], 2
        ),
        "total_resume": profil["total_resume"],
        "pengguna_baru": 0,
        "umpan_balik": umpan_balik,
        "sumber_data": "dummy",
    }


# ==========================================
# ID BUKU DUMMY
# ==========================================

def user_id_book_id(profil, nomor):
    nomor_pengguna = abs(profil["user_id"])
    return (nomor_pengguna - 1) * JUMLAH_DATA_PER_PENGGUNA + nomor


# ==========================================
# GENERATE DATASET DUMMY
# ==========================================

def buat_dataset_dummy():
    seluruh_data = []

    for user_id in range(1, JUMLAH_PENGGUNA + 1):
        profil = buat_profil_pengguna(user_id)

        for nomor in range(1, JUMLAH_DATA_PER_PENGGUNA + 1):
            seluruh_data.append(buat_data_buku(profil, nomor))

    return pd.DataFrame(seluruh_data, columns=KOLOM_DATASET)


# ==========================================
# GABUNGKAN DATA DATABASE + DATA DUMMY
# ==========================================

def main():
    (BASE_DIR / "data").mkdir(parents=True, exist_ok=True)

    print("Membaca dataset asli dari database SAFAE...")
    df_asli = ambil_data_database()

    print(f"Data asli dari database: {len(df_asli)}")

    print("Membuat dataset dummy...")
    df_dummy = buat_dataset_dummy()

    df_gabungan = pd.concat(
        [df_asli, df_dummy],
        ignore_index=True,
    )

    df_gabungan = df_gabungan[KOLOM_DATASET]
    df_gabungan.to_csv(FILE_GABUNGAN, index=False)

    print("\n================================")
    print("DATASET BERHASIL DIBUAT")
    print("================================")
    print(f"Data asli  : {len(df_asli)}")
    print(f"Data dummy : {len(df_dummy)}")
    print(f"Total data : {len(df_gabungan)}")

    print("\nDistribusi label:")
    print(df_gabungan["umpan_balik"].value_counts().sort_index())

    print("\nDistribusi sumber data:")
    print(df_gabungan["sumber_data"].value_counts())

    print(f"\nFile tersimpan: {FILE_GABUNGAN}")


if __name__ == "__main__":
    main()
