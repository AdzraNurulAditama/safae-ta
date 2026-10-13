@extends('layouts.app')

@section('title', 'Ulasan Buku - ' . $book->title)

@section('content')

<style>
    .review-page-wrapper {
        padding: 10px 0 50px 0;
        color: #f1f5f9;
    }

    .dark-panel {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    /* Rating Summary Left Card */
    .rating-score-huge {
        font-size: 3.2rem;
        font-weight: 800;
        color: #f8fafc;
        line-height: 1;
    }

    .star-gold {
        color: #f59e0b;
    }

    .star-muted {
        color: #475569;
    }

    .progress-bar-rating {
        height: 8px;
        background: #0f172a;
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-bar-fill {
        background: #f59e0b;
        height: 100%;
        border-radius: 10px;
    }

    /* Feedback Cards Right Side */
    .feedback-card {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 18px;
        padding: 20px;
        margin-bottom: 16px;
        transition: transform 0.2s ease, border-color 0.2s ease;
    }

    .feedback-card:hover {
        border-color: #38bdf8;
        transform: translateY(-2px);
    }

    .user-avatar-circle {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, #38bdf8, #818cf8);
        color: #0f172a;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    /* Modal Styling */
    .modal-dark .modal-content {
        background: #1e293b;
        border: 1px solid #334155;
        color: white;
        border-radius: 20px;
    }

    .modal-dark .form-control {
        background: #0f172a;
        border: 1px solid #334155;
        color: white;
        border-radius: 12px;
    }

    .modal-dark .form-control:focus {
        border-color: #38bdf8;
        box-shadow: none;
    }

    /* SYSTEM STAR RATING NATIVE CSS (100% WORKS & RESPONSIF) */
    .rate-stars {
        display: inline-flex;
        flex-direction: row-reverse;
        justify-content: center;
        gap: 10px;
        margin: 10px 0;
    }

    .rate-stars input {
        display: none;
    }

    .rate-stars label {
        font-size: 2.5rem;
        color: #475569;
        cursor: pointer;
        transition: color 0.2s ease, transform 0.1s ease;
    }

    .rate-stars label:hover,
    .rate-stars label:hover ~ label,
    .rate-stars input:checked ~ label {
        color: #f59e0b !important;
    }

    .rate-stars label:hover {
        transform: scale(1.2);
    }

    .btn-submit-review {
        background: #f59e0b;
        color: #0f172a;
        font-weight: 700;
        border: none;
        padding: 12px 20px;
        border-radius: 12px;
        width: 100%;
        transition: 0.2s;
    }

    .btn-submit-review:hover {
        background: #fbbf24;
    }
</style>

<div class="review-page-wrapper">
    <div class="container-fluid">

        <!-- HEADER INFORMASI BUKU -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div>
                <a href="{{ route('genre.index') }}" class="btn btn-outline-secondary btn-sm rounded-3 mb-2">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                </a>
                <h2 class="fw-bold text-white mb-1"><i class="fa-solid fa-star text-warning me-2"></i> {{ $book->title }}</h2>
                <p class="text-secondary small mb-0">Ulasan dan pendapat pembaca mengenai buku ini.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success bg-opacity-10 border-success text-success mb-4 rounded-3">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger bg-opacity-10 border-danger text-danger mb-4 rounded-3">
                <i class="fa-solid fa-circle-exclamation me-2"></i> {{ session('error') }}
            </div>
        @endif

        <!-- LAYOUT 2 KOLOM -->
        <div class="row g-4">
            
            <!-- KOLOM KIRI: AVERAGE RATING & BREAKDOWN -->
            <div class="col-lg-4">
                <div class="dark-panel">
                    <h5 class="fw-bold text-white mb-3">Average Rating</h5>
                    
                    <div class="d-flex align-items-baseline gap-3 mb-3">
                        <div class="rating-score-huge">{{ $avgRating }}</div>
                        <div>
                            <div class="fs-5">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa-solid fa-star {{ $i <= round($avgRating) ? 'star-gold' : 'star-muted' }}"></i>
                                @endfor
                            </div>
                            <small class="text-secondary">{{ $totalReview }} Ulasan Pembaca</small>
                        </div>
                    </div>

                    <!-- BREAKDOWN BINTANG 5 - 1 -->
                    <div class="d-flex flex-column gap-2 mb-4">
                        @for($star = 5; $star >= 1; $star--)
                            @php $pct = $ratingPercentages[$star] ?? 0; @endphp
                            <div class="d-flex align-items-center gap-3 small">
                                <span class="text-secondary fw-semibold" style="width: 15px;">{{ $star }}</span>
                                <div class="progress-bar-rating flex-grow-1">
                                    <div class="progress-bar-fill" style="width: {{ $pct }}%;"></div>
                                </div>
                                <span class="text-secondary fw-semibold" style="width: 35px; text-align: right;">{{ $pct }}%</span>
                            </div>
                        @endfor
                    </div>

                    <hr class="border-secondary border-opacity-25 my-4">

                    <h6 class="fw-bold text-white mb-2">Tulis Ulasanmu</h6>
                    <p class="text-secondary small mb-3">Bagikan pendapatmu untuk membantu pembaca lainnya.</p>

                    @auth
                        @if(!$reviews->contains('user_id', Auth::id()))
                            <button type="button" class="btn btn-info text-dark fw-bold w-100 rounded-3 py-2" data-bs-toggle="modal" data-bs-target="#modalTulisUlasan">
                                <i class="fa-solid fa-pen-to-square me-1"></i> Tulis Ulasan Sekarang
                            </button>
                        @else
                            <div class="p-3 rounded-3 bg-dark bg-opacity-50 text-center border border-secondary border-opacity-25 small text-info">
                                <i class="fa-solid fa-circle-check me-1"></i> Kamu sudah memberikan ulasan.
                            </div>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-info w-100 rounded-3">
                            Login untuk menulis ulasan
                        </a>
                    @endauth
                </div>
            </div>

            <!-- KOLOM KANAN: DAFTAR CUSTOMER FEEDBACK -->
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold text-white mb-0">Ulasan Pembaca</h5>
                    <span class="badge bg-secondary bg-opacity-25 text-info px-3 py-2 rounded-3">
                        Total {{ $totalReview }} Ulasan
                    </span>
                </div>

                @forelse($reviews as $review)
                    @php
                        $userName = $review->user->nama_depan 
                            ? $review->user->nama_depan . ' ' . $review->user->nama_belakang
                            : ($review->user->username ?? 'Pembaca Safae');
                        $initials = strtoupper(substr($userName, 0, 2));
                    @endphp

                    <div class="feedback-card">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="user-avatar-circle">{{ $initials }}</div>
                                <div>
                                    <h6 class="fw-bold text-white mb-0">{{ $userName }}</h6>
                                    <small class="text-secondary" style="font-size: 0.78rem;">
                                        {{ $review->created_at->diffForHumans() }}
                                    </small>
                                </div>
                            </div>
                            
                            <div class="small">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa-solid fa-star {{ $i <= $review->rating ? 'star-gold' : 'star-muted' }}"></i>
                                @endfor
                            </div>
                        </div>

                        <p class="text-slate-300 small mb-0 lh-lg" style="color: #cbd5e1;">
                            {{ $review->komentar }}
                        </p>
                    </div>
                @empty
                    <div class="dark-panel text-center py-5">
                        <i class="fa-regular fa-comments fa-3x text-secondary mb-3"></i>
                        <h5 class="fw-bold text-white">Belum Ada Ulasan</h5>
                        <p class="text-secondary small">Jadilah orang pertama yang memberikan ulasan untuk buku ini!</p>
                    </div>
                @endforelse
            </div>

        </div>

    </div>
</div>

<!-- MODAL FORM TULIS ULASAN (SUDAH DIKEMBALIKAN & BINTANG KELUAR AMAN) -->
@auth
<div class="modal fade modal-dark" id="modalTulisUlasan" tabindex="-1" aria-labelledby="modalTulisUlasanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-secondary border-opacity-25">
                <h5 class="modal-title fw-bold text-white" id="modalTulisUlasanLabel">
                    <i class="fa-solid fa-star text-warning me-2"></i> Tulis Ulasan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('ulasan.store', $book->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-4 text-center">
                        <label class="form-label small text-secondary d-block mb-2">Pilih Rating Bintang</label>
                        
                        <!-- RATING BINTANG NATIVE CSS -->
                        <div class="rate-stars">
                            <input type="radio" id="star5" name="rating" value="5" required />
                            <label for="star5" title="5 Bintang"><i class="fa-solid fa-star"></i></label>

                            <input type="radio" id="star4" name="rating" value="4" />
                            <label for="star4" title="4 Bintang"><i class="fa-solid fa-star"></i></label>

                            <input type="radio" id="star3" name="rating" value="3" />
                            <label for="star3" title="3 Bintang"><i class="fa-solid fa-star"></i></label>

                            <input type="radio" id="star2" name="rating" value="2" />
                            <label for="star2" title="2 Bintang"><i class="fa-solid fa-star"></i></label>

                            <input type="radio" id="star1" name="rating" value="1" />
                            <label for="star1" title="1 Bintang"><i class="fa-solid fa-star"></i></label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small text-secondary">Ulasan Kamu</label>
                        <textarea name="komentar" rows="4" class="form-control" placeholder="Tuliskan pendapatmu tentang alur cerita, karakter, atau pesan dari buku ini..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-secondary border-opacity-25">
                    <button type="submit" class="btn-submit-review">Kirim Ulasan ⭐</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endauth

@endsection