
@extends('layouts.app')

@section('title', 'Ulasan Buku - ' . $book->title)

@section('content')

<style>
    .review-page-wrapper {
        padding: 10px 0 50px 0;
        color: #514d69;
    }

    .dark-panel {
        background: #ffffff;
        border: 1px solid #e5def5;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 10px 30px rgba(185, 165, 232, 0.12);
    }

    /* Rating Summary Left Card */
    .rating-score-huge {
        font-size: 3.2rem;
        font-weight: 800;
        color: #514d69;
        line-height: 1;
    }

    .star-gold {
        color: #d5a64d;
    }

    .star-muted {
        color: #ded6ef;
    }

    .progress-bar-rating {
        height: 8px;
        background: #eee8f8;
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-bar-fill {
        background: #d5a64d;
        height: 100%;
        border-radius: 10px;
    }

    /* Feedback Cards Right Side */
    .feedback-card {
        background: #ffffff;
        border: 1px solid #e5def5;
        border-radius: 18px;
        padding: 20px;
        margin-bottom: 16px;
        transition: transform 0.2s ease, border-color 0.2s ease;
    }

    .feedback-card:hover {
        border-color: #b9a5e8;
        transform: translateY(-2px);
    }

    .user-avatar-circle {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, #b9a5e8, #82a9d8);
        color: #ffffff;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    /* Modal Styling */
    .modal-dark .modal-content {
        background: #ffffff;
        border: 1px solid #e5def5;
        color: #514d69;
        border-radius: 20px;
    }

    .modal-dark .form-control {
        background: #faf9fd;
        border: 1px solid #ded6ef;
        color: #514d69;
        border-radius: 12px;
    }

    .modal-dark .form-control:focus {
        background: #ffffff;
        border-color: #b9a5e8;
        box-shadow: 0 0 0 3px rgba(185, 165, 232, 0.15);
        color: #514d69;
    }

    .modal-dark .form-control::placeholder {
        color: #aaa3bc;
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
        color: #ded6ef;
        cursor: pointer;
        transition: color 0.2s ease, transform 0.1s ease;
    }

    .rate-stars label:hover,
    .rate-stars label:hover ~ label,
    .rate-stars input:checked ~ label {
        color: #d5a64d !important;
    }

    .rate-stars label:hover {
        transform: scale(1.2);
    }

    .btn-submit-review {
        background: #b9a5e8;
        color: #ffffff;
        font-weight: 700;
        border: none;
        padding: 12px 20px;
        border-radius: 12px;
        width: 100%;
        transition: 0.2s;
    }

    .btn-submit-review:hover {
        background: #a48bdc;
    }

    /* ================= COLOR UTILITIES ================= */
    .review-page-wrapper .text-white {
        color: #514d69 !important;
    }

    .review-page-wrapper .text-secondary {
        color: #89839f !important;
    }

    .review-page-wrapper .text-warning {
        color: #d5a64d !important;
    }

    .review-page-wrapper .text-info {
        color: #82a9d8 !important;
    }

    .review-page-wrapper .text-dark {
        color: #514d69 !important;
    }

    .review-page-wrapper .text-slate-300 {
        color: #716b87 !important;
    }

    .review-page-wrapper .btn-outline-secondary {
        color: #89839f;
        border-color: #ded6ef;
    }

    .review-page-wrapper .btn-outline-secondary:hover {
        background: #eee8f8;
        color: #8065b5;
        border-color: #b9a5e8;
    }

    .review-page-wrapper .btn-info {
        background: #b9a5e8;
        border-color: #b9a5e8;
        color: #ffffff !important;
    }

    .review-page-wrapper .btn-info:hover {
        background: #a48bdc;
        border-color: #a48bdc;
    }

    .review-page-wrapper .btn-outline-info {
        color: #82a9d8;
        border-color: #82a9d8;
    }

    .review-page-wrapper .btn-outline-info:hover {
        background: #82a9d8;
        color: #ffffff;
    }

    .review-page-wrapper .badge.bg-secondary {
        background: #eee8f8 !important;
        color: #8065b5 !important;
    }

    .review-page-wrapper .alert-success {
        background-color: #e4f4eb !important;
        border-color: #b9e2cc !important;
        color: #438b68 !important;
    }

    .review-page-wrapper .alert-danger {
        background-color: #fff1f4 !important;
        border-color: #f2d2dc !important;
        color: #cf8297 !important;
    }

    .review-page-wrapper .border-secondary {
        border-color: #e5def5 !important;
    }

    .review-page-wrapper .bg-dark {
        background-color: #f5f1fc !important;
    }

    .review-page-wrapper .border-success {
        border-color: #b9e2cc !important;
    }

    .review-page-wrapper .border-danger {
        border-color: #f2d2dc !important;
    }

    .modal-dark .modal-header,
    .modal-dark .modal-footer {
        border-color: #e5def5 !important;
    }

    .modal-dark .modal-title {
        color: #514d69 !important;
    }

    .modal-dark .btn-close-white {
        filter: none;
        opacity: 0.6;
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

                        <p class="text-slate-300 small mb-0 lh-lg" style="color: #716b87;">
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
