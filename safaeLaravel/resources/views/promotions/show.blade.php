
@extends('layouts.app')

@section('title', $promotion->title)

@section('content')

<style>
    .promotion-page {
        min-height: 100vh;
        width: 100%;
        overflow-x: hidden;
        background:
            radial-gradient(circle at 10% 10%, rgba(185, 165, 232, 0.2), transparent 40%),
            radial-gradient(circle at 90% 90%, rgba(207, 130, 151, 0.15), transparent 40%),
            #f8f6fc;
        padding: 40px 20px;
    }

    /* Tombol Kembali dengan Gaya Minimalis */
    .btn-back-minimal {
        color: #89839f;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: .25s ease;
        padding: 8px 16px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.7);
        border: 1px solid #e5def5;
    }

    .btn-back-minimal:hover {
        color: #a48bdc;
        background: #eee8f8;
        border-color: #b9a5e8;
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
            0 25px 50px -12px rgba(81, 77, 105, 0.12),
            0 0 40px rgba(185, 165, 232, 0.15);
        margin-bottom: 40px;
        border: 1px solid #e5def5;
    }

    .promo-banner-premium {
        width: 100%;
        height: 450px;
        object-fit: cover;
    }

    /* Efek Gradasi di Bawah Gambar */
    .banner-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(81, 77, 105, 0.4) 0%, transparent 60%);
    }

    /* Main Glass Card untuk Tulisan */
    .glass-article-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
        border: 1px solid #e5def5;
        border-radius: 32px;
        padding: 50px;
        box-shadow: 0 30px 60px rgba(81, 77, 105, 0.08);
    }

    /* Kapsul Tanggal */
    .event-badge-premium {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: linear-gradient(135deg, #f0eafb, #fff1f4);
        color: #514d69;
        border: 1px solid #e5def5;
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
        background: linear-gradient(135deg, #514d69 40%, #a48bdc 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        letter-spacing: -1px;
    }

    /* Gaya Paragraf Artikel Modern */
    .promo-body-premium {
        color: #6f6987;
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

                    <div class="my-4" style="height: 1px; width: 80px; background: linear-gradient(to right, #b9a5e8, transparent);"></div>

                    <div class="promo-body-premium">
                        {!! nl2br(e($promotion->content)) !!}
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

@endsection
