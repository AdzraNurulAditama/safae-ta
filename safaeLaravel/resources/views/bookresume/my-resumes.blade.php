
@extends('layouts.app')

@section('title', 'Resume Bacaan Saya - Safae')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

:root {
    --text: #514d69;
    --muted: #9290a3;
    --purple: #a394d0;
    --purple-dark: #8978b9;
    --purple-light: #f0ebff;
    --blue-light: #eaf1ff;
    --pink-light: #fff0f4;
    --green-light: #e8f6ef;
    --border: #eeeaf5;
}

.resume-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 24px 25px 45px;
    color: var(--text);
    font-family: 'Plus Jakarta Sans', sans-serif;
}

/* HEADER */
.resume-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    padding: 23px 26px;
    margin-bottom: 20px;
    border: 1px solid #eee7f8;
    border-radius: 18px;
    background: linear-gradient(110deg, #eaf1ff, #f0ebff 55%, #fff0f4);
}

.resume-header-content {
    display: flex;
    align-items: center;
    gap: 15px;
}

.resume-header-icon {
    width: 55px;
    height: 55px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 15px;
    background: rgba(255,255,255,.85);
    color: var(--purple-dark);
    font-size: 23px;
}

.resume-header h2 {
    margin: 0 0 5px;
    color: var(--text);
    font-size: 23px;
    font-weight: 800;
}

.resume-header p {
    margin: 0;
    color: #858198;
    font-size: 12px;
}

.btn-create-resume {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 11px 17px;
    border: 1px solid rgba(255,255,255,.9);
    border-radius: 11px;
    background: rgba(255,255,255,.85);
    color: var(--purple-dark);
    font-size: 12px;
    font-weight: 800;
    text-decoration: none;
    white-space: nowrap;
    transition: .2s;
}

.btn-create-resume:hover {
    background: white;
    color: #7662a9;
    transform: translateY(-2px);
}

/* ALERT */
.resume-alert {
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 12px 16px;
    margin-bottom: 18px;
    border: 1px solid #ccebdc;
    border-radius: 11px;
    background: var(--green-light);
    color: #43866c;
    font-size: 12px;
    font-weight: 600;
}

/* SECTION LABEL */
.resume-section-label {
    margin-bottom: 10px;
    color: #817c96;
    font-size: 12px;
    font-weight: 800;
    letter-spacing: .3px;
}

/* FILTER */
.resume-filter-row {
    margin-bottom: 21px;
}

.filter-box {
    display: flex;
    align-items: center;
    gap: 10px;
    height: 46px;
    padding: 0 13px;
    border: 1px solid var(--border);
    border-radius: 11px;
    background: #fff;
    box-shadow: 0 3px 10px rgba(130,125,165,.035);
}

.filter-box > i {
    color: var(--purple);
    font-size: 14px;
}

.filter-box form {
    flex: 1;
    min-width: 0;
}

.filter-box input,
.filter-box select {
    width: 100%;
    height: 44px;
    border: none;
    outline: none;
    background: transparent;
    color: #656078;
    font-family: inherit;
    font-size: 11px;
}

.filter-box input::placeholder {
    color: #aaa6b8;
}

.filter-box select {
    cursor: pointer;
}

/* STATISTICS */
.resume-stats {
    margin-bottom: 25px;
}

.stat-card {
    display: flex;
    align-items: center;
    gap: 13px;
    min-height: 88px;
    padding: 15px 17px;
    border: 1px solid var(--border);
    border-radius: 14px;
    background: #fff;
    box-shadow: 0 4px 13px rgba(130,125,165,.05);
    transition: .2s;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 7px 17px rgba(130,125,165,.09);
}

.stat-icon-wrapper {
    width: 45px;
    height: 45px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 13px;
    background: var(--purple-light);
    color: var(--purple-dark);
    font-size: 18px;
}

.stat-icon-blue {
    background: var(--blue-light);
    color: #829bd0;
}

.stat-icon-green {
    background: var(--green-light);
    color: #71ae91;
}

.stat-info small {
    display: block;
    margin-bottom: 4px;
    color: #9692a6;
    font-size: 10px;
    font-weight: 600;
}

.stat-info h4,
.stat-info h5 {
    margin: 0;
    color: var(--text);
    font-size: 19px;
    font-weight: 800;
}

/* LIST */
.resume-list-section {
    margin-top: 5px;
}

.resume-list-heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 13px;
}

.resume-list-heading h4 {
    margin: 0;
    color: var(--text);
    font-size: 17px;
    font-weight: 800;
}

.resume-list-heading p {
    margin: 4px 0 0;
    color: #9995a8;
    font-size: 11px;
}

.resume-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.resume-item-card {
    display: flex;
    align-items: stretch;
    gap: 18px;
    padding: 17px;
    border: 1px solid var(--border);
    border-radius: 15px;
    background: #fff;
    box-shadow: 0 4px 13px rgba(130,125,165,.045);
    cursor: pointer;
    transition: .2s;
}

.resume-item-card:hover {
    transform: translateY(-2px);
    border-color: #ded6f1;
    box-shadow: 0 8px 19px rgba(130,125,165,.09);
}

.resume-cover {
    width: 92px;
    height: 125px;
    flex-shrink: 0;
    object-fit: cover;
    border-radius: 10px;
    background: var(--purple-light);
    box-shadow: 0 3px 9px rgba(100,90,130,.08);
}

.resume-item-content {
    display: flex;
    flex-direction: column;
    flex: 1;
    min-width: 0;
}

.resume-item-top {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 12px;
}

.resume-item-title {
    margin: 7px 0 3px;
    color: var(--text);
    font-size: 15px;
    font-weight: 800;
    line-height: 1.4;
}

.resume-book-title {
    color: #8f80bd;
    font-size: 11px;
    font-weight: 700;
}

.badge-genre {
    display: inline-block;
    padding: 5px 9px;
    border: 1px solid #e4dcf5;
    border-radius: 7px;
    background: var(--purple-light);
    color: #8d7bb9;
    font-size: 9px;
    font-weight: 800;
}

.badge-status {
    display: inline-block;
    flex-shrink: 0;
    padding: 7px 10px;
    border: 1px solid #dce5fa;
    border-radius: 20px;
    background: var(--blue-light);
    color: #718bbd;
    font-size: 9px;
    font-weight: 800;
}

.resume-excerpt {
    display: -webkit-box;
    max-width: 750px;
    overflow: hidden;
    margin: 10px 0 12px;
    color: #89869b;
    font-size: 11px;
    line-height: 1.7;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.resume-item-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
    margin-top: auto;
}

.resume-updated {
    color: #a09caf;
    font-size: 10px;
}

.resume-updated i {
    margin-right: 4px;
    color: var(--purple);
}

.btn-detail {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    padding: 8px 12px;
    border: 1px solid #e4dcf5;
    border-radius: 9px;
    background: var(--purple-light);
    color: var(--purple-dark);
    font-family: inherit;
    font-size: 10px;
    font-weight: 800;
    transition: .2s;
}

.btn-detail:hover {
    background: #a99bd9;
    border-color: #a99bd9;
    color: white;
}

/* EMPTY STATE */
.resume-empty {
    padding: 42px 20px;
    border: 1px dashed #dcd5ee;
    border-radius: 17px;
    background: linear-gradient(135deg, #f5f2ff, #fff3f6);
    text-align: center;
}

.resume-empty-icon {
    width: 70px;
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 14px;
    border-radius: 22px;
    background: #fff;
    color: var(--purple);
    font-size: 30px;
}

.resume-empty h5 {
    margin-bottom: 6px;
    color: var(--text);
    font-size: 17px;
    font-weight: 800;
}

.resume-empty p {
    margin: 0;
    color: #9290a2;
    font-size: 11px;
}

/* DETAIL DRAWER */
.detail-drawer {
    width: 480px !important;
    max-width: 100%;
    border: none;
    background: #fcfbff;
    color: var(--text);
    box-shadow: -8px 0 25px rgba(100,90,130,.09);
}

.detail-drawer .offcanvas-header {
    padding: 17px 20px;
    border-bottom: 1px solid var(--border);
    background: linear-gradient(110deg, #eaf1ff, #f0ebff, #fff0f4);
}

.detail-drawer .offcanvas-title {
    color: var(--text);
    font-size: 16px;
    font-weight: 800;
}

.detail-drawer .offcanvas-body {
    padding: 19px 20px;
}

.drawer-top-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
    margin-bottom: 17px;
}

.drawer-action-buttons {
    display: flex;
    gap: 7px;
}

.drawer-status {
    padding: 7px 10px;
    border: 1px solid #dce5fa;
    border-radius: 20px;
    background: var(--blue-light);
    color: #718bbd;
    font-size: 9px;
    font-weight: 800;
}

.btn-drawer-edit,
.btn-drawer-delete {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    padding: 8px 10px;
    border-radius: 9px;
    font-size: 10px;
    font-weight: 700;
    text-decoration: none;
}

.btn-drawer-edit {
    border: 1px solid #ded5f3;
    background: var(--purple-light);
    color: var(--purple-dark);
}

.btn-drawer-delete {
    border: 1px solid #f4d7e2;
    background: var(--pink-light);
    color: #cb819d;
}

.drawer-book-info {
    display: flex;
    align-items: center;
    gap: 13px;
    padding: 13px;
    margin-bottom: 15px;
    border: 1px solid var(--border);
    border-radius: 13px;
    background: #fff;
}

.drawer-book-cover {
    width: 65px;
    height: 88px;
    flex-shrink: 0;
    object-fit: cover;
    border-radius: 8px;
    background: var(--purple-light);
}

.drawer-book-info h6 {
    margin: 0 0 6px;
    color: var(--text);
    font-size: 13px;
    font-weight: 800;
}

.drawer-book-info small {
    display: block;
    margin-bottom: 5px;
    color: #9692a6;
    font-size: 10px;
}

.drawer-book-info .drawer-genre {
    color: var(--purple-dark);
    font-weight: 700;
}

.detail-section {
    padding: 15px;
    margin-bottom: 12px;
    border: 1px solid var(--border);
    border-radius: 13px;
    background: #fff;
}

.detail-section h6 {
    margin-bottom: 10px;
    color: #8172b0;
    font-size: 12px;
    font-weight: 800;
}

.drawer-progress-info {
    display: flex;
    justify-content: space-between;
    gap: 8px;
    margin-bottom: 9px;
    color: #89859d;
    font-size: 10px;
    font-weight: 700;
}

.drawer-progress {
    height: 8px;
    overflow: hidden;
    border-radius: 20px;
    background: #eeeaf5;
}

.drawer-progress-bar {
    height: 100%;
    border-radius: 20px;
    background: linear-gradient(90deg, #b5a5df, #8fa5d9);
}

.drawer-content {
    color: #77738b;
    font-size: 11px;
    line-height: 1.8;
    white-space: pre-line;
    overflow-wrap: anywhere;
}

.drawer-dates {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 10px;
    padding-top: 14px;
    margin-top: 16px;
    border-top: 1px solid var(--border);
    color: #9995a8;
    font-size: 9px;
}

.drawer-dates span {
    color: #625c7b;
    font-weight: 700;
}

/* RESPONSIVE */
@media(max-width: 768px) {
    .resume-container {
        padding: 18px 14px 35px;
    }

    .resume-header {
        align-items: flex-start;
        flex-direction: column;
        padding: 19px;
    }

    .resume-header-icon {
        width: 47px;
        height: 47px;
        font-size: 20px;
    }

    .resume-header h2 {
        font-size: 19px;
    }

    .resume-header p {
        font-size: 10px;
        line-height: 1.6;
    }

    .resume-item-card {
        gap: 13px;
        padding: 13px;
    }

    .resume-cover {
        width: 78px;
        height: 110px;
    }

    .resume-item-title {
        font-size: 13px;
    }

    .resume-item-top {
        flex-wrap: wrap;
    }

    .resume-item-footer {
        align-items: flex-start;
        flex-direction: column;
    }

    .detail-drawer {
        width: 100% !important;
    }
}

@media(max-width: 480px) {
    .resume-header {
        gap: 13px;
    }

    .resume-header-content {
        gap: 10px;
    }

    .resume-header h2 {
        font-size: 17px;
    }

    .resume-item-card {
        gap: 10px;
        padding: 11px;
    }

    .resume-cover {
        width: 65px;
        height: 95px;
    }

    .resume-item-title {
        font-size: 12px;
    }

    .resume-book-title {
        font-size: 10px;
    }

    .resume-excerpt {
        font-size: 10px;
    }

    .btn-detail {
        padding: 7px 10px;
        font-size: 9px;
    }

    .drawer-top-actions {
        align-items: flex-start;
        flex-direction: column;
    }
}
</style>

<div class="resume-container">
    <div class="container-fluid px-0">

        {{-- HEADER --}}
        <div class="resume-header">
            <div class="resume-header-content">
                <div class="resume-header-icon">
                    <i class="fa-solid fa-file-lines"></i>
                </div>

                <div>
                    <h2>Resume Bacaan Saya</h2>
                    <p>Catatan, pemahaman, dan poin penting dari buku yang kamu baca.</p>
                </div>
            </div>

            <a href="{{ route('genre.index') }}" class="btn-create-resume">
                <i class="fa-solid fa-plus"></i>
                Buat Resume
            </a>
        </div>

        {{-- NOTIFIKASI --}}
        @if(session('success'))
            <div class="resume-alert">
                <i class="fa-solid fa-circle-check"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- FILTER & SEARCH --}}
        <div class="resume-section-label">
            <i class="fa-solid fa-sliders me-1"></i>
            Pencarian dan Filter Resume
        </div>

        <div class="row g-2 resume-filter-row">
            <div class="col-md-6 col-lg-4">
                <div class="filter-box">
                    <i class="fa-solid fa-magnifying-glass"></i>

                    <form action="{{ route('resume.my') }}" method="GET">
                        <input
                            type="text"
                            name="search"
                            placeholder="Cari judul buku atau topik..."
                            value="{{ request('search') }}"
                        >
                    </form>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="filter-box">
                    <i class="fa-solid fa-filter"></i>

                    <select
                        name="status"
                        onchange="window.location.href='{{ route('resume.my') }}?status=' + this.value"
                    >
                        <option value="Semua" {{ $statusFilter == 'Semua' ? 'selected' : '' }}>
                            Semua status
                        </option>

                        <option value="Sedang Dibaca" {{ $statusFilter == 'Sedang Dibaca' ? 'selected' : '' }}>
                            Sedang Dibaca
                        </option>

                        <option value="Selesai Dibaca" {{ $statusFilter == 'Selesai Dibaca' ? 'selected' : '' }}>
                            Selesai Dibaca
                        </option>
                    </select>
                </div>
            </div>
        </div>

        {{-- STATISTIK --}}
        <div class="resume-section-label">
            <i class="fa-solid fa-chart-simple me-1"></i>
            Ringkasan Resume
        </div>

        <div class="row g-2 resume-stats">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon-wrapper">
                        <i class="fa-solid fa-file-lines"></i>
                    </div>

                    <div class="stat-info">
                        <small>Total Resume</small>
                        <h4>{{ $totalResume }}</h4>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon-wrapper stat-icon-blue">
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>

                    <div class="stat-info">
                        <small>Terakhir Diperbarui</small>
                        <h5>{{ $lastUpdated }}</h5>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon-wrapper stat-icon-green">
                        <i class="fa-solid fa-book-open"></i>
                    </div>

                    <div class="stat-info">
                        <small>Terhubung ke Buku</small>
                        <h4>{{ $connectedBooks }}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- DAFTAR RESUME --}}
        <div class="resume-list-section">
            <div class="resume-list-heading">
                <div>
                    <h4>Daftar Resume</h4>
                    <p>Kumpulan catatan dari buku yang sudah kamu baca.</p>
                </div>
            </div>

            <div class="resume-list">
                @forelse($resumes as $resume)

                    @php
                        $history = $histories->get($resume->book_id);
                        $status = $history->status ?? 'Sedang Dibaca';
                        $progressPage = $history->progress ?? 1;
                        $totalPages = $resume->book->jumlah_halaman ?? 100;
                        $percent = round(($progressPage / max($totalPages, 1)) * 100);
                    @endphp

                    <div
                        class="resume-item-card"
                        onclick="openResumeDetail({{ json_encode([
                            'id' => $resume->id,
                            'title' => $resume->title,
                            'content' => $resume->content,
                            'book_title' => $resume->book->title ?? 'Buku',
                            'author' => $resume->book->author ?? '-',
                            'genre' => $resume->book->genre ?? 'Umum',
                            'cover' => asset($resume->book->image_path ?? 'https://via.placeholder.com/150'),
                            'created_at' => $resume->created_at->isoFormat('D MMM YYYY'),
                            'updated_at' => $resume->updated_at->isoFormat('D MMM YYYY'),
                            'status' => $status,
                            'progress_page' => $progressPage,
                            'total_pages' => $totalPages,
                            'percent' => $percent,
                            'edit_url' => route('bookresume.edit', $resume->id),
                            'delete_url' => route('bookresume.destroy', $resume->id),
                        ]) }})"
                    >

                        <img
                            src="{{ asset($resume->book->image_path ?? 'https://via.placeholder.com/150') }}"
                            class="resume-cover"
                            alt="Cover"
                        >

                        <div class="resume-item-content">
                            <div class="resume-item-top">
                                <div>
                                    <span class="badge-genre">
                                        {{ $resume->book->genre ?? 'Umum' }}
                                    </span>

                                    <h5 class="resume-item-title">
                                        {{ $resume->title }}
                                    </h5>

                                    <div class="resume-book-title">
                                        {{ $resume->book->title ?? '-' }}
                                    </div>
                                </div>

                                <span class="badge-status">
                                    {{ $status }}
                                </span>
                            </div>

                            <p class="resume-excerpt">
                                {{ Str::limit(strip_tags($resume->content), 120) }}
                            </p>

                            <div class="resume-item-footer">
                                <div class="resume-updated">
                                    <i class="fa-regular fa-clock"></i>
                                    Diperbarui {{ $resume->updated_at->diffForHumans() }}
                                </div>

                                <button type="button" class="btn-detail">
                                    Lihat Detail
                                    <i class="fa-solid fa-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                @empty

                    <div class="resume-empty">
                        <div class="resume-empty-icon">
                            <i class="fa-solid fa-file-circle-xmark"></i>
                        </div>

                        <h5>Belum Ada Resume</h5>

                        <p>
                            Kamu belum menulis resume untuk buku yang dibaca.
                        </p>
                    </div>

                @endforelse
            </div>
        </div>

    </div>
</div>

{{-- DRAWER DETAIL RESUME --}}
<div
    class="offcanvas offcanvas-end detail-drawer"
    tabindex="-1"
    id="drawerResumeDetail"
>
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="drawerTitle">
            Detail Resume
        </h5>

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas"
            aria-label="Close"
        ></button>
    </div>

    <div class="offcanvas-body">

        {{-- STATUS DAN TOMBOL AKSI --}}
        <div class="drawer-top-actions">
            <span class="drawer-status" id="drawerStatus">
                Sedang Dibaca
            </span>

            <div class="drawer-action-buttons">
                <a
                    id="drawerEditBtn"
                    href="#"
                    class="btn-drawer-edit"
                >
                    <i class="fa-solid fa-pen"></i>
                    Edit
                </a>

                <form
                    id="drawerDeleteForm"
                    action=""
                    method="POST"
                    onsubmit="return confirm('Hapus resume ini?')"
                >
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn-drawer-delete">
                        <i class="fa-solid fa-trash"></i>
                        Hapus
                    </button>
                </form>
            </div>
        </div>

        {{-- INFO BUKU --}}
        <div class="drawer-book-info">
            <img
                id="drawerCover"
                src=""
                class="drawer-book-cover"
                alt="Cover Buku"
            >

            <div>
                <h6 id="drawerBookTitle">Judul Buku</h6>
                <small id="drawerAuthor">Penulis</small>
                <small id="drawerGenre" class="drawer-genre">Genre</small>
            </div>
        </div>

        {{-- PROGRESS BACA --}}
        <div class="detail-section">
            <h6>
                <i class="fa-solid fa-chart-line me-2"></i>
                Progress Membaca
            </h6>

            <div class="drawer-progress-info">
                <span>Progres Buku</span>
                <span id="drawerProgressText">
                    Halaman 0 dari 0 (0%)
                </span>
            </div>

            <div class="drawer-progress">
                <div
                    id="drawerProgressBar"
                    class="drawer-progress-bar"
                    style="width: 0%"
                ></div>
            </div>
        </div>

        {{-- ISI RESUME --}}
        <div class="detail-section">
            <h6>
                <i class="fa-solid fa-align-left me-2"></i>
                Ringkasan Isi & Pesan Moral
            </h6>

            <div
                class="drawer-content"
                id="drawerContent"
            ></div>
        </div>

        {{-- TANGGAL --}}
        <div class="drawer-dates">
            <div>
                Dibuat:
                <span id="drawerCreatedAt"></span>
            </div>

            <div>
                Diperbarui:
                <span id="drawerUpdatedAt"></span>
            </div>
        </div>
    </div>
</div>

<script>
    function openResumeDetail(data) {
        document.getElementById('drawerTitle').innerText = data.title;
        document.getElementById('drawerStatus').innerText = data.status;
        document.getElementById('drawerBookTitle').innerText = data.book_title;
        document.getElementById('drawerAuthor').innerText = data.author;
        document.getElementById('drawerGenre').innerText = data.genre;
        document.getElementById('drawerCover').src = data.cover;
        document.getElementById('drawerContent').innerText = data.content;

        document.getElementById('drawerProgressText').innerText =
            `Halaman ${data.progress_page} dari ${data.total_pages} (${data.percent}%)`;

        document.getElementById('drawerProgressBar').style.width =
            `${data.percent}%`;

        document.getElementById('drawerCreatedAt').innerText = data.created_at;
        document.getElementById('drawerUpdatedAt').innerText = data.updated_at;

        document.getElementById('drawerEditBtn').href = data.edit_url;
        document.getElementById('drawerDeleteForm').action = data.delete_url;

        var bsOffcanvas = new bootstrap.Offcanvas(
            document.getElementById('drawerResumeDetail')
        );

        bsOffcanvas.show();
    }
</script>

@endsection
