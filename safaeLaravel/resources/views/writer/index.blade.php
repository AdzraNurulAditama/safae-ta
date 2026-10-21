
@extends('layouts.app')
@section('title', 'Studio Penulis - Safae')
@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    /* 1. WARNA & UKURAN DASAR */
    .writer-page {
        --card: #162033;
        --card-inner: #0f1a2e;
        --line: rgba(148, 163, 184, .18);
        --text: #f1f5f9;
        --text-soft: #a3b1c6;
        --accent: #38bdf8;
        --accent-dark: #062a40;
        --danger: #fb7185;
        font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
        color: var(--text);
        padding: 16px 0 48px;
    }

    .writer-container {
        max-width: 1280px;
        margin: auto;
        padding: 0 20px;
    }

    .writer-page a:focus-visible,
    .writer-page button:focus-visible {
        outline: 2px solid var(--accent);
        outline-offset: 3px;
    }

    /* 2. HEADER STUDIO PENULIS */
    .writer-hero {
        position: relative;
        overflow: hidden;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 14px;
        padding: 22px 28px;
        margin-bottom: 14px;
        border: 1px solid rgba(125, 211, 252, .18);
        border-radius: 24px;
        background:
            radial-gradient(420px 220px at 90% 0%, rgba(99, 102, 241, .3), transparent 70%),
            linear-gradient(120deg, #14214a, #0b3a5c 60%, #0d1730);
    }

    .writer-hero-content {
        position: relative;
        z-index: 1;
    }

    .writer-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 5px 12px;
        margin-bottom: 10px;
        border: 1px solid rgba(255, 255, 255, .12);
        border-radius: 999px;
        background: rgba(255, 255, 255, .06);
        color: #cfe8fb;
        font-size: 12.5px;
        font-weight: 600;
    }

    .writer-eyebrow i {
        color: var(--accent);
    }

    .writer-hero h1 {
        margin: 0 0 5px;
        color: #fff;
        font-size: clamp(26px, 3.2vw, 38px);
        font-weight: 800;
        letter-spacing: -0.03em;
    }

    .writer-hero p {
        max-width: 540px;
        margin: 0;
        color: #b9c9de;
        font-size: 14px;
        line-height: 1.6;
    }

    .writer-create-button {
        position: relative;
        z-index: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 11px 20px;
        border-radius: 14px;
        background: var(--accent);
        color: var(--accent-dark);
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        white-space: nowrap;
        transition: background .2s, transform .2s;
    }

    .writer-create-button:hover {
        background: #7dd3fc;
        color: var(--accent-dark);
        transform: translateY(-2px);
    }

    /* 3. STATISTIK TOTAL */
    .writer-overview {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 10px;
        margin-bottom: 20px;
    }

    .writer-overview-card {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        background: var(--card);
        border: 1px solid var(--line);
        border-radius: 18px;
    }

    .writer-overview-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        width: 40px;
        height: 40px;
        border-radius: 12px;
        font-size: 16px;
    }

    .writer-overview-icon.blue {
        color: #38bdf8;
        background: rgba(56, 189, 248, .14);
    }

    .writer-overview-icon.purple {
        color: #a78bfa;
        background: rgba(167, 139, 250, .14);
    }

    .writer-overview-icon.pink {
        color: #fb7185;
        background: rgba(251, 113, 133, .14);
    }

    .writer-overview-icon.green {
        color: #4ade80;
        background: rgba(74, 222, 128, .14);
    }

    .writer-overview-number {
        color: #fff;
        font-size: 22px;
        font-weight: 800;
        line-height: 1.1;
    }

    .writer-overview-label {
        margin-top: 2px;
        color: var(--text-soft);
        font-size: 12px;
    }

    /* 4. KOLEKSI KARYA */
    .writer-section-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 12px;
    }

    .writer-section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0 0 2px;
        color: #fff;
        font-size: 20px;
        font-weight: 800;
        letter-spacing: -0.02em;
    }

    .writer-section-subtitle {
        margin: 0;
        color: var(--text-soft);
        font-size: 13px;
    }

    .writer-book-count {
        padding: 5px 12px;
        border: 1px solid rgba(56, 189, 248, .25);
        border-radius: 999px;
        background: rgba(56, 189, 248, .1);
        color: #7dd3fc;
        font-size: 12.5px;
        font-weight: 600;
    }

    /* 5. CARD BUKU */
    .writer-book-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
    }

    .writer-book-card {
        display: flex;
        flex-direction: column;
        gap: 10px;
        min-width: 0;
        padding: 12px;
        background: var(--card);
        border: 1px solid var(--line);
        border-radius: 20px;
        transition: border-color .25s, box-shadow .25s;
    }

    .writer-book-card:hover {
        border-color: rgba(56, 189, 248, .45);
        box-shadow: 0 16px 36px rgba(2, 8, 23, .35);
    }

    /* COVER DAN INFORMASI */
    .writer-book-main {
        display: flex;
        gap: 12px;
        min-width: 0;
    }

    .writer-book-cover-link {
        flex-shrink: 0;
        display: block;
    }

    .writer-book-cover,
    .writer-cover-placeholder {
        display: block;
        width: 80px;
        height: 112px;
        border-radius: 10px;
        border: 1px solid var(--line);
    }

    .writer-book-cover {
        object-fit: cover;
        background: var(--card-inner);
    }

    .writer-cover-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(145deg, #172554, #0c4a6e);
        color: #7dd3fc;
        font-size: 28px;
    }

    .writer-book-info {
        flex: 1;
        min-width: 0;
    }

    .writer-book-badges {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 4px 8px;
        margin-bottom: 5px;
    }

    /* STATUS BUKU */
    .writer-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 3px 9px;
        border: 1px solid transparent;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
    }

    .writer-status.published {
        color: #4ade80;
        background: rgba(34, 197, 94, .12);
        border-color: rgba(34, 197, 94, .28);
    }

    .writer-status.draft {
        color: #facc15;
        background: rgba(234, 179, 8, .12);
        border-color: rgba(234, 179, 8, .28);
    }

    .writer-status.pending {
        color: #7dd3fc;
        background: rgba(56, 189, 248, .12);
        border-color: rgba(56, 189, 248, .28);
    }

    .writer-status.rejected {
        color: #fda4af;
        background: rgba(244, 63, 94, .12);
        border-color: rgba(244, 63, 94, .28);
    }

    .writer-genre {
        color: var(--text-soft);
        font-size: 12px;
    }

    .writer-book-title {
        margin: 0 0 3px;
        font-size: 16px;
        font-weight: 700;
        line-height: 1.3;
    }

    .writer-book-title a {
        color: #fff;
        text-decoration: none;
    }

    .writer-book-title a:hover {
        color: var(--accent);
    }

    .writer-book-description {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin: 0;
        color: var(--text-soft);
        font-size: 12.5px;
        line-height: 1.5;
    }

    /* STATISTIK PER BUKU */
    .writer-book-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        padding: 8px 4px;
        background: var(--card-inner);
        border: 1px solid var(--line);
        border-radius: 14px;
    }

    .writer-stat-box {
        text-align: center;
        min-width: 0;
    }

    .writer-stat-box + .writer-stat-box {
        border-left: 1px solid var(--line);
    }

    .writer-stat-value {
        color: #fff;
        font-size: 16px;
        font-weight: 800;
        line-height: 1.2;
    }

    .writer-stat-label {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        margin-top: 1px;
        color: var(--text-soft);
        font-size: 11px;
    }

    /* TOMBOL AKSI */
    .writer-book-actions {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .writer-action-manage {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        flex: 1;
        min-height: 38px;
        padding: 0 12px;
        border-radius: 12px;
        background: var(--accent);
        color: var(--accent-dark);
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        transition: background .2s;
    }

    .writer-action-manage:hover {
        background: #7dd3fc;
        color: var(--accent-dark);
    }

    .writer-action-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        min-height: 38px;
        padding: 0 12px;
        background: transparent;
        border: 1px solid var(--line);
        border-radius: 12px;
        color: var(--text-soft);
        font-family: inherit;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: border-color .2s, color .2s, background .2s;
    }

    .writer-action-icon:hover {
        border-color: var(--accent);
        color: #7dd3fc;
        background: rgba(56, 189, 248, .08);
    }

    .writer-action-icon.delete {
        width: 38px;
        padding: 0;
        color: var(--danger);
        border-color: rgba(251, 113, 133, .3);
    }

    .writer-action-icon.delete:hover {
        border-color: var(--danger);
        background: rgba(251, 113, 133, .12);
        color: var(--danger);
    }

    .writer-delete-form {
        margin: 0;
    }

    /* 6. PENGAJUAN BUKU PREMIUM */
    .writer-premium-panel {
        padding: 11px 12px;
        border: 1px solid rgba(167, 139, 250, .27);
        background: linear-gradient(110deg, rgba(99, 102, 241, .11), rgba(56, 189, 248, .045));
        border-radius: 14px;
    }

    .writer-premium-heading {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        font-weight: 800;
        color: #e9d5ff;
        margin-bottom: 5px;
    }

    .writer-premium-description {
        margin: 0 0 9px;
        color: var(--text-soft);
        font-size: 12px;
        line-height: 1.55;
    }

    .writer-premium-button {
        width: 100%;
        min-height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 7px 12px;
        border: 0;
        border-radius: 10px;
        background: #a78bfa;
        color: #111827;
        font: 700 12.5px 'Plus Jakarta Sans', sans-serif;
        cursor: pointer;
    }

    .writer-premium-button:hover {
        background: #c4b5fd;
    }

    .writer-premium-state {
        display: flex;
        align-items: center;
        gap: 7px;
        font-size: 12px;
        font-weight: 700;
        line-height: 1.5;
    }

    .writer-premium-state.approved {
        color: #86efac;
    }

    .writer-premium-state.pending {
        color: #fde68a;
    }

    .writer-premium-state.unavailable {
        color: #94a3b8;
    }

    .writer-premium-state.rejected {
        color: #fda4af;
    }

    /* 7. BELUM ADA KARYA */
    .writer-empty {
        grid-column: 1 / -1;
        padding: 44px 20px;
        background: var(--card);
        border: 1px dashed rgba(148, 163, 184, .35);
        border-radius: 22px;
        text-align: center;
    }

    .writer-empty-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 64px;
        height: 64px;
        margin: 0 auto 14px;
        border-radius: 22px;
        background: rgba(56, 189, 248, .1);
        color: var(--accent);
        font-size: 30px;
    }

    .writer-empty h3 {
        margin-bottom: 8px;
        color: #fff;
        font-size: 21px;
        font-weight: 700;
    }

    .writer-empty p {
        margin-bottom: 16px;
        color: var(--text-soft);
        font-size: 13.5px;
    }

    /* 8. RESPONSIVE */
    @media (max-width: 1100px) {
        .writer-overview {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 900px) {
        .writer-book-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 575px) {
        .writer-container {
            padding: 0 12px;
        }

        .writer-hero {
            padding: 18px 16px;
        }

        .writer-create-button {
            width: 100%;
        }

        .writer-overview {
            gap: 8px;
        }

        .writer-overview-card {
            padding: 10px;
            gap: 8px;
        }

        .writer-overview-icon {
            width: 38px;
            height: 38px;
            font-size: 15px;
        }

        .writer-overview-number {
            font-size: 20px;
        }

        .writer-overview-label {
            font-size: 11px;
        }

        .writer-book-card {
            padding: 10px;
        }

        .writer-book-cover,
        .writer-cover-placeholder {
            width: 72px;
            height: 100px;
        }

        .writer-action-icon .btn-text {
            display: none;
        }

        .writer-action-icon {
            width: 38px;
            padding: 0;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .writer-page * {
            transition: none !important;
        }
    }
</style>

<div class="writer-page">
    <div class="writer-container">
        @php
            $writerBooks = collect($books ?? []);
            $totalBooks = $writerBooks->count();
            $totalReaders = $writerBooks->sum(fn($book) => (int) ($book->readers_count ?? $book->reader_count ?? 0));
            $totalFavorites = $writerBooks->sum(fn($book) => (int) ($book->favorites_count ?? 0));
            $totalComments = $writerBooks->sum(fn($book) => (int) ($book->comments_count ?? 0));
        @endphp

        <!-- HEADER -->
        <div class="writer-hero">
            <div class="writer-hero-content">
                <div class="writer-eyebrow">
                    <i class="fa-solid fa-feather-pointed"></i> Ruang Kreatif Penulis
                </div>
                <h1>Studio Penulis</h1>
                <p>Kelola karya, tulis bab baru, dan lihat perkembangan jumlah pembaca, favorite, serta komentar dari karya yang sudah kamu buat.</p>
            </div>
            <a href="{{ url('/penulis/buku/create') }}" class="writer-create-button">
                <i class="fa-solid fa-plus"></i> Buat Buku Baru
            </a>
        </div>

        <!-- NOTIFIKASI -->
        @if(session('success'))
            <div class="alert alert-success rounded-4 mb-4">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger rounded-4 mb-4">
                <i class="fa-solid fa-circle-exclamation me-2"></i> {{ session('error') }}
            </div>
        @endif

        <!-- TOTAL STATISTIK -->
        <div class="writer-overview">
            <div class="writer-overview-card">
                <div class="writer-overview-icon blue">
                    <i class="fa-solid fa-book-open"></i>
                </div>
                <div>
                    <div class="writer-overview-number">{{ number_format($totalBooks) }}</div>
                    <div class="writer-overview-label">Total Karya</div>
                </div>
            </div>
            <div class="writer-overview-card">
                <div class="writer-overview-icon purple">
                    <i class="fa-solid fa-eye"></i>
                </div>
                <div>
                    <div class="writer-overview-number">{{ number_format($totalReaders) }}</div>
                    <div class="writer-overview-label">Total Pembaca</div>
                </div>
            </div>
            <div class="writer-overview-card">
                <div class="writer-overview-icon pink">
                    <i class="fa-solid fa-heart"></i>
                </div>
                <div>
                    <div class="writer-overview-number">{{ number_format($totalFavorites) }}</div>
                    <div class="writer-overview-label">Total Favorite</div>
                </div>
            </div>
            <div class="writer-overview-card">
                <div class="writer-overview-icon green">
                    <i class="fa-solid fa-comments"></i>
                </div>
                <div>
                    <div class="writer-overview-number">{{ number_format($totalComments) }}</div>
                    <div class="writer-overview-label">Total Komentar</div>
                </div>
            </div>
        </div>

        <!-- KOLEKSI KARYA -->
        <div class="writer-section-header">
            <div>
                <h2 class="writer-section-title">
                    <i class="fa-solid fa-layer-group" style="color:#38bdf8"></i> Koleksi Karya Saya
                </h2>
                <p class="writer-section-subtitle">Semua buku yang kamu buat dan kelola di Safae.</p>
            </div>
            <span class="writer-book-count">{{ $totalBooks }} Karya</span>
        </div>

        <!-- GRID BUKU -->
        <div class="writer-book-grid">
            @forelse($writerBooks as $book)
                @php
                    $status = strtolower($book->status ?? 'draft');
                    $statusClass = match($status) {
                        'published', 'approved' => 'published',
                        'pending' => 'pending',
                        'rejected' => 'rejected',
                        default => 'draft'
                    };
                    $statusLabel = match($status) {
                        'published' => 'Dipublikasikan',
                        'approved' => 'Disetujui',
                        'pending' => 'Menunggu Review',
                        'rejected' => 'Ditolak',
                        default => 'Draft'
                    };
                    $coverPath = $book->image_path
                        ? preg_replace('#^(public/|storage/)+#', '', $book->image_path)
                        : null;
                    $premiumRequests = $book->premiumRequests;
                    $latestPremiumRequest = $premiumRequests->sortByDesc('id')->first();
                    $premiumPending = $premiumRequests->contains('status', 'pending');
                    $premiumApprovedRequest = $premiumRequests->contains('status', 'approved');
                    $bookApproved = in_array($book->status, ['approved', 'published'], true);
                    $bookPremium = (bool) $book->is_premium;
                    $canApplyPremium = $bookApproved && !$bookPremium && !$premiumPending && !$premiumApprovedRequest;
                @endphp

                <div class="writer-book-card">
                    <!-- COVER DAN INFO -->
                    <div class="writer-book-main">
                        <a href="{{ url('/penulis/buku/'.$book->id.'/baca') }}" class="writer-book-cover-link" title="Pratinjau Buku">
                            @if($coverPath)
                                <img src="{{ asset('storage/'.$coverPath) }}" alt="Cover {{ $book->title }}" class="writer-book-cover">
                            @else
                                <div class="writer-cover-placeholder">
                                    <i class="fa-solid fa-book-open"></i>
                                </div>
                            @endif
                        </a>
                        <div class="writer-book-info">
                            <div class="writer-book-badges">
                                <span class="writer-status {{ $statusClass }}">
                                    <i class="fa-solid fa-circle" style="font-size:6px"></i> {{ $statusLabel }}
                                </span>
                                <span class="writer-genre">
                                    <i class="fa-solid fa-tag me-1"></i> {{ $book->genre ?? 'Tanpa Genre' }}
                                </span>
                            </div>
                            <h3 class="writer-book-title">
                                <a href="{{ url('/penulis/buku/'.$book->id.'/baca') }}">{{ $book->title }}</a>
                            </h3>
                            <p class="writer-book-description">
                                {{ $book->description ?: 'Belum ada deskripsi untuk karya ini.' }}
                            </p>
                        </div>
                    </div>

                    <!-- STATISTIK BUKU -->
                    <div class="writer-book-stats">
                        <div class="writer-stat-box">
                            <div class="writer-stat-value">{{ $book->chapters_count ?? 0 }}</div>
                            <div class="writer-stat-label">
                                <i class="fa-solid fa-list" style="color:#38bdf8"></i> Bab
                            </div>
                        </div>
                        <div class="writer-stat-box">
                            <div class="writer-stat-value">
                                {{ number_format((int) ($book->readers_count ?? $book->reader_count ?? 0)) }}
                            </div>
                            <div class="writer-stat-label">
                                <i class="fa-solid fa-eye" style="color:#a78bfa"></i> Pembaca
                            </div>
                        </div>
                        <div class="writer-stat-box">
                            <div class="writer-stat-value">
                                {{ number_format((int) ($book->favorites_count ?? 0)) }}
                            </div>
                            <div class="writer-stat-label">
                                <i class="fa-solid fa-heart" style="color:#fb7185"></i> Favorite
                            </div>
                        </div>
                        <div class="writer-stat-box">
                            <div class="writer-stat-value">
                                {{ number_format((int) ($book->comments_count ?? 0)) }}
                            </div>
                            <div class="writer-stat-label">
                                <i class="fa-solid fa-comment-dots" style="color:#4ade80"></i> Komentar
                            </div>
                        </div>
                    </div>

                    <!-- PENGAJUAN PREMIUM -->
                    <div class="writer-premium-panel">
                        <div class="writer-premium-heading">
                            <i class="fa-solid fa-crown"></i> Pengajuan Buku Premium
                        </div>
                        @if($bookPremium || $premiumApprovedRequest)
                            <div class="writer-premium-state approved">
                                <i class="fa-solid fa-circle-check"></i>
                                Sudah Premium — atur bab gratis/premium di Kelola Bab.
                            </div>
                        @elseif($premiumPending)
                            <div class="writer-premium-state pending">
                                <i class="fa-solid fa-clock"></i>
                                Menunggu persetujuan admin Safae.
                            </div>
                        @elseif(!$bookApproved)
                            <div class="writer-premium-state unavailable">
                                <i class="fa-solid fa-lock"></i>
                                Buku harus disetujui admin sebelum bisa diajukan.
                            </div>
                        @else
                            <p class="writer-premium-description">
                                {{ $latestPremiumRequest?->status === 'rejected' ? 'Pengajuan sebelumnya ditolak. Kamu bisa mengajukan kembali.' : 'Jadikan buku premium agar kamu bisa memilih bab gratis dan premium. Tanpa batas minimal pembaca.' }}
                            </p>
                            @if($canApplyPremium)
                                <form action="{{ route('premium.store', $book->id) }}" method="POST" onsubmit="return confirm('Yakin ingin mengajukan buku ini menjadi premium?')">
                                    @csrf
                                    <button type="submit" class="writer-premium-button">
                                        <i class="fa-solid fa-crown"></i> Ajukan Premium
                                    </button>
                                </form>
                            @endif
                        @endif
                    </div>

                    <!-- TOMBOL AKSI -->
                    <div class="writer-book-actions">
                        <a href="{{ url('/penulis/buku/'.$book->id.'/chapters') }}" class="writer-action-manage">
                            <i class="fa-solid fa-list-check"></i> Kelola Bab
                        </a>
                        <a href="{{ url('/penulis/buku/'.$book->id.'/baca') }}" class="writer-action-icon" title="Pratinjau Buku" aria-label="Pratinjau Buku">
                            <i class="fa-solid fa-eye"></i>
                            <span class="btn-text">Pratinjau</span>
                        </a>
                        <a href="{{ url('/penulis/buku/'.$book->id.'/edit') }}" class="writer-action-icon" title="Edit Buku" aria-label="Edit Buku">
                            <i class="fa-solid fa-pen-to-square"></i>
                            <span class="btn-text">Edit</span>
                        </a>
                        <form action="{{ url('/penulis/buku/'.$book->id) }}" method="POST" class="writer-delete-form" onsubmit="return confirm('Yakin ingin menghapus buku ini beserta seluruh babnya?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="writer-action-icon delete" title="Hapus Buku" aria-label="Hapus Buku">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="writer-empty">
                    <div class="writer-empty-icon">
                        <i class="fa-solid fa-feather-pointed"></i>
                    </div>
                    <h3>Belum Ada Karya</h3>
                    <p>Mulai perjalanan menulismu dengan membuat karya pertama di Safae.</p>
                    <a href="{{ url('/penulis/buku/create') }}" class="writer-create-button">
                        <i class="fa-solid fa-plus"></i> Mulai Menulis
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
