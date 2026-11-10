
@extends('layouts.app')

@section('title', 'Dashboard User - Safae')

@section('content')

<style>
    /* =========================================
       DASHBOARD SAFae - PASTEL GRADIENT
    ========================================= */

    .dashboard-page {
        min-height: 100vh;
        width: 100%;
        padding: 20px 0;

        background:
            radial-gradient(
                ellipse at 5% 5%,
                rgba(157, 211, 245, 0.35),
                transparent 40%
            ),
            radial-gradient(
                ellipse at 95% 10%,
                rgba(245, 190, 224, 0.30),
                transparent 40%
            ),
            radial-gradient(
                ellipse at 50% 70%,
                rgba(207, 197, 245, 0.20),
                transparent 45%
            ),
            radial-gradient(
                ellipse at 5% 95%,
                rgba(174, 224, 211, 0.30),
                transparent 40%
            );

        border-radius: 20px;
    }

    /* =========================================
       GENERAL CARD
    ========================================= */

    .glass-card-premium {
        background: rgba(255, 255, 255, 0.82);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);

        border: 1px solid rgba(255, 255, 255, 0.95);
        border-radius: 22px;

        color: #30364b;

        transition:
            transform .3s ease,
            box-shadow .3s ease,
            border-color .3s ease;

        box-shadow: 0 8px 28px rgba(120, 150, 200, 0.09);
        overflow: hidden;
    }

    .glass-card-premium:hover {
        transform: translateY(-3px);

        border-color: rgba(165, 216, 243, 0.8);

        box-shadow: 0 15px 35px rgba(120, 150, 200, 0.15);
    }

    .card-header-premium {
        background: transparent !important;

        border-bottom: 1px solid #edf0f8 !important;

        padding: 20px 24px;
    }

    .section-title-premium {
        color: #38425d;

        font-weight: 700;
        font-size: 1.15rem;

        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* =========================================
       WELCOME BANNER
    ========================================= */

    .welcome-banner-premium {
        position: relative;
        overflow: hidden;

        background:
            radial-gradient(
                circle at 10% 20%,
                rgba(255,255,255,0.75),
                transparent 40%
            ),
            radial-gradient(
                circle at 90% 20%,
                rgba(255, 215, 235, 0.65),
                transparent 45%
            ),
            linear-gradient(
                120deg,
                #dcefff 0%,
                #e9e5ff 50%,
                #fce8f3 100%
            );

        border: 1px solid rgba(255,255,255,.95);

        color: #394461;

        padding: 35px;
        border-radius: 26px;

        margin-bottom: 30px;

        box-shadow: 0 12px 35px rgba(120, 150, 200, 0.12);
    }

    .welcome-banner-premium::after {
        content: '';
        position: absolute;

        width: 190px;
        height: 190px;

        right: 10%;
        top: -110px;

        background: rgba(255,255,255,.35);
        border-radius: 50%;

        filter: blur(3px);
        pointer-events: none;
    }

    .welcome-banner-premium h2 {
        color: #38425d !important;
    }

    .welcome-banner-premium p {
        color: #74819d !important;
    }

    .welcome-banner-premium .text-primary {
        color: #6485d4 !important;
    }

    .welcome-banner-premium .text-warning {
        color: #e6ac44 !important;
    }

    /* =========================================
       STATISTIC CARDS
    ========================================= */

    .stat-card {
        height: 100%;
        position: relative;
    }

    .stat-icon {
        width: 52px;
        height: 52px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 16px;
        font-size: 1.2rem;
    }

    .stat-blue {
        background: linear-gradient(135deg, #e0f1ff, #d8e8ff);
        color: #6596d4;
    }

    .stat-green {
        background: linear-gradient(135deg, #ddf6eb, #e4f5ed);
        color: #58ae89;
    }

    .stat-purple {
        background: linear-gradient(135deg, #eee5ff, #e8e5ff);
        color: #9a81d4;
    }

    .stat-yellow {
        background: linear-gradient(135deg, #fff2d8, #ffebd2);
        color: #d6a04b;
    }

    .stat-title {
        color: #8792a8 !important;
        font-weight: 600;
    }

    .stat-value {
        color: #38425d !important;
        font-weight: 800;
    }

    /* =========================================
       READING LIST
    ========================================= */

    .list-item-premium {
        display: flex;
        align-items: center;

        padding: 14px 20px;

        text-decoration: none;

        color: #46516b;

        border-bottom: 1px solid #edf0f8;

        transition: .25s ease;
    }

    .list-item-premium:last-child {
        border-bottom: none;
    }

    .list-item-premium:hover {
        background: linear-gradient(
            100deg,
            rgba(225, 241, 255, .65),
            rgba(244, 233, 255, .55)
        );

        color: #6589cf;
    }

    .list-item-premium img {
        border: 2px solid #ffffff;
        box-shadow: 0 4px 12px rgba(100, 130, 180, .12);
    }

    .reading-book-title {
        color: #38425d !important;
    }

    .reading-book-info {
        color: #929db2 !important;
    }

    /* =========================================
       PROGRESS BAR
    ========================================= */

    .progress-track-premium {
        background: #edf1fa !important;

        height: 9px;
        border-radius: 999px;
        overflow: hidden;
    }

    .progress-bar-glow {
        background: linear-gradient(
            90deg,
            #82bce9,
            #9c9de7,
            #d5a9dc
        );

        border-radius: 999px;

        box-shadow: 0 0 8px rgba(130, 188, 233, .25);
    }

    .genre-label {
        color: #53617c;
    }

    .genre-count {
        color: #929db2 !important;
    }

    /* =========================================
       PROMOTION CARD
    ========================================= */

    .promo-inner-card {
        background: rgba(255,255,255,.82);

        border: 1px solid #edf0f8;
        border-radius: 19px;

        overflow: hidden;
        height: 100%;

        transition: .3s ease;

        display: flex;
        flex-direction: column;

        box-shadow: 0 5px 18px rgba(120,150,200,.06);
    }

    .promo-inner-card:hover {
        transform: translateY(-4px);

        background: #ffffff;

        border-color: #dce8fa;

        box-shadow: 0 12px 28px rgba(120,150,200,.14);
    }

    .promo-img-wrapper {
        width: 100%;
        height: 190px;

        overflow: hidden;
        position: relative;
        flex-shrink: 0;
    }

    .promo-img-wrapper img {
        width: 100%;
        height: 100%;

        object-fit: cover;

        transition: transform .5s ease;
    }

    .promo-inner-card:hover .promo-img-wrapper img {
        transform: scale(1.06);
    }

    .promo-title {
        color: #38425d !important;
    }

    .promo-description {
        color: #8792a8 !important;
        line-height: 1.6;
    }

    .promo-date {
        color: #6c9bcf !important;
    }

    .promo-divider {
        border-color: #e9edf5 !important;
    }

    /* =========================================
       BUTTON
    ========================================= */

    .btn-premium-sm {
        background: linear-gradient(
            120deg,
            #83bce9,
            #9c9de7,
            #c8a7df
        );

        border: none;
        color: #ffffff;

        font-weight: 700;
        font-size: .85rem;

        padding: 10px 16px;
        border-radius: 12px;

        transition: .25s;

        text-align: center;
        text-decoration: none;

        box-shadow: 0 5px 15px rgba(130, 155, 210, .18);
    }

    .btn-premium-sm:hover {
        transform: translateY(-2px);

        box-shadow: 0 8px 20px rgba(130, 155, 210, .28);

        color: #ffffff;
    }

    /* =========================================
       EMPTY STATE
    ========================================= */

    .empty-state {
        color: #929db2 !important;
    }

    /* =========================================
       RESPONSIVE
    ========================================= */

    @media(max-width: 768px) {
        .dashboard-page {
            padding: 10px 0;
        }

        .welcome-banner-premium {
            padding: 25px 20px;
        }

        .welcome-banner-premium h2 {
            font-size: 1.35rem;
        }

        .card-header-premium {
            padding: 18px;
        }
    }

</style>


<div class="dashboard-page">

    <div class="container-fluid px-4">

        <!-- =====================================
             WELCOME BANNER
        ====================================== -->

        <div class="welcome-banner-premium">

            <div class="row align-items-center">

                <div class="col-md-8">

                    <h2 class="mb-2 fw-bold">

                        <i class="fas fa-hand-sparkles me-2"
                           style="color: #8c9de0;"></i>

                        Selamat Datang, {{ Auth::user()->username }}!

                    </h2>

                    <p class="mb-0">
                        Selamat membaca dan jelajahi koleksi buku kami hari ini
                    </p>

                </div>

                <div class="col-md-4 text-md-end mt-3 mt-md-0">

                    <div class="d-flex justify-content-md-end align-items-center">

                        <div class="me-3 text-start">

                            <div class="fs-4 fw-bold text-primary">
                                {{ $userPoints }}
                            </div>

                            <small style="color: #8792a8;">
                                Total Poin
                            </small>

                        </div>

                        <i class="fas fa-trophy fa-3x text-warning opacity-75"></i>

                    </div>

                </div>

            </div>

        </div>


        <!-- =====================================
             STATISTICS
        ====================================== -->

        <div class="row g-4 mb-4">

            @php
                $stats = [
                    [
                        'title' => 'Total Buku',
                        'val' => $totalBooks,
                        'icon' => 'fa-book',
                        'color' => 'stat-blue'
                    ],
                    [
                        'title' => 'Pengguna',
                        'val' => $totalUsers,
                        'icon' => 'fa-users',
                        'color' => 'stat-green'
                    ],
                    [
                        'title' => 'Dibaca',
                        'val' => $userBooksRead,
                        'icon' => 'fa-book-reader',
                        'color' => 'stat-purple'
                    ],
                    [
                        'title' => 'Review',
                        'val' => $userReviews,
                        'icon' => 'fa-star',
                        'color' => 'stat-yellow'
                    ]
                ];
            @endphp

            @foreach($stats as $s)

                <div class="col-xl-3 col-md-6">

                    <div class="card glass-card-premium stat-card p-3">

                        <div class="d-flex align-items-center">

                            <div class="stat-icon {{ $s['color'] }} me-3">

                                <i class="fas {{ $s['icon'] }}"></i>

                            </div>

                            <div>

                                <h6 class="stat-title mb-1 small">
                                    {{ $s['title'] }}
                                </h6>

                                <h3 class="stat-value mb-0 fs-4">
                                    {{ number_format($s['val']) }}
                                </h3>

                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>


        <!-- =====================================
             READING HISTORY & POPULAR GENRES
        ====================================== -->

        <div class="row g-4 mb-4">

            <!-- SEDANG DIBACA -->

            <div class="col-xl-6">

                <div class="card glass-card-premium h-100">

                    <div class="card-header-premium">

                        <h5 class="section-title-premium mb-0">

                            <i class="fas fa-book-open"
                               style="color: #78aee1;"></i>

                            Sedang Dibaca

                        </h5>

                    </div>

                    <div class="card-body p-0">

                        @forelse($recentBooks as $history)

                            <a href="{{ route('book.show', [
                                'id' => $history->book->id,
                                'page' => $history->progress ?? 1
                            ]) }}"
                               class="list-item-premium">

                                <img
                                    src="{{ $history->book->image_path
                                        ? asset($history->book->image_path)
                                        : 'https://via.placeholder.com/300x400?text=No+Cover' }}"
                                    width="45"
                                    height="62"
                                    class="rounded me-3 object-fit-cover"
                                    alt="{{ $history->book->title }}">

                                <div>

                                    <h6 class="reading-book-title mb-1 small fw-bold">
                                        {{ $history->book->title }}
                                    </h6>

                                    <small class="reading-book-info">

                                        {{ $history->book->author }}

                                        •

                                        <span style="color: #70a9df;">
                                            {{ $history->last_read_at->diffForHumans() }}
                                        </span>

                                    </small>

                                </div>

                            </a>

                        @empty

                            <p class="empty-state text-center py-5 m-0">
                                <i class="fas fa-book-open fa-2x mb-3 d-block"
                                   style="color: #b8c9e5;"></i>

                                Belum ada buku yang dibaca.
                            </p>

                        @endforelse

                    </div>

                </div>

            </div>


            <!-- GENRE POPULER -->

            <div class="col-xl-6">

                <div class="card glass-card-premium h-100">

                    <div class="card-header-premium">

                        <h5 class="section-title-premium mb-0">

                            <i class="fas fa-chart-pie"
                               style="color: #9e91dc;"></i>

                            Genre Populer

                        </h5>

                    </div>

                    <div class="card-body p-4">

                        @forelse($popularGenres as $genre)

                            <div class="mb-4">

                                <div class="d-flex justify-content-between mb-2 small fw-bold">

                                    <span class="genre-label">
                                        {{ $genre->genre }}
                                    </span>

                                    <span class="genre-count">
                                        {{ $genre->total }} buku
                                    </span>

                                </div>

                                <div class="progress progress-track-premium">

                                    <div
                                        class="progress-bar progress-bar-glow"
                                        style="width: {{ ($genre->total / max(1, $totalBooks)) * 100 }}%">
                                    </div>

                                </div>

                            </div>

                        @empty

                            <p class="empty-state text-center py-4 m-0">
                                Belum ada data genre.
                            </p>

                        @endforelse

                    </div>

                </div>

            </div>

        </div>


        <!-- =====================================
             REKOMENDASI BUKU
        ====================================== -->

        @include('partials.rekomendasi', [
            'rekomendasi' => $rekomendasi
        ])


        <!-- =====================================
             COMMUNITY & COMPETITION
        ====================================== -->

        <div class="row g-4 mb-4">

            <div class="col-12">

                <div class="card glass-card-premium">

                    <div class="card-header-premium">

                        <h5 class="section-title-premium mb-0">

                            <i class="fas fa-bullhorn"
                               style="color: #e6b45f;"></i>

                            Info Komunitas & Lomba

                        </h5>

                    </div>

                    <div class="card-body p-4">

                        <div class="row g-4">

                            @forelse($promotions as $promo)

                                <div class="col-xl-4 col-md-6">

                                    <div class="promo-inner-card">

                                        <!-- IMAGE -->

                                        <div class="promo-img-wrapper">

                                            @if($promo->image)

                                                <img
                                                    src="{{ asset('storage/' . $promo->image) }}"
                                                    alt="{{ $promo->title }}">

                                            @else

                                                <img
                                                    src="https://via.placeholder.com/600x400?text=No+Cover"
                                                    alt="No Cover">

                                            @endif

                                        </div>


                                        <!-- CONTENT -->

                                        <div class="p-4 d-flex flex-column flex-grow-1 justify-content-between">

                                            <div>

                                                <h5 class="promo-title fw-bold mb-2 fs-6">

                                                    {{ $promo->title }}

                                                </h5>

                                                <p class="promo-description small mb-3">

                                                    {{ Str::limit($promo->short_description, 110) }}

                                                </p>

                                            </div>


                                            <!-- FOOTER PROMOTION -->

                                            <div class="d-flex align-items-center justify-content-between mt-2 pt-3 border-top promo-divider">

                                                @if($promo->event_date)

                                                    <small class="promo-date fw-bold">

                                                        <i class="fas fa-calendar-day me-1"></i>

                                                        {{ \Carbon\Carbon::parse($promo->event_date)->format('d M Y') }}

                                                    </small>

                                                @else

                                                    <span></span>

                                                @endif


                                                <a href="{{ route('promotions.show', $promo->id) }}"
                                                   class="btn-premium-sm">

                                                    Baca Detail

                                                    <i class="fa-solid fa-arrow-right-long ms-1 small"></i>

                                                </a>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            @empty

                                <div class="col-12">

                                    <p class="empty-state text-center py-4 m-0">

                                        <i class="fas fa-calendar-xmark fa-2x mb-3 d-block"
                                           style="color: #bdcce5;"></i>

                                        Belum ada informasi komunitas atau lomba saat ini.

                                    </p>

                                </div>

                            @endforelse

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
