
@extends('layouts.app')
@section('title', 'Buku Premium - Safae')
@section('content')
<link rel="stylesheet" href="{{ asset('css/buku-premium.css') }}">

<div class="premium-page">
    <section class="premium-hero">
        <div class="premium-hero-content">
            <span class="premium-eyebrow">
                <i class="fa-solid fa-crown"></i>
                SAFAE PREMIUM COLLECTION
            </span>
            <h1>Jelajahi Cerita <span>Premium</span></h1>
            <p>Temukan karya pilihan dari penulis Safae. Nikmati bab gratis dan lanjutkan cerita favoritmu dengan poin.</p>

            <div class="premium-hero-benefits">
                <span><i class="fa-solid fa-book-open"></i> Bab Awal Gratis</span>
                <span><i class="fa-solid fa-coins"></i> 50 Poin per Bab Premium</span>
                <span><i class="fa-solid fa-unlock"></i> Akses Seluruh Bab</span>
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
                <p>Pilih cerita yang ingin kamu baca dan temukan pengalaman membaca yang berbeda.</p>
            </div>

            <div class="premium-total">
                <i class="fa-solid fa-book"></i>
                {{ $books instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator ? $books->total() : $books->count() }} Buku
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
                <p>Belum ada buku yang sesuai dengan pencarianmu. Coba kata kunci atau genre lainnya.</p>

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
