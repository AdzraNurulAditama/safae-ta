
@extends('layouts.app')

@section('title', 'Koleksi Genre')

@section('content')

<style>
    .genre-page {
        color: #475569;
        background:
            radial-gradient(circle at 5% 5%, rgba(186, 230, 253, .22), transparent 28%),
            radial-gradient(circle at 95% 15%, rgba(221, 214, 254, .22), transparent 28%);
        min-height: 100vh;
    }

    /* HEADER */
    .genre-heading {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 18px;
        margin-bottom: 24px;
    }

    .genre-heading h3 {
        color: #334155;
        font-weight: 800;
        margin: 0 0 6px;
    }

    .genre-heading p {
        color: #94a3b8;
        margin: 0;
    }

    /* TOOLBAR */
    .genre-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        padding-bottom: 22px;
        margin-bottom: 24px;
        border-bottom: 1px solid #e2e8f0;
    }

    .genre-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 9px;
    }

    .genre-chip {
        display: inline-flex;
        align-items: center;
        text-decoration: none;
        border: 1px solid #e2e8f0;
        border-radius: 999px;
        padding: 9px 17px;
        color: #64748b;
        background: rgba(255, 255, 255, .85);
        font-weight: 650;
        font-size: .88rem;
        transition: .2s;
    }

    .genre-chip:hover {
        color: #7c3aed;
        border-color: #c4b5fd;
        background: #f5f3ff;
        transform: translateY(-2px);
    }

    .genre-chip.active {
        background: linear-gradient(135deg, #bfdbfe, #ddd6fe);
        border-color: #c4b5fd;
        color: #4338ca;
        box-shadow: 0 4px 10px rgba(139, 92, 246, .10);
    }

    /* SEARCH */
    .genre-search {
        display: flex;
        gap: 9px;
        min-width: min(100%, 330px);
    }

    .genre-search input {
        flex: 1;
        min-width: 0;
        background: #fff;
        border: 1px solid #e2e8f0;
        color: #334155;
        border-radius: 13px;
        padding: 11px 15px;
        transition: .2s;
    }

    .genre-search input::placeholder {
        color: #94a3b8;
    }

    .genre-search input:focus {
        outline: none;
        border-color: #a5b4fc;
        box-shadow: 0 0 0 3px rgba(167, 139, 250, .13);
    }

    .genre-search button {
        border: 0;
        border-radius: 13px;
        padding: 0 19px;
        color: #3730a3;
        background: linear-gradient(135deg, #93c5fd, #c4b5fd);
        font-weight: 750;
        transition: .2s;
    }

    .genre-search button:hover {
        background: linear-gradient(135deg, #bfdbfe, #ddd6fe);
        transform: translateY(-2px);
    }

    /* JUDUL SECTION */
    .genre-section-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin: 4px 0 18px;
    }

    .genre-section-head h4 {
        margin: 0;
        color: #334155;
        font-weight: 800;
    }

    .genre-section-head small {
        color: #94a3b8;
    }

    /* GRID BUKU */
    .book-grid {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 22px;
    }

    .book-card {
        min-width: 0;
        background: rgba(255, 255, 255, .95);
        border: 1px solid #e2e8f0;
        border-radius: 19px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
        transition: .25s;
        box-shadow: 0 5px 16px rgba(148, 163, 184, .08);
    }

    .book-card:hover {
        transform: translateY(-5px);
        border-color: #c4b5fd;
        box-shadow: 0 14px 30px rgba(148, 163, 184, .16);
    }

    .book-cover-wrap {
        height: 265px;
        position: relative;
        overflow: hidden;
        background: #f1f5f9;
    }

    .book-cover {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .35s;
    }

    .book-card:hover .book-cover {
        transform: scale(1.045);
    }

    .book-type-label {
        position: absolute;
        left: 12px;
        top: 12px;
        background: rgba(255, 255, 255, .9);
        color: #6366f1;
        border: 1px solid #c4b5fd;
        border-radius: 8px;
        padding: 5px 9px;
        font-size: .72rem;
        font-weight: 750;
        backdrop-filter: blur(6px);
    }

    .book-content {
        display: flex;
        flex-direction: column;
        flex: 1;
        padding: 17px;
    }

    .book-title {
        color: #334155;
        font-size: 1rem;
        font-weight: 800;
        line-height: 1.4;
        margin: 0 0 7px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 45px;
    }

    .book-author {
        color: #94a3b8;
        font-size: .83rem;
        margin-bottom: 8px;
    }

    .book-description {
        color: #64748b;
        font-size: .8rem;
        line-height: 1.5;
        margin: 0 0 12px;
        min-height: 36px;
    }

    /* BADGE */
    .book-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 13px;
    }

    .book-tag {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 9px;
        border-radius: 7px;
        font-size: .72rem;
        font-weight: 700;
        background: #f1f5f9;
        color: #64748b;
        border: 1px solid #e2e8f0;
    }

    .book-tag.genre {
        background: #ecfeff;
        color: #0891b2;
        border-color: #a5f3fc;
    }

    .book-tag.premium {
        background: #fff7ed;
        color: #c2410c;
        border-color: #fed7aa;
    }

    /* STATISTIK BUKU */
    .book-stats {
        display: flex;
        align-items: center;
        gap: 14px;
        flex-wrap: wrap;
        padding: 11px 0;
        margin-top: auto;
        border-top: 1px solid #e2e8f0;
        border-bottom: 1px solid #e2e8f0;
    }

    .book-stat {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #64748b;
        font-size: .76rem;
        white-space: nowrap;
    }

    .book-stat.favorite i {
        color: #fb7185;
    }

    .book-stat.readers i {
        color: #60a5fa;
    }

    /* TOMBOL */
    .book-actions {
        display: flex;
        align-items: center;
        gap: 9px;
        padding-top: 14px;
    }

    .btn-detail {
        flex: 1;
        min-height: 43px;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 7px;
        text-align: center;
        text-decoration: none;
        padding: 9px 10px;
        border-radius: 12px;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        color: #3b82f6;
        font-weight: 750;
        font-size: .84rem;
        transition: .2s;
    }

    .btn-detail:hover {
        background: #bfdbfe;
        border-color: #93c5fd;
        color: #1e40af;
    }

    .favorite-form {
        margin: 0;
    }

    .btn-favorite {
        width: 43px;
        height: 43px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        background: #fff;
        color: #94a3b8;
        font-size: 1.05rem;
        cursor: pointer;
        transition: .2s;
        text-decoration: none;
    }

    .btn-favorite:hover {
        border-color: #fda4af;
        color: #fb7185;
        background: #fff1f2;
    }

    .btn-favorite.active {
        background: #fb7185;
        border-color: #fb7185;
        color: #fff;
    }

    .btn-favorite.active:hover {
        background: #f43f5e;
        color: #fff;
    }

    /* EMPTY STATE */
    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 65px 20px;
        color: #94a3b8;
        background: rgba(255, 255, 255, .9);
        border: 1px dashed #c4b5fd;
        border-radius: 18px;
    }

    .empty-state i {
        font-size: 3rem;
        color: #a78bfa;
        margin-bottom: 15px;
    }

    .empty-state h4 {
        color: #334155;
    }

    /* PAGINATION BOOTSTRAP 5 */
    .genre-pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        margin: 35px 0 25px;
        overflow: visible;
    }

    .genre-pagination nav {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
        max-width: 100%;
    }

    .genre-pagination nav > div:first-child {
        color: #94a3b8;
        font-size: .85rem;
    }

    .genre-pagination .pagination {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 7px;
        margin: 0;
        padding: 0;
    }

    .genre-pagination .page-item {
        margin: 0;
    }

    .genre-pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        min-height: 40px;
        padding: 8px 13px;
        background: #fff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 9px !important;
        color: #64748b !important;
        font-size: 13px;
        line-height: 1.2;
        text-decoration: none;
        box-shadow: none !important;
    }

    .genre-pagination .page-link:hover {
        background: #f5f3ff !important;
        border-color: #c4b5fd !important;
        color: #7c3aed !important;
    }

    .genre-pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #bfdbfe, #ddd6fe) !important;
        border-color: #c4b5fd !important;
        color: #4338ca !important;
    }

    .genre-pagination .page-item.disabled .page-link {
        opacity: .4;
        color: #94a3b8 !important;
    }

    /* UKURAN PANAH PAGINATION */
    .genre-pagination svg {
        display: inline-block !important;
        width: 16px !important;
        height: 16px !important;
        max-width: 16px !important;
        max-height: 16px !important;
        vertical-align: middle;
    }

    .genre-pagination .page-link svg {
        width: 16px !important;
        height: 16px !important;
    }

    /* RESPONSIVE */
    @media(max-width: 1400px) {
        .book-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }
    }

    @media(max-width: 1100px) {
        .book-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media(max-width: 768px) {
        .book-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .book-cover-wrap {
            height: 220px;
        }

        .book-content {
            padding: 13px;
        }

        .book-stats {
            gap: 9px;
        }
    }

    @media(max-width: 480px) {
        .book-grid {
            grid-template-columns: 1fr;
        }

        .book-cover-wrap {
            height: 290px;
        }

        .genre-heading {
            align-items: flex-start;
        }
    }
</style>

<div class="container-fluid genre-page">

    <!-- HEADER -->
    <div class="genre-heading">
        <div>
            <h3>
                <i class="fa-solid fa-layer-group me-2"
                   style="color:#8b5cf6"></i>
                Koleksi Genre
            </h3>

            <p>
                Jelajahi buku berdasarkan genre dan temukan bacaan favoritmu.
            </p>
        </div>
    </div>

    <!-- NOTIFIKASI -->
    @if(session('success'))
        <div class="alert alert-success bg-opacity-10 border-success text-success mb-4 rounded-3">
            <i class="fa-solid fa-circle-check me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- FILTER DAN PENCARIAN -->
    <div class="genre-toolbar">

        <div class="genre-filters">

            <a href="{{ route('genre.index') }}"
               class="genre-chip {{ empty($current_genre) ? 'active' : '' }}">
                Semua
            </a>

            @if(isset($all_genres) && count($all_genres) > 0)
                @foreach($all_genres as $g)
                    <a href="{{ route('genre.index', ['genre' => $g]) }}"
                       class="genre-chip {{ ($current_genre ?? null) == $g ? 'active' : '' }}">
                        {{ $g }}
                    </a>
                @endforeach
            @endif

        </div>

        <form method="GET"
              action="{{ route('genre.index') }}"
              class="genre-search">

            @if(!empty($current_genre))
                <input type="hidden"
                       name="genre"
                       value="{{ $current_genre }}">
            @endif

            <input type="text"
                   name="search"
                   placeholder="Cari judul buku atau penulis..."
                   value="{{ request('search') }}">

            <button type="submit">
                <i class="fa-solid fa-search me-1"></i>
                Cari
            </button>

        </form>
    </div>

    <!-- JUDUL DAFTAR BUKU -->
    <div class="genre-section-head">
        <h4>
            {{ !empty($current_genre) ? $current_genre : 'Semua Buku' }}
        </h4>

        <small>
            {{ method_exists($books_to_show, 'total') ? $books_to_show->total() : count($books_to_show) }}
            buku
        </small>
    </div>

    <!-- GRID BUKU -->
    <div class="book-grid">

        @forelse($books_to_show as $book)

            @php
                $isBookmarked = in_array($book->id, $bookmarkedBookIds ?? []);
                $isFavorite = in_array($book->id, $favorites ?? []);

                $rawPath = $book->image_path
                    ?? $book->cover
                    ?? $book->gambar
                    ?? $book->image
                    ?? null;

                $imageUrl = 'https://via.placeholder.com/300x400?text=No+Cover';

                if (!empty($rawPath)) {
                    if (\Illuminate\Support\Str::startsWith($rawPath, ['http://', 'https://'])) {
                        $imageUrl = $rawPath;
                    } elseif (file_exists(public_path($rawPath))) {
                        $imageUrl = asset($rawPath);
                    } else {
                        $cleanPath = str_replace(
                            ['public/', 'storage/'],
                            '',
                            ltrim($rawPath, '/')
                        );

                        $imageUrl = asset('storage/' . $cleanPath);
                    }
                }

                $favoriteCount = (int) ($book->favorites_count ?? 0);
                $readerCount = (int) ($book->readers_count ?? 0);

                $jumlahBab = (int) ($book->chapters_count ?? 0);
                $totalHalamanBaca = $jumlahBab > 0 ? $jumlahBab : 1;
            @endphp

            <article class="book-card">

                <!-- COVER -->
                <div class="book-cover-wrap">

                    <img src="{{ $imageUrl }}"
                         class="book-cover"
                         alt="Cover {{ $book->title }}"
                         loading="lazy"
                         onerror="this.onerror=null;this.src='https://via.placeholder.com/300x400?text=No+Cover';">

                    @if(!empty($book->jenis_buku))
                        <span class="book-type-label">
                            {{ $book->jenis_buku }}
                        </span>
                    @endif

                </div>

                <!-- INFORMASI BUKU -->
                <div class="book-content">

                    <h5 class="book-title" title="{{ $book->title }}">
                        {{ $book->title }}
                    </h5>

                    <div class="book-author">
                        {{ $book->author ?? 'Penulis tidak diketahui' }}
                        {{ !empty($book->year) ? ' • ' . $book->year : '' }}
                    </div>

                    <p class="book-description">
                        {{ \Illuminate\Support\Str::limit($book->description ?? 'Belum ada deskripsi buku.', 65) }}
                    </p>

                    <!-- BADGE -->
                    <div class="book-tags">

                        @if(!empty($book->genre))
                            <span class="book-tag genre">
                                {{ $book->genre }}
                            </span>
                        @endif

                        <span class="book-tag">
                            <i class="fa-solid fa-book-open"></i>
                            {{ $totalHalamanBaca }} Halaman
                        </span>

                        @if(isset($book->is_premium) && $book->is_premium)
                            <span class="book-tag premium">
                                <i class="fa-solid fa-crown"></i>
                                Premium
                            </span>
                        @endif

                    </div>

                    <!-- STATISTIK FAVORIT DAN PEMBACA -->
                    <div class="book-stats">

                        <span class="book-stat favorite"
                              title="Jumlah pengguna yang memfavoritkan buku ini">

                            <i class="fa-solid fa-heart"></i>

                            <strong>
                                {{ number_format($favoriteCount, 0, ',', '.') }}
                            </strong>

                            Favorit
                        </span>

                        <span class="book-stat readers"
                              title="Jumlah pengguna yang pernah membaca buku ini">

                            <i class="fa-solid fa-book-open-reader"></i>

                            <strong>
                                {{ number_format($readerCount, 0, ',', '.') }}
                            </strong>

                            Dibaca
                        </span>

                    </div>

                    <!-- TOMBOL DETAIL DAN FAVORIT -->
                    <div class="book-actions">

                        <a href="{{ route('book.preview', $book->id) }}"
                           class="btn-detail">

                            <i class="fa-solid fa-eye"></i>
                            Detail Buku

                        </a>

                        @auth

                            <form action="{{ $isFavorite
                                ? route('favorite.hapus')
                                : route('favorite.tambah') }}"
                                  method="POST"
                                  class="favorite-form">

                                @csrf

                                <input type="hidden"
                                       name="book_id"
                                       value="{{ $book->id }}">

                                <button type="submit"
                                        class="btn-favorite {{ $isFavorite ? 'active' : '' }}"
                                        title="{{ $isFavorite ? 'Hapus dari Favorit' : 'Tambah ke Favorit' }}"
                                        aria-label="{{ $isFavorite ? 'Hapus dari Favorit' : 'Tambah ke Favorit' }}">

                                    <i class="fa-{{ $isFavorite ? 'solid' : 'regular' }} fa-heart"></i>

                                </button>

                            </form>

                        @else

                            <a href="{{ route('login') }}"
                               class="btn-favorite"
                               title="Login untuk menambahkan favorit"
                               aria-label="Login untuk favorit">

                                <i class="fa-regular fa-heart"></i>

                            </a>

                        @endauth

                    </div>

                </div>

            </article>

        @empty

            <div class="empty-state">

                <i class="fa-solid fa-book-open d-block"></i>

                <h4 class="fw-bold">
                    Buku tidak ditemukan
                </h4>

                <p class="mb-0">
                    Coba kata kunci lain atau pilih genre yang berbeda.
                </p>

            </div>

        @endforelse

    </div>

    <!-- PAGINATION -->
    @if($books_to_show instanceof \Illuminate\Contracts\Pagination\Paginator || $books_to_show instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)

        @if($books_to_show->hasPages())

            <div class="genre-pagination">
                {{ $books_to_show->withQueryString()->links('pagination::bootstrap-5') }}
            </div>

        @endif

    @endif

</div>

@endsection
