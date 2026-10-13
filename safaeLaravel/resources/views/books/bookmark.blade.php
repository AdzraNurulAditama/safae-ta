@extends('layouts.app')

@section('title', 'Bookmark Saya - Safae')

@section('content')

<style>
    .bookmark-wrapper {
        padding: 10px 0 50px 0;
        color: #f1f5f9;
    }

    /* Filter Bar Genre */
    .genre-nav-bar {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        padding-bottom: 10px;
        margin-bottom: 30px;
    }

    .genre-nav-btn {
        background: #1e293b;
        border: 1px solid #334155;
        color: #94a3b8;
        padding: 8px 18px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.88rem;
        text-decoration: none;
        white-space: nowrap;
        transition: all 0.3s ease;
    }

    .genre-nav-btn:hover {
        background: #334155;
        color: #38bdf8;
    }

    /* Section Genre Title */
    .genre-section-title {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
        padding-bottom: 8px;
        border-bottom: 1px solid #334155;
    }

    .genre-badge-title {
        background: rgba(56, 189, 248, 0.15);
        color: #38bdf8;
        border: 1px solid rgba(56, 189, 248, 0.3);
        padding: 4px 14px;
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 700;
    }

    /* Grid Buku */
    .bookmark-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 22px;
        margin-bottom: 40px;
    }

    .bookmark-card {
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

    .bookmark-card:hover {
        transform: translateY(-6px);
        border-color: #38bdf8;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3);
    }

    .card-img-wrapper {
        width: 100%;
        height: 250px;
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

    .bookmark-card:hover .book-cover {
        transform: scale(1.05);
    }

    .bookmark-content {
        padding: 16px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .book-title {
        color: #f8fafc;
        font-size: 0.98rem;
        font-weight: 700;
        line-height: 1.4;
        margin-bottom: 4px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 40px;
    }

    .book-footer {
        margin-top: auto;
        padding-top: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-baca {
        flex: 1;
        background: rgba(56, 189, 248, 0.12);
        color: #38bdf8;
        border: 1px solid rgba(56, 189, 248, 0.25);
        font-weight: 700;
        padding: 8px 12px;
        border-radius: 12px;
        text-decoration: none;
        text-align: center;
        transition: 0.2s;
        font-size: 0.85rem;
    }

    .btn-baca:hover {
        background: #38bdf8;
        color: #0f172a;
    }

    .btn-delete-bookmark {
        width: 38px;
        height: 38px;
        border: 1px solid #334155;
        border-radius: 12px;
        background: #0f172a;
        color: #f87171;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.2s;
        cursor: pointer;
        padding: 0;
    }

    .btn-delete-bookmark:hover {
        background: #ef4444;
        color: #ffffff;
        border-color: #ef4444;
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
        color: #94a3b8;
        background: #1e293b;
        border: 2px dashed #334155;
        border-radius: 20px;
        margin-top: 20px;
    }

    /* Responsive Grid */
    @media(max-width: 1400px) { .bookmark-grid { grid-template-columns: repeat(4, 1fr); } }
    @media(max-width: 1100px) { .bookmark-grid { grid-template-columns: repeat(3, 1fr); } }
    @media(max-width: 768px) { 
        .bookmark-grid { grid-template-columns: repeat(2, 1fr); gap: 15px; } 
        .card-img-wrapper { height: 210px; }
    }
    @media(max-width: 480px) { .bookmark-grid { grid-template-columns: repeat(1, 1fr); } }
</style>

<div class="bookmark-wrapper">
    <div class="container-fluid">

        <!-- HEADER -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h3 class="fw-bold text-white mb-1">
                    <i class="fa-solid fa-bookmark text-warning me-2"></i>Bookmark Saya
                </h3>
                <p class="text-secondary small mb-0">Daftar buku tersimpan yang tersusun rapi berdasarkan kategori genre[cite: 3].</p>
            </div>
            <a href="{{ route('genre.index') }}" class="btn btn-outline-info rounded-3 btn-sm">
                <i class="fa-solid fa-plus me-1"></i> Tambah Bookmark
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success bg-opacity-10 border-success text-success mb-4 rounded-3">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            </div>
        @endif

        @if($bookmarks->isEmpty())
            <div class="empty-state">
                <i class="fa-regular fa-bookmark fa-4x text-secondary mb-3"></i>
                <h4 class="text-white fw-bold mb-2">Belum Ada Bookmark</h4>
                <p class="text-secondary small mb-4">Kamu belum menyimpan buku apa pun ke daftar bookmark.</p>
                <a href="{{ route('genre.index') }}" class="btn btn-info text-dark fw-bold rounded-3 px-4 py-2">
                    <i class="fa-solid fa-compass me-1"></i> Jelajahi Buku
                </a>
            </div>
        @else

            <!-- GENRE NAV TAB / QUICK JUMP -->
            <div class="genre-nav-bar">
                <span class="text-secondary small align-self-center me-2"><i class="fa-solid fa-filter me-1"></i> Lompat ke:</span>
                @foreach($groupedBookmarks as $genreName => $items)
                    <a href="#genre-{{ Str::slug($genreName) }}" class="genre-nav-btn">
                        {{ $genreName }} <span class="badge bg-secondary bg-opacity-50 text-white ms-1">{{ $items->count() }}</span>
                    </a>
                @endforeach
            </div>

            <!-- LOOP BERDASARKAN KELOMPOK GENRE -->
            @foreach($groupedBookmarks as $genreName => $items)
                <div id="genre-{{ Str::slug($genreName) }}" class="mb-5 pt-2">
                    
                    <!-- JUDUL SECTION GENRE -->
                    <div class="genre-section-title">
                        <span class="genre-badge-title"><i class="fa-solid fa-layer-group me-1"></i> {{ $genreName }}</span>
                        <small class="text-secondary">({{ $items->count() }} Buku Tersimpan)</small>
                    </div>

                    <!-- KUMPULAN BUKU DALAM GENRE INI -->
                    <div class="bookmark-grid">
                        @foreach($items as $bookmark)
                            <div class="bookmark-card">
                                
                                <div class="card-img-wrapper">
                                    @php
                                        $coverPath = $bookmark->book && $bookmark->book->image_path ? str_replace(['public/', 'storage/'], '', $bookmark->book->image_path) : null;
                                    @endphp

                                    @if($coverPath)
                                        <img src="{{ asset('storage/' . $coverPath) }}" 
                                             class="book-cover" 
                                             alt="{{ $bookmark->book->title }}"
                                             onerror="this.onerror=null; this.src='{{ asset($bookmark->book->image_path) }}';">
                                    @else
                                        <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-dark text-secondary">
                                            <i class="fa-solid fa-book fa-3x"></i>
                                        </div>
                                    @endif
                                </div>

                                <div class="bookmark-content">
                                    <div class="book-title" title="{{ $bookmark->book->title ?? 'Judul Tidak Tersedia' }}">
                                        {{ $bookmark->book->title ?? 'Judul Tidak Tersedia' }}
                                    </div>

                                    <small class="text-secondary d-block mb-3">
                                        {{ $bookmark->book->author ?? '-' }} &bull; {{ $bookmark->book->year ?? '' }}
                                    </small>

                                    <div class="book-footer">
                                        <a href="{{ route('book.show', ['id' => $bookmark->book_id, 'page' => 1]) }}" class="btn-baca">
                                            <i class="fa-solid fa-book-open me-1"></i> Baca
                                        </a>

                                        <form action="{{ route('bookmark.remove', $bookmark->id) }}" method="POST" class="m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn-delete-bookmark" 
                                                    onclick="return confirm('Hapus buku ini dari bookmark?')" 
                                                    title="Hapus dari Bookmark">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>

                </div>
            @endforeach

        @endif

    </div>
</div>

@endsection