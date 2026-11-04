@extends('layouts.layoutsAdmin')

@section('content')

<style>
    .genre-page {
        color: #292044;
        padding: 15px 8px 35px;
        font-family: inherit;
    }

    /* HEADER */
    .genre-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 28px;
        padding: 22px 24px;
        background: linear-gradient(120deg, #f0edff, #ffffff);
        border: 1px solid #e4defd;
        border-radius: 16px;
    }

    .genre-header h2 {
        font-size: 25px;
        font-weight: 800;
        margin: 0 0 8px;
        color: #302052;
        letter-spacing: -.5px;
    }

    .genre-header p {
        color: #62577e;
        font-size: 13px;
        font-weight: 500;
        margin: 0;
    }

    .btn-add-book {
        background: #7053c8;
        color: #fff !important;
        padding: 12px 19px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 9px;
        box-shadow: 0 4px 12px rgba(112, 83, 200, .2);
        transition: .2s;
    }

    .btn-add-book:hover {
        background: #573cae;
        transform: translateY(-2px);
        box-shadow: 0 7px 15px rgba(112, 83, 200, .25);
    }

    /* ALERT */
    .genre-alert {
        padding: 13px 17px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 13px;
        font-weight: 600;
    }

    .genre-alert.success {
        background: #e6f8ed;
        color: #176b3c;
        border: 1px solid #b8e8c9;
    }

    .genre-alert.error {
        background: #fff0f0;
        color: #b52e38;
        border: 1px solid #f5caca;
    }

    /* FILTER GENRE */
    .genre-filter {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 30px;
    }

    .genre-filter a {
        padding: 9px 17px;
        border: 1px solid #ded7f2;
        border-radius: 9px;
        text-decoration: none;
        color: #49396d;
        font-size: 12px;
        font-weight: 700;
        background: #fff;
        transition: .2s;
    }

    .genre-filter a:hover {
        background: #f0edff;
        color: #6346bb;
        border-color: #a998e5;
    }

    .genre-filter a.active {
        background: #7053c8;
        color: #fff;
        border-color: #7053c8;
        box-shadow: 0 3px 9px rgba(112, 83, 200, .2);
    }

    /* SECTION GENRE */
    .genre-section {
        margin-bottom: 32px;
        padding: 20px;
        background: #fff;
        border: 1px solid #e9e4f5;
        border-radius: 15px;
        box-shadow: 0 3px 12px rgba(48, 32, 82, .04);
    }

    .genre-section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 19px;
        gap: 10px;
        padding-bottom: 14px;
        border-bottom: 1px solid #eeeaf7;
    }

    .genre-section-header h3 {
        font-size: 17px;
        font-weight: 800;
        margin: 0;
        color: #302052;
    }

    .genre-section-header h3 i {
        color: #7053c8;
        margin-right: 7px;
    }

    .genre-section-header h3 span {
        color: #584878 !important;
        font-weight: 700 !important;
    }

    .genre-section-header a {
        color: #6546bd;
        font-size: 12px;
        text-decoration: none;
        font-weight: 700;
    }

    .genre-section-header a:hover {
        color: #3e278d;
    }

    /* BOOK GRID */
    .genre-book-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(190px, 1fr));
        gap: 18px;
    }

    .genre-book-card {
        background: #fff;
        border: 1px solid #e9e4f5;
        border-radius: 13px;
        overflow: hidden;
        transition: .25s ease;
    }

    .genre-book-card:hover {
        transform: translateY(-5px);
        border-color: #c8b9f0;
        box-shadow: 0 9px 22px rgba(63, 43, 111, .11);
    }

    /* BOOK COVER */
    .genre-book-cover {
        height: 195px;
        background: linear-gradient(145deg, #f0edff, #e5defa);
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
    }

    .genre-book-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: .3s;
    }

    .genre-book-card:hover .genre-book-cover img {
        transform: scale(1.04);
    }

    .genre-book-cover .no-cover {
        color: #7053c8;
        font-size: 38px;
    }

    /* BOOK INFORMATION */
    .genre-book-info {
        padding: 15px;
    }

    .genre-book-info h4 {
        font-size: 14px;
        font-weight: 800;
        margin: 0 0 7px;
        color: #302052;
        line-height: 1.5;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .genre-book-info .book-author {
        color: #594a78;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 13px;
    }

    .book-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 14px;
        gap: 5px;
    }

    .book-year {
        font-size: 11px;
        color: #594a78;
        font-weight: 700;
    }

    .book-status {
        background: #e4f7eb;
        color: #176b3c;
        font-size: 10px;
        font-weight: 800;
        padding: 6px 10px;
        border-radius: 20px;
    }

    /* ACTION BUTTONS */
    .book-actions {
        display: flex;
        gap: 7px;
    }

    .book-actions a,
    .book-actions button {
        flex: 1;
        border: none;
        border-radius: 7px;
        padding: 9px 5px;
        font-size: 11px;
        font-weight: 700;
        text-align: center;
        text-decoration: none;
        cursor: pointer;
        transition: .2s;
    }

    .btn-detail {
        background: #eeeaff;
        color: #573cae !important;
    }

    .btn-edit {
        background: #fff2dc;
        color: #9a5a00 !important;
    }

    .btn-delete {
        background: #ffebeb;
        color: #b52e38 !important;
    }

    .btn-detail:hover {
        background: #dcd3ff;
    }

    .btn-edit:hover {
        background: #ffe3b3;
    }

    .btn-delete:hover {
        background: #ffd2d2;
    }

    /* EMPTY STATE */
    .empty-books {
        background: #faf9ff;
        border: 1px dashed #c9bde9;
        border-radius: 12px;
        padding: 40px 20px;
        text-align: center;
        color: #49396d;
        font-size: 13px;
        font-weight: 600;
    }

    .empty-books i {
        display: block;
        font-size: 34px;
        margin-bottom: 12px;
        color: #7053c8;
    }

    .empty-books p {
        margin: 0;
        color: #49396d;
    }

    /* PAGINATION */
    .pagination-wrapper {
        margin-top: 22px;
        display: flex;
        justify-content: center;
    }

    .pagination-wrapper .pagination {
        gap: 5px;
    }

    .pagination-wrapper .page-link {
        border-radius: 7px !important;
        border: 1px solid #ded7f2;
        color: #573cae;
        font-size: 12px;
        font-weight: 600;
    }

    .pagination-wrapper .active .page-link {
        background: #7053c8;
        border-color: #7053c8;
        color: #fff;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .genre-header {
            padding: 18px;
        }

        .genre-header h2 {
            font-size: 21px;
        }

        .genre-section {
            padding: 14px;
        }

        .genre-book-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 11px;
        }

        .genre-book-cover {
            height: 155px;
        }

        .genre-book-info {
            padding: 11px;
        }

        .book-actions {
            flex-wrap: wrap;
        }
    }

    @media (max-width: 420px) {
        .genre-book-grid {
            grid-template-columns: 1fr 1fr;
        }

        .genre-book-cover {
            height: 125px;
        }

        .genre-book-info h4 {
            font-size: 12px;
        }

        .genre-book-info .book-author {
            font-size: 11px;
        }
    }
</style>

<div class="genre-page">

    {{-- HEADER --}}
    <div class="genre-header">
        <div>
            <h2>Kelola Genre & Buku</h2>
            <p>Kelola koleksi buku dan kategori genre yang tersedia di Safae.</p>
        </div>

        <a href="{{ route('admin.books.create') }}" class="btn-add-book">
            <i class="fa-solid fa-plus"></i>
            Tambah Buku
        </a>
    </div>

    {{-- NOTIFIKASI --}}
    @if(session('success'))
        <div class="genre-alert success">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="genre-alert error">
            <i class="fa-solid fa-circle-exclamation"></i>
            {{ session('error') }}
        </div>
    @endif

    {{-- FILTER GENRE --}}
    <div class="genre-filter">
        <a href="{{ route('admin.genre.index') }}"
           class="{{ empty($current_genre) ? 'active' : '' }}">
            Semua Genre
        </a>

        @foreach($all_genres as $genre)
            <a href="{{ route('admin.genre.index', ['genre' => $genre]) }}"
               class="{{ $current_genre == $genre ? 'active' : '' }}">
                {{ $genre }}
            </a>
        @endforeach
    </div>

    {{-- JIKA GENRE DIPILIH --}}
    @if(!empty($current_genre))

        <div class="genre-section">
            <div class="genre-section-header">
                <h3>
                    <i class="fa-solid fa-book-open"></i>
                    Genre {{ $current_genre }}
                </h3>
            </div>

            @if($books_to_show->count() > 0)

                <div class="genre-book-grid">
                    @foreach($books_to_show as $book)

                        <div class="genre-book-card">

                            <div class="genre-book-cover">
                                @if($book->image_path)
                                    <img src="{{ $book->image_path }}"
                                         alt="{{ $book->title }}">
                                @else
                                    <i class="fa-solid fa-book-open no-cover"></i>
                                @endif
                            </div>

                            <div class="genre-book-info">
                                <h4 title="{{ $book->title }}">
                                    {{ $book->title }}
                                </h4>

                                <div class="book-author">
                                    {{ $book->author }}
                                </div>

                                <div class="book-meta">
                                    <span class="book-year">
                                        {{ $book->year }}
                                    </span>

                                    <span class="book-status">
                                        Disetujui
                                    </span>
                                </div>

                                <div class="book-actions">

                                    <a href="{{ route('admin.books.show', $book->id) }}"
                                       class="btn-detail">
                                        Detail
                                    </a>

                                    <a href="{{ route('admin.books.edit', $book->id) }}"
                                       class="btn-edit">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.books.delete') }}"
                                          method="POST"
                                          style="flex:1;"
                                          onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                        @csrf

                                        <input type="hidden" name="id" value="{{ $book->id }}">

                                        <button type="submit" class="btn-delete" style="width:100%;">
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </div>

                        </div>

                    @endforeach
                </div>

                <div class="pagination-wrapper">
                    {{ $books_to_show->appends(request()->query())->links() }}
                </div>

            @else

                <div class="empty-books">
                    <i class="fa-solid fa-book-open"></i>
                    <p>Belum ada buku pada genre ini.</p>
                </div>

            @endif
        </div>

    {{-- JIKA SEMUA GENRE DITAMPILKAN --}}
    @else

        @forelse($grouped_books as $genre => $books)

            <div class="genre-section">

                <div class="genre-section-header">
                    <h3>
                        <i class="fa-solid fa-bookmark"></i>
                        {{ $genre }}

                        <span style="font-size:11px; color:#9995a9; font-weight:400;">
                            ({{ $books->count() }} buku)
                        </span>
                    </h3>

                    <a href="{{ route('admin.genre.index', ['genre' => $genre]) }}">
                        Lihat Semua <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

                <div class="genre-book-grid">

                    @foreach($books->take(4) as $book)

                        <div class="genre-book-card">

                            <div class="genre-book-cover">
                                @if($book->image_path)
                                    <img src="{{ $book->image_path }}"
                                         alt="{{ $book->title }}">
                                @else
                                    <i class="fa-solid fa-book-open no-cover"></i>
                                @endif
                            </div>

                            <div class="genre-book-info">
                                <h4 title="{{ $book->title }}">
                                    {{ $book->title }}
                                </h4>

                                <div class="book-author">
                                    {{ $book->author }}
                                </div>

                                <div class="book-meta">
                                    <span class="book-year">
                                        {{ $book->year }}
                                    </span>

                                    <span class="book-status">
                                        Disetujui
                                    </span>
                                </div>

                                <div class="book-actions">

                                    <a href="{{ route('admin.books.show', $book->id) }}"
                                       class="btn-detail">
                                        Detail
                                    </a>

                                    <a href="{{ route('admin.books.edit', $book->id) }}"
                                       class="btn-edit">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.books.delete') }}"
                                          method="POST"
                                          style="flex:1;"
                                          onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                        @csrf

                                        <input type="hidden" name="id" value="{{ $book->id }}">

                                        <button type="submit" class="btn-delete" style="width:100%;">
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

        @empty

            <div class="empty-books">
                <i class="fa-solid fa-book-open"></i>
                <p>Belum ada buku yang tersedia.</p>
            </div>

        @endforelse

    @endif

</div>

@endsection