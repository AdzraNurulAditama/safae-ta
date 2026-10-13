@extends('layouts.app')

@section('title', 'Resume Bacaan Saya - Safae')

@section('content')

<style>
    .resume-container {
        padding: 10px 0 50px 0;
        color: #f1f5f9;
    }

    /* Top Stats Bar */
    .stat-card-dark {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 18px;
        padding: 18px 22px;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .stat-icon-wrapper {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        background: rgba(56, 189, 248, 0.12);
        color: #38bdf8;
    }

    /* Fix Warna Dropdown Option agar Kelihatan */
    .filter-box select option {
        background-color: #1e293b !important;
        color: #f8fafc !important;
        padding: 10px;
    }
    /* Filter & Search Bar */
    .filter-box {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 14px;
        padding: 6px 14px;
        color: white;
    }

    .filter-box input, .filter-box select {
        background: transparent;
        border: none;
        color: white;
        outline: none;
    }

    /* Resume List Card */
    .resume-item-card {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 20px;
        padding: 20px;
        display: flex;
        gap: 20px;
        position: relative;
        transition: 0.2s ease;
        cursor: pointer;
    }

    .resume-item-card:hover, .resume-item-card.active {
        border-color: #38bdf8;
        box-shadow: 0 10px 25px rgba(56, 189, 248, 0.12);
    }

    .resume-cover {
        width: 90px;
        height: 125px;
        object-fit: cover;
        border-radius: 12px;
        flex-shrink: 0;
    }

    .badge-genre {
        background: rgba(168, 85, 247, 0.2);
        color: #c084fc;
        border: 1px solid rgba(168, 85, 247, 0.3);
        border-radius: 8px;
        padding: 3px 10px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-status {
        background: rgba(56, 189, 248, 0.15);
        color: #38bdf8;
        border-radius: 6px;
        padding: 2px 8px;
        font-size: 0.72rem;
        font-weight: 700;
    }

    .btn-detail {
        background: #0f172a;
        color: #f8fafc;
        border: 1px solid #334155;
        border-radius: 10px;
        padding: 6px 14px;
        font-size: 0.82rem;
        font-weight: 600;
        transition: 0.2s;
    }

    .btn-detail:hover {
        background: #38bdf8;
        color: #0f172a;
        border-color: #38bdf8;
    }

    /* Side Detail Panel (Drawer / Offcanvas) */
    .detail-drawer {
        background: #1e293b;
        border-left: 1px solid #334155;
        color: white;
    }

    .detail-section {
        background: #0f172a;
        border: 1px solid #334155;
        border-radius: 16px;
        padding: 18px;
        margin-bottom: 16px;
    }
</style>

<div class="resume-container">
    <div class="container-fluid">

        <!-- HEADER & TOMBOL TAMBAH -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div>
                <h2 class="fw-bold text-white mb-1"><i class="fa-solid fa-file-lines text-info me-2"></i> Resume Bacaan Saya</h2>
                <p class="text-secondary small mb-0">Catatan, pemahaman, dan poin penting dari buku yang kamu baca.</p>
            </div>
            <a href="{{ route('genre.index') }}" class="btn btn-info text-dark fw-bold rounded-3 px-4 py-2">
                <i class="fa-solid fa-plus me-1"></i> Buat Resume
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success bg-opacity-10 border-success text-success mb-4 rounded-3">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            </div>
        @endif

        <!-- FILTER & SEARCH BAR -->
        <div class="row g-3 mb-4">
            <div class="col-md-6 col-lg-4">
                <div class="filter-box d-flex align-items-center gap-2">
                    <i class="fa-solid fa-magnifying-glass text-secondary"></i>
                    <form action="{{ route('resume.my') }}" method="GET" class="w-100">
                        <input type="text" name="search" class="w-100" placeholder="Cari judul buku atau topik..." value="{{ request('search') }}">
                    </form>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="filter-box">
                    <select name="status" class="w-100" onchange="window.location.href='{{ route('resume.my') }}?status=' + this.value">
                        <option value="Semua" {{ $statusFilter == 'Semua' ? 'selected' : '' }}>Semua status</option>
                        <option value="Sedang Dibaca" {{ $statusFilter == 'Sedang Dibaca' ? 'selected' : '' }}>Sedang Dibaca</option>
                        <option value="Selesai Dibaca" {{ $statusFilter == 'Selesai Dibaca' ? 'selected' : '' }}>Selesai Dibaca</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- TOP STATS BAR -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="stat-card-dark">
                    <div class="stat-icon-wrapper"><i class="fa-solid fa-file-lines"></i></div>
                    <div>
                        <small class="text-secondary d-block">Total Resume</small>
                        <h4 class="fw-bold mb-0 text-white">{{ $totalResume }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card-dark">
                    <div class="stat-icon-wrapper" style="color: #a855f7; background: rgba(168, 85, 247, 0.12);"><i class="fa-solid fa-calendar-days"></i></div>
                    <div>
                        <small class="text-secondary d-block">Terakhir diperbarui</small>
                        <h5 class="fw-bold mb-0 text-white">{{ $lastUpdated }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card-dark">
                    <div class="stat-icon-wrapper" style="color: #4ade80; background: rgba(74, 222, 128, 0.12);"><i class="fa-solid fa-book-open"></i></div>
                    <div>
                        <small class="text-secondary d-block">Terhubung ke buku</small>
                        <h4 class="fw-bold mb-0 text-white">{{ $connectedBooks }}</h4>
                    </div>
                </div>
            </div>
        </div>

<!-- LIST DAFTAR RESUME -->
        <div class="row g-3">
            @forelse($resumes as $resume)
                @php
                    $history = $histories->get($resume->book_id);
                    $status = $history->status ?? 'Sedang Dibaca';
                    $progressPage = $history->progress ?? 1;
                    $totalPages = $resume->book->jumlah_halaman ?? 100;
                    $percent = round(($progressPage / max($totalPages, 1)) * 100);
                @endphp
                <div class="col-12">
                    <div class="resume-item-card" onclick="openResumeDetail({{ json_encode([
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
                    ]) }})">
                        
                        <img src="{{ asset($resume->book->image_path ?? 'https://via.placeholder.com/150') }}" class="resume-cover" alt="Cover">

                        <div class="w-100">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <div>
                                    <span class="badge-genre mb-2 d-inline-block">{{ $resume->book->genre ?? 'Umum' }}</span>
                                    <h5 class="fw-bold text-white mb-1">{{ $resume->title }}</h5>
                                    <small class="text-info fw-semibold">{{ $resume->book->title ?? '-' }}</small>
                                </div>
                                <span class="badge-status">{{ $status }}</span>
                            </div>

                            <p class="text-secondary small text-truncate-2 mt-2 mb-3" style="max-width: 600px;">
                                {{ Str::limit(strip_tags($resume->content), 120) }}
                            </p>

                            <div class="d-flex justify-content-between align-items-center mt-auto text-secondary small">
                                <div>
                                    <i class="fa-regular fa-clock me-1"></i> Diperbarui {{ $resume->updated_at->diffForHumans() }}
                                </div>
                                <button class="btn-detail">Lihat Detail <i class="fa-solid fa-chevron-right ms-1"></i></button>
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5 rounded-4" style="background: #1e293b; border: 1px dashed #334155;">
                    <i class="fa-solid fa-file-circle-xmark fa-3x text-muted mb-3"></i>
                    <h5 class="fw-bold text-white">Belum Ada Resume</h5>
                    <p class="text-secondary small">Kamu belum menulis resume untuk buku yang dibaca.</p>
                </div>
            @endforelse
        </div>

<!-- DRAWER OFFCANVAS UNTUK DETAIL RESUME (SAMPING KANAN) -->
<div class="offcanvas offcanvas-end detail-drawer w-50" tabindex="-1" id="drawerResumeDetail" style="min-width: 380px;">
    <div class="offcanvas-header border-bottom border-secondary border-opacity-25">
        <h5 class="offcanvas-title fw-bold text-white" id="drawerTitle">Detail Resume</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <span class="badge-status fs-6 px-3 py-1" id="drawerStatus">Sedang Dibaca</span>
            <div class="d-flex gap-2">
                <a id="drawerEditBtn" href="#" class="btn btn-outline-info btn-sm rounded-2"><i class="fa-solid fa-pen me-1"></i> Edit</a>
                <form id="drawerDeleteForm" action="" method="POST" onsubmit="return confirm('Hapus resume ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-2"><i class="fa-solid fa-trash me-1"></i> Hapus</button>
                </form>
            </div>
        </div>

        <!-- INFO BUKU -->
        <div class="d-flex gap-3 align-items-center mb-4">
            <img id="drawerCover" src="" width="65" height="90" class="rounded-2" style="object-fit: cover;">
            <div>
                <h6 class="fw-bold text-white mb-1" id="drawerBookTitle">Judul Buku</h6>
                <small class="text-secondary d-block" id="drawerAuthor">Penulis</small>
                <small class="text-purple fw-semibold" id="drawerGenre">Genre</small>
            </div>
        </div>

        <!-- PROGRESS BACA -->
        <div class="detail-section">
            <div class="d-flex justify-content-between small text-white mb-2">
                <span>Progress Membaca</span>
                <span id="drawerProgressText">Halaman 0 dari 0 (0%)</span>
            </div>
            <div class="progress" style="height: 8px; background: #1e293b;">
                <div id="drawerProgressBar" class="progress-bar bg-info" style="width: 0%"></div>
            </div>
        </div>

        <!-- ISINYA RESUME -->
        <div class="detail-section">
            <h6 class="fw-bold text-info mb-2"><i class="fa-solid fa-align-left me-2"></i> Ringkasan Isi & Pesan Moral</h6>
            <div class="text-slate-300 small lh-lg" id="drawerContent" style="white-space: pre-line;"></div>
        </div>

        <!-- FOOTER TANGGAL -->
        <div class="d-flex justify-content-between text-secondary small mt-4 pt-3 border-top border-secondary border-opacity-25">
            <div>Dibuat: <span id="drawerCreatedAt" class="text-white"></span></div>
            <div>Diperbarui: <span id="drawerUpdatedAt" class="text-white"></span></div>
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
        
        document.getElementById('drawerProgressText').innerText = `Halaman ${data.progress_page} dari ${data.total_pages} (${data.percent}%)`;
        document.getElementById('drawerProgressBar').style.width = `${data.percent}%`;
        
        document.getElementById('drawerCreatedAt').innerText = data.created_at;
        document.getElementById('drawerUpdatedAt').innerText = data.updated_at;

        document.getElementById('drawerEditBtn').href = data.edit_url;
        document.getElementById('drawerDeleteForm').action = data.delete_url;

        var bsOffcanvas = new bootstrap.Offcanvas(document.getElementById('drawerResumeDetail'));
        bsOffcanvas.show();
    }
</script>

@endsection