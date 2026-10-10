@extends('layouts.layoutsAdmin')

@section('title', 'Admin Console - Kelola Genre & Buku')

@push('styles')
<style>
    .console-container {
        width: 100%;
        color: #f8fafc;
    }

    /* Core Action Button (Tambah Buku) */
    .btn-console-primary {
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

    .btn-console-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(6, 182, 212, 0.4);
        color: #fff;
    }

    /* Filter Terminal Bar Component */
    .filter-panel {
        background: #111827;
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 14px;
        padding: 20px;
    }

    .filter-title {
        font-size: 0.75rem;
        font-weight: 700;
        color: #64748b;
        letter-spacing: 1.5px;
        text-transform: uppercase;
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

    /* Section Heading Group */
    .genre-row-header {
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        padding-bottom: 12px;
        font-weight: 800;
        letter-spacing: -0.5px;
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

    /* Books Dashboard Grid System */
    .cyber-books-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1.5rem;
    }

    /* Cyber Hard-Slate Book Card */
    .book-slate-card {
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

    .book-slate-card:hover {
        transform: translateY(-3px);
        border-color: rgba(6, 182, 212, 0.25);
    }

    .book-cover-frame {
        height: 260px;
        background: #1e293b;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        position: relative;
    }

    .book-cover-frame img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .book-meta-body {
        padding: 18px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .book-headline-title {
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

    .book-info-spec {
        font-size: 0.85rem;
        color: #64748b;
        margin-bottom: 4px;
    }

    .book-info-spec strong {
        color: #94a3b8;
    }

    /* Footer Controller Buttons Group */
    .mainframe-action-footer {
        padding: 12px 18px 18px;
        border-top: 1px solid rgba(255, 255, 255, 0.03);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .btn-console-tool {
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

    /* Core Log Alert Box */
    .log-alert-success {
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
<div class="console-container">

    {{-- TERMINAL HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom border-secondary border-opacity-10 pb-3">
        <div>
            <h1 class="h4 fw-bold text-white m-0 tracking-wider">GENRE_&_BOOKS_REGISTRY</h1>
            <small class="text-muted font-monospace" style="font-size: 0.72rem;">SYSTEM // CENTRAL_INVENTORY_PROTOCOL</small>
        </div>
    </div>

    {{-- LOG ACTION NOTIFICATION --}}
    @if (session('success'))
        <div class="log-alert-success mb-4 shadow-sm d-flex align-items-center gap-3 font-monospace">
            <i class="fa-solid fa-terminal text-primary"></i>
            <span>LOG_FEED: {{ session('success') }}</span>
        </div>
    @endif

    {{-- RECORD CREATION TRIGGER --}}
    <div class="mb-4">
        <a href="{{ route('admin.books.create') }}" class="btn-console-primary">
            <i class="fas fa-plus"></i> NEW_BOOK_RECORD
        </a>
    </div>

    {{-- FILTER GENRE PANEL --}}
    <div class="filter-panel mb-5">
        <div class="filter-title mb-3">
            <i class="fas fa-filter me-1 text-primary"></i> INDEX_FILTER_BY_GENRE
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('admin.genre.index') }}"
               class="filter-pill {{ empty($current_genre) ? 'active' : '' }}">
                ALL_RECORDS
            </a>

            @foreach($all_genres as $g)
                <a href="{{ route('admin.genre.index', ['genre' => $g]) }}"
                   class="filter-pill {{ ($current_genre == $g) ? 'active' : '' }}">
                    {{ strtoupper($g) }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- ================= KONDISI 1: JIKA GENRE DIPILIH ================= --}}
    @if(!empty($current_genre))
        <div class="mb-5">
            <div class="genre-row-header d-flex align-items-center mb-4">
                <h3 class="h5 text-white m-0 tracking-tight font-monospace">
                    <i class="fa-solid fa-folder-open text-primary me-2"></i>{{ strtoupper($current_genre) }}
                </h3>
            </div>

            <div class="cyber-books-grid mb-4">
                @forelse($books_to_show as $book)
                <div class="book-slate-card">
                    <div class="book-cover-frame">
                        @if (!empty($book['image_path']))
                            <img src="{{ asset($book['image_path']) }}" alt="Cover">
                        @else
                            <i class="fas fa-barcode fa-2x text-muted"></i>
                        @endif
                    </div>

                    <div class="book-meta-body">
                        <h5 class="book-headline-title">{{ $book['title'] }}</h5>
                        <div>
                            <div class="book-info-spec"><strong>AUTH //</strong> {{ $book['author'] }}</div>
                            <div class="book-info-spec"><strong>YEAR //</strong> {{ $book['year'] }}</div>
                        </div>
                    </div>

                    <div class="mainframe-action-footer">
                        <a href="{{ route('admin.books.show', $book['id']) }}" class="btn-console-tool tool-view" title="View Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.books.edit', $book['id']) }}" class="btn-console-tool tool-edit" title="Edit Record">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST" action="{{ url('/books/delete') }}" class="m-0">
                            @csrf
                            <input type="hidden" name="id" value="{{ $book['id'] }}">
                            <input type="hidden" name="genre_filter" value="{{ $current_genre }}"> 
                            <button type="submit" class="btn-console-tool tool-delete" title="Purge Record" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>

                @include('partials.view-modal', ['book' => $book])

                @empty
                <div class="col-12">
                    <div class="alert alert-secondary border-0 font-monospace rounded-3 opacity-75" style="background: rgba(255,255,255,0.02); color: #94a3b8;">
                        NO_RECORDS_FOUND // No books found in the "{{ $current_genre }}" genre.
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
                <div class="genre-row-header d-flex justify-content-between align-items-center mb-4">
                    <h3 class="h5 text-white m-0 tracking-tight font-monospace">
                        <i class="fa-solid fa-folder text-muted me-2"></i>{{ strtoupper($genreName) }}
                    </h3>
                    <a href="{{ url('/genre', ['genre' => $genreName]) }}" class="btn-view-all font-monospace">
                        EXPAND_ALL <i class="fa-solid fa-arrow-right-long ms-1 small"></i>
                    </a>
                </div>

                <div class="cyber-books-grid">
                    @foreach($booksInGenre->take(4) as $book)
                    <div class="book-slate-card">
                        <div class="book-cover-frame">
                            @if (!empty($book['image_path']))
                                <img src="{{ asset($book['image_path']) }}" alt="Cover">
                            @else
                                <i class="fas fa-barcode fa-2x text-muted"></i>
                            @endif
                        </div>

                        <div class="book-meta-body">
                            <h5 class="book-headline-title">{{ $book['title'] }}</h5>
                            <div>
                                <div class="book-info-spec"><strong>AUTH //</strong> {{ $book['author'] }}</div>
                                <div class="book-info-spec"><strong>YEAR //</strong> {{ $book['year'] }}</div>
                            </div>
                        </div>

                        <div class="mainframe-action-footer">
                            <a href="{{ route('admin.books.show', $book['id']) }}" class="btn-console-tool tool-view" title="View Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.buku.edit', $book['id']) }}" class="btn-console-tool tool-edit" title="Edit Record">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ url('/books/delete') }}" class="m-0">
                                @csrf
                                <input type="hidden" name="id" value="{{ $book['id'] }}">
                                <input type="hidden" name="genre_filter" value="">
                                <button type="submit" class="btn-console-tool tool-delete" title="Purge Record" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">
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
            <div class="text-center py-5 font-monospace" style="color: #64748b;">
                <i class="fas fa-book-open fa-3x mb-3 opacity-50"></i>
                <h4 class="text-white h5">NO_DATA_IN_MAIN_REGISTRY</h4>
                <p class="small mb-3">Add your first book record to get started.</p>
                <a href="{{ url('/books/create') }}" class="btn-console-primary py-2 px-3 fs-7">
                    <i class="fas fa-plus"></i> ADD_FIRST_RECORD
                </a>
            </div>
        @endif
    @endif

</div>
@endsection