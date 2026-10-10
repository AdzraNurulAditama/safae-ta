@extends('layouts.app')

@section('title', $promotion->title)

@section('content')

<style>
    .promo-detail-page {
        min-height: 100vh;
        width: 100%;
        overflow-x: hidden;
        background:
            radial-gradient(circle at 15% 15%, rgba(139, 92, 246, 0.18), transparent 45%),
            radial-gradient(circle at 85% 85%, rgba(236, 72, 153, 0.12), transparent 45%),
            #020617;
        padding: 40px 20px;
    }

    /* Tombol Kembali Kapsul Modern */
    .btn-back-glow {
        color: #94a3b8;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: .3s cubic-bezier(0.4, 0, 0.2, 1);
        padding: 10px 20px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .btn-back-glow:hover {
        color: #38bdf8;
        background: rgba(56, 189, 248, 0.08);
        border-color: rgba(56, 189, 248, 0.2);
        transform: translateX(-4px);
    }

    /* Hero Banner Sinematik Terpisah */
    .premium-banner-wrapper {
        position: relative;
        width: 100%;
        max-height: 460px;
        border-radius: 28px;
        overflow: hidden;
        box-shadow: 
            0 30px 60px -15px rgba(0, 0, 0, 0.7),
            0 0 50px rgba(139, 92, 246, 0.12);
        margin-bottom: 40px;
        border: 1px solid rgba(255, 255, 255, 0.06);
    }

    .premium-banner-img {
        width: 100%;
        height: 460px;
        object-fit: cover;
    }

    .premium-banner-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(2, 6, 23, 0.85) 0%, transparent 70%);
    }

    /* Glassmorphism Article Card */
    .glass-premium-card {
        background: rgba(15, 23, 42, 0.4);
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 32px;
        padding: 55px;
        box-shadow: 0 30px 70px rgba(0, 0, 0, 0.5);
    }

    /* Kapsul Info Waktu */
    .time-badge-premium {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: linear-gradient(135deg, rgba(139, 92, 246, 0.12), rgba(236, 72, 153, 0.12));
        color: #f1f5f9;
        border: 1px solid rgba(168, 85, 247, 0.2);
        padding: 10px 22px;
        border-radius: 999px;
        font-weight: 700;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        margin-bottom: 25px;
    }

    /* Judul dengan Teks Gradasi Logam */
    .promo-headline-premium {
        font-size: 3rem;
        font-weight: 800;
        line-height: 1.2;
        background: linear-gradient(135deg, #ffffff 30%, #c084fc 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        letter-spacing: -1px;
    }

    /* Elemen Pembatas Minimalis */
    .accent-bar {
        height: 2px;
        width: 60px;
        background: linear-gradient(to right, #38bdf8, transparent);
        margin: 25px 0;
    }

    /* Pembacaan Konten Artikel Premium */
    .promo-body-premium {
        color: #cbd5e1;
        font-size: 1.15rem;
        line-height: 1.9;
        font-weight: 400;
    }

    /* Memberikan jarak paragraf yang rapi dari nl2br */
    .promo-body-premium br {
        content: "";
        margin: 14px 0;
        display: block;
    }

    @media(max-width: 992px) {
        .glass-premium-card {
            padding: 40px 25px;
        }
    }

    @media(max-width: 768px) {
        .promo-headline-premium {
            font-size: 2.1rem;
        }
        .premium-banner-wrapper,
        .premium-banner-img {
            height: 260px;
        }
        .promo-detail-page {
            padding: 20px 12px;
        }
    }
</style>

<div class="promo-detail-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-9 col-lg-10">

                <div class="mb-4">
                    <a href="{{ url()->previous() }}" class="btn-back-glow">
                        <i class="fa-solid fa-arrow-left-long"></i> Kembali
                    </a>
                </div>

                @if($promotion->image)
                    <div class="premium-banner-wrapper">
                        <img src="{{ asset('storage/' . $promotion->image) }}"
                             class="premium-banner-img"
                             alt="{{ $promotion->title }}">
                        <div class="premium-banner-overlay"></div>
                    </div>
                @endif

                <div class="glass-premium-card">
                    
                    @if($promotion->event_date)
                        <div class="time-badge-premium">
                            <i class="fa-solid fa-calendar-days text-info"></i>
                            <span>{{ \Carbon\Carbon::parse($promotion->event_date)->format('d F Y') }}</span>
                        </div>
                    @endif

                    <h1 class="promo-headline-premium">
                        {{ $promotion->title }}
                    </h1>

                    <div class="accent-bar"></div>

                    <div class="promo-body-premium">
                        {!! nl2br(e($promotion->content)) !!}
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

@endsection