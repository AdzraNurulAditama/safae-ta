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

    /* ================= GRID BUKU (5 KOLOM) ================= */
    .book-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
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
        position: relative;
    }

    .book-card:hover {
        transform: translateY(-8px);
        border-color: #38bdf8;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
    }

    /* ================= COVER & BOOKMARK FLOATING ================= */
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

    .btn-bookmark-floating {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: rgba(15, 23, 42, 0.75);
        backdrop-filter: blur(6px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        color: #cbd5e1;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.3s ease;
        z-index: 10;
        cursor: pointer;
    }

    .btn-bookmark-floating:hover, .btn-bookmark-floating.active {
        background: #f59e0b;
        color: #0f172a;
        border-color: #f59e0b;
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
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
        margin-bottom: 5px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 42px;
    }

    /* ================= FOOTER BUTTONS ================= */
    .book-footer {
        margin-top: auto;
        padding-top: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-detail {
        flex: 1;
        background: rgba(56, 189, 248, 0.1);
        color: #38bdf8;
        border: 1px solid rgba(56, 189, 248, 0.2);
        padding: 10px 12px;
        border-radius: 12px;
        font-weight: 700;
        text-decoration: none;
        text-align: center;
        transition: 0.3s;
        font-size: 0.88rem;
    }

    .btn-detail:hover {
        background: #38bdf8;
        color: #0f172a;
    }

    .btn-action-icon {
        width: 40px;
        height: 40px;
        border: 1px solid #334155;
        border-radius: 12px;
        background: #1e293b;
        color: #94a3b8;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.3s;
        cursor: pointer;
        padding: 0;
    }

    .btn-fav:hover, .btn-fav.active {
        background: #ef4444;
        color: #fff;
        border-color: #ef4444;
    }

    .btn-bookmark:hover, .btn-bookmark.active {
        background: #f59e0b;
        color: #0f172a;
        border-color: #f59e0b;
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
        .book-grid { grid-template-columns: repeat(4, 1fr); }
    }

    @media(max-width: 1100px) {
        .book-grid { grid-template-columns: repeat(3, 1fr); }
    }

    @media(max-width: 768px) {
        .book-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
        .card-img-wrapper { height: 230px; }
        .search-wrapper { width: 100%; }
    }

    @media(max-width: 480px) {
        .book-grid { grid-template-columns: repeat(1, 1fr); }
    }
</style>

<div class="container-fluid">

    <h3 class="page-title"><i class="fa-solid fa-layer-group me-2 text-primary"></i>Koleksi Genre</h3>

    @if(session('success'))
        <div class="alert alert-success bg-opacity-10 border-success text-success mb-4 rounded-3">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3 border-bottom border-secondary pb-4">

        <!-- FILTER GENRE -->
        <div class="filter-bar">
            <a href="{{ route('genre.index') }}" class="btn {{ empty($current_genre) ? 'btn-primary' : '' }}">
                Semua
            </a>
            @if(isset($all_genres) && count($all_genres) > 0)
                @foreach($all_genres as $g)
                    <a href="{{ route('genre.index', ['genre' => $g]) }}" class="btn {{ ($current_genre ?? null) == $g ? 'btn-primary' : '' }}">
                        {{ $g }}
                    </a>
                @endforeach
            @endif
        </div>

        <!-- SEARCH BAR -->
        <form method="GET" action="{{ route('genre.index') }}" class="search-bar d-flex gap-2">
            <input type="hidden" name="genre" value="{{ $current_genre }}">
            
            <div class="search-wrapper">
                <i class="fa fa-search search-icon"></i>
                <input type="text" name="search" class="form-control" placeholder="Cari buku, penulis..." value="{{ request('search') }}">
            </div>

            <button type="submit" class="btn-search">Cari</button>
        </form>

    </div>

    <!-- DAFTAR BUKU -->
    <div class="book-grid">
        @forelse($books_to_show as $book)
            @php
                $isBookmarked = in_array($book->id, $bookmarkedBookIds ?? []);
                $isFavorite = in_array($book->id, $favorites ?? []);
            @endphp

            <div class="book-card">
           <div class="card-img-wrapper">
    @php
        $rawPath = $book->image_path ?? $book->cover ?? $book->gambar ?? $book->image ?? null;
        $imageUrl = 'https://via.placeholder.com/300x400?text=No+Cover';

        if (!empty($rawPath)) {
            // 1. Jika URL eksternal (http/https)
            if (\Illuminate\Support\Str::startsWith($rawPath, ['http://', 'https://'])) {
                $imageUrl = $rawPath;
            } 
            // 2. Jika path disimpan lengkap seperti "uploads/cover/nama.jpg" atau "storage/books/nama.jpg"
            elseif (file_exists(public_path($rawPath))) {
                $imageUrl = asset($rawPath);
            } 
            // 3. Jika path dari Storage
            else {
                $cleanPath = str_replace(['public/', 'storage/'], '', ltrim($rawPath, '/'));
                $imageUrl = asset('storage/' . $cleanPath);
            }
        }
    @endphp

    <img src="{{ $imageUrl }}"
         class="book-cover"
         alt="{{ $book->title }}"
         onerror="this.onerror=null; this.src='https://via.placeholder.com/300x400?text=No+Cover';">

    <!-- TOMBOL BOOKMARK FLOATING -->
    @auth
        <form action="{{ route('bookmark.toggle', $book->id) }}" method="POST" class="m-0">
            @csrf
            <button type="submit" 
                    class="btn-bookmark-floating {{ $isBookmarked ? 'active' : '' }}" 
                    title="{{ $isBookmarked ? 'Hapus dari Bookmark' : 'Simpan ke Bookmark' }}">
                <i class="fa-{{ $isBookmarked ? 'solid' : 'regular' }} fa-bookmark"></i>
            </button>
        </form>
    @else
        <a href="{{ route('login') }}" class="btn-bookmark-floating" title="Login untuk simpan bookmark">
            <i class="fa-regular fa-bookmark"></i>
        </a>
    @endauth
</div>

                <div class="book-content">
                    <div class="book-title" title="{{ $book->title }}">
                        {{ $book->title }}
                    </div>

                    <small class="text-secondary d-block mb-2" style="color: #94a3b8 !important;">
                        {{ $book->author }} &bull; {{ $book->year }}
                    </small>
                    
                    <p class="text-white-50 small mb-2" style="font-size: 0.8rem;">
                        {{ Str::limit($book->description, 60) }}
                    </p>

                    <div class="mt-2 d-flex flex-wrap gap-1 mb-2">
                        <span class="badge bg-info bg-opacity-25 text-info">{{ $book->genre }}</span>
                        <span class="badge bg-secondary bg-opacity-25 text-light">{{ $book->jenis_buku }}</span>
                        <span class="badge bg-secondary bg-opacity-25 text-light">{{ $book->jumlah_halaman }} hal</span>
                        
                        @if (isset($book->is_premium) && $book->is_premium)
                            <span class="badge bg-warning bg-opacity-25 text-warning">
                                <i class="fas fa-crown me-1"></i>Premium
                            </span>
                        @endif
                    </div>

               <div class="book-footer">
    <!-- Tombol Detail / Baca Buku -->
    <a href="{{ route('book.preview', $book->id) }}" class="btn-detail">
        <i class="fa-solid fa-eye me-1"></i> Detail Buku
    </a>

    <!-- Tombol Favorit (Love) -->
    @auth
        @if($isFavorite)
            <!-- Form untuk Menghapus dari Favorit (Toggle Off) -->
            <form action="{{ route('favorite.hapus') }}" method="POST" class="m-0">
                @csrf
                <input type="hidden" name="book_id" value="{{ $book->id }}">
                <button type="submit" class="btn-action-icon btn-fav active" title="Hapus dari Favorit">
                    <i class="fa-solid fa-heart text-danger"></i>
                </button>
            </form>
        @else
            <!-- Form untuk Menambahkan ke Favorit (Toggle On) -->
            <form action="{{ route('favorite.tambah') }}" method="POST" class="m-0">
                @csrf
                <input type="hidden" name="book_id" value="{{ $book->id }}">
                <button type="submit" class="btn-action-icon btn-fav" title="Tambah ke Favorit">
                    <i class="fa-regular fa-heart"></i>
                </button>
            </form>
        @endif
    @else
        <a href="{{ route('login') }}" class="btn-action-icon btn-fav text-decoration-none" title="Login untuk favorit">
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