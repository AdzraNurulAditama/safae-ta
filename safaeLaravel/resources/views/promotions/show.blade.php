@extends('layouts.app')

@section('title', $promotion->title)

@section('content')

<style>
    .promotion-page {
        min-height: 100vh;
        width: 100%;
        overflow-x: hidden;
        background:
            radial-gradient(circle at 10% 10%, rgba(139, 92, 246, 0.2), transparent 40%),
            radial-gradient(circle at 90% 90%, rgba(236, 72, 153, 0.15), transparent 40%),
            #020617;
        padding: 40px 20px;
    }

    /* Tombol Kembali dengan Gaya Minimalis Gading */
    .btn-back-minimal {
        color: #94a3b8;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: .25s ease;
        padding: 8px 16px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .btn-back-minimal:hover {
        color: #38bdf8;
        background: rgba(56, 189, 248, 0.08);
        border-color: rgba(56, 189, 248, 0.2);
        transform: translateX(-4px);
    }

    /* Wadah Gambar Bergaya Sinematik */
    .banner-container {
        position: relative;
        width: 100%;
        max-height: 450px;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 
            0 25px 50px -12px rgba(0, 0, 0, 0.6),
            0 0 40px rgba(139, 92, 246, 0.15); /* Pijar Ungu Halus */
        margin-bottom: 40px;
        border: 1px solid rgba(255, 255, 255, 0.08);
    }

    .promo-banner-premium {
        width: 100%;
        height: 450px;
        object-fit: cover;
    }

    /* Efek Gradasi Gelap di Bawah Gambar */
    .banner-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(2, 6, 23, 0.8) 0%, transparent 60%);
    }

    /* Main Glass Card untuk Tulisan */
    .glass-article-card {
        background: rgba(15, 23, 42, 0.45);
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 32px;
        padding: 50px;
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.4);
    }

    /* Kapsul Tanggal */
    .event-badge-premium {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: linear-gradient(135deg, rgba(139, 92, 246, 0.15), rgba(236, 72, 153, 0.15));
        color: #e9d5ff;
        border: 1px solid rgba(168, 85, 247, 0.25);
        padding: 10px 20px;
        border-radius: 999px;
        font-weight: 700;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        margin-bottom: 25px;
    }

    /* Judul dengan Efek Gradasi */
    .promo-title-premium {
        font-size: 2.8rem;
        font-weight: 800;
        line-height: 1.25;
        background: linear-gradient(135deg, #ffffff 40%, #c084fc 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        letter-spacing: -1px;
    }

    /* Gaya Paragraf Artikel Modern */
    .promo-body-premium {
        color: #cbd5e1;
        font-size: 1.15rem;
        line-height: 1.9;
        font-weight: 400;
        letter-spacing: 0.2px;
    }

    /* Mempercantik spasi antar paragraf dari nl2br */
    .promo-body-premium br {
        content: "";
        margin: 12px 0;
        display: block;
    }

    @media(max-width: 992px) {
        .glass-article-card {
            padding: 35px 25px;
        }
    }

    @media(max-width: 768px) {
        .promo-title-premium {
            font-size: 2rem;
        }
        .banner-container,
        .promo-banner-premium {
            height: 280px;
        }
        .promotion-page {
            padding: 20px 12px;
        }
    }
</style>

<div class="promotion-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-9 col-lg-10">

                <div class="mb-4">
                    <a href="{{ url()->previous() }}" class="btn-back-minimal">
                        <i class="fa-solid fa-arrow-left-long"></i> Kembali ke Dashboard
                    </a>
                </div>

                @if($promotion->image)
                    <div class="banner-container">
                        <img src="{{ asset('storage/' . $promotion->image) }}"
                             class="promo-banner-premium"
                             alt="{{ $promotion->title }}">
                        <div class="banner-overlay"></div>
                    </div>
                @endif

                <div class="glass-article-card">
                    
                    @if($promotion->event_date)
                        <div class="event-badge-premium">
                            <i class="fa-solid fa-calendar-check text-primary"></i>
                            <span>EVENT: {{ \Carbon\Carbon::parse($promotion->event_date)->format('d F Y') }}</span>
                        </div>
                    @endif

                    <h1 class="promo-title-premium mb-4">
                        {{ $promotion->title }}
                    </h1>

                    <div class="my-4" style="height: 1px; width: 80px; background: linear-gradient(to right, #8b5cf6, transparent);"></div>

                    <div class="promo-body-premium">
                        {!! nl2br(e($promotion->content)) !!}
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

@endsection