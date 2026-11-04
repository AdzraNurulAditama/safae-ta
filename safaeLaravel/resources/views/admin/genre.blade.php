@extends('layouts.layoutsAdmin')

@section('title', 'Kelola Genre & Buku')

@push('styles')
<style>
    .console-container {
        width: 100%;
        color: #f8fafc;
    }

    /* HEADER */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 28px;
        padding-bottom: 20px;
        border-bottom: 1px solid rgba(255,255,255,0.07);
    }

    .page-title {
        font-size: 1.5rem;
        font-weight: 750;
        color: #f8fafc;
        margin: 0 0 6px;
        letter-spacing: -0.5px;
    }

    .page-description {
        font-size: 0.88rem;
        color: #94a3b8;
        margin: 0;
    }

    /* BUTTON TAMBAH BUKU */
    .btn-console-primary {
        background: linear-gradient(135deg, #06b6d4, #3b82f6);
        color: #fff;
        font-weight: 700;
        border: none;
        padding: 11px 20px;
        border-radius: 10px;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        box-shadow: 0 4px 14px rgba(6,182,212,0.2);
        white-space: nowrap;
        font-size: 0.9rem;
    }

    .btn-console-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(6,182,212,0.35);
        color: #fff;
    }

    /* NOTIFIKASI */
    .log-alert-success {
        background: rgba(16,185,129,0.08);
        border: 1px solid rgba(16,185,129,0.25);
        color: #34d399;
        border-radius: 12px;
        padding: 14px 18px;
        font-size: 0.9rem;
    }

    /* FILTER GENRE */
    .filter-panel {
        background: #111827;
        border: 1px solid rgba(255,255,255,0.06);
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 32px;
    }

    .filter-heading {
        display: flex;
        align-items: center;
        gap: 9px;
        color: #f8fafc;
        font-size: 0.95rem;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .filter-heading i {
        color: #06b6d4;
    }

    .filter-description {
        font-size: 0.8rem;
        color: #64748b;
        margin-bottom: 14px;
    }

    .filter-pill {
        background: #1e293b;
        color: #cbd5e1;
        border: 1px solid rgba(255,255,255,0.07);
        padding: 8px 15px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 0.82rem;
        text-decoration: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .filter-pill:hover {
        background: #263449;
        color: #fff;
        border-color: rgba(6,182,212,0.4);
    }

    .filter-pill.active {
        background: rgba(6,182,212,0.13);
        color: #22d3ee;
        border-color: rgba(6,182,212,0.5);
    }

    /* HEADER GENRE */
    .genre-section {
        margin-bottom: 38px;
    }

    .genre-row-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-bottom: 18px;
        padding-bottom: 13px;
        border-bottom: 1px solid rgba(255,255,255,0.07);
    }

    .genre-heading {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1.05rem;
        font-weight: 750;
        color: #f8fafc;
        margin: 0;
    }

    .genre-heading i {
        color: #06b6d4;
    }

    .btn-view-all {
        color: #22d3ee;
        font-weight: 600;
        font-size: 0.82rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        transition: 0.2s;
        white-space: nowrap;
    }

    .btn-view-all:hover {
        color: #67e8f9;
        gap: 11px;
    }

    /* GRID BUKU */
    .cyber-books-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
        gap: 20px;
    }

    /* CARD BUKU */
    .book-slate-card {
        background: #111827;
        border: 1px solid rgba(255,255,255,0.06);
        border-radius: 14px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
        transition: transform 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease;
    }

    .book-slate-card:hover {
        transform: translateY(-4px);
        border-color: rgba(6,182,212,0.4);
        box-shadow: 0 12px 28px rgba(0,0,0,0.25);
    }

    /* COVER */
    .book-cover-frame {
        height: 245px;
        background: #1e293b;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
    }

    .book-cover-frame img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .book-slate-card:hover .book-cover-frame img {
        transform: scale(1.04);
    }

    .book-cover-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 10px;
        color: #64748b;
    }

    .book-cover-placeholder i {
        font-size: 2.5rem;
    }

    .book-cover-placeholder span {
        font-size: 0.75rem;
    }

    /* INFORMASI BUKU */
    .book-meta-body {
        padding: 17px 17px 14px;
        flex-grow: 1;
    }

    .book-headline-title {
        font-size: 0.98rem;
        font-weight: 750;
        color: #f8fafc;
        line-height: 1.45;
        margin-bottom: 12px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 2.8em;
    }

    .book-info-spec {
        font-size: 0.82rem;
        color: #94a3b8;
        margin-bottom: 7px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .book-info-spec i {
        color: #64748b;
        width: 14px;
        text-align: center;
    }

    .book-info-spec strong {
        color: #cbd5e1;
        font-weight: 600;
    }

    /* FOOTER AKSI */
    .mainframe-action-footer {
        padding: 12px 17px 16px;
        border-top: 1px solid rgba(255,255,255,0.06);
        display: flex;
        align-items: center;
        gap: 9px;
    }

    .action-label {
        font-size: 0.75rem;
        color: #64748b;
        margin-right: auto;
        font-weight: 600;
    }

    .btn-console-tool {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        font-size: 0.85rem;
        transition: all 0.2s ease;
        text-decoration: none;
        cursor: pointer;
    }

    .tool-view {
        background: rgba(148,163,184,0.1);
        color: #cbd5e1;
        border: 1px solid rgba(148,163,184,0.15);
    }

    .tool-view:hover {
        background: #475569;
        color: #fff;
    }

    .tool-edit {
        background: rgba(59,130,246,0.12);
        color: #60a5fa;
        border: 1px solid rgba(59,130,246,0.2);
    }

    .tool-edit:hover {
        background: #3b82f6;
        color: #fff;
    }

    .tool-delete {
        background: rgba(239,68,68,0.1);
        color: #f87171;
        border: 1px solid rgba(239,68,68,0.2);
    }

    .tool-delete:hover {
        background: #ef4444;
        color: #fff;
    }

    .mainframe-action-footer form {
        margin: 0;
    }

    /* EMPTY STATE */
    .empty-state {
        background: #111827;
        border: 1px dashed rgba(255,255,255,0.12);
        border-radius: 15px;
        padding: 45px 20px;
        text-align: center;
        color: #94a3b8;
    }

    .empty-state i {
        font-size: 2.8rem;
        color: #475569;
        margin-bottom: 15px;
    }

    .empty-state h4 {
        font-size: 1.05rem;
        font-weight: 700;
        color: #f8fafc;
        margin-bottom: 8px;
    }

    .empty-state p {
        font-size: 0.85rem;
        margin-bottom: 20px;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .page-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .page-title {
            font-size: 1.25rem;
        }

        .btn-console-primary {
            width: 100%;
        }

        .cyber-books-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .book-cover-frame {
            height: 190px;
        }

        .book-meta-body {
            padding: 13px;
        }

        .book-headline-title {
            font-size: 0.88rem;
        }

        .mainframe-action-footer {
            padding: 10px 12px 13px;
            gap: 6px;
        }

        .action-label {
            display: none;
        }

        .genre-row-header {
            align-items: flex-start;
        }
    }

    @media (max-width: 380px) {
        .cyber-books-grid {
            grid-template-columns: 1fr;
        }

        .book-cover-frame {
            height: 250px;
        }
    }
</style>
@endpush

@section('content')
<div class="console-container">

<div style="background: red; color: white; padding: 20px; font-size: 24px;">
    TEST UI BARU SUDAH TERBACA
</div>

    {{-- HEADER HALAMAN --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Kelola Genre & Buku</h1>
            <p class="page-description">
                Kelola koleksi buku dan kategori genre pada platform Safae.
            </p>
        </div>

        <a href="{{ route('books.create') }}" class="btn-console-primary">
            <i class="fas fa-plus"></i>
            Tambah Buku
        </a>
    </div>

    {{-- NOTIFIKASI SUKSES --}}
    @if (session('success'))
        <div class="log-alert-success mb-4 d-flex align-items-center gap-3">
            <i class="fa-solid fa-circle-check"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- FILTER GENRE --}}
    <div class="filter-panel">
        <div class="filter-heading">
            <i class="fas fa-filter"></i>
            Filter Berdasarkan Genre
        </div>

        <p class="filter-description">
            Pilih genre untuk melihat koleksi buku berdasarkan kategori.
        </p>

        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('genre.index') }}"
               class="filter-pill {{ empty($current_genre) ? 'active' : '' }}">
                <i class="fas fa-layer-group"></i>
                Semua Buku
            </a>

            @foreach($all_genres as $g)
                <a href="{{ route('genre.index', ['genre' => $g]) }}"
                   class="filter-pill {{ ($current_genre == $g) ? 'active' : '' }}">
                    {{ $g }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- KONDISI 1: JIKA GENRE DIPILIH --}}
    @if(!empty($current_genre))

        <div class="genre-section">

            <div class="genre-row-header">
                <h3 class="genre-heading">
                    <i class="fa-solid fa-folder-open"></i>
                    {{ $current_genre }}
                </h3>

                <span class="text-muted small">
                    {{ $books_to_show->total() }} Buku
                </span>
            </div>

            <div class="cyber-books-grid">

                @forelse($books_to_show as $book)

                    <div class="book-slate-card">

                        {{-- COVER BUKU --}}
                        <div class="book-cover-frame">
                            @if (!empty($book['image_path']))
                                <img src="{{ asset($book['image_path']) }}" alt="Cover {{ $book['title'] }}">
                            @else
                                <div class="book-cover-placeholder">
                                    <i class="fas fa-book-open"></i>
                                    <span>Cover tidak tersedia</span>
                                </div>
                            @endif
                        </div>

                        {{-- INFORMASI BUKU --}}
                        <div class="book-meta-body">
                            <h5 class="book-headline-title">
                                {{ $book['title'] }}
                            </h5>

                            <div class="book-info-spec">
                                <i class="fas fa-user-pen"></i>
                                <span>{{ $book['author'] }}</span>
                            </div>

                            <div class="book-info-spec">
                                <i class="fas fa-calendar"></i>
                                <span>{{ $book['year'] }}</span>
                            </div>
                        </div>

                        {{-- TOMBOL AKSI --}}
                        <div class="mainframe-action-footer">
                            <span class="action-label">Aksi</span>

                            <a href="{{ route('books.show', $book['id']) }}"
                               class="btn-console-tool tool-view"
                               title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>

                            <a href="{{ route('books.edit', $book['id']) }}"
                               class="btn-console-tool tool-edit"
                               title="Edit Buku">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form method="POST" action="{{ route('books.delete') }}">
                                @csrf
                                <input type="hidden" name="id" value="{{ $book['id'] }}">
                                <input type="hidden" name="genre_filter" value="{{ $current_genre }}">

                                <button type="submit"
                                        class="btn-console-tool tool-delete"
                                        title="Hapus Buku"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    @include('partials.view-modal', ['book' => $book])

                @empty

                    <div class="empty-state" style="grid-column: 1 / -1;">
                        <i class="fas fa-book-open d-block"></i>
                        <h4>Belum Ada Buku</h4>
                        <p>Belum ada koleksi buku dalam genre {{ $current_genre }}.</p>
                    </div>

                @endforelse

            </div>

            <div class="mt-4">
                {{ $books_to_show->links() }}
            </div>

        </div>

    {{-- KONDISI 2: TAMPILKAN SEMUA GENRE --}}
    @else

        @if($grouped_books->isNotEmpty())

            @foreach($grouped_books as $genreName => $booksInGenre)

                <div class="genre-section">

                    <div class="genre-row-header">
                        <h3 class="genre-heading">
                            <i class="fa-solid fa-folder"></i>
                            {{ $genreName }}
                        </h3>

                        <a href="{{ route('genre.index', ['genre' => $genreName]) }}"
                           class="btn-view-all">
                            Lihat Semua
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>

                    <div class="cyber-books-grid">

                        @foreach($booksInGenre->take(4) as $book)

                            <div class="book-slate-card">

                                {{-- COVER BUKU --}}
                                <div class="book-cover-frame">
                                    @if (!empty($book['image_path']))
                                        <img src="{{ asset($book['image_path']) }}" alt="Cover {{ $book['title'] }}">
                                    @else
                                        <div class="book-cover-placeholder">
                                            <i class="fas fa-book-open"></i>
                                            <span>Cover tidak tersedia</span>
                                        </div>
                                    @endif
                                </div>

                                {{-- INFORMASI BUKU --}}
                                <div class="book-meta-body">
                                    <h5 class="book-headline-title">
                                        {{ $book['title'] }}
                                    </h5>

                                    <div class="book-info-spec">
                                        <i class="fas fa-user-pen"></i>
                                        <span>{{ $book['author'] }}</span>
                                    </div>

                                    <div class="book-info-spec">
                                        <i class="fas fa-calendar"></i>
                                        <span>{{ $book['year'] }}</span>
                                    </div>
                                </div>

                                {{-- TOMBOL AKSI --}}
                                <div class="mainframe-action-footer">
                                    <span class="action-label">Aksi</span>

                                    <a href="{{ route('books.show', $book['id']) }}"
                                       class="btn-console-tool tool-view"
                                       title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ route('books.edit', $book['id']) }}"
                                       class="btn-console-tool tool-edit"
                                       title="Edit Buku">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form method="POST" action="{{ route('books.delete') }}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $book['id'] }}">
                                        <input type="hidden" name="genre_filter" value="">

                                        <button type="submit"
                                                class="btn-console-tool tool-delete"
                                                title="Hapus Buku"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            @include('partials.view-modal', ['book' => $book])

                        @endforeach

                    </div>
                </div>

            @endforeach

        @else

            {{-- EMPTY STATE --}}
            <div class="empty-state">
                <i class="fas fa-book-open d-block"></i>
                <h4>Belum Ada Koleksi Buku</h4>
                <p>Tambahkan buku pertama untuk mulai mengelola koleksi Safae.</p>

                <a href="{{ route('books.create') }}" class="btn-console-primary">
                    <i class="fas fa-plus"></i>
                    Tambah Buku
                </a>
            </div>

        @endif

    @endif

</div>
@endsection