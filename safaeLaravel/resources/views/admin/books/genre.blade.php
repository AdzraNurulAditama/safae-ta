@extends('layouts.layoutsAdmin')

@section('title', 'Admin Dashboard - Kelola Genre & Buku')

@push('styles')
<style>
    .admin-container {
        width: 100%;
        color: #f8fafc;
    }

    /* Tombol Tambah Buku */
    .btn-admin-primary {
        background: linear-gradient(135deg, #06b6d4, #3b82f6);
        color: #fff;
        font-weight: 700;
        border: none;
        padding: 12px 24px;
        border-radius: 10px;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 15px rgba(6, 182, 212, 0.25);
    }

    .btn-admin-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(6, 182, 212, 0.4);
        color: #fff;
    }

    /* Panel Filter */
    .filter-panel {
        background: #111827;
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 14px;
        padding: 20px;
    }

    .filter-title {
        font-size: 0.85rem;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .filter-pill {
        background: rgba(255, 255, 255, 0.02);
        color: #94a3b8;
        border: 1px solid rgba(255, 255, 255, 0.05);
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.88rem;
        text-decoration: none;
        transition: all 0.15s ease;
    }

    .filter-pill:hover {
        background: rgba(255, 255, 255, 0.05);
        color: #fff;
    }

    .filter-pill.active {
        background: rgba(6, 182, 212, 0.08) !important;
        color: #06b6d4 !important;
        border-color: #06b6d4 !important;
        font-weight: 700;
    }

    /* Heading Section */
    .genre-section-header {
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        padding-bottom: 12px;
    }

    .btn-view-all {
        color: #06b6d4;
        font-weight: 700;
        font-size: 0.85rem;
        text-decoration: none;
        transition: color 0.15s;
    }

    .btn-view-all:hover {
        color: #22d3ee;
        text-decoration: underline;
    }

    /* Grid Buku */
    .books-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1.5rem;
    }

    /* Kartu Buku */
    .book-admin-card {
        background: #111827;
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 14px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        transition: transform 0.2s, border-color 0.2s;
    }

    .book-admin-card:hover {
        transform: translateY(-3px);
        border-color: rgba(6, 182, 212, 0.25);
    }

    .book-cover-wrapper {
        height: 260px;
        background: #1e293b;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .book-cover-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .book-details {
        padding: 18px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .book-card-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: #fff;
        line-height: 1.4;
        margin-bottom: 8px;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .book-card-text {
        font-size: 0.85rem;
        color: #64748b;
        margin-bottom: 4px;
    }

    .book-card-text strong {
        color: #94a3b8;
    }

    /* Footer Tombol Aksi */
    .card-action-footer {
        padding: 12px 18px 18px;
        border-top: 1px solid rgba(255, 255, 255, 0.03);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .btn-action-tool {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        font-size: 0.85rem;
        border: none;
        transition: all 0.15s ease;
        text-decoration: none;
        cursor: pointer;
    }

    .tool-view {
        background: rgba(255, 255, 255, 0.03);
        color: #94a3b8;
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .tool-view:hover {
        background: rgba(255, 255, 255, 0.08);
        color: #fff;
    }

    .tool-edit {
        background: rgba(59, 130, 246, 0.1);
        color: #60a5fa;
        border: 1px solid rgba(59, 130, 246, 0.2);
    }

    .tool-edit:hover {
        background: #3b82f6;
        color: #fff;
    }

    .tool-delete {
        background: rgba(239, 68, 68, 0.1);
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .tool-delete:hover {
        background: #ef4444;
        color: #fff;
    }

    .alert-admin-success {
        background: rgba(6, 182, 212, 0.04);
        border: 1px solid rgba(6, 182, 212, 0.25);
        color: #22d3ee;
        border-radius: 12px;
        padding: 14px 18px;
        font-size: 0.9rem;
    }
</style>
@endpush

@section('content')
<div class="admin-container">
    
    {{-- HEADER HALAMAN --}}
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom border-secondary border-opacity-10 pb-3">
        <div>
            <h1 class="h4 fw-bold text-white m-0">Kelola Genre & Buku</h1>
            <small class="text-muted">Halaman Administrasi Data Buku Utama</small>
        </div>
    </div>

    {{-- NOTIFIKASI BERHASIL --}}
    @if (session('success'))
        <div class="alert alert-admin-success mb-4 shadow-sm d-flex align-items-center gap-2">
            <i class="fa-solid fa-check-circle text-primary"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- TOMBOL TAMBAH BUKU --}}
    <div class="mb-4">
        <a href="{{ route('admin.books.create') }}" class="btn-admin-primary">
            <i class="fas fa-plus"></i> Tambah Buku Baru
        </a>
    </div>

    {{-- PANEL FILTER BERDASARKAN GENRE --}}
    <div class="filter-panel mb-5">
        <div class="filter-title mb-3">
            <i class="fas fa-filter me-1 text-primary"></i> Filter Berdasarkan Genre
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('admin.genre.index') }}"
               class="filter-pill {{ empty($current_genre) ? 'active' : '' }}">
                Semua Buku
            </a>

            @foreach($all_genres as $g)
                <a href="{{ route('admin.genre.index', ['genre' => $g]) }}"
                   class="filter-pill {{ ($current_genre == $g) ? 'active' : '' }}">
                    {{ $g }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- ================= KONDISI 1: JIKA GENRE DIPILIH ================= --}}
    @if(!empty($current_genre))
        <div class="mb-5">
            <div class="genre-section-header d-flex align-items-center mb-4">
                <h3 class="h5 text-white m-0 fw-bold">
                    <i class="fa-solid fa-folder-open text-primary me-2"></i>Genre: {{ $current_genre }}
                </h3>
            </div>

            <div class="books-grid mb-4">
                @forelse($books_to_show as $book)
                <div class="book-admin-card">
                    <div class="book-cover-wrapper">
                        @if ($book->image_path)
                            <img src="{{ asset($book->image_path) }}" alt="Cover">
                        @else
                            <i class="fas fa-book fa-2x text-muted"></i>
                        @endif
                    </div>

                    <div class="book-details">
                        <h5 class="book-card-title">{{ $book->title }}</h5>
                        <div>
                            <div class="book-card-text"><strong>Penulis:</strong> {{ $book->author }}</div>
                            <div class="book-card-text"><strong>Tahun:</strong> {{ $book->year }}</div>
                        </div>
                    </div>

                    <div class="card-action-footer">
                        <a href="{{ route('admin.books.show', $book->id) }}" class="btn-action-tool tool-view" title="Lihat Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.books.edit', $book->id) }}" class="btn-action-tool tool-edit" title="Edit Buku">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST" action="{{ url('/books/delete') }}" class="m-0">
                            @csrf
                            <input type="hidden" name="id" value="{{ $book->id }}">
                            <input type="hidden" name="genre_filter" value="{{ $current_genre }}"> 
                            <button type="submit" class="btn-action-tool tool-delete" title="Hapus Buku" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>

                @include('partials.view-modal', ['book' => $book])

                @empty
                <div class="col-12">
                    <div class="alert alert-secondary border-0 rounded-3 opacity-75" style="background: rgba(255,255,255,0.02); color: #94a3b8;">
                        Belum ada data buku untuk genre "{{ $current_genre }}".
                    </div>
                </div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $books_to_show->links() }}
            </div>
        </div>

    {{-- ================= KONDISI 2: SEMUA REKOR GENRE LENGKAP ================= --}}
    @else
        @if($grouped_books->isNotEmpty())
            @foreach($grouped_books as $genreName => $booksInGenre)
            <div class="mb-5">
                <div class="genre-section-header d-flex justify-content-between align-items-center mb-4">
                    <h3 class="h5 text-white m-0 fw-bold">
                        <i class="fa-solid fa-folder text-muted me-2"></i>{{ $genreName }}
                    </h3>
                    <a href="{{ url('/genre', ['genre' => $genreName]) }}" class="btn-view-all">
                        Lihat Semua <i class="fa-solid fa-arrow-right-long ms-1 small"></i>
                    </a>
                </div>

                <div class="books-grid">
                    @foreach($booksInGenre->take(4) as $book)
                    <div class="book-admin-card">
                        <div class="book-cover-wrapper">
                            @if ($book->image_path)
                                <img src="{{ asset($book->image_path) }}" alt="Cover">
                            @else
                                <i class="fas fa-book fa-2x text-muted"></i>
                            @endif
                        </div>

                        <div class="book-details">
                            <h5 class="book-card-title">{{ $book->title }}</h5>
                            <div>
                                <div class="book-card-text"><strong>Penulis:</strong> {{ $book->author }}</div>
                                <div class="book-card-text"><strong>Tahun:</strong> {{ $book->year }}</div>
                            </div>
                        </div>

                        <div class="card-action-footer">
                            <a href="{{ route('admin.books.show', $book->id) }}" class="btn-action-tool tool-view" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.books.edit', $book->id) }}" class="btn-action-tool tool-edit" title="Edit Buku">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ url('/books/delete') }}" class="m-0">
                                @csrf
                                <input type="hidden" name="id" value="{{ $book->id }}">
                                <input type="hidden" name="genre_filter" value="">
                                <button type="submit" class="btn-action-tool tool-delete" title="Hapus Buku" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">
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
            <div class="text-center py-5" style="color: #64748b;">
                <i class="fas fa-book-open fa-3x mb-3 opacity-50"></i>
                <h4 class="text-white h5">Belum Ada Data Buku</h4>
                <p class="small mb-3">Silakan tambahkan data buku pertama kamu di sistem ini.</p>
                <a href="{{ route('admin.books.create') }}" class="btn-admin-primary py-2 px-3 fs-7">
                    <i class="fas fa-plus"></i> Tambah Buku Baru
                </a>
            </div>
        @endif
    @endif

</div>
@endsection