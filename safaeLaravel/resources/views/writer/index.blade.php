
@extends('layouts.app')

@section('title', 'Studio Penulis - Safae')

@section('content')

<style>
    /* =========================================
       STUDIO PENULIS - PASTEL GRADIENT THEME
    ========================================= */

    .writer-page {
        --card: rgba(255, 255, 255, .84);
        --card-inner: #f5f8ff;
        --line: #e8edf8;
        --text: #38425d;
        --text-soft: #8995aa;
        --accent: #719bd7;
        --accent-dark: #ffffff;
        --danger: #e87991;

        font-family: 'Plus Jakarta Sans', 'Space Grotesk', sans-serif;
        color: var(--text);
        padding: 16px 0 48px;

        background:
            radial-gradient(
                ellipse at 5% 5%,
                rgba(157, 211, 245, .30),
                transparent 40%
            ),
            radial-gradient(
                ellipse at 95% 10%,
                rgba(245, 190, 224, .28),
                transparent 40%
            ),
            radial-gradient(
                ellipse at 50% 75%,
                rgba(207, 197, 245, .20),
                transparent 45%
            ),
            radial-gradient(
                ellipse at 5% 95%,
                rgba(174, 224, 211, .25),
                transparent 40%
            );
        border-radius: 20px;
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

    /* =========================================
       HEADER STUDIO PENULIS
    ========================================= */

    .writer-hero {
        position: relative;
        overflow: hidden;

        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 14px;

        padding: 28px;
        margin-bottom: 20px;

        border: 1px solid rgba(255,255,255,.95);
        border-radius: 24px;

        background:
            radial-gradient(
                ellipse at 90% 0%,
                rgba(245, 190, 224, .65),
                transparent 50%
            ),
            radial-gradient(
                ellipse at 5% 100%,
                rgba(157, 211, 245, .65),
                transparent 55%
            ),
            linear-gradient(
                120deg,
                #e3f3ff,
                #eeeaff 55%,
                #fcebf5
            );

        box-shadow: 0 12px 35px rgba(120, 150, 200, .12);
    }

    .writer-hero::after {
        content: '';
        position: absolute;
        width: 180px;
        height: 180px;
        right: 15%;
        top: -120px;
        background: rgba(255,255,255,.4);
        border-radius: 50%;
        filter: blur(5px);
        pointer-events: none;
    }

    .writer-hero-content {
        position: relative;
        z-index: 1;
    }

    .writer-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;

        padding: 6px 12px;
        margin-bottom: 10px;

        border: 1px solid rgba(255,255,255,.9);
        border-radius: 999px;

        background: rgba(255,255,255,.55);
        color: #7189c8;

        font-size: 12.5px;
        font-weight: 700;
    }

    .writer-eyebrow i {
        color: #78b9e5;
    }

    .writer-hero h1 {
        margin: 0 0 5px;
        color: #394461;

        font-size: clamp(26px, 3.2vw, 38px);
        font-weight: 800;
        letter-spacing: -0.03em;
    }

    .writer-hero p {
        max-width: 540px;
        margin: 0;

        color: #77849e;
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

        padding: 12px 20px;
        border-radius: 14px;

        background: linear-gradient(
            120deg,
            #7ebce8,
            #9c9de7,
            #c7a7df
        );

        color: #ffffff;
        font-size: 14px;
        font-weight: 700;

        text-decoration: none;
        white-space: nowrap;

        box-shadow: 0 5px 16px rgba(130, 155, 210, .2);
        transition: .25s;
    }

    .writer-create-button:hover {
        background: linear-gradient(
            120deg,
            #6faadd,
            #898bdc,
            #b994d5
        );

        color: #ffffff;
        transform: translateY(-2px);
    }

    /* =========================================
       NOTIFICATION
    ========================================= */

    .writer-page .alert {
        border: 1px solid rgba(255,255,255,.9);
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(120,150,200,.06);
    }

    /* =========================================
       STATISTIK TOTAL
    ========================================= */

    .writer-overview {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 12px;
        margin-bottom: 28px;
    }

    .writer-overview-card {
        display: flex;
        align-items: center;
        gap: 12px;

        padding: 15px 16px;

        background: rgba(255,255,255,.85);
        border: 1px solid rgba(255,255,255,.95);
        border-radius: 18px;

        box-shadow: 0 6px 20px rgba(120,150,200,.07);
        transition: .25s;
    }

    .writer-overview-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 25px rgba(120,150,200,.13);
    }

    .writer-overview-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;

        width: 44px;
        height: 44px;

        border-radius: 14px;
        font-size: 17px;
    }

    .writer-overview-icon.blue {
        color: #6596d4;
        background: linear-gradient(135deg, #e0f1ff, #d8e8ff);
    }

    .writer-overview-icon.purple {
        color: #9a81d4;
        background: linear-gradient(135deg, #eee5ff, #e8e5ff);
    }

    .writer-overview-icon.pink {
        color: #e58baa;
        background: linear-gradient(135deg, #ffe6f0, #fceafa);
    }

    .writer-overview-icon.green {
        color: #58ae89;
        background: linear-gradient(135deg, #ddf6eb, #e4f5ed);
    }

    .writer-overview-number {
        color: #38425d;
        font-size: 22px;
        font-weight: 800;
        line-height: 1.1;
    }

    .writer-overview-label {
        margin-top: 3px;
        color: #929db2;
        font-size: 12px;
    }

    /* =========================================
       KOLEKSI KARYA
    ========================================= */

    .writer-section-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 15px;
    }

    .writer-section-title {
        display: flex;
        align-items: center;
        gap: 10px;

        margin: 0 0 4px;
        color: #38425d;

        font-size: 20px;
        font-weight: 800;
        letter-spacing: -0.02em;
    }

    .writer-section-subtitle {
        margin: 0;
        color: #8995aa;
        font-size: 13px;
    }

    .writer-book-count {
        padding: 6px 13px;

        border: 1px solid #dce8fa;
        border-radius: 999px;

        background: linear-gradient(120deg, #e2f1ff, #eee8ff);
        color: #7189cf;

        font-size: 12.5px;
        font-weight: 700;
    }

    /* =========================================
       CARD BUKU
    ========================================= */

    .writer-book-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 15px;
    }

    .writer-book-card {
        display: flex;
        flex-direction: column;
        gap: 12px;

        min-width: 0;
        padding: 15px;

        background: rgba(255,255,255,.88);
        border: 1px solid rgba(255,255,255,.95);
        border-radius: 20px;

        box-shadow: 0 6px 22px rgba(120,150,200,.07);

        transition: .3s;
    }

    .writer-book-card:hover {
        border-color: #dce8fa;
        box-shadow: 0 14px 30px rgba(120,150,200,.14);
        transform: translateY(-3px);
    }

    /* COVER DAN INFORMASI */

    .writer-book-main {
        display: flex;
        gap: 13px;
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

        border-radius: 11px;
        border: 1px solid #e8edf8;
    }

    .writer-book-cover {
        object-fit: cover;
        background: #f5f8ff;
        box-shadow: 0 4px 12px rgba(100,130,180,.12);
    }

    .writer-cover-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;

        background: linear-gradient(
            145deg,
            #dceeff,
            #eee5ff,
            #fceafa
        );

        color: #829bd6;
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
        margin-bottom: 6px;
    }

    /* =========================================
       STATUS BUKU
    ========================================= */

    .writer-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;

        padding: 4px 9px;

        border: 1px solid transparent;
        border-radius: 999px;

        font-size: 11px;
        font-weight: 700;
    }

    .writer-status.published {
        color: #39976c;
        background: #e2f7ec;
        border-color: #c8eedb;
    }

    .writer-status.draft {
        color: #b68b35;
        background: #fff5dc;
        border-color: #f5e6b9;
    }

    .writer-status.pending {
        color: #568fc4;
        background: #e4f3ff;
        border-color: #cfe8fa;
    }

    .writer-status.rejected {
        color: #d66c83;
        background: #ffebf0;
        border-color: #f8d4de;
    }

    .writer-genre {
        color: #929db2;
        font-size: 12px;
    }

    .writer-book-title {
        margin: 0 0 5px;
        font-size: 16px;
        font-weight: 700;
        line-height: 1.3;
    }

    .writer-book-title a {
        color: #38425d;
        text-decoration: none;
    }

    .writer-book-title a:hover {
        color: #719bd7;
    }

    .writer-book-description {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;

        margin: 0;

        color: #8995aa;
        font-size: 12.5px;
        line-height: 1.5;
    }

    /* =========================================
       STATISTIK PER BUKU
    ========================================= */

    .writer-book-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));

        padding: 10px 4px;

        background: linear-gradient(
            120deg,
            #f1f7ff,
            #f6f2ff,
            #fff5fa
        );

        border: 1px solid #edf0f8;
        border-radius: 14px;
    }

    .writer-stat-box {
        text-align: center;
        min-width: 0;
    }

    .writer-stat-box + .writer-stat-box {
        border-left: 1px solid #e5eaf4;
    }

    .writer-stat-value {
        color: #38425d;
        font-size: 16px;
        font-weight: 800;
        line-height: 1.2;
    }

    .writer-stat-label {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;

        margin-top: 3px;

        color: #929db2;
        font-size: 11px;
    }

    /* =========================================
       PENGAJUAN PREMIUM
    ========================================= */

    .writer-premium-panel {
        padding: 12px;

        border: 1px solid #e9e0f8;

        background: linear-gradient(
            110deg,
            #f1edff,
            #eaf5ff,
            #fff1f7
        );

        border-radius: 14px;
    }

    .writer-premium-heading {
        display: flex;
        align-items: center;
        gap: 8px;

        font-size: 13px;
        font-weight: 800;
        color: #9579c7;

        margin-bottom: 6px;
    }

    .writer-premium-description {
        margin: 0 0 10px;

        color: #8995aa;
        font-size: 12px;
        line-height: 1.55;
    }

    .writer-premium-button {
        width: 100%;
        min-height: 37px;

        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;

        padding: 8px 12px;

        border: 0;
        border-radius: 10px;

        background: linear-gradient(
            120deg,
            #c2a6e7,
            #9eb7ed,
            #e7afd1
        );

        color: #ffffff;

        font: 700 12.5px 'Plus Jakarta Sans', sans-serif;

        cursor: pointer;
        transition: .25s;
    }

    .writer-premium-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 14px rgba(160,140,210,.2);
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
        color: #39976c;
    }

    .writer-premium-state.pending {
        color: #bd923e;
    }

    .writer-premium-state.unavailable {
        color: #8995aa;
    }

    .writer-premium-state.rejected {
        color: #d66c83;
    }

    /* =========================================
       TOMBOL AKSI
    ========================================= */

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

        background: linear-gradient(
            120deg,
            #83bce9,
            #9c9de7,
            #c8a7df
        );

        color: #ffffff;

        font-size: 13px;
        font-weight: 700;
        text-decoration: none;

        transition: .25s;
    }

    .writer-action-manage:hover {
        background: linear-gradient(
            120deg,
            #6faadd,
            #898bdc,
            #b994d5
        );

        color: #ffffff;
    }

    .writer-action-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;

        min-height: 38px;
        padding: 0 12px;

        background: #ffffff;
        border: 1px solid #e5eaf4;
        border-radius: 12px;

        color: #8795ad;

        font-family: inherit;
        font-size: 13px;
        font-weight: 600;

        text-decoration: none;
        cursor: pointer;

        transition: .2s;
    }

    .writer-action-icon:hover {
        border-color: #b8d9f4;
        color: #6b9dce;
        background: #eff7ff;
    }

    .writer-action-icon.delete {
        width: 38px;
        padding: 0;

        color: #dc8295;
        border-color: #f4dce2;
    }

    .writer-action-icon.delete:hover {
        border-color: #e9a6b6;
        background: #fff0f3;
        color: #d66c83;
    }

    .writer-delete-form {
        margin: 0;
    }

    /* =========================================
       EMPTY STATE
    ========================================= */

    .writer-empty {
        grid-column: 1 / -1;

        padding: 48px 20px;

        background: rgba(255,255,255,.85);
        border: 1px dashed #d9e5f5;
        border-radius: 22px;

        text-align: center;

        box-shadow: 0 6px 20px rgba(120,150,200,.06);
    }

    .writer-empty-icon {
        display: flex;
        align-items: center;
        justify-content: center;

        width: 68px;
        height: 68px;

        margin: 0 auto 14px;

        border-radius: 22px;

        background: linear-gradient(
            135deg,
            #e0f1ff,
            #eee5ff,
            #fceafa
        );

        color: #829bd6;
        font-size: 30px;
    }

    .writer-empty h3 {
        margin-bottom: 8px;
        color: #38425d;
        font-size: 21px;
        font-weight: 700;
    }

    .writer-empty p {
        margin-bottom: 16px;
        color: #8995aa;
        font-size: 13.5px;
    }

    /* =========================================
       RESPONSIVE
    ========================================= */

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
            padding: 20px 16px;
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
            padding: 11px;
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

        .writer-section-title {
            font-size: 18px;
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
                    <i class="fa-solid fa-feather-pointed"></i>
                    Ruang Kreatif Penulis
                </div>

                <h1>Studio Penulis</h1>

                <p>
                    Kelola karya, tulis bab baru, dan lihat perkembangan jumlah pembaca,
                    favorite, serta komentar dari karya yang sudah kamu buat.
                </p>

            </div>

            <a href="{{ url('/penulis/buku/create') }}" class="writer-create-button">
                <i class="fa-solid fa-plus"></i>
                Buat Buku Baru
            </a>

        </div>


        <!-- NOTIFIKASI -->

        @if(session('success'))
            <div class="alert alert-success mb-4">
                <i class="fa-solid fa-circle-check me-2"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger mb-4">
                <i class="fa-solid fa-circle-exclamation me-2"></i>
                {{ session('error') }}
            </div>
        @endif


        <!-- TOTAL STATISTIK -->

        <div class="writer-overview">

            <div class="writer-overview-card">

                <div class="writer-overview-icon blue">
                    <i class="fa-solid fa-book-open"></i>
                </div>

                <div>
                    <div class="writer-overview-number">
                        {{ number_format($totalBooks) }}
                    </div>

                    <div class="writer-overview-label">
                        Total Karya
                    </div>
                </div>

            </div>


            <div class="writer-overview-card">

                <div class="writer-overview-icon purple">
                    <i class="fa-solid fa-eye"></i>
                </div>

                <div>
                    <div class="writer-overview-number">
                        {{ number_format($totalReaders) }}
                    </div>

                    <div class="writer-overview-label">
                        Total Pembaca
                    </div>
                </div>

            </div>


            <div class="writer-overview-card">

                <div class="writer-overview-icon pink">
                    <i class="fa-solid fa-heart"></i>
                </div>

                <div>
                    <div class="writer-overview-number">
                        {{ number_format($totalFavorites) }}
                    </div>

                    <div class="writer-overview-label">
                        Total Favorite
                    </div>
                </div>

            </div>


            <div class="writer-overview-card">

                <div class="writer-overview-icon green">
                    <i class="fa-solid fa-comments"></i>
                </div>

                <div>
                    <div class="writer-overview-number">
                        {{ number_format($totalComments) }}
                    </div>

                    <div class="writer-overview-label">
                        Total Komentar
                    </div>
                </div>

            </div>

        </div>


        <!-- KOLEKSI KARYA -->

        <div class="writer-section-header">

            <div>

                <h2 class="writer-section-title">

                    <i class="fa-solid fa-layer-group" style="color:#83bce9"></i>

                    Koleksi Karya Saya

                </h2>

                <p class="writer-section-subtitle">
                    Semua buku yang kamu buat dan kelola di Safae.
                </p>

            </div>

            <span class="writer-book-count">
                {{ $totalBooks }} Karya
            </span>

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

                        <a href="{{ url('/penulis/buku/'.$book->id.'/baca') }}"
                           class="writer-book-cover-link"
                           title="Pratinjau Buku">

                            @if($coverPath)

                                <img
                                    src="{{ asset('storage/'.$coverPath) }}"
                                    alt="Cover {{ $book->title }}"
                                    class="writer-book-cover">

                            @else

                                <div class="writer-cover-placeholder">
                                    <i class="fa-solid fa-book-open"></i>
                                </div>

                            @endif

                        </a>


                        <div class="writer-book-info">

                            <div class="writer-book-badges">

                                <span class="writer-status {{ $statusClass }}">

                                    <i class="fa-solid fa-circle" style="font-size:6px"></i>

                                    {{ $statusLabel }}

                                </span>

                                <span class="writer-genre">

                                    <i class="fa-solid fa-tag me-1"></i>

                                    {{ $book->genre ?? 'Tanpa Genre' }}

                                </span>

                            </div>


                            <h3 class="writer-book-title">

                                <a href="{{ url('/penulis/buku/'.$book->id.'/baca') }}">
                                    {{ $book->title }}
                                </a>

                            </h3>


                            <p class="writer-book-description">

                                {{ $book->description ?: 'Belum ada deskripsi untuk karya ini.' }}

                            </p>

                        </div>

                    </div>


                    <!-- STATISTIK BUKU -->

                    <div class="writer-book-stats">

                        <div class="writer-stat-box">

                            <div class="writer-stat-value">
                                {{ $book->chapters_count ?? 0 }}
                            </div>

                            <div class="writer-stat-label">
                                <i class="fa-solid fa-list" style="color:#78b9e5"></i>
                                Bab
                            </div>

                        </div>


                        <div class="writer-stat-box">

                            <div class="writer-stat-value">
                                {{ number_format((int) ($book->readers_count ?? $book->reader_count ?? 0)) }}
                            </div>

                            <div class="writer-stat-label">
                                <i class="fa-solid fa-eye" style="color:#9a91d8"></i>
                                Pembaca
                            </div>

                        </div>


                        <div class="writer-stat-box">

                            <div class="writer-stat-value">
                                {{ number_format((int) ($book->favorites_count ?? 0)) }}
                            </div>

                            <div class="writer-stat-label">
                                <i class="fa-solid fa-heart" style="color:#e58baa"></i>
                                Favorite
                            </div>

                        </div>


                        <div class="writer-stat-box">

                            <div class="writer-stat-value">
                                {{ number_format((int) ($book->comments_count ?? 0)) }}
                            </div>

                            <div class="writer-stat-label">
                                <i class="fa-solid fa-comment-dots" style="color:#58ae89"></i>
                                Komentar
                            </div>

                        </div>

                    </div>


                    <!-- PENGAJUAN PREMIUM -->

                    <div class="writer-premium-panel">

                        <div class="writer-premium-heading">

                            <i class="fa-solid fa-crown"></i>

                            Pengajuan Buku Premium

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

                                {{ $latestPremiumRequest?->status === 'rejected'
                                    ? 'Pengajuan sebelumnya ditolak. Kamu bisa mengajukan kembali.'
                                    : 'Jadikan buku premium agar kamu bisa memilih bab gratis dan premium. Tanpa batas minimal pembaca.' }}

                            </p>

                            @if($canApplyPremium)

                                <form
                                    action="{{ route('premium.store', $book->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin mengajukan buku ini menjadi premium?')">

                                    @csrf

                                    <button type="submit" class="writer-premium-button">

                                        <i class="fa-solid fa-crown"></i>

                                        Ajukan Premium

                                    </button>

                                </form>

                            @endif

                        @endif

                    </div>


                    <!-- TOMBOL AKSI -->

                    <div class="writer-book-actions">

                        <a href="{{ url('/penulis/buku/'.$book->id.'/chapters') }}"
                           class="writer-action-manage">

                            <i class="fa-solid fa-list-check"></i>

                            Kelola Bab

                        </a>


                        <a href="{{ url('/penulis/buku/'.$book->id.'/baca') }}"
                           class="writer-action-icon"
                           title="Pratinjau Buku"
                           aria-label="Pratinjau Buku">

                            <i class="fa-solid fa-eye"></i>

                            <span class="btn-text">Pratinjau</span>

                        </a>


                        <a href="{{ url('/penulis/buku/'.$book->id.'/edit') }}"
                           class="writer-action-icon"
                           title="Edit Buku"
                           aria-label="Edit Buku">

                            <i class="fa-solid fa-pen-to-square"></i>

                            <span class="btn-text">Edit</span>

                        </a>


                        <form
                            action="{{ url('/penulis/buku/'.$book->id) }}"
                            method="POST"
                            class="writer-delete-form"
                            onsubmit="return confirm('Yakin ingin menghapus buku ini beserta seluruh babnya?')">

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="writer-action-icon delete"
                                title="Hapus Buku"
                                aria-label="Hapus Buku">

                                <i class="fa-solid fa-trash"></i>

                            </button>

                        </form>

                    </div>

                </div>


            @empty

                <!-- BELUM ADA KARYA -->

                <div class="writer-empty">

                    <div class="writer-empty-icon">

                        <i class="fa-solid fa-feather-pointed"></i>

                    </div>

                    <h3>Belum Ada Karya</h3>

                    <p>
                        Mulai perjalanan menulismu dengan membuat karya pertama di Safae.
                    </p>

                    <a href="{{ url('/penulis/buku/create') }}"
                       class="writer-create-button">

                        <i class="fa-solid fa-plus"></i>

                        Mulai Menulis

                    </a>

                </div>

            @endforelse

        </div>

    </div>

</div>

@endsection
