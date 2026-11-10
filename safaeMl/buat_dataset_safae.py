
import os
from pathlib import Path

import pandas as pd
from sqlalchemy import create_engine, text
from sqlalchemy.engine import URL


# =====================================================
# KONFIGURASI DATABASE
# =====================================================

DB_HOST = os.getenv("DB_HOST", "127.0.0.1")
DB_PORT = int(os.getenv("DB_PORT", "3306"))
DB_NAME = os.getenv("DB_DATABASE", "safae")
DB_USER = os.getenv("DB_USERNAME", "root")
DB_PASSWORD = os.getenv("DB_PASSWORD", "190606")

# Asumsi duration tersimpan dalam detik.
# Jika tersimpan dalam menit, ubah menjadi 1.
DURASI_BAGI = 60

OUTPUT_DIR = Path("data")
OUTPUT_FILE = OUTPUT_DIR / "dataset_safae.csv"

LABEL = "umpan_balik"


# =====================================================
# KONEKSI DATABASE
# =====================================================

def koneksi_database():

    url = URL.create(
        "mysql+pymysql",
        username=DB_USER,
        password=DB_PASSWORD,
        host=DB_HOST,
        port=DB_PORT,
        database=DB_NAME
    )

    return create_engine(url)


# =====================================================
# MENGAMBIL DATA DARI DATABASE
# =====================================================

def load_data(engine):

    users = pd.read_sql(
        text("""
            SELECT
                id AS user_id,
                jurusan,
                semester
            FROM users
        """),
        engine
    )

    books = pd.read_sql(
        text("""
            SELECT
                id AS book_id,
                genre AS kategori_topik,
                jenis_buku,
                tipe_konten,
                jumlah_halaman,
                is_premium AS status_premium
            FROM books
            WHERE status = 'approved'
        """),
        engine
    )

    histories = pd.read_sql(
        text("""
            SELECT
                user_id,
                book_id,
                status,
                progress_percentage,
                created_at,
                updated_at
            FROM reading_histories
        """),
        engine
    )

    progress = pd.read_sql(
        text("""
            SELECT
                user_id,
                book_id,
                duration,
                created_at
            FROM reading_progress
        """),
        engine
    )

    favorites = pd.read_sql(
        text("""
            SELECT
                user_id,
                book_id,
                created_at
            FROM favorite_books
        """),
        engine
    )

    feedbacks = pd.read_sql(
        text("""
            SELECT
                user_id,
                book_id,
                cocok,
                created_at
            FROM book_feedbacks
        """),
        engine
    )

    return (
        users,
        books,
        histories,
        progress,
        favorites,
        feedbacks
    )


# =====================================================
# PEMBERSIHAN DATA
# =====================================================

def clean_data(
    users,
    books,
    histories,
    progress,
    favorites,
    feedbacks
):

    # Menyamakan tipe data ID
    for df in [
        users,
        books,
        histories,
        progress,
        favorites,
        feedbacks
    ]:

        for col in ["user_id", "book_id"]:

            if col in df.columns:
                df[col] = pd.to_numeric(
                    df[col],
                    errors="coerce"
                ).astype("Int64")

    # Mengubah kolom tanggal menjadi datetime
    for df in [
        histories,
        progress,
        favorites,
        feedbacks
    ]:

        if "created_at" in df.columns:
            df["created_at"] = pd.to_datetime(
                df["created_at"],
                errors="coerce"
            )

    histories["updated_at"] = pd.to_datetime(
        histories["updated_at"],
        errors="coerce"
    )

    # Membersihkan data pengguna
    users["jurusan"] = (
        users["jurusan"]
        .fillna("Tidak diketahui")
        .astype(str)
    )

    users["semester"] = pd.to_numeric(
        users["semester"],
        errors="coerce"
    )

    # Membersihkan data buku
    books["jumlah_halaman"] = pd.to_numeric(
        books["jumlah_halaman"],
        errors="coerce"
    )

    books["status_premium"] = (
        books["status_premium"]
        .fillna(0)
        .astype(int)
    )

    for col in [
        "jenis_buku",
        "tipe_konten",
        "kategori_topik"
    ]:

        books[col] = (
            books[col]
            .fillna("Tidak diketahui")
            .astype(str)
        )

    # Membersihkan durasi membaca
    progress["duration"] = pd.to_numeric(
        progress["duration"],
        errors="coerce"
    ).fillna(0)

    return (
        users,
        books,
        histories,
        progress,
        favorites,
        feedbacks
    )


# =====================================================
# MEMBENTUK FITUR BERDASARKAN AKTIVITAS PENGGUNA
# =====================================================

def buat_fitur(
    feedback,
    users,
    books,
    histories,
    progress,
    favorites
):

    user_id = feedback["user_id"]
    target_book_id = feedback["book_id"]
    waktu_feedback = feedback["created_at"]

    # Mengambil profil pengguna
    user_data = users[
        users["user_id"] == user_id
    ]

    # Mengambil informasi buku yang diberi feedback
    book_data = books[
        books["book_id"] == target_book_id
    ]

    if user_data.empty or book_data.empty:
        return None

    user_data = user_data.iloc[0]
    book_data = book_data.iloc[0]

    # -------------------------------------------------
    # RIWAYAT MEMBACA SEBELUM FEEDBACK
    # -------------------------------------------------

    riwayat = histories[
        (histories["user_id"] == user_id) &
        (histories["created_at"] <= waktu_feedback)
    ].copy()

    # Status selesai hanya digunakan jika tidak
    # mengalami perubahan setelah feedback diberikan.
    riwayat["selesai"] = (
        (riwayat["status"] == "Selesai Dibaca") &
        (riwayat["updated_at"] <= waktu_feedback)
    )

    # -------------------------------------------------
    # DURASI MEMBACA SEBELUM FEEDBACK
    # -------------------------------------------------

    durasi = progress[
        (progress["user_id"] == user_id) &
        (progress["created_at"] <= waktu_feedback)
    ].copy()

    # Menjumlahkan durasi berdasarkan buku
    durasi_buku = (
        durasi.groupby("book_id")["duration"]
        .sum()
        .reset_index()
    )

    # -------------------------------------------------
    # DATA FAVORIT SEBELUM FEEDBACK
    # -------------------------------------------------

    favorit = favorites[
        (favorites["user_id"] == user_id) &
        (favorites["created_at"] <= waktu_feedback)
    ]["book_id"].unique()

    # -------------------------------------------------
    # MENGGABUNGKAN AKTIVITAS MEMBACA
    # -------------------------------------------------

    buku_dibaca = set(
        riwayat["book_id"].dropna().tolist()
    )

    buku_dibaca.update(
        durasi_buku["book_id"].dropna().tolist()
    )

    # Mengeluarkan buku yang sedang dinilai
    buku_dibaca.discard(target_book_id)

    aktivitas = pd.DataFrame({
        "book_id": pd.Series(
            list(buku_dibaca),
            dtype="Int64"
        )
    })

    # Menggabungkan informasi buku
    aktivitas = aktivitas.merge(
        books,
        on="book_id",
        how="left"
    )

    # Menggabungkan durasi membaca
    aktivitas = aktivitas.merge(
        durasi_buku,
        on="book_id",
        how="left"
    )

    aktivitas["duration"] = (
        aktivitas["duration"].fillna(0)
    )

    # Menandai buku yang difavoritkan
    aktivitas["favorite"] = (
        aktivitas["book_id"]
        .isin(favorit)
        .astype(int)
    )

    # Menandai buku yang selesai dibaca
    status_selesai = (
        riwayat[
            riwayat["selesai"] == True
        ]["book_id"]
        .dropna()
        .unique()
    )

    aktivitas["selesai"] = (
        aktivitas["book_id"]
        .isin(status_selesai)
        .astype(int)
    )

    total_buku = len(aktivitas)

    # -------------------------------------------------
    # FITUR BERDASARKAN GENRE BUKU TARGET
    # -------------------------------------------------

    genre_target = book_data["kategori_topik"]

    aktivitas_genre = aktivitas[
        aktivitas["kategori_topik"] == genre_target
    ]

    # -------------------------------------------------
    # FITUR BERDASARKAN JENIS BUKU TARGET
    # -------------------------------------------------

    jenis_target = book_data["jenis_buku"]

    aktivitas_jenis = aktivitas[
        aktivitas["jenis_buku"] == jenis_target
    ]

    # -------------------------------------------------
    # PERHITUNGAN FITUR
    # -------------------------------------------------

    rata_durasi = (
        aktivitas["duration"].mean()
        if total_buku > 0 else 0
    )

    rasio_favorit = (
        aktivitas["favorite"].sum() / total_buku
        if total_buku > 0 else 0
    )

    porsi_genre = (
        len(aktivitas_genre) / total_buku
        if total_buku > 0 else 0
    )

    porsi_jenis = (
        len(aktivitas_jenis) / total_buku
        if total_buku > 0 else 0
    )

    rata_durasi_genre = (
        aktivitas_genre["duration"].mean()
        if len(aktivitas_genre) > 0 else 0
    )

    rasio_selesai = (
        aktivitas["selesai"].sum() / total_buku
        if total_buku > 0 else 0
    )

    total_durasi = (
        aktivitas["duration"].sum() / DURASI_BAGI
    )

    # -------------------------------------------------
    # HASIL FITUR DATASET
    # -------------------------------------------------

    return {
        "user_id": user_id,
        "book_id": target_book_id,

        "jurusan": user_data["jurusan"],
        "semester": user_data["semester"],

        "jenis_buku": book_data["jenis_buku"],
        "kategori_topik": book_data["kategori_topik"],
        "tipe_konten": book_data["tipe_konten"],

        "jumlah_halaman": book_data["jumlah_halaman"],
        "status_premium": book_data["status_premium"],

        "rata_durasi_lain": rata_durasi,
        "rasio_favorit_lain": rasio_favorit,
        "jumlah_buku_lain": total_buku,

        "porsi_genre_dibaca": porsi_genre,
        "porsi_jenis_dibaca": porsi_jenis,

        "rata_durasi_genre_lain": rata_durasi_genre,
        "rasio_selesai": rasio_selesai,

        "total_menit_dibaca": total_durasi,

        # Sementara 0 karena fitur resume
        # belum dimasukkan ke pembentukan dataset.
        "total_resume": 0,

        "pengguna_baru": int(total_buku == 0),

        LABEL: int(feedback["cocok"])
    }


# =====================================================
# MEMBENTUK DATASET
# =====================================================

def main():

    print("Menghubungkan ke database SAFAE...")

    engine = koneksi_database()

    try:

        print("Mengambil data dari database...")

        (
            users,
            books,
            histories,
            progress,
            favorites,
            feedbacks
        ) = load_data(engine)

        (
            users,
            books,
            histories,
            progress,
            favorites,
            feedbacks
        ) = clean_data(
            users,
            books,
            histories,
            progress,
            favorites,
            feedbacks
        )

        # Menampilkan jumlah data
        print("\nJumlah pengguna:", len(users))
        print("Jumlah buku approved:", len(books))
        print("Jumlah riwayat membaca:", len(histories))
        print("Jumlah aktivitas durasi:", len(progress))
        print("Jumlah favorit:", len(favorites))
        print("Jumlah feedback:", len(feedbacks))

        if feedbacks.empty:
            print("\nTidak ada feedback. Dataset tidak dapat dibuat.")
            return

        # Membentuk fitur untuk setiap feedback
        hasil = []

        for _, feedback in feedbacks.iterrows():

            fitur = buat_fitur(
                feedback,
                users,
                books,
                histories,
                progress,
                favorites
            )

            if fitur is not None:
                hasil.append(fitur)

        if not hasil:
            print("\nTidak ada data yang berhasil diproses.")
            return

        dataset = pd.DataFrame(hasil)

        # Membuat folder output jika belum tersedia
        OUTPUT_DIR.mkdir(
            parents=True,
            exist_ok=True
        )

        # Menyimpan dataset ke CSV
        dataset.to_csv(
            OUTPUT_FILE,
            index=False,
            encoding="utf-8-sig"
        )

        print("\n================================")
        print("DATASET BERHASIL DIBUAT")
        print("================================")

        print("Lokasi:", OUTPUT_FILE)
        print("Jumlah baris:", len(dataset))

        print("\nDistribusi label:")
        print(dataset[LABEL].value_counts())

        print("\nPreview dataset:")
        print(dataset.head())

        print("\nJumlah label berbeda:")
        print(dataset[LABEL].nunique())

    finally:
        engine.dispose()


if __name__ == "__main__":
    main()
