
import os
import numpy as np
import pandas as pd

# ==========================================
# KONFIGURASI
# ==========================================

RANDOM_STATE = 42
JUMLAH_PENGGUNA = 100
JUMLAH_DATA_PER_PENGGUNA = 10

FILE_ASLI = "data/dataset_safae.csv"
FILE_GABUNGAN = "data/dataset_safae_gabungan.csv"

rng = np.random.default_rng(RANDOM_STATE)

# ==========================================
# PILIHAN DATA SIMULASI
# ==========================================

GENRE_FIKSI = [
    "Romance",
    "Fantasy",
    "Thriller",
    "Science Fiction",
    "Mystery",
    "Horror"
]

GENRE_NONFIKSI = [
    "Bisnis",
    "Sains",
    "Teknologi",
    "Sejarah",
    "Pendidikan",
    "Self Improvement"
]

JURUSAN = [
    "Sistem Informasi",
    "Informatika",
    "Teknik Industri",
    "Manajemen",
    "Akuntansi",
    "Ilmu Komunikasi"
]

# ==========================================
# MEMBUAT PROFIL PENGGUNA
# ==========================================

def buat_profil_pengguna(user_id):

    jenis_favorit = rng.choice(["fiksi", "nonfiksi"])

    semua_genre = GENRE_FIKSI + GENRE_NONFIKSI

    if jenis_favorit == "fiksi":
        genre_favorit = rng.choice(GENRE_FIKSI)
    else:
        genre_favorit = rng.choice(GENRE_NONFIKSI)

    # Membuat distribusi genre dari riwayat membaca pengguna
    bobot_genre = {}

    for genre in semua_genre:
        if genre == genre_favorit:
            bobot_genre[genre] = rng.uniform(5, 8)
        elif genre in (GENRE_FIKSI if jenis_favorit == "fiksi" else GENRE_NONFIKSI):
            bobot_genre[genre] = rng.uniform(1, 3)
        else:
            bobot_genre[genre] = rng.uniform(0.2, 1)

    total_bobot = sum(bobot_genre.values())

    riwayat_genre = {
        genre: bobot / total_bobot
        for genre, bobot in bobot_genre.items()
    }

    # Distribusi jenis buku dari riwayat membaca
    porsi_jenis_favorit = rng.uniform(0.65, 0.90)

    riwayat_jenis = {
        jenis_favorit: porsi_jenis_favorit,
        "nonfiksi" if jenis_favorit == "fiksi" else "fiksi":
            1 - porsi_jenis_favorit
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
        "total_resume": int(rng.integers(0, 6))
    }
    jenis_favorit = rng.choice(["fiksi", "nonfiksi"])

    if jenis_favorit == "fiksi":
        genre_favorit = rng.choice(GENRE_FIKSI)
    else:
        genre_favorit = rng.choice(GENRE_NONFIKSI)

    return {
        "user_id": -user_id,
        "jurusan": rng.choice(JURUSAN),
        "semester": int(rng.integers(1, 9)),

        "jenis_favorit": jenis_favorit,
        "genre_favorit": genre_favorit,

        # Preferensi pengguna
        "preferensi_jenis": float(rng.uniform(0.65, 0.95)),
        "preferensi_genre": float(rng.uniform(0.65, 0.95)),

        # Riwayat aktivitas pengguna
        # Nilainya dibuat sekali per pengguna,
        # tidak berubah mengikuti buku yang dinilai.
        "rata_durasi": float(rng.uniform(15, 90)),
        "rasio_favorit": float(rng.uniform(0.05, 0.45)),
        "jumlah_buku": int(rng.integers(3, 21)),
        "porsi_genre": float(rng.uniform(0.20, 0.85)),
        "porsi_jenis": float(rng.uniform(0.30, 0.90)),
        "rata_durasi_genre": float(rng.uniform(15, 90)),
        "rasio_selesai": float(rng.uniform(0.35, 0.95)),
        "total_resume": int(rng.integers(0, 6))
    }
    jenis_favorit = rng.choice(
        ["fiksi", "nonfiksi"]
    )

    if jenis_favorit == "fiksi":
        genre_favorit = rng.choice(GENRE_FIKSI)
        genre_lain = rng.choice(GENRE_FIKSI)
    else:
        genre_favorit = rng.choice(GENRE_NONFIKSI)
        genre_lain = rng.choice(GENRE_NONFIKSI)

    return {
        "user_id": -user_id,
        "jurusan": rng.choice(JURUSAN),
        "semester": int(rng.integers(1, 9)),
        "jenis_favorit": jenis_favorit,
        "genre_favorit": genre_favorit,
        "genre_lain": genre_lain,
        "preferensi_jenis": float(rng.uniform(0.65, 0.95)),
        "preferensi_genre": float(rng.uniform(0.65, 0.95)),
        "kebiasaan_baca": float(rng.uniform(15, 90)),
        "kebiasaan_selesai": float(rng.uniform(0.35, 0.95)),
        "jumlah_buku": int(rng.integers(3, 21))
    }


# ==========================================
# MEMBUAT SATU DATA BUKU
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
            "tugas akhir"
        ])

    # Mengambil preferensi berdasarkan riwayat pengguna
    porsi_genre = profil["riwayat_genre"].get(kategori, 0)
    porsi_jenis = profil["riwayat_jenis"].get(jenis_buku, 0)

    # Membuat label berdasarkan informasi riwayat tersebut
    skor = (
        0.50 * porsi_genre
        + 0.35 * porsi_jenis
        + 0.15 * rng.random()
    )

    peluang_cocok = np.clip(
        0.10 + skor,
        0.10,
        0.90
    )

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
        "sumber_data": "dummy"
    }
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
            "tugas akhir"
        ])

    # Menghitung kecocokan buku dengan preferensi pengguna
    cocok_jenis = int(
        jenis_buku == profil["jenis_favorit"]
    )

    cocok_genre = int(
        kategori == profil["genre_favorit"]
    )

    skor = (
        0.35 * cocok_jenis * profil["preferensi_jenis"]
        + 0.45 * cocok_genre * profil["preferensi_genre"]
        + 0.10 * rng.random()
        + 0.10 * rng.random()
    )

    peluang_cocok = np.clip(
        0.15 + skor,
        0.10,
        0.95
    )

    umpan_balik = int(
        rng.random() < peluang_cocok
    )

    # Fitur riwayat pengguna tidak bergantung pada
    # kecocokan buku yang sedang dinilai.
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

        "rata_durasi_lain": round(
            profil["rata_durasi"], 2
        ),
        "rasio_favorit_lain": round(
            profil["rasio_favorit"], 4
        ),
        "jumlah_buku_lain": profil["jumlah_buku"],
        "porsi_genre_dibaca": round(
            profil["porsi_genre"], 4
        ),
        "porsi_jenis_dibaca": round(
            profil["porsi_jenis"], 4
        ),
        "rata_durasi_genre_lain": round(
            profil["rata_durasi_genre"], 2
        ),
        "rasio_selesai": round(
            profil["rasio_selesai"], 4
        ),
        "total_menit_dibaca": round(
            profil["rata_durasi"] * profil["jumlah_buku"], 2
        ),
        "total_resume": profil["total_resume"],
        "pengguna_baru": 0,
        "umpan_balik": umpan_balik,
        "sumber_data": "dummy"
    }
    jenis_buku = rng.choice(
        ["fiksi", "nonfiksi"],
        p=[0.5, 0.5]
    )

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
            "tugas akhir"
        ])

    # Kesesuaian dengan preferensi pengguna
    cocok_jenis = int(
        jenis_buku == profil["jenis_favorit"]
    )

    cocok_genre = int(
        kategori == profil["genre_favorit"]
    )

    # Simulasi tingkat kecocokan
    skor = (
        0.35 * cocok_jenis * profil["preferensi_jenis"]
        + 0.45 * cocok_genre * profil["preferensi_genre"]
        + 0.10 * rng.random()
        + 0.10 * rng.random()
    )

    # Label ditentukan berdasarkan kecocokan pengguna,
    # bukan berdasarkan peringkat seluruh dataset.
    peluang_cocok = np.clip(
        0.15 + skor,
        0.10,
        0.95
    )

    umpan_balik = int(
        rng.random() < peluang_cocok
    )

    # Aktivitas membaca dibuat berdasarkan profil
    # dan kecocokan buku dengan preferensi pengguna.
    jumlah_buku_lain = profil["jumlah_buku"]

    porsi_genre = np.clip(
        0.15 + cocok_genre * 0.55
        + rng.normal(0, 0.08),
        0,
        1
    )

    porsi_jenis = np.clip(
        0.20 + cocok_jenis * 0.55
        + rng.normal(0, 0.08),
        0,
        1
    )

    durasi = max(
        0,
        profil["kebiasaan_baca"]
        + cocok_genre * 15
        + rng.normal(0, 12)
    )

    rasio_favorit = np.clip(
        0.10 + cocok_genre * 0.20
        + rng.normal(0, 0.08),
        0,
        1
    )

    rasio_selesai = np.clip(
        profil["kebiasaan_selesai"]
        + (0.15 if cocok_genre else -0.10)
        + rng.normal(0, 0.10),
        0,
        1
    )

    jumlah_halaman = int(
        rng.integers(30, 401)
    )

    status_premium = int(
        rng.random() < 0.25
    )

    total_menit = round(
        durasi * jumlah_buku_lain,
        2
    )

    total_resume = int(
        rng.integers(0, 6)
    )

    return {
        "user_id": profil["user_id"],
        "book_id": -(user_id_book_id(profil, nomor)),
        "jurusan": profil["jurusan"],
        "semester": profil["semester"],
        "jenis_buku": jenis_buku,
        "kategori_topik": kategori,
        "tipe_konten": tipe_konten,
        "jumlah_halaman": jumlah_halaman,
        "status_premium": status_premium,
        "rata_durasi_lain": round(durasi, 2),
        "rasio_favorit_lain": round(rasio_favorit, 4),
        "jumlah_buku_lain": jumlah_buku_lain,
        "porsi_genre_dibaca": round(porsi_genre, 4),
        "porsi_jenis_dibaca": round(porsi_jenis, 4),
        "rata_durasi_genre_lain": round(
            max(0, durasi + rng.normal(0, 8)), 2
        ),
        "rasio_selesai": round(rasio_selesai, 4),
        "total_menit_dibaca": total_menit,
        "total_resume": total_resume,
        "pengguna_baru": 0,
        "umpan_balik": umpan_balik,
        "sumber_data": "dummy"
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

            data = buat_data_buku(
                profil,
                nomor
            )

            seluruh_data.append(data)

    return pd.DataFrame(seluruh_data)


# ==========================================
# GABUNGKAN DENGAN DATA ASLI
# ==========================================

def main():

    os.makedirs("data", exist_ok=True)

    if not os.path.exists(FILE_ASLI):
        raise FileNotFoundError(
            f"Dataset asli tidak ditemukan: {FILE_ASLI}"
        )

    print("Membaca dataset asli SAFAE...")

    df_asli = pd.read_csv(FILE_ASLI)

    # Data asli tidak diubah
    df_asli = df_asli.copy()
    df_asli["sumber_data"] = "asli"

    print("Membuat dataset dummy...")

    df_dummy = buat_dataset_dummy()

    # Samakan urutan kolom
    kolom = df_asli.columns.tolist()

    for col in kolom:
        if col not in df_dummy.columns:
            df_dummy[col] = np.nan

    df_dummy = df_dummy[kolom]

    # Gabungkan data
    df_gabungan = pd.concat(
        [df_asli, df_dummy],
        ignore_index=True
    )

    df_gabungan.to_csv(
        FILE_GABUNGAN,
        index=False
    )

    print("\n================================")
    print("DATASET BERHASIL DIBUAT")
    print("================================")

    print(f"Data asli  : {len(df_asli)}")
    print(f"Data dummy : {len(df_dummy)}")
    print(f"Total data : {len(df_gabungan)}")

    print("\nDistribusi label:")
    print(
        df_gabungan["umpan_balik"]
        .value_counts()
        .sort_index()
    )

    print("\nDistribusi sumber data:")
    print(
        df_gabungan["sumber_data"]
        .value_counts()
    )

    print(f"\nFile tersimpan: {FILE_GABUNGAN}")


if __name__ == "__main__":
    main()
