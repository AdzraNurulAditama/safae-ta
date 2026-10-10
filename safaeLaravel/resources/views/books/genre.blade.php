@extends('layouts.app')

@section('title', 'Genre Buku')

@section('content')

<style>
    /* ================= HEADER & FILTER ================= */
    .page-title {
        color: #f1f5f9;
        font-weight: 800;
        margin-bottom: 20px;
    }

    .filter-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .filter-bar .btn {
        border-radius: 14px;
        padding: 8px 20px;
        font-weight: 600;
        border: 1px solid #334155;
        background: #1e293b;
        color: #94a3b8;
        transition: all 0.3s ease;
    }

    .filter-bar .btn:hover {
        background: #334155;
        color: #38bdf8;
        transform: translateY(-2px);
    }

    .filter-bar .btn-primary {
        background: #38bdf8 !important;
        border-color: #38bdf8 !important;
        color: #0f172a !important;
        box-shadow: 0 4px 15px rgba(56, 189, 248, 0.2);
    }

    /* ================= SEARCH BAR MODERN ================= */
    .search-wrapper {
        position: relative;
        min-width: 280px;
    }

    .search-wrapper .search-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
    }

    .search-wrapper .form-control {
        background: #1e293b;
        border: 1px solid #334155;
        color: #fff;
        border-radius: 14px;
        padding: 12px 15px 12px 45px;
        width: 100%;
        transition: 0.3s;
    }

    .search-wrapper .form-control:focus {
        box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.15);
        border-color: #38bdf8;
        outline: none;
    }

    .search-wrapper .form-control::placeholder {
        color: #64748b;
    }

    .btn-search {
        background: #38bdf8;
        color: #0f172a;
        border: none;
        border-radius: 14px;
        font-weight: 700;
        padding: 0 20px;
        transition: 0.3s;
    }
    
    .btn-search:hover { background: #7dd3fc; }

    /* ================= GRID BUKU (SETTING 5 KOLOM) ================= */
    .book-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr); /* Default 5 kolom untuk desktop */
        gap: 25px;
        margin-top: 20px;
    }

    /* ================= CARD ================= */
    .book-card {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 20px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: 0.3s ease;
        height: 100%;
    }

    .book-card:hover {
        transform: translateY(-8px);
        border-color: #38bdf8;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
    }

    /* ================= COVER ================= */
    .card-img-wrapper {
        width: 100%;
        height: 280px;
        overflow: hidden;
        position: relative;
        background: #0f172a;
    }

    .book-cover {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .book-card:hover .book-cover {
        transform: scale(1.05);
    }

    /* ================= CONTENT ================= */
    .book-content {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .book-title {
        color: #f8fafc;
        font-size: 1.05rem;
        font-weight: 700;
        line-height: 1.4;
        margin-bottom: 15px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 42px;
    }

    .book-meta {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #94a3b8;
        font-size: 0.85rem;
        margin-bottom: 8px;
    }

    .book-meta i {
        width: 16px;
        color: #38bdf8;
        text-align: center;
    }

    /* ================= FOOTER BUTTONS ================= */
    .book-footer {
        margin-top: auto;
        padding-top: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-detail {
        flex: 1;
        background: rgba(56, 189, 248, 0.1);
        color: #38bdf8;
        border: 1px solid rgba(56, 189, 248, 0.2);
        padding: 10px 15px;
        border-radius: 12px;
        font-weight: 700;
        text-decoration: none;
        text-align: center;
        transition: 0.3s;
    }

    .btn-detail:hover {
        background: #38bdf8;
        color: #0f172a;
    }

    .btn-fav {
        width: 42px;
        height: 42px;
        border: 1px solid #334155;
        border-radius: 12px;
        background: #1e293b;
        color: #f87171;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.3s;
    }

    .btn-fav:hover, .btn-fav.active {
        background: #ef4444;
        color: #fff;
        border-color: #ef4444;
    }

    /* ================= EMPTY STATE ================= */
    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 80px 20px;
        color: #94a3b8;
        background: #1e293b;
        border: 2px dashed #334155;
        border-radius: 20px;
        margin-top: 20px;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 20px;
        color: #475569;
    }

    /* ================= RESPONSIVE ================= */
    @media(max-width: 1400px) {
        .book-grid { grid-template-columns: repeat(4, 1fr); } /* 4 kolom untuk layar laptop sedang */
    }

    @media(max-width: 1100px) {
        .book-grid { grid-template-columns: repeat(3, 1fr); } /* 3 kolom untuk tablet landscape */
    }

    @media(max-width: 768px) {
        .book-grid {
            grid-template-columns: repeat(2, 1fr); /* 2 kolom untuk tablet portrait/HP besar */
            gap: 15px;
        }

        .card-img-wrapper { height: 230px; }
        
        .search-bar { width: 100%; }
        .search-wrapper { width: 100%; }
        .search-wrapper .form-control { min-width: unset; }
    }

    @media(max-width: 480px) {
        .book-grid { grid-template-columns: repeat(1, 1fr); } /* 1 kolom untuk HP kecil agar tetap jelas terbaca */
    }
</style>

<div class="container-fluid">

    <h3 class="page-title"><i class="fa-solid fa-layer-group me-2 text-primary"></i>Koleksi Genre</h3>

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3 border-bottom border-secondary pb-4">

        <div class="filter-bar">
            <a href="{{ route('genre.index') }}" class="btn {{ empty($current_genre) ? 'btn-primary' : '' }}">
                Semua
            </a>
            @foreach($all_genres as $g)
                <a href="{{ route('genre.index', ['genre' => $g]) }}" class="btn {{ ($current_genre ?? null) == $g ? 'btn-primary' : '' }}">
                    {{ $g }}
                </a>
            @endforeach
        </div>

        <form method="GET" action="{{ route('genre.index') }}" class="search-bar d-flex gap-2">
            <input type="hidden" name="genre" value="{{ $current_genre }}">
            
            <div class="search-wrapper">
                <i class="fa fa-search search-icon"></i>
                <input type="text" name="search" class="form-control" placeholder="Cari buku, penulis..." value="{{ request('search') }}">
            </div>

            <button type="submit" class="btn-search">Cari</button>
        </form>

    </div>

    <div class="book-grid">
        @forelse($books_to_show as $book)
            <div class="book-card">
                
                <div class="card-img-wrapper">
                    <img src="{{ $book->image_path ? asset($book->image_path) : 'https://via.placeholder.com/300x400?text=No+Cover' }}"
                         class="book-cover"
                         alt="{{ $book->title }}">
                </div>

                <div class="book-content">
                    <div class="book-title" title="{{ $book->title }}">
                        {{ $book->title }}
                    </div>

                    <div class="book-meta">
                        <i class="fa-solid fa-user"></i>
                        <span class="text-truncate">{{ $book->author }}</span>
                    </div>
                    <div class="book-meta">
                        <i class="fa-solid fa-tag"></i>
                        <span>{{ $book->genre }}</span>
                    </div>
                    <div class="book-meta">
                        <i class="fa-solid fa-calendar"></i>
                        <span>{{ $book->year }}</span>
                    </div>

                    <div class="book-footer">
                        <a href="{{ route('book.show', $book->id) }}" class="btn-detail">
                            <i class="fa-solid fa-book-open me-1"></i> Baca
                        </a>

                        @auth
                            @if(in_array($book->id, $favorites))
                                <button class="btn-fav active" disabled title="Sudah Favorit">
                                    <i class="fa-solid fa-heart"></i>
                                </button>
                            @else
                                <form action="{{ route('favorite.tambah') }}" method="POST" class="m-0">
                                    @csrf
                                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                                    <button class="btn-fav" title="Tambah Favorit">
                                        <i class="fa-regular fa-heart"></i>
                                    </button>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn-fav text-decoration-none" title="Login untuk favorit">
                                <i class="fa-regular fa-heart"></i>
                            </a>
                        @endauth
                    </div>
                </div>

            </div>
        @empty
            <div class="empty-state shadow-sm">
                <i class="fa-solid fa-book-open"></i>
                <h4 class="text-white fw-bold mb-2">Tidak ada buku ditemukan</h4>
                <p>Coba gunakan kata kunci pencarian lain atau pilih genre yang berbeda.</p>
            </div>
        @endforelse
    </div>

</div>

@endsection