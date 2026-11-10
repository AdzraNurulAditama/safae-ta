
@extends('layouts.app')

@section('title', 'Buku Favorit')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

:root {
    --fav-purple: #a394d0;
    --fav-purple-light: #eee9ff;
    --fav-blue: #e5efff;
    --fav-pink: #ffe8ef;
    --fav-pink-dark: #d98da9;
    --fav-text: #4d4964;
    --fav-muted: #9290a3;
}

.favorite-page {
    max-width: 1450px;
    margin: 0 auto;
    padding: 35px 30px 60px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: var(--fav-text);
}

/* HEADER */

.favorite-heading {
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

.favorite-heading-content {
    display: flex;
    align-items: center;
    gap: 20px;
}

.favorite-heading-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 65px;
    height: 65px;
    flex-shrink: 0;
    border-radius: 20px;
    background: rgba(255,255,255,.75);
    color: #d78ca9;
    font-size: 27px;
}

.favorite-header {
    margin: 0;
    color: #4e4967;
    font-size: 27px;
    font-weight: 800;
}

.favorite-subtitle {
    margin: 7px 0 0;
    color: #858198;
    font-size: 13px;
    line-height: 1.7;
}

.favorite-count {
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 12px 18px;
    border: 1px solid rgba(255,255,255,.8);
    border-radius: 30px;
    background: rgba(255,255,255,.7);
    color: #907dbb;
    font-size: 12px;
    font-weight: 800;
    white-space: nowrap;
}

/* BOOK GRID */

.favorite-grid {
    display: grid;
    grid-template-columns: repeat(5, minmax(0, 1fr));
    gap: 25px;
}

.favorite-col {
    min-width: 0;
}

.book-card {
    height: 100%;
    overflow: hidden;
    border: 1px solid #eeeaf5;
    border-radius: 19px;
    background: #fff;
    box-shadow: 0 7px 22px rgba(130, 125, 165, .08);
    transition: transform .25s ease, box-shadow .25s ease;
}

.book-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 14px 30px rgba(130, 125, 165, .15);
}

.book-card-link {
    display: block;
    color: inherit;
    text-decoration: none;
}

/* COVER */

.card-img-wrapper {
    position: relative;
    width: 100%;
    height: 255px;
    overflow: hidden;
    background: linear-gradient(135deg, #e6edff, #f0eaff, #ffeaf1);
}

.card-img-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .35s ease;
}

.book-card:hover .card-img-wrapper img {
    transform: scale(1.05);
}

/* BOOK INFORMATION */

.book-card .card-body {
    min-height: 115px;
    padding: 18px 15px;
    background: #fff;
    text-align: left;
}

.book-title {
    display: -webkit-box;
    overflow: hidden;
    min-height: 42px;
    margin: 0 0 10px;
    color: #4e4a65;
    font-size: 14px;
    font-weight: 800;
    line-height: 1.5;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.book-author {
    display: flex;
    align-items: center;
    gap: 7px;
    overflow: hidden;
    color: #9995a9;
    font-size: 11px;
    white-space: nowrap;
    text-overflow: ellipsis;
}

.book-author i {
    color: #ad9bd0;
}

/* FOOTER & REMOVE BUTTON */

.book-card .card-footer {
    padding: 12px 15px 16px;
    border: none;
    background: #fff;
}

.btn-remove {
    min-height: 39px;
    border: 1px solid #f4d7e2;
    border-radius: 10px;
    background: #fff0f4;
    color: #cb819d;
    font-family: inherit;
    font-size: 12px;
    font-weight: 700;
    transition: .2s ease;
}

.btn-remove:hover {
    border-color: #e8b5c8;
    background: #f9dce7;
    color: #b96787;
}

/* EMPTY STATE */

.empty-state {
    padding: 65px 25px;
    border: 1px dashed #dcd5ee;
    border-radius: 25px;
    background: linear-gradient(135deg, #f5f2ff, #fff3f6);
    text-align: center;
}

.empty-state-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100px;
    height: 100px;
    margin: 0 auto 22px;
    border-radius: 30px;
    background: rgba(255,255,255,.8);
    color: #b29bd6;
    font-size: 42px;
}

.empty-state h4 {
    margin-bottom: 12px;
    color: #514d69;
    font-size: 21px;
    font-weight: 800;
}

.empty-state p {
    max-width: 450px;
    margin: 0 auto 25px;
    color: #9290a2;
    font-size: 13px;
    line-height: 1.8;
}

.btn-explore {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    padding: 13px 23px;
    border: none;
    border-radius: 30px;
    background: linear-gradient(120deg, #a99bd9, #8fa5d9);
    color: white;
    font-family: inherit;
    font-size: 12px;
    font-weight: 800;
    text-decoration: none;
    transition: .2s;
}

.btn-explore:hover {
    transform: translateY(-2px);
    background: linear-gradient(120deg, #9382c8, #7f94ce);
    color: white;
}

/* RESPONSIVE */

@media (max-width: 1200px) {
    .favorite-grid {
        grid-template-columns: repeat(4, minmax(0, 1fr));
    }
}

@media (max-width: 992px) {
    .favorite-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }
}

@media (max-width: 700px) {
    .favorite-page {
        padding: 20px 15px 40px;
    }

    .favorite-heading {
        align-items: flex-start;
        flex-direction: column;
        padding: 23px 20px;
    }

    .favorite-heading-content {
        gap: 14px;
    }

    .favorite-heading-icon {
        width: 52px;
        height: 52px;
        font-size: 22px;
    }

    .favorite-header {
        font-size: 21px;
    }

    .favorite-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 15px;
    }

    .card-img-wrapper {
        height: 205px;
    }

    .book-card .card-body {
        padding: 14px 11px;
    }

    .book-card .card-footer {
        padding: 10px 11px 13px;
    }

    .book-title {
        font-size: 12px;
    }

    .book-author {
        font-size: 10px;
    }
}

@media (max-width: 380px) {
    .favorite-grid {
        grid-template-columns: 1fr;
    }

    .card-img-wrapper {
        height: 260px;
    }
}
</style>

<div class="favorite-page">

    {{-- HEADER --}}
    <div class="favorite-heading">

        <div class="favorite-heading-content">
            <div class="favorite-heading-icon">
                <i class="fa-solid fa-heart"></i>
            </div>

            <div>
                <h3 class="favorite-header">
                    Buku Favorit Saya
                </h3>

                <p class="favorite-subtitle">
                    Kumpulan cerita pilihan yang kamu simpan di Safae.
                </p>
            </div>
        </div>

        <div class="favorite-count">
            <i class="fa-solid fa-bookmark"></i>
            {{ $favorites->count() }} Favorit
        </div>

    </div>

    {{-- DAFTAR BUKU FAVORIT --}}
    @if($favorites->count() > 0)

        <div class="favorite-grid">

            @foreach ($favorites as $fav)

                @if($fav->book)

                    <div class="favorite-col">

                        <div class="book-card">

                            <a href="{{ route('fullbacaan.show', $fav->book->id) }}"
                               class="book-card-link">

                                {{-- COVER BUKU --}}
                                <div class="card-img-wrapper">

                                    @php
                                        $rawPath = $fav->book->image_path ?? $fav->book->cover ?? $fav->book->gambar ?? $fav->book->image ?? null;
                                        $imageUrl = 'https://via.placeholder.com/300x400?text=No+Cover';

                                        if (!empty($rawPath)) {
                                            // 1. Jika URL penuh (http:// atau https://)
                                            if (\Illuminate\Support\Str::startsWith($rawPath, ['http://', 'https://'])) {
                                                $imageUrl = $rawPath;
                                            }
                                            // 2. Jika path disimpan lengkap di public/
                                            elseif (file_exists(public_path($rawPath))) {
                                                $imageUrl = asset($rawPath);
                                            }
                                            // 3. Jika nama file ada di folder public/uploads/cover/
                                            elseif (file_exists(public_path('uploads/cover/' . basename($rawPath)))) {
                                                $imageUrl = asset('uploads/cover/' . basename($rawPath));
                                            }
                                            // 4. Fallback ke folder storage
                                            else {
                                                $cleanPath = str_replace(['public/', 'storage/'], '', ltrim($rawPath, '/'));
                                                $imageUrl = asset('storage/' . $cleanPath);
                                            }
                                        }
                                    @endphp

                                    <img
                                        src="{{ $imageUrl }}"
                                        alt="{{ $fav->book->title }}"
                                        onerror="this.onerror=null; this.src='https://via.placeholder.com/300x400?text=No+Cover';"
                                    >

                                </div>

                                {{-- INFORMASI BUKU --}}
                                <div class="card-body">

                                    <h6 class="book-title" title="{{ $fav->book->title }}">
                                        {{ $fav->book->title }}
                                    </h6>

                                    <small class="book-author">
                                        <i class="fa-solid fa-user"></i>
                                        {{ $fav->book->author }}
                                    </small>

                                </div>

                            </a>

                            {{-- HAPUS FAVORIT --}}
                            <div class="card-footer">

                                <form action="{{ route('favorite.hapus') }}" method="POST">
                                    @csrf

                                    <input
                                        type="hidden"
                                        name="book_id"
                                        value="{{ $fav->book->id }}"
                                    >

                                    <button type="submit" class="btn btn-remove w-100">
                                        <i class="fa-solid fa-heart-crack me-1"></i>
                                        Hapus dari Favorit
                                    </button>

                                </form>

                            </div>

                        </div>

                    </div>

                @endif

            @endforeach

        </div>

    @else

        {{-- EMPTY STATE --}}
        <div class="empty-state">

            <div class="empty-state-icon">
                <i class="fa-solid fa-book-heart"></i>
            </div>

            <h4>Belum Ada Buku Favorit</h4>

            <p>
                Sepertinya kamu belum menyimpan buku favorit.
                Jelajahi koleksi Safae dan simpan cerita yang kamu sukai
                agar mudah ditemukan kembali!
            </p>

            <a href="{{ route('genre.index') }}" class="btn-explore">
                <i class="fa-solid fa-magnifying-glass"></i>
                Mulai Eksplorasi
            </a>

        </div>

    @endif

</div>

@endsection
