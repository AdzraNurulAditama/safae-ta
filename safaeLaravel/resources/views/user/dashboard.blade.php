@extends('layouts.app')

@section('title', 'Dashboard User - Safae')

@section('content')
<style>
    .dashboard-page {
        min-height: 100vh;
        width: 100%;
        background:
            radial-gradient(circle at top left, rgba(139,92,246,0.12), transparent 40%),
            radial-gradient(circle at bottom right, rgba(56,189,248,0.12), transparent 40%),
            #020617;
        padding: 20px 0;
    }

    /* Glassmorphism Card Master Base */
    .glass-card-premium {
        background: rgba(255, 255, 255, 0.04);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.07);
        border-radius: 24px;
        color: #f1f5f9;
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), border-color 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        overflow: hidden;
    }
    
    .glass-card-premium:hover { 
        transform: translateY(-4px); 
        border-color: rgba(56, 189, 248, 0.3);
        box-shadow: 0 20px 40px rgba(56, 189, 248, 0.05);
    }
    
    .card-header-premium { 
        background: transparent !important; 
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important; 
        padding: 20px 24px;
    }
    
    .section-title-premium { 
        color: #fff; 
        font-weight: 700; 
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    /* Welcome Banner */
    .welcome-banner-premium {
        background: linear-gradient(135deg, rgba(30, 41, 59, 0.6) 0%, rgba(15, 23, 42, 0.8) 100%);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        color: white;
        padding: 35px;
        border-radius: 28px;
        margin-bottom: 35px;
        box-shadow: 0 20px 45px rgba(0,0,0,0.3);
    }

    /* List Group Item Link Style */
    .list-item-premium {
        display: flex;
        align-items: center;
        padding: 14px 20px;
        text-decoration: none;
        color: #e2e8f0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        transition: .25s ease;
    }

    .list-item-premium:last-child {
        border-bottom: none;
    }

    .list-item-premium:hover {
        background: rgba(255, 255, 255, 0.04);
        color: #38bdf8;
    }

    /* Modern Progress Bar */
    .progress-track-premium {
        background: rgba(255, 255, 255, 0.08) !important;
        height: 8px;
        border-radius: 999px;
        overflow: hidden;
    }

    .progress-bar-glow {
        background: linear-gradient(90deg, #10b981, #34d399);
        box-shadow: 0 0 10px rgba(16, 185, 129, 0.4);
    }

    /* Perbaikan Utama: Memaksa isi card promosi membagi tinggi secara seimbang */
    .promo-inner-card {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 20px;
        overflow: hidden;
        height: 100%;
        transition: .3s;
        display: flex;
        flex-direction: column;
    }

    .promo-inner-card:hover {
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(139, 92, 246, 0.3);
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
        transition: transform 0.5s ease;
    }

    .promo-inner-card:hover .promo-img-wrapper img {
        transform: scale(1.06);
    }

    .btn-premium-sm {
        background: linear-gradient(135deg, #8b5cf6, #ec4899);
        border: none;
        color: #fff;
        font-weight: 700;
        font-size: 0.85rem;
        padding: 10px 16px;
        border-radius: 12px;
        transition: .25s;
        text-align: center;
        text-decoration: none;
        box-shadow: 0 5px 15px rgba(139, 92, 246, 0.2);
    }

    .btn-premium-sm:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(139, 92, 246, 0.35);
        color: #fff;
    }
</style>

<div class="dashboard-page">
    <div class="container-fluid px-4">
        
        <div class="welcome-banner-premium shadow">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-2 text-white fw-bold">
                        <i class="fas fa-hand-sparkles me-2 text-primary"></i>Selamat Datang, {{ Auth::user()->username }}!
                    </h2>
                    <p class="mb-0 text-secondary" style="color: #94a3b8 !important;">
                        Selamat membaca dan jelajahi koleksi buku kami hari ini
                    </p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <div class="d-flex justify-content-md-end align-items-center">
                        <div class="me-3 text-start">
                            <div class="fs-4 fw-bold text-primary">{{ $userPoints }}</div>
                            <small class="text-secondary" style="color: #94a3b8 !important;">Total Poin</small>
                        </div>
                        <i class="fas fa-trophy fa-3x text-warning opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            @php
                $stats = [
                    ['title' => 'Total Buku', 'val' => $totalBooks, 'icon' => 'fa-book', 'color' => 'text-primary'],
                    ['title' => 'Pengguna', 'val' => $totalUsers, 'icon' => 'fa-users', 'color' => 'text-success'],
                    ['title' => 'Dibaca', 'val' => $userBooksRead, 'icon' => 'fa-book-reader', 'color' => 'text-info'],
                    ['title' => 'Review', 'val' => $userReviews, 'icon' => 'fa-star', 'color' => 'text-warning']
                ];
            @endphp
            
            @foreach($stats as $s)
            <div class="col-xl-3 col-md-6">
                <div class="card glass-card-premium p-3">
                    <div class="d-flex align-items-center">
                        <div class="p-3 rounded-4 me-3" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05);">
                            <i class="fas {{ $s['icon'] }} {{ $s['color'] }} fa-1x opacity-75"></i>
                        </div>
                        <div>
                            <h6 class="text-secondary mb-0 small" style="color: #94a3b8 !important;">{{ $s['title'] }}</h6>
                            <h3 class="mb-0 fw-bold text-white fs-4">{{ number_format($s['val']) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="row g-4 mb-4">
            <div class="col-xl-6">
                <div class="card glass-card-premium h-100">
                    <div class="card-header-premium">
                        <h5 class="section-title-premium mb-0">
                            <i class="fas fa-book-open text-primary"></i> Sedang Dibaca
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        @forelse($recentBooks as $history)
                            <a href="{{ route('book.show', $history->book->id) }}" class="list-item-premium">
                                <img src="{{ $history->book->image_path ? asset($history->book->image_path) : 'https://via.placeholder.com/300x400?text=No+Cover' }}" 
                                     width="45" height="62" class="rounded me-3 object-fit-cover shadow-sm">
                                <div>
                                    <h6 class="mb-1 text-white small fw-bold">{{ $history->book->title }}</h6>
                                    <small class="text-secondary" style="color: #94a3b8 !important;">
                                        {{ $history->book->author }} • <span class="text-info">{{ $history->last_read_at->diffForHumans() }}</span>
                                    </small>
                                </div>
                            </a>
                        @empty
                            <p class="text-secondary text-center py-5 m-0" style="color: #94a3b8 !important;">Belum ada buku yang dibaca.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="card glass-card-premium h-100">
                    <div class="card-header-premium">
                        <h5 class="section-title-premium mb-0">
                            <i class="fas fa-chart-pie text-success"></i> Genre Populer
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        @foreach($popularGenres as $genre)
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1 small fw-bold">
                                <span>{{ $genre->genre }}</span>
                                <span class="text-secondary" style="color: #94a3b8 !important;">{{ $genre->total }} buku</span>
                            </div>
                            <div class="progress progress-track-premium">
                                <div class="progress-bar progress-bar-glow" style="width: {{ ($genre->total / max(1, $totalBooks)) * 100 }}%"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="card glass-card-premium">
                    <div class="card-header-premium">
                        <h5 class="section-title-premium mb-0">
                            <i class="fas fa-bullhorn text-warning"></i> Info Komunitas & Lomba
                        </h5>
                    </div>

                    <div class="card-body p-4">
                        <div class="row g-4">
                            @forelse($promotions as $promo)
                                <div class="col-xl-4 col-md-6">
                                    <div class="promo-inner-card">

                                        <div class="promo-img-wrapper">
                                            @if($promo->image)
                                                <img src="{{ asset('storage/' . $promo->image) }}" alt="{{ $promo->title }}">
                                            @else
                                                <img src="https://via.placeholder.com/600x400?text=No+Cover" alt="No Cover">
                                            @endif
                                        </div>

                                        <div class="p-4 d-flex flex-column flex-grow-1 justify-content-between">
                                            <div>
                                                <h5 class="text-white fw-bold mb-2 fs-6">
                                                    {{ $promo->title }}
                                                </h5>
                                                <p class="text-secondary small mb-3" style="color: #94a3b8 !important; line-height: 1.6;">
                                                    {{ Str::limit($promo->short_description, 110) }}
                                                </p>
                                            </div>

                                            <div class="d-flex align-items-center justify-content-between mt-2 pt-2 border-top border-secondary border-opacity-25">
                                                @if($promo->event_date)
                                                    <small class="text-info fw-bold small">
                                                        <i class="fas fa-calendar-day me-1"></i>
                                                        {{ \Carbon\Carbon::parse($promo->event_date)->format('d M Y') }}
                                                    </small>
                                                @else
                                                    <span></span>
                                                @endif

                                                <a href="{{ route('promotions.show', $promo->id) }}" class="btn-premium-sm">
                                                    Baca Detail <i class="fa-solid fa-arrow-right-long ms-1 small"></i>
                                                </a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <p class="text-secondary text-center py-4 m-0" style="color: #94a3b8 !important;">
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