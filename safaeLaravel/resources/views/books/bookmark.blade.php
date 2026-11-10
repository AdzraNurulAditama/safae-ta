
@extends('layouts.app')

@section('title', 'Bookmark Saya - Safae')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

:root {
    --bookmark-purple: #a394d0;
    --bookmark-purple-light: #eee9ff;
    --bookmark-blue: #e5efff;
    --bookmark-pink: #ffe8ef;
    --bookmark-pink-dark: #d98da9;
    --bookmark-text: #4d4964;
    --bookmark-muted: #9290a3;
}

.bookmark-wrapper {
    max-width: 1500px;
    margin: 0 auto;
    padding: 30px 25px 60px;
    color: var(--bookmark-text);
    font-family: 'Plus Jakarta Sans', sans-serif;
}

/* =========================
   HEADER
========================= */

.bookmark-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    padding: 30px 35px;
    margin-bottom: 35px;
    border: 1px solid #eee7f8;
    border-radius: 24px;
    background: linear-gradient(115deg, #e7efff, #eee8ff 55%, #ffeaf1);
    box-shadow: 0 9px 25px rgba(145, 135, 185, .09);
}

.bookmark-header-content {
    display: flex;
    align-items: center;
    gap: 18px;
}

.bookmark-header-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 65px;
    height: 65px;
    flex-shrink: 0;
    border-radius: 20px;
    background: rgba(255,255,255,.8);
    color: #a28ecf;
    font-size: 27px;
}

.bookmark-header h3 {
    margin: 0 0 7px;
    color: #4e4967;
    font-size: 27px;
    font-weight: 800;
}

.bookmark-header p {
    margin: 0;
    color: #858198;
    font-size: 13px;
    line-height: 1.7;
}

.btn-add-bookmark {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    padding: 13px 20px;
    border: 1px solid rgba(255,255,255,.8);
    border-radius: 13px;
    background: rgba(255,255,255,.75);
    color: #8978b9;
    font-size: 12px;
    font-weight: 800;
    text-decoration: none;
    white-space: nowrap;
    transition: .2s;
}

.btn-add-bookmark:hover {
    background: #fff;
    color: #7662a9;
    transform: translateY(-2px);
}

/* =========================
   NOTIFICATION
========================= */

.bookmark-alert {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 16px 20px;
    margin-bottom: 25px;
    border: 1px solid #ccebdc;
    border-radius: 14px;
    background: #e3f6ed;
    color: #43866c;
    font-size: 13px;
    font-weight: 600;
}

/* =========================
   GENRE NAVIGATION
========================= */

.genre-navigation {
    padding: 20px 22px;
    margin-bottom: 35px;
    border: 1px solid #eee9f5;
    border-radius: 18px;
    background: #fff;
    box-shadow: 0 6px 20px rgba(130, 125, 165, .06);
}

.genre-navigation-label {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 15px;
    color: #89859d;
    font-size: 12px;
    font-weight: 800;
}

.genre-navigation-label i {
    color: #a394d0;
}

.genre-nav-bar {
    display: flex;
    gap: 11px;
    overflow-x: auto;
    padding: 3px 2px 10px;
    scrollbar-width: thin;
    scrollbar-color: #d9d0ef transparent;
}

.genre-nav-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
    padding: 11px 16px;
    border: 1px solid #e7e0f5;
    border-radius: 12px;
    background: #f8f6ff;
    color: #897bb3;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
    white-space: nowrap;
    transition: .2s;
}

.genre-nav-btn:hover {
    border-color: #c9bce9;
    background: #eee9ff;
    color: #7664a9;
    transform: translateY(-2px);
}

.genre-nav-count {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 23px;
    height: 23px;
    padding: 0 6px;
    border-radius: 20px;
    background: #e8e1f8;
    color: #8e7bb9;
    font-size: 10px;
    font-weight: 800;
}

/* =========================
   GENRE SECTION
========================= */

.bookmark-genre-section {
    margin-bottom: 48px;
    padding-top: 5px;
    scroll-margin-top: 25px;
}

.genre-section-title {
    display: flex;
    align-items: center;
    gap: 14px;
    padding-bottom: 17px;
    margin-bottom: 24px;
    border-bottom: 1px solid #ebe6f3;
}

.genre-badge-title {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    padding: 11px 17px;
    border: 1px solid #e4dcf5;
    border-radius: 12px;
    background: #f0ebff;
    color: #8d7bb9;
    font-size: 13px;
    font-weight: 800;
}

.genre-section-count {
    color: #9995a8;
    font-size: 12px;
    font-weight: 600;
}

/* =========================
   BOOK GRID
========================= */

.bookmark-grid {
    display: grid;
    grid-template-columns: repeat(5, minmax(0, 1fr));
    gap: 25px;
}

.bookmark-card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    height: 100%;
    overflow: hidden;
    border: 1px solid #eeeaf5;
    border-radius: 20px;
    background: #fff;
    box-shadow: 0 7px 22px rgba(130, 125, 165, .08);
    transition: transform .25s ease, box-shadow .25s ease;
}

.bookmark-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 14px 30px rgba(130, 125, 165, .15);
}

/* =========================
   BOOK COVER
========================= */

.card-img-wrapper {
    position: relative;
    width: 100%;
    height: 255px;
    overflow: hidden;
    background: linear-gradient(135deg, #e6edff, #f0eaff, #ffeaf1);
}

.book-cover {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .4s ease;
}

.bookmark-card:hover .book-cover {
    transform: scale(1.05);
}

.book-cover-empty {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
    color: #a394d0;
    font-size: 55px;
}

/* =========================
   BOOK INFORMATION
========================= */

.bookmark-content {
    display: flex;
    flex-direction: column;
    flex: 1;
    padding: 19px 17px;
}

.book-title {
    display: -webkit-box;
    overflow: hidden;
    min-height: 43px;
    margin-bottom: 9px;
    color: #4e4965;
    font-size: 14px;
    font-weight: 800;
    line-height: 1.55;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.book-author-info {
    display: flex;
    align-items: center;
    gap: 7px;
    min-height: 20px;
    margin-bottom: 13px;
    color: #9995a9;
    font-size: 11px;
    line-height: 1.5;
}

.book-author-info i {
    color: #ad9bd0;
}

.book-footer {
    display: flex;
    align-items: center;
    gap: 9px;
    padding-top: 13px;
    margin-top: auto;
    border-top: 1px solid #f0edf5;
}

/* READ BUTTON */

.btn-baca {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex: 1;
    min-height: 40px;
    gap: 7px;
    padding: 9px 12px;
    border: 1px solid #e2daf5;
    border-radius: 11px;
    background: #f0ebff;
    color: #8977b9;
    font-size: 12px;
    font-weight: 800;
    text-align: center;
    text-decoration: none;
    transition: .2s;
}

.btn-baca:hover {
    border-color: #a99bd9;
    background: #a99bd9;
    color: #fff;
}

/* DELETE BUTTON */

.btn-delete-bookmark {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    flex-shrink: 0;
    padding: 0;
    border: 1px solid #f4d7e2;
    border-radius: 11px;
    background: #fff0f4;
    color: #cb819d;
    cursor: pointer;
    transition: .2s;
}

.btn-delete-bookmark:hover {
    border-color: #e8b5c8;
    background: #f4d4e0;
    color: #b96787;
}

/* =========================
   EMPTY STATE
========================= */

.bookmark-empty-state {
    padding: 70px 25px;
    margin-top: 20px;
    border: 1px dashed #dcd5ee;
    border-radius: 25px;
    background: linear-gradient(135deg, #f5f2ff, #fff3f6);
    text-align: center;
}

.bookmark-empty-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100px;
    height: 100px;
    margin: 0 auto 22px;
    border-radius: 30px;
    background: rgba(255,255,255,.85);
    color: #a394d0;
    font-size: 42px;
}

.bookmark-empty-state h4 {
    margin-bottom: 12px;
    color: #514d69;
    font-size: 21px;
    font-weight: 800;
}

.bookmark-empty-state p {
    max-width: 450px;
    margin: 0 auto 25px;
    color: #9290a2;
    font-size: 13px;
    line-height: 1.8;
}

.btn-explore-bookmark {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    padding: 13px 23px;
    border: none;
    border-radius: 30px;
    background: linear-gradient(120deg, #a99bd9, #8fa5d9);
    color: white;
    font-size: 12px;
    font-weight: 800;
    text-decoration: none;
    transition: .2s;
}

.btn-explore-bookmark:hover {
    transform: translateY(-2px);
    background: linear-gradient(120deg, #9382c8, #7f94ce);
    color: white;
}

/* =========================
   RESPONSIVE
========================= */

@media(max-width: 1400px) {
    .bookmark-grid {
        grid-template-columns: repeat(4, minmax(0, 1fr));
    }
}

@media(max-width: 1100px) {
    .bookmark-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }
}

@media(max-width: 768px) {
    .bookmark-wrapper {
        padding: 20px 15px 40px;
    }

    .bookmark-header {
        align-items: flex-start;
        flex-direction: column;
        padding: 23px 20px;
    }

    .bookmark-header-content {
        gap: 14px;
    }

    .bookmark-header-icon {
        width: 53px;
        height: 53px;
        font-size: 22px;
    }

    .bookmark-header h3 {
        font-size: 21px;
    }

    .bookmark-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 15px;
    }

    .card-img-wrapper {
        height: 210px;
    }

    .bookmark-content {
        padding: 14px 11px;
    }

    .book-title {
        font-size: 12px;
    }

    .book-author-info {
        font-size: 10px;
    }

    .btn-baca {
        font-size: 11px;
        padding: 8px;
    }
}

@media(max-width: 480px) {
    .bookmark-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .card-img-wrapper {
        height: 190px;
    }

    .genre-section-title {
        flex-wrap: wrap;
    }

    .bookmark-empty-state {
        padding: 50px 18px;
    }
}
</style>

<div class="bookmark-wrapper">
    <div class="container-fluid">

        {{-- HEADER --}}
        <div class="bookmark-header">

            <div class="bookmark-header-content">
                <div class="bookmark-header-icon">
                    <i class="fa-solid fa-bookmark"></i>
                </div>

                <div>
                    <h3>Bookmark Saya</h3>
                    <p>
                        Daftar buku tersimpan yang tersusun rapi berdasarkan kategori genre.
                    </p>
                </div>
            </div>

            <a href="{{ route('genre.index') }}" class="btn-add-bookmark">
                <i class="fa-solid fa-plus"></i>
                Tambah Bookmark
            </a>

        </div>

        {{-- NOTIFIKASI --}}
        @if(session('success'))
            <div class="bookmark-alert">
                <i class="fa-solid fa-circle-check"></i>
                {{ session('success') }}
            </div>
        @endif

        @if($bookmarks->isEmpty())

            {{-- EMPTY STATE --}}
            <div class="bookmark-empty-state">

                <div class="bookmark-empty-icon">
                    <i class="fa-regular fa-bookmark"></i>
                </div>

                <h4>Belum Ada Bookmark</h4>

                <p>
                    Kamu belum menyimpan buku apa pun ke daftar bookmark.
                    Jelajahi koleksi Safae dan simpan buku yang ingin kamu baca nanti!
                </p>

                <a href="{{ route('genre.index') }}" class="btn-explore-bookmark">
                    <i class="fa-solid fa-compass"></i>
                    Jelajahi Buku
                </a>

            </div>

        @else

            {{-- GENRE NAV TAB / QUICK JUMP --}}
            <div class="genre-navigation">

                <div class="genre-navigation-label">
                    <i class="fa-solid fa-filter"></i>
                    Lompat ke Kategori Genre
                </div>

                <div class="genre-nav-bar">

                    @foreach($groupedBookmarks as $genreName => $items)

                        <a href="#genre-{{ Str::slug($genreName) }}" class="genre-nav-btn">
                            {{ $genreName }}

                            <span class="genre-nav-count">
                                {{ $items->count() }}
                            </span>
                        </a>

                    @endforeach

                </div>

            </div>

            {{-- LOOP BERDASARKAN KELOMPOK GENRE --}}
            @foreach($groupedBookmarks as $genreName => $items)

                <div id="genre-{{ Str::slug($genreName) }}" class="bookmark-genre-section">

                    {{-- JUDUL SECTION GENRE --}}
                    <div class="genre-section-title">

                        <span class="genre-badge-title">
                            <i class="fa-solid fa-layer-group"></i>
                            {{ $genreName }}
                        </span>

                        <small class="genre-section-count">
                            {{ $items->count() }} Buku Tersimpan
                        </small>

                    </div>

                    {{-- KUMPULAN BUKU DALAM GENRE --}}
                    <div class="bookmark-grid">

                        @foreach($items as $bookmark)

                            <div class="bookmark-card">

                                {{-- COVER BUKU --}}
                                <div class="card-img-wrapper">

                                    @php
                                        $coverPath = $bookmark->book && $bookmark->book->image_path
                                            ? str_replace(['public/', 'storage/'], '', $bookmark->book->image_path)
                                            : null;
                                    @endphp

                                    @if($coverPath)

                                        <img
                                            src="{{ asset('storage/' . $coverPath) }}"
                                            class="book-cover"
                                            alt="{{ $bookmark->book->title }}"
                                            onerror="this.onerror=null; this.src='{{ asset($bookmark->book->image_path) }}';"
                                        >

                                    @else

                                        <div class="book-cover-empty">
                                            <i class="fa-solid fa-book"></i>
                                        </div>

                                    @endif

                                </div>

                                {{-- INFORMASI BUKU --}}
                                <div class="bookmark-content">

                                    <div
                                        class="book-title"
                                        title="{{ $bookmark->book->title ?? 'Judul Tidak Tersedia' }}"
                                    >
                                        {{ $bookmark->book->title ?? 'Judul Tidak Tersedia' }}
                                    </div>

                                    <small class="book-author-info">
                                        <i class="fa-solid fa-user"></i>

                                        {{ $bookmark->book->author ?? '-' }}
                                        &bull;
                                        {{ $bookmark->book->year ?? '' }}
                                    </small>

                                    {{-- TOMBOL AKSI --}}
                                    <div class="book-footer">

                                        <a
                                            href="{{ route('book.show', ['id' => $bookmark->book_id, 'page' => 1]) }}"
                                            class="btn-baca"
                                        >
                                            <i class="fa-solid fa-book-open"></i>
                                            Baca
                                        </a>

                                        <form
                                            action="{{ route('bookmark.remove', $bookmark->id) }}"
                                            method="POST"
                                            class="m-0"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn-delete-bookmark"
                                                onclick="return confirm('Hapus buku ini dari bookmark?')"
                                                title="Hapus dari Bookmark"
                                            >
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
