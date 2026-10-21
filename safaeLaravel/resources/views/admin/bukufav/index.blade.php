
@extends('layouts.layoutsAdmin')
@section('title', 'Kelola Buku Favorit')
@section('content')
<link rel="stylesheet" href="{{ asset('css/admin-buku-favorit-index.css') }}?v=3">

<div class="saf-fav-page">

    {{-- HEADER --}}
    <div class="saf-fav-header">
        <div>
            <div class="saf-fav-eyebrow">
                <i class="fa-solid fa-heart"></i>
                SAFAE FAVORITE MANAGEMENT
            </div>
            <h1>Kelola <span>Buku Favorit</span></h1>
            <p>Pantau dan kelola buku yang ditambahkan pengguna ke daftar favorit.</p>
        </div>
        <div class="saf-fav-header-icon">
            <i class="fa-solid fa-heart"></i>
        </div>
    </div>

    {{-- NOTIFIKASI --}}
    @if(session('success'))
        <div class="saf-fav-alert">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="saf-fav-alert error">
            <i class="fa-solid fa-circle-exclamation"></i>
            {{ session('error') }}
        </div>
    @endif

    {{-- STATISTIK --}}
    <div class="saf-fav-stats">
        <div class="saf-fav-stat">
            <div class="saf-fav-stat-icon pink">
                <i class="fa-solid fa-heart"></i>
            </div>
            <div>
                <span>Total Favorit</span>
                <strong>{{ number_format($totalFavorites, 0, ',', '.') }}</strong>
                <small>Aktivitas favorit pembaca</small>
            </div>
        </div>

        <div class="saf-fav-stat">
            <div class="saf-fav-stat-icon blue">
                <i class="fa-solid fa-book-open"></i>
            </div>
            <div>
                <span>Buku Difavoritkan</span>
                <strong>{{ number_format($totalBooks, 0, ',', '.') }}</strong>
                <small>Judul buku yang disukai</small>
            </div>
        </div>

        <div class="saf-fav-stat">
            <div class="saf-fav-stat-icon purple">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <span>Pengguna Aktif</span>
                <strong>{{ number_format($totalUsers, 0, ',', '.') }}</strong>
                <small>Pengguna yang memiliki favorit</small>
            </div>
        </div>
    </div>

    {{-- PANEL FAVORIT --}}
    <section class="saf-fav-panel">
        <div class="saf-fav-panel-heading">
            <div>
                <span class="saf-fav-overline">FAVORITE LIBRARY</span>
                <h2><i class="fa-solid fa-bookmark"></i> Daftar Buku Favorit</h2>
                <p>Informasi buku yang disimpan oleh pengguna Safae.</p>
            </div>
            <div class="saf-fav-total">
                <i class="fa-solid fa-heart"></i>
                {{ $favorites->total() }} Favorit
            </div>
        </div>

        {{-- PENCARIAN --}}
        <form action="{{ route('admin.favorit.index') }}" method="GET" class="saf-fav-search-form">
            <div class="saf-fav-search-field">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="search" name="search" value="{{ request('search') }}"
                    placeholder="Cari username atau judul buku..." autocomplete="off">
            </div>

            <button type="submit" class="saf-fav-search-button">
                <i class="fa-solid fa-magnifying-glass"></i>
                Cari Buku
            </button>

            @if(request('search'))
                <a href="{{ route('admin.favorit.index') }}" class="saf-fav-reset">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </a>
            @endif
        </form>

        @if(request('search'))
            <div class="saf-fav-search-info">
                Ditemukan {{ $favorites->total() }} hasil untuk
                <strong>"{{ request('search') }}"</strong>
            </div>
        @endif

        {{-- DAFTAR --}}
        <div class="saf-fav-list">
            @forelse($favorites as $fav)
                @php
                    $user = $fav->user;
                    $book = $fav->book;
                    $cover = $book?->image_path ?: ($book?->cover_image ?? null);
                    $cover = $cover ? preg_replace('#^(public/|storage/)+#', '', ltrim($cover, '/')) : null;
                    $avatar = $user?->foto_profil ?: ($user?->profile_image ?? null);
                    $avatar = $avatar ? preg_replace('#^(public/|storage/)+#', '', ltrim($avatar, '/')) : null;
                @endphp

                <article class="saf-fav-item">
                    <div class="saf-fav-book-cover">
                        @if($cover)
                            <img src="{{ asset('storage/'.$cover) }}" alt="Cover {{ $book?->title ?? 'Buku' }}">
                        @else
                            <div class="saf-fav-no-cover">
                                <i class="fa-solid fa-book-open"></i>
                            </div>
                        @endif
                    </div>

                    <div class="saf-fav-book-body">
                        <div class="saf-fav-book-top">
                            <span class="saf-fav-book-id">BUKU #{{ $book?->id ?? '-' }}</span>
                            <span class="saf-fav-genre">
                                <i class="fa-solid fa-layer-group"></i>
                                {{ $book?->genre ?? 'Tanpa Genre' }}
                            </span>
                        </div>

                        <h3>{{ $book?->title ?? 'Buku tidak ditemukan' }}</h3>

                        <div class="saf-fav-book-meta">
                            <span>
                                <i class="fa-solid fa-feather-pointed"></i>
                                {{ $book?->author ?? 'Penulis tidak diketahui' }}
                            </span>
                            <span>
                                <i class="fa-regular fa-calendar"></i>
                                {{ $fav->created_at?->format('d M Y') ?? '-' }}
                            </span>
                        </div>

                        <div class="saf-fav-user-line">
                            @if($avatar)
                                <img src="{{ asset('storage/'.$avatar) }}" alt="Foto pengguna">
                            @else
                                <div class="saf-fav-user-placeholder">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                            @endif

                            <div>
                                <strong>{{ $user?->username ?? 'Pengguna tidak ditemukan' }}</strong>
                                <small>{{ $user?->email ?? '-' }}</small>
                            </div>

                            <span class="saf-fav-user-tag">
                                <i class="fa-solid fa-heart"></i> Favorit #{{ $fav->id }}
                            </span>
                        </div>
                    </div>

                    <div class="saf-fav-item-actions">
                        <a href="{{ route('admin.favorit.show', $fav->id) }}" class="saf-fav-action-detail">
                            <i class="fa-solid fa-eye"></i>
                            Lihat Detail
                        </a>

                        <form action="{{ route('admin.favorit.destroy', $fav->id) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus buku ini dari favorit pengguna?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="saf-fav-action-delete">
                                <i class="fa-solid fa-trash-can"></i>
                                Hapus
                            </button>
                        </form>
                    </div>
                </article>
            @empty
                <div class="saf-fav-empty">
                    <i class="fa-regular fa-heart"></i>
                    <h3>{{ request('search') ? 'Buku tidak ditemukan' : 'Belum ada buku favorit' }}</h3>
                    <p>{{ request('search') ? 'Coba cari menggunakan username atau judul buku lain.' : 'Buku yang difavoritkan pengguna akan muncul di halaman ini.' }}</p>
                </div>
            @endforelse
        </div>

        @if($favorites->hasPages())
            <div class="saf-fav-pagination">
                {{ $favorites->links() }}
            </div>
        @endif
    </section>

    {{-- TOP 3 FAVORIT --}}
    @if($popularBooks->isNotEmpty())
        <section class="saf-fav-popular">
            <div class="saf-fav-popular-heading">
                <div>
                    <span class="saf-fav-overline">MOST FAVORITED BOOKS</span>
                    <h2><i class="fa-solid fa-fire-flame-curved"></i> Buku Paling Difavoritkan</h2>
                    <p>Tiga buku dengan jumlah favorit terbanyak di Safae.</p>
                </div>
                <div class="saf-fav-popular-label">
                    <i class="fa-solid fa-trophy"></i> TOP 3
                </div>
            </div>

            <div class="saf-fav-popular-grid">
                @foreach($popularBooks as $index => $book)
                    @php
                        $popularCover = $book->image_path ?: ($book->cover_image ?? null);
                        $popularCover = $popularCover ? preg_replace('#^(public/|storage/)+#', '', ltrim($popularCover, '/')) : null;
                    @endphp

                    <div class="saf-fav-popular-card">
                        <span class="saf-fav-rank">#{{ $index + 1 }}</span>

                        @if($popularCover)
                            <img src="{{ asset('storage/'.$popularCover) }}" alt="Cover {{ $book->title }}">
                        @else
                            <div class="saf-fav-popular-no-cover">
                                <i class="fa-solid fa-book"></i>
                            </div>
                        @endif

                        <div class="saf-fav-popular-info">
                            <h3>{{ $book->title }}</h3>
                            <p>{{ $book->author ?? 'Penulis tidak diketahui' }}</p>
                            <strong>
                                <i class="fa-solid fa-heart"></i>
                                {{ $book->favorites_count }} Favorit
                            </strong>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
</div>
@endsection
