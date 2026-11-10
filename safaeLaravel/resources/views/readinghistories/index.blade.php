
@extends('layouts.app')

@section('title', 'Riwayat Baca per Genre - Safae')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

:root {
    --history-text: #4d4964;
    --history-muted: #9290a3;
    --history-purple: #a394d0;
    --history-purple-light: #f2effb;
    --history-blue: #eaf1ff;
    --history-pink: #fff0f4;
    --history-green: #e8f6ef;
}

.history-page {
    max-width: 1500px;
    margin: 0 auto;
    padding: 30px 28px 65px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: var(--history-text);
}

/* =========================
   HEADER
========================= */

.history-header {
    position: relative;
    display: flex;
    align-items: center;
    gap: 22px;
    padding: 34px 38px;
    margin-bottom: 35px;
    overflow: hidden;
    border: 1px solid #eee7f8;
    border-radius: 25px;
    background: linear-gradient(115deg, #e7efff, #eee8ff 55%, #ffeaf1);
    box-shadow: 0 8px 25px rgba(145,135,185,.07);
}

.history-header::after {
    content: "";
    position: absolute;
    width: 190px;
    height: 190px;
    right: -45px;
    top: -90px;
    border-radius: 50%;
    background: rgba(255,255,255,.35);
}

.history-header-icon {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    width: 70px;
    height: 70px;
    border-radius: 22px;
    background: rgba(255,255,255,.8);
    color: #9b89ca;
    font-size: 29px;
}

.history-header-content {
    position: relative;
    z-index: 1;
}

.history-header-content h3 {
    margin: 0 0 9px;
    color: #4e4967;
    font-size: 26px;
    font-weight: 800;
}

.history-header-content p {
    margin: 0;
    color: #858198;
    font-size: 13px;
    line-height: 1.8;
}

/* =========================
   ALERT
========================= */

.history-alert {
    display: flex;
    align-items: center;
    gap: 11px;
    padding: 16px 20px;
    margin-bottom: 28px;
    border: 1px solid #ccebdc;
    border-radius: 14px;
    background: #e8f6ef;
    color: #43866c;
    font-size: 13px;
    font-weight: 600;
}

/* =========================
   FILTER
========================= */

.history-filter {
    padding: 23px 25px;
    margin-bottom: 40px;
    border: 1px solid #eee9f5;
    border-radius: 20px;
    background: #fff;
    box-shadow: 0 6px 20px rgba(130,125,165,.05);
}

.filter-heading {
    display: flex;
    align-items: center;
    gap: 9px;
    margin-bottom: 17px;
    color: #77738e;
    font-size: 13px;
    font-weight: 800;
}

.filter-heading i {
    color: #a394d0;
}

.filter-pills {
    display: flex;
    flex-wrap: wrap;
    gap: 11px;
}

.btn-filter {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 11px 18px;
    border: 1px solid #e7e0f5;
    border-radius: 12px;
    background: #faf9fd;
    color: #8980aa;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
    transition: .2s ease;
}

.btn-filter:hover {
    border-color: #c9bce9;
    background: #f0ebff;
    color: #7664a9;
    transform: translateY(-2px);
}

.btn-filter.active {
    border-color: #a99bd9;
    background: linear-gradient(120deg, #a99bd9, #8fa5d9);
    color: #fff;
    box-shadow: 0 5px 12px rgba(143,135,196,.15);
}

/* =========================
   GENRE SECTION
========================= */

.genre-section {
    padding: 27px;
    margin-bottom: 35px;
    border: 1px solid #eee9f5;
    border-radius: 24px;
    background: #fbfaff;
    box-shadow: 0 6px 22px rgba(130,125,165,.045);
    scroll-margin-top: 25px;
}

.genre-section:nth-of-type(even) {
    background: #fffafd;
}

.genre-section-title {
    display: flex;
    align-items: center;
    gap: 13px;
    padding-bottom: 21px;
    margin-bottom: 26px;
    border-bottom: 1px solid #eae5f2;
}

.genre-title-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 45px;
    height: 45px;
    flex-shrink: 0;
    border-radius: 14px;
    background: #eee9ff;
    color: #9a87c8;
    font-size: 18px;
}

.genre-title-content {
    min-width: 0;
}

.genre-title-content h4 {
    margin: 0 0 5px;
    color: #514d69;
    font-size: 17px;
    font-weight: 800;
}

.genre-title-content p {
    margin: 0;
    color: #9995a8;
    font-size: 11px;
}

.genre-book-count {
    flex-shrink: 0;
    margin-left: auto;
    padding: 9px 14px;
    border: 1px solid #e4dcf5;
    border-radius: 20px;
    background: #f0ebff;
    color: #8d7bb9;
    font-size: 11px;
    font-weight: 800;
}

/* =========================
   BOOK GRID
========================= */

.history-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 25px;
}

.history-grid-item {
    min-width: 0;
    display: flex;
}

/* =========================
   BOOK CARD
========================= */

.history-card {
    display: flex;
    flex-direction: column;
    width: 100%;
    min-width: 0;
    height: 100%;
    overflow: hidden;
    border: 1px solid #eeeaf5;
    border-radius: 19px;
    background: #fff;
    box-shadow: 0 5px 18px rgba(130,125,165,.07);
    transition: transform .25s ease, box-shadow .25s ease;
}

.history-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 27px rgba(130,125,165,.13);
}

/* COVER */

.cover-wrapper {
    position: relative;
    height: 255px;
    flex-shrink: 0;
    overflow: hidden;
    background: linear-gradient(135deg, #e6edff, #f0eaff, #ffeaf1);
}

.cover-wrapper img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .4s ease;
}

.history-card:hover .cover-wrapper img {
    transform: scale(1.04);
}

.cover-empty {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
    color: #a394d0;
    font-size: 55px;
}

/* STATUS */

.status-badge {
    position: absolute;
    top: 14px;
    right: 14px;
    padding: 8px 12px;
    border: 1px solid rgba(255,255,255,.85);
    border-radius: 20px;
    background: rgba(255,255,255,.94);
    font-size: 10px;
    font-weight: 800;
    box-shadow: 0 3px 9px rgba(0,0,0,.06);
}

.badge-selesai {
    color: #478b70;
}

.badge-sedang {
    color: #718bbd;
}

.badge-belum {
    color: #858196;
}

/* CARD CONTENT */

.history-card-body {
    display: flex;
    flex-direction: column;
    flex: 1;
    padding: 19px;
}

.book-title {
    display: -webkit-box;
    min-height: 45px;
    overflow: hidden;
    margin: 0 0 12px;
    color: #4e4965;
    font-size: 14px;
    font-weight: 800;
    line-height: 1.6;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.meta-text {
    display: flex;
    align-items: center;
    gap: 9px;
    margin-bottom: 9px;
    color: #9290a3;
    font-size: 11px;
    line-height: 1.5;
}

.meta-text i {
    width: 14px;
    flex-shrink: 0;
    text-align: center;
}

.meta-text .fa-user {
    color: #a394d0;
}

.meta-text .fa-clock {
    color: #d4ad70;
}

/* =========================
   READING PROGRESS
========================= */

.progress-wrapper {
    padding: 15px;
    margin: 13px 0 17px;
    border: 1px solid #eee9f5;
    border-radius: 14px;
    background: #faf9fd;
}

.progress-info {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    margin-bottom: 11px;
    color: #89859d;
    font-size: 11px;
    font-weight: 700;
}

.progress-info span:last-child {
    color: #9583c4;
}

.history-progress {
    width: 100%;
    height: 9px;
    overflow: hidden;
    border-radius: 20px;
    background: #e9e5f1;
}

.history-progress-bar {
    height: 100%;
    border-radius: 20px;
    background: linear-gradient(90deg, #b5a5df, #8fa5d9);
}

/* =========================
   ACTION BUTTONS
========================= */

.card-actions {
    display: flex;
    flex-direction: column;
    gap: 9px;
    padding-top: 16px;
    margin-top: auto;
    border-top: 1px solid #f0edf5;
}

.btn-act {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    min-height: 40px;
    gap: 8px;
    padding: 10px 12px;
    border: 1px solid transparent;
    border-radius: 11px;
    font-family: inherit;
    font-size: 11px;
    font-weight: 800;
    text-align: center;
    text-decoration: none;
    cursor: pointer;
    transition: .2s ease;
}

.btn-primary-act {
    border-color: #dce5fa;
    background: #e9f0ff;
    color: #718bbd;
}

.btn-primary-act:hover {
    border-color: #9eb4df;
    background: #a2b6e1;
    color: #fff;
}

.btn-secondary-act {
    border-color: #e4dcf5;
    background: #f0ebff;
    color: #927fbd;
}

.btn-secondary-act:hover {
    border-color: #b5a5df;
    background: #b5a5df;
    color: #fff;
}

.btn-success-act {
    border-color: #ccebdc;
    background: #e8f6ef;
    color: #579477;
}

.btn-success-act:hover {
    border-color: #9bd4b6;
    background: #9bd4b6;
    color: #fff;
}

.btn-danger-act {
    border-color: #f4d7e2;
    background: #fff0f4;
    color: #cb819d;
}

.btn-danger-act:hover {
    border-color: #e8b5c8;
    background: #e9b4c7;
    color: #fff;
}

.card-actions form {
    width: 100%;
    margin: 0;
}

/* =========================
   EMPTY STATE
========================= */

.history-empty-state {
    padding: 75px 25px;
    border: 1px dashed #dcd5ee;
    border-radius: 25px;
    background: linear-gradient(135deg, #f5f2ff, #fff3f6);
    text-align: center;
}

.history-empty-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100px;
    height: 100px;
    margin: 0 auto 23px;
    border-radius: 30px;
    background: #fff;
    color: #a394d0;
    font-size: 42px;
}

.history-empty-state h5 {
    margin-bottom: 12px;
    color: #514d69;
    font-size: 21px;
    font-weight: 800;
}

.history-empty-state p {
    max-width: 450px;
    margin: 0 auto 24px;
    color: #9290a2;
    font-size: 13px;
    line-height: 1.8;
}

.btn-empty-explore {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    padding: 13px 24px;
    border-radius: 30px;
    background: linear-gradient(120deg, #a99bd9, #8fa5d9);
    color: #fff;
    font-size: 12px;
    font-weight: 800;
    text-decoration: none;
    transition: .2s;
}

.btn-empty-explore:hover {
    transform: translateY(-2px);
    color: #fff;
}

/* =========================
   RESPONSIVE
========================= */

@media(max-width: 1250px) {
    .history-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }
}

@media(max-width: 900px) {
    .history-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .genre-section {
        padding: 20px;
    }
}

@media(max-width: 600px) {
    .history-page {
        padding: 20px 14px 40px;
    }

    .history-header {
        padding: 23px 19px;
        gap: 14px;
    }

    .history-header-icon {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        font-size: 22px;
    }

    .history-header-content h3 {
        font-size: 19px;
    }

    .history-header-content p {
        font-size: 11px;
    }

    .history-filter {
        padding: 18px;
        margin-bottom: 28px;
    }

    .filter-pills {
        gap: 8px;
    }

    .btn-filter {
        padding: 9px 12px;
        font-size: 11px;
    }

    .genre-section {
        padding: 15px;
        margin-bottom: 25px;
        border-radius: 19px;
    }

    .genre-section-title {
        gap: 10px;
        margin-bottom: 19px;
    }

    .genre-title-icon {
        width: 38px;
        height: 38px;
    }

    .genre-title-content h4 {
        font-size: 14px;
    }

    .genre-book-count {
        padding: 7px 9px;
        font-size: 9px;
    }

    .history-grid {
        gap: 13px;
    }

    .cover-wrapper {
        height: 185px;
    }

    .history-card-body {
        padding: 13px 11px;
    }

    .book-title {
        font-size: 12px;
        min-height: 39px;
    }

    .meta-text {
        font-size: 10px;
    }

    .progress-wrapper {
        padding: 10px;
    }

    .progress-info {
        font-size: 9px;
    }

    .btn-act {
        min-height: 36px;
        padding: 8px 5px;
        font-size: 10px;
        gap: 5px;
    }
}

@media(max-width: 360px) {
    .history-grid {
        grid-template-columns: 1fr;
    }

    .cover-wrapper {
        height: 250px;
    }
}
</style>

<div class="history-page">

    {{-- HEADER --}}
    <div class="history-header">

        <div class="history-header-icon">
            <i class="fa-solid fa-layer-group"></i>
        </div>

        <div class="history-header-content">
            <h3>Riwayat Baca Berdasarkan Genre</h3>
            <p>
                Pantau progres membaca dan temukan kembali cerita
                yang pernah kamu baca di Safae.
            </p>
        </div>

    </div>

    {{-- NOTIFIKASI --}}
    @if(session('success'))
        <div class="history-alert">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- FILTER GENRE --}}
    <div class="history-filter">

        <div class="filter-heading">
            <i class="fa-solid fa-filter"></i>
            Filter Riwayat Berdasarkan Genre
        </div>

        <div class="filter-pills">

            <a
                href="{{ route('reading.history', ['genre' => 'Semua', 'status' => $statusFilter]) }}"
                class="btn-filter {{ $selectedGenre == 'Semua' ? 'active' : '' }}"
            >
                Semua Genre
            </a>

            @foreach($availableGenres as $genreName)
                <a
                    href="{{ route('reading.history', ['genre' => $genreName, 'status' => $statusFilter]) }}"
                    class="btn-filter {{ $selectedGenre == $genreName ? 'active' : '' }}"
                >
                    {{ $genreName }}
                </a>
            @endforeach

        </div>

    </div>

    {{-- TAMPILAN KOSONG --}}
    @if($groupedHistories->isEmpty())

        <div class="history-empty-state">

            <div class="history-empty-icon">
                <i class="fa-solid fa-book-open"></i>
            </div>

            <h5>Tidak Ada Riwayat Baca</h5>

            <p>
                Belum ada buku yang dibaca pada genre ini.
                Mulai membaca cerita dan riwayatmu akan muncul di sini.
            </p>

            <a href="{{ route('genre.index') }}" class="btn-empty-explore">
                <i class="fa-solid fa-compass"></i>
                Cari Buku
            </a>

        </div>

    @else

        {{-- LOOP SETIAP GENRE --}}
        @foreach($groupedHistories as $genre => $items)

            <section class="genre-section">

                {{-- JUDUL GENRE --}}
                <div class="genre-section-title">

                    <div class="genre-title-icon">
                        <i class="fa-solid fa-bookmark"></i>
                    </div>

                    <div class="genre-title-content">
                        <h4>{{ $genre }}</h4>
                        <p>Kumpulan buku yang pernah kamu baca</p>
                    </div>

                    <span class="genre-book-count">
                        {{ $items->count() }} Buku
                    </span>

                </div>

                {{-- GRID BUKU --}}
                <div class="history-grid">

                    @foreach($items as $history)

                        @php
                            $buku = $history->book;
                            $status = $history->status ?? 'Sedang Dibaca';
                            $percent = $history->progress_percentage ?? 0;
                            $hasResume = in_array($history->book_id, $resumesBookIds);
                        @endphp

                        <div class="history-grid-item">

                            <article class="history-card">

                                {{-- COVER BUKU --}}
                                <div class="cover-wrapper">

                                    @php
                                        $rawPath = $buku->image_path ?? $buku->cover ?? $buku->gambar ?? $buku->image ?? null;
                                        $imageUrl = 'https://via.placeholder.com/300x400?text=No+Cover';

                                        if (!empty($rawPath)) {
                                            $fileName = basename($rawPath);

                                            if (\Illuminate\Support\Str::startsWith($rawPath, ['http://', 'https://'])) {
                                                $imageUrl = $rawPath;
                                            } elseif (file_exists(public_path($rawPath))) {
                                                $imageUrl = asset($rawPath);
                                            } elseif (file_exists(public_path('uploads/cover/' . $fileName))) {
                                                $imageUrl = asset('uploads/cover/' . $fileName);
                                            } elseif (file_exists(public_path('uploads/' . $fileName))) {
                                                $imageUrl = asset('uploads/' . $fileName);
                                            } else {
                                                $cleanPath = str_replace(['public/', 'storage/'], '', ltrim($rawPath, '/'));
                                                $imageUrl = asset('storage/' . $cleanPath);
                                            }
                                        }
                                    @endphp

                                    <img
                                        src="{{ $imageUrl }}"
                                        alt="{{ $buku->title ?? 'Cover Buku' }}"
                                        onerror="this.onerror=null; this.src='https://via.placeholder.com/300x400?text=No+Cover';"
                                    >

                                    <span class="status-badge {{ $status == 'Selesai Dibaca' ? 'badge-selesai' : ($status == 'Sedang Dibaca' ? 'badge-sedang' : 'badge-belum') }}">
                                        {{ $status }}
                                    </span>

                                </div>

                                {{-- INFORMASI BUKU --}}
                                <div class="history-card-body">

                                    <h5 class="book-title" title="{{ $buku->title ?? '-' }}">
                                        {{ $buku->title ?? 'Judul Tidak Ada' }}
                                    </h5>

                                    <div class="meta-text">
                                        <i class="fa-solid fa-user"></i>
                                        {{ $buku->author ?? '-' }}
                                    </div>

                                    <div class="meta-text">
                                        <i class="fa-regular fa-clock"></i>
                                        {{ $history->last_read_at ? $history->last_read_at->diffForHumans() : '-' }}
                                    </div>

                                    {{-- PROGRESS MEMBACA --}}
                                    <div class="progress-wrapper">

                                        <div class="progress-info">
                                            <span>Hal {{ $history->progress }}</span>
                                            <span>{{ $percent }}%</span>
                                        </div>

                                        <div class="history-progress">
                                            <div
                                                class="history-progress-bar"
                                                style="width: {{ $percent }}%"
                                            ></div>
                                        </div>

                                    </div>

                                    {{-- TOMBOL AKSI --}}
                                    <div class="card-actions">

                                        @if($buku)
                                            <a
                                                href="{{ route('book.show', ['id' => $buku->id, 'page' => $history->progress ?: 1]) }}"
                                                class="btn-act btn-primary-act"
                                            >
                                                <i class="fa-solid fa-play"></i>
                                                Lanjutkan
                                            </a>
                                        @endif

                                        @if($hasResume)

                                            <a
                                                href="{{ route('resume.my') }}"
                                                class="btn-act btn-secondary-act"
                                            >
                                                <i class="fa-solid fa-file-lines"></i>
                                                Lihat Resume
                                            </a>

                                        @else

                                            <a
                                                href="{{ route('resume.create', $history->book_id) }}"
                                                class="btn-act btn-secondary-act"
                                            >
                                                <i class="fa-solid fa-pen"></i>
                                                Tulis Resume
                                            </a>

                                        @endif

                                        @if($status !== 'Selesai Dibaca')
                                            <form
                                                action="{{ route('reading.history.markFinished', $history->id) }}"
                                                method="POST"
                                            >
                                                @csrf

                                                <button type="submit" class="btn-act btn-success-act">
                                                    <i class="fa-solid fa-circle-check"></i>
                                                    Selesai
                                                </button>
                                            </form>
                                        @endif

                                        <form
                                            action="{{ route('reading.history.delete', $history->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Hapus buku ini dari riwayat?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn-act btn-danger-act">
                                                <i class="fa-solid fa-trash-can"></i>
                                                Hapus
                                            </button>
                                        </form>

                                    </div>

                                </div>

                            </article>

                        </div>

                    @endforeach

                </div>

            </section>

        @endforeach

    @endif

</div>

@endsection
                                                