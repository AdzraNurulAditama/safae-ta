
@extends('layouts.app')

@section('title', 'Buku Premium - Safae')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

:root {
    --premium-blue: #dcecff;
    --premium-blue-dark: #789bd1;
    --premium-purple: #e9e2ff;
    --premium-purple-dark: #9b88d5;
    --premium-pink: #ffe4ed;
    --premium-pink-dark: #d98eaa;
    --premium-mint: #ddf4e9;
    --premium-text: #45445b;
    --premium-muted: #88879b;
    --premium-white: #ffffff;
}

.premium-page {
    font-family: 'Plus Jakarta Sans', sans-serif;
    max-width: 1250px;
    margin: 0 auto;
    padding: 35px 25px 60px;
    color: var(--premium-text);
}

/* =========================
   HERO SECTION
========================= */

.premium-hero {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: space-between;
    min-height: 330px;
    padding: 55px 65px;
    margin-bottom: 55px;
    border-radius: 32px;
    overflow: hidden;
    background:
        radial-gradient(circle at 90% 10%, rgba(255,255,255,.8), transparent 28%),
        linear-gradient(120deg, #e4efff 0%, #eee8ff 52%, #ffeaf1 100%);
    box-shadow: 0 12px 35px rgba(143, 151, 199, .12);
}

.premium-hero::before {
    content: "";
    position: absolute;
    width: 250px;
    height: 250px;
    border-radius: 50%;
    background: rgba(255,255,255,.35);
    right: 140px;
    top: -145px;
}

.premium-hero::after {
    content: "";
    position: absolute;
    width: 170px;
    height: 170px;
    border-radius: 50%;
    background: rgba(255,255,255,.25);
    right: 300px;
    bottom: -115px;
}

.premium-hero-content {
    position: relative;
    z-index: 2;
    max-width: 760px;
}

.premium-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    padding: 10px 17px;
    margin-bottom: 22px;
    border-radius: 30px;
    background: rgba(255,255,255,.75);
    color: #8875bf;
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 1.3px;
}

.premium-eyebrow i {
    color: #d9a84d;
    font-size: 15px;
}

.premium-hero h1 {
    margin: 0 0 18px;
    color: #48445f;
    font-size: clamp(34px, 4vw, 48px);
    font-weight: 800;
    line-height: 1.2;
    letter-spacing: -1.5px;
}

.premium-hero h1 span {
    color: #9b83d1;
}

.premium-hero-content > p {
    max-width: 650px;
    margin: 0;
    color: #77758d;
    font-size: 15px;
    line-height: 1.9;
}

.premium-hero-benefits {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 28px;
}

.premium-hero-benefits span {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 11px 15px;
    border: 1px solid rgba(255,255,255,.8);
    border-radius: 30px;
    background: rgba(255,255,255,.7);
    color: #696780;
    font-size: 12px;
    font-weight: 700;
}

.premium-hero-benefits i {
    color: #9b83d1;
}

.premium-hero-icon {
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    width: 180px;
    height: 180px;
    margin-left: 35px;
    border: 1px solid rgba(255,255,255,.8);
    border-radius: 45px;
    background: rgba(255,255,255,.48);
    transform: rotate(8deg);
}

.premium-hero-icon i {
    color: #c3a4df;
    font-size: 95px;
    filter: drop-shadow(0 8px 8px rgba(140, 120, 180, .15));
}

/* =========================
   ALERT
========================= */

.premium-alert {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 17px 22px;
    margin-bottom: 25px;
    border-radius: 15px;
    font-size: 14px;
    font-weight: 600;
}

.premium-alert.success {
    color: #43866c;
    background: #e3f6ed;
    border: 1px solid #ccebdc;
}

.premium-alert.error {
    color: #b76e84;
    background: #fff0f3;
    border: 1px solid #f5d5df;
}

/* =========================
   SECTION HEADING
========================= */

.premium-section {
    margin-top: 15px;
}

.premium-section-heading {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 30px;
}

.premium-label {
    display: inline-block;
    margin-bottom: 12px;
    color: #a18acb;
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 2px;
}

.premium-section-heading h2 {
    display: flex;
    align-items: center;
    gap: 13px;
    margin: 0 0 12px;
    color: #48465f;
    font-size: 30px;
    font-weight: 800;
}

.premium-section-heading h2 i {
    color: #ad96d8;
    font-size: 25px;
}

.premium-section-heading p {
    margin: 0;
    color: var(--premium-muted);
    font-size: 14px;
    line-height: 1.7;
}

.premium-total {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 13px 20px;
    border: 1px solid #e5dcf7;
    border-radius: 14px;
    background: #f4f0ff;
    color: #8978b9;
    font-size: 13px;
    font-weight: 800;
    white-space: nowrap;
}

/* =========================
   SEARCH & FILTER
========================= */

.premium-filter {
    display: flex;
    align-items: center;
    gap: 13px;
    padding: 20px;
    margin-bottom: 35px;
    border: 1px solid #eee9f7;
    border-radius: 20px;
    background: #fff;
    box-shadow: 0 7px 22px rgba(143, 135, 180, .07);
}

.premium-search {
    display: flex;
    align-items: center;
    flex: 1;
    min-width: 200px;
    gap: 12px;
    padding: 0 17px;
    height: 52px;
    border: 1px solid #e9e5f2;
    border-radius: 13px;
    background: #faf9fd;
}

.premium-search i {
    color: #a194c6;
    font-size: 16px;
}

.premium-search input {
    width: 100%;
    height: 100%;
    border: none;
    outline: none;
    background: transparent;
    color: var(--premium-text);
    font-family: inherit;
    font-size: 13px;
}

.premium-search input::placeholder {
    color: #aaa7b9;
}

.premium-select {
    width: 210px;
    height: 52px;
    padding: 0 15px;
    border: 1px solid #e9e5f2;
    border-radius: 13px;
    outline: none;
    background: #faf9fd;
    color: #77738e;
    font-family: inherit;
    font-size: 13px;
    cursor: pointer;
}

.premium-filter-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    height: 52px;
    padding: 0 24px;
    border: none;
    border-radius: 13px;
    background: linear-gradient(135deg, #a99bd9, #8f9fd7);
    color: white;
    font-family: inherit;
    font-size: 13px;
    font-weight: 800;
    cursor: pointer;
    transition: .25s;
}

.premium-filter-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 7px 17px rgba(143, 135, 196, .25);
}

.premium-reset {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 48px;
    height: 48px;
    flex-shrink: 0;
    border-radius: 13px;
    background: #fff0f4;
    color: #d28ca8;
    text-decoration: none;
    transition: .2s;
}

.premium-reset:hover {
    background: #f9dce7;
    color: #bd6d8c;
}

/* =========================
   BOOK GRID
========================= */

.premium-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 28px;
}

.premium-card {
    min-width: 0;
    overflow: hidden;
    border: 1px solid #eeeaf5;
    border-radius: 23px;
    background: #fff;
    box-shadow: 0 8px 25px rgba(125, 122, 160, .08);
    transition: transform .25s, box-shadow .25s;
}

.premium-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 15px 32px rgba(125, 122, 160, .14);
}

.premium-cover-wrapper {
    position: relative;
    height: 270px;
    overflow: hidden;
    background: linear-gradient(135deg, #e6edff, #f4eaff, #ffeaf1);
}

.premium-cover {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .4s;
}

.premium-card:hover .premium-cover {
    transform: scale(1.04);
}

.premium-cover-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 13px;
    width: 100%;
    height: 100%;
    color: #a294cf;
}

.premium-cover-empty i {
    font-size: 65px;
}

.premium-cover-empty span {
    font-size: 13px;
    font-weight: 800;
    letter-spacing: 3px;
}

.premium-card-badge {
    position: absolute;
    top: 15px;
    left: 15px;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 9px 13px;
    border: 1px solid rgba(255,255,255,.8);
    border-radius: 30px;
    background: rgba(255,255,255,.92);
    color: #a68bcb;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: .8px;
}

/* =========================
   BOOK CONTENT
========================= */

.premium-card-content {
    display: flex;
    flex-direction: column;
    padding: 23px;
}

.premium-genre {
    align-self: flex-start;
    padding: 7px 12px;
    border-radius: 20px;
    background: #f0ebff;
    color: #9280c3;
    font-size: 11px;
    font-weight: 700;
}

.premium-card-content h3 {
    display: -webkit-box;
    overflow: hidden;
    margin: 15px 0 9px;
    color: #49465f;
    font-size: 19px;
    font-weight: 800;
    line-height: 1.5;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.premium-author {
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 0 0 13px;
    color: #9995aa;
    font-size: 12px;
    font-weight: 600;
}

.premium-author i {
    color: #b39bd4;
}

.premium-description {
    min-height: 63px;
    margin: 0 0 18px;
    color: #88869a;
    font-size: 12px;
    line-height: 1.8;
}

.premium-card-stats {
    display: flex;
    align-items: center;
    gap: 18px;
    padding: 14px 0;
    margin-bottom: 17px;
    border-top: 1px solid #f0edf5;
    border-bottom: 1px solid #f0edf5;
}

.premium-card-stats span {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    color: #9290a2;
    font-size: 11px;
    font-weight: 600;
}

.premium-card-stats i {
    color: #aa9acb;
}

.premium-card-footer {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.premium-point-info {
    display: flex;
    align-items: center;
    gap: 9px;
    color: #918ca3;
    font-size: 11px;
}

.premium-point-info > i {
    color: #d6ac5f;
    font-size: 17px;
}

.premium-point-info strong {
    color: #a48bca;
    font-size: 13px;
}

.premium-read-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    min-height: 47px;
    padding: 12px 15px;
    border-radius: 12px;
    background: linear-gradient(120deg, #a99bd9, #8fa5d9);
    color: white;
    font-size: 12px;
    font-weight: 800;
    text-decoration: none;
    transition: .25s;
}

.premium-read-btn:hover {
    background: linear-gradient(120deg, #9382c8, #7e94ce);
    color: white;
    transform: translateY(-2px);
}

/* =========================
   PAGINATION
========================= */

.premium-pagination {
    display: flex;
    justify-content: center;
    margin-top: 40px;
}

.premium-pagination nav {
    display: flex;
    justify-content: center;
}

/* =========================
   EMPTY STATE
========================= */

.premium-empty {
    padding: 65px 25px;
    border: 1px dashed #dcd5ee;
    border-radius: 25px;
    background: #fcfaff;
    text-align: center;
}

.premium-empty-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 95px;
    height: 95px;
    margin: 0 auto 22px;
    border-radius: 30px;
    background: #eee9ff;
    color: #a291cf;
    font-size: 38px;
}

.premium-empty h3 {
    margin-bottom: 12px;
    color: #514d69;
    font-size: 21px;
    font-weight: 800;
}

.premium-empty p {
    max-width: 480px;
    margin: 0 auto 23px;
    color: #9290a2;
    font-size: 13px;
    line-height: 1.8;
}

.premium-empty a {
    display: inline-block;
    padding: 12px 22px;
    border-radius: 12px;
    background: #a99bd9;
    color: white;
    font-size: 12px;
    font-weight: 800;
    text-decoration: none;
}

/* =========================
   PREMIUM INFORMATION
========================= */

.premium-info {
    display: flex;
    align-items: flex-start;
    gap: 22px;
    padding: 28px 32px;
    margin-top: 55px;
    border: 1px solid #e9e1f7;
    border-radius: 22px;
    background: linear-gradient(120deg, #f0edff, #fff0f4);
}

.premium-info-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    width: 55px;
    height: 55px;
    border-radius: 18px;
    background: rgba(255,255,255,.8);
    color: #aa91ce;
    font-size: 23px;
}

.premium-info h3 {
    margin: 2px 0 10px;
    color: #59546e;
    font-size: 16px;
    font-weight: 800;
}

.premium-info p {
    margin: 0;
    color: #858196;
    font-size: 12px;
    line-height: 1.9;
}

/* =========================
   RESPONSIVE
========================= */

@media (max-width: 992px) {
    .premium-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .premium-hero {
        padding: 45px;
    }

    .premium-hero-icon {
        width: 135px;
        height: 135px;
    }

    .premium-hero-icon i {
        font-size: 70px;
    }
}

@media (max-width: 700px) {
    .premium-page {
        padding: 20px 15px 40px;
    }

    .premium-hero {
        flex-direction: column;
        align-items: flex-start;
        gap: 25px;
        padding: 32px 25px;
        border-radius: 24px;
    }

    .premium-hero h1 {
        font-size: 32px;
    }

    .premium-hero-content > p {
        font-size: 13px;
    }

    .premium-hero-icon {
        width: 95px;
        height: 95px;
        margin: 0;
        border-radius: 25px;
    }

    .premium-hero-icon i {
        font-size: 48px;
    }

    .premium-hero-benefits {
        gap: 8px;
    }

    .premium-hero-benefits span {
        font-size: 10px;
    }

    .premium-section-heading {
        align-items: flex-start;
        flex-direction: column;
    }

    .premium-section-heading h2 {
        font-size: 25px;
    }

    .premium-filter {
        flex-direction: column;
        align-items: stretch;
        padding: 15px;
    }

    .premium-search,
    .premium-select,
    .premium-filter-btn {
        width: 100%;
    }

    .premium-grid {
        grid-template-columns: 1fr;
        gap: 22px;
    }

    .premium-cover-wrapper {
        height: 290px;
    }

    .premium-info {
        padding: 22px;
        gap: 15px;
    }
}
</style>

<div class="premium-page">

    {{-- HERO --}}
    <section class="premium-hero">
        <div class="premium-hero-content">
            <span class="premium-eyebrow">
                <i class="fa-solid fa-crown"></i>
                SAFAE PREMIUM COLLECTION
            </span>

            <h1>Jelajahi Cerita <span>Premium</span></h1>

            <p>
                Temukan karya pilihan dari penulis Safae. Nikmati bab gratis
                dan lanjutkan cerita favoritmu dengan poin.
            </p>

            <div class="premium-hero-benefits">
                <span>
                    <i class="fa-solid fa-book-open"></i>
                    Bab Awal Gratis
                </span>

                <span>
                    <i class="fa-solid fa-coins"></i>
                    50 Poin per Bab Premium
                </span>

                <span>
                    <i class="fa-solid fa-unlock"></i>
                    Akses Seluruh Bab
                </span>
            </div>
        </div>

        <div class="premium-hero-icon">
            <i class="fa-solid fa-crown"></i>
        </div>
    </section>

    {{-- NOTIFIKASI --}}
    @if(session('success'))
        <div class="premium-alert success">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="premium-alert error">
            <i class="fa-solid fa-circle-exclamation"></i>
            {{ session('error') }}
        </div>
    @endif

    {{-- DAFTAR BUKU PREMIUM --}}
    <section class="premium-section">

        <div class="premium-section-heading">
            <div>
                <span class="premium-label">KOLEKSI EKSKLUSIF</span>

                <h2>
                    <i class="fa-solid fa-gem"></i>
                    Buku Premium
                </h2>

                <p>
                    Pilih cerita yang ingin kamu baca dan temukan pengalaman
                    membaca yang berbeda.
                </p>
            </div>

            <div class="premium-total">
                <i class="fa-solid fa-book"></i>
                {{ $books instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator ? $books->total() : $books->count() }}
                Buku
            </div>
        </div>

        {{-- SEARCH DAN FILTER GENRE --}}
        <form method="GET" action="{{ url('/buku-premium') }}" class="premium-filter">

            <div class="premium-search">
                <i class="fa-solid fa-magnifying-glass"></i>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari judul buku atau penulis..."
                >
            </div>

            <select name="genre" class="premium-select">
                <option value="">Semua Genre</option>

                @foreach($genres as $genre)
                    <option
                        value="{{ $genre }}"
                        {{ request('genre') == $genre ? 'selected' : '' }}
                    >
                        {{ $genre }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="premium-filter-btn">
                <i class="fa-solid fa-filter"></i>
                Terapkan
            </button>

            @if(request('search') || request('genre'))
                <a href="{{ url('/buku-premium') }}" class="premium-reset">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
            @endif

        </form>

        {{-- TAMPILKAN BUKU --}}
        @if($books->count() > 0)

            <div class="premium-grid">

                @foreach($books as $book)

                    @php
                        $cover = $book->image_path
                            ? preg_replace('#^(public/|storage/)#', '', $book->image_path)
                            : null;
                    @endphp

                    <article class="premium-card">

                        {{-- COVER BUKU --}}
                        <div class="premium-cover-wrapper">

                            @if($cover)
                                <img
                                    src="{{ asset('storage/' . $cover) }}"
                                    alt="{{ $book->title }}"
                                    class="premium-cover"
                                >
                            @else
                                <div class="premium-cover-empty">
                                    <i class="fa-solid fa-book-open"></i>
                                    <span>SAFAE</span>
                                </div>
                            @endif

                            <span class="premium-card-badge">
                                <i class="fa-solid fa-crown"></i>
                                PREMIUM
                            </span>

                        </div>

                        {{-- INFORMASI BUKU --}}
                        <div class="premium-card-content">

                            <span class="premium-genre">
                                {{ $book->genre ?? 'Cerita' }}
                            </span>

                            <h3 title="{{ $book->title }}">
                                {{ $book->title }}
                            </h3>

                            <p class="premium-author">
                                <i class="fa-regular fa-user"></i>
                                {{ $book->author ?? 'Penulis Safae' }}
                            </p>

                            <p class="premium-description">
                                {{ \Illuminate\Support\Str::limit($book->description ?? 'Jelajahi cerita menarik dari koleksi premium Safae.', 105) }}
                            </p>

                            {{-- STATISTIK BUKU --}}
                            <div class="premium-card-stats">

                                <span>
                                    <i class="fa-solid fa-eye"></i>
                                    {{ number_format($book->reader_count ?? 0) }}
                                </span>

                                <span>
                                    <i class="fa-solid fa-list"></i>
                                    {{ $book->chapters_count ?? 0 }} Bab
                                </span>

                            </div>

                            {{-- TOMBOL MULAI MEMBACA --}}
                            <div class="premium-card-footer">

                                <div class="premium-point-info">
                                    <i class="fa-solid fa-coins"></i>

                                    <span>
                                        <strong>50 Poin</strong> / Bab Premium
                                    </span>
                                </div>

                                <a
                                    href="{{ route('book.show', ['id' => $book->id, 'page' => 1]) }}"
                                    class="premium-read-btn"
                                >
                                    <i class="fa-solid fa-book-open"></i>
                                    Mulai Membaca
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>

                            </div>

                        </div>

                    </article>

                @endforeach

            </div>

            {{-- PAGINATION --}}
            @if($books instanceof \Illuminate\Contracts\Pagination\Paginator)
                <div class="premium-pagination">
                    {{ $books->withQueryString()->links() }}
                </div>
            @endif

        @else

            {{-- JIKA TIDAK ADA BUKU --}}
            <div class="premium-empty">

                <div class="premium-empty-icon">
                    <i class="fa-solid fa-book-open"></i>
                </div>

                <h3>Belum Ada Buku Premium</h3>

                <p>
                    Belum ada buku yang sesuai dengan pencarianmu.
                    Coba kata kunci atau genre lainnya.
                </p>

                <a href="{{ url('/buku-premium') }}">
                    Lihat Semua Buku
                </a>

            </div>

        @endif

    </section>

    {{-- INFORMASI PREMIUM --}}
    <section class="premium-info">

        <div class="premium-info-icon">
            <i class="fa-solid fa-lightbulb"></i>
        </div>

        <div>
            <h3>Bagaimana Cara Membaca Buku Premium?</h3>

            <p>
                Kamu bisa membaca bab gratis terlebih dahulu.
                Untuk melanjutkan bab premium, gunakan 50 poin per bab
                atau pilih akses seluruh bab seharga Rp15.000 melalui
                simulasi pembayaran pada halaman bacaan.
            </p>
        </div>

    </section>

</div>

@endsection
