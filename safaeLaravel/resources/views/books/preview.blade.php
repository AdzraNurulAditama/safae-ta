@extends('layouts.app')

@section('title', $book->title . ' - Detail Buku')

@section('content')

<style>
    .wattpad-preview-wrapper {
        padding: 20px 0 60px 0;
        color: #f1f5f9;
        max-width: 1000px;
        margin: 0 auto;
    }

    /* Cover & Header Details */
    .book-cover-wattpad {
        width: 180px;
        height: 270px;
        object-fit: cover;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
    }

    .author-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, #38bdf8, #818cf8);
        color: #0f172a;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
    }

    .stat-badge {
        color: #94a3b8;
        font-size: 0.9rem;
    }

    /* Buttons */
    .btn-read-main {
        background: #f8fafc;
        color: #0f172a;
        font-weight: 700;
        padding: 12px 40px;
        border-radius: 999px;
        border: none;
        font-size: 1rem;
        transition: 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-read-main:hover {
        background: #38bdf8;
        color: #0f172a;
        transform: translateY(-2px);
    }

    /* Nav Tabs */
    .wattpad-tabs {
        border-bottom: 1px solid #334155;
        margin-top: 30px;
        margin-bottom: 25px;
    }

    .wattpad-tab-btn {
        background: transparent;
        border: none;
        color: #94a3b8;
        font-weight: 700;
        padding: 12px 24px;
        font-size: 1rem;
        position: relative;
        cursor: pointer;
        transition: 0.2s;
    }

    .wattpad-tab-btn.active {
        color: #38bdf8;
    }

    .wattpad-tab-btn.active::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        right: 0;
        height: 3px;
        background: #38bdf8;
        border-radius: 3px 3px 0 0;
    }

    /* Tags Pill */
    .tag-pill {
        background: #1e293b;
        border: 1px solid #334155;
        color: #cbd5e1;
        padding: 5px 14px;
        border-radius: 8px;
        font-size: 0.82rem;
        display: inline-block;
        margin-bottom: 8px;
        margin-right: 6px;
    }

    /* Recommended Book Card */
    .rec-card {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 16px;
        padding: 12px;
        display: flex;
        gap: 12px;
        transition: 0.2s;
        text-decoration: none;
        color: white;
        height: 100%;
    }

    .rec-card:hover {
        border-color: #38bdf8;
        transform: translateY(-3px);
        color: white;
    }

    .rec-cover {
        width: 70px;
        height: 105px;
        object-fit: cover;
        border-radius: 8px;
        flex-shrink: 0;
    }

    .rec-title {
        font-weight: 700;
        font-size: 0.95rem;
        margin-bottom: 4px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Review / Ulasan Styling */
    .dark-panel {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 20px;
        padding: 24px;
    }

    .rating-score-huge {
        font-size: 3rem;
        font-weight: 800;
        color: #f8fafc;
        line-height: 1;
    }

    .star-gold { color: #f59e0b; }
    .star-muted { color: #475569; }

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

    .feedback-card {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 18px;
        padding: 20px;
        margin-bottom: 16px;
    }

    .user-avatar-circle {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: linear-gradient(135deg, #38bdf8, #818cf8);
        color: #0f172a;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
        flex-shrink: 0;
    }

    /* Modal Dark & Star Rating Native */
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

    .rate-stars {
        display: inline-flex;
        flex-direction: row-reverse;
        justify-content: center;
        gap: 10px;
        margin: 10px 0;
    }

    .rate-stars input { display: none; }

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

    .rate-stars label:hover { transform: scale(1.2); }

    .btn-submit-review {
        background: #f59e0b;
        color: #0f172a;
        font-weight: 700;
        border: none;
        padding: 12px 20px;
        border-radius: 12px;
        width: 100%;
    }
</style>

<div class="wattpad-preview-wrapper">
    
    <!-- TOMBOL KEMBALI -->
    <div class="mb-4">
        <a href="{{ route('genre.index') }}" class="btn btn-outline-secondary btn-sm rounded-3">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Genre
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success bg-opacity-10 border-success text-success mb-4 rounded-3">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
        </div>
    @endif

    <!-- HEADER INFO BUKU UTAMA -->
    <div class="d-flex flex-column flex-md-row gap-4 align-items-center align-items-md-start mb-4">
        
        <!-- COVER BUKU -->
        @php
            $coverPath = $book->image_path ? str_replace(['public/', 'storage/'], '', $book->image_path) : null;
            $avgRating = round($book->reviews()->avg('rating') ?? 0, 1);
            $totalReview = $book->reviews()->count();
        @endphp

        @if($coverPath)
            <img src="{{ asset('storage/' . $coverPath) }}" 
                 class="book-cover-wattpad" 
                 alt="{{ $book->title }}"
                 onerror="this.onerror=null; this.src='{{ asset($book->image_path) }}';">
        @else
            <img src="https://via.placeholder.com/300x400?text=No+Cover" class="book-cover-wattpad" alt="No Cover">
        @endif

        <!-- DETAIL BUKU -->
        <div class="flex-grow-1 text-center text-md-start">
            <h2 class="fw-bold text-white mb-2 fs-2">{{ $book->title }}</h2>
            
            <div class="d-flex align-items-center justify-content-center justify-content-md-start gap-2 mb-3">
                <span class="author-avatar">{{ strtoupper(substr($book->author ?? 'A', 0, 2)) }}</span>
                <span class="text-secondary fw-semibold">{{ $book->author ?? 'Penulis Safae' }}</span>
            </div>

            <!-- STATISTIK -->
            <div class="d-flex align-items-center justify-content-center justify-content-md-start gap-4 mb-4 flex-wrap">
                <span class="stat-badge"><i class="fa-solid fa-eye me-1"></i> {{ number_format(rand(1000, 50000)) }} dibaca</span>
                <span class="stat-badge"><i class="fa-solid fa-star text-warning me-1"></i> {{ $avgRating > 0 ? $avgRating : '4.8' }}</span>
                <span class="stat-badge"><i class="fa-solid fa-list me-1"></i> {{ $book->jumlah_halaman ?? 1 }} bab / hal</span>
            </div>

            <!-- TOMBOL BACA UTAMA -->
            <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                <a href="{{ route('book.show', ['id' => $book->id, 'page' => 1]) }}" class="btn-read-main">
                    Mulai membaca
                </a>
            </div>
        </div>

    </div>

    <!-- TAB NAVIGASI TOGGLE -->
    <div class="wattpad-tabs d-flex">
        <button class="wattpad-tab-btn active" id="tabRingkasanBtn" onclick="switchTab('ringkasan')">Ringkasan</button>
        <button class="wattpad-tab-btn" id="tabUlasanBtn" onclick="switchTab('ulasan')">Ulasan Pembaca ({{ $totalReview }})</button>
    </div>

    <!-- KONTEN TAB 1: RINGKASAN -->
    <div id="contentRingkasan">
        <div class="d-flex align-items-center gap-2 mb-2 text-secondary small">
            <span class="badge bg-success bg-opacity-25 text-success fw-bold"><i class="fa-solid fa-check me-1"></i> Lengkap</span>
            &bull;
            <span>Terbit {{ $book->year ?? '2026' }}</span>
        </div>

        <div class="d-flex align-items-center gap-2 mb-4 text-info small">
            <i class="fa-solid fa-circle-info"></i>
            <span>{{ $book->genre }} &bull; {{ $book->jenis_buku ?? 'Novel' }}</span>
        </div>

        <!-- TAGS -->
        <div class="mb-4">
            <span class="tag-pill">{{ strtolower($book->genre) }}</span>
            <span class="tag-pill">safae</span>
            <span class="tag-pill">bacaan favorit</span>
            <span class="tag-pill">populer</span>
            <span class="tag-pill">rekomendasi</span>
        </div>

        <!-- SINOPSIS -->
        <div class="p-4 rounded-4 bg-dark bg-opacity-50 border border-secondary border-opacity-25 mb-5">
            <h6 class="fw-bold text-white mb-3">Sinopsis / Ringkasan Cerita</h6>
            <p class="text-slate-300 lh-lg mb-0" style="color: #cbd5e1; white-space: pre-line;">
                {{ $book->description ?? 'Belum ada ringkasan sinopsis untuk buku ini.' }}
            </p>
        </div>
    </div>

    <!-- KONTEN TAB 2: ULASAN PEMBACA (LANGSUNG TAMPIL DI BAWAH) -->
    <div id="contentUlasan" style="display: none;">
        <div class="row g-4 mb-5">
            <!-- RATING SUMMARY KIRI -->
            <div class="col-lg-4">
                <div class="dark-panel">
                    <h6 class="fw-bold text-white mb-3">Average Rating</h6>
                    <div class="d-flex align-items-baseline gap-3 mb-3">
                        <div class="rating-score-huge">{{ $avgRating }}</div>
                        <div>
                            <div class="fs-6">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa-solid fa-star {{ $i <= round($avgRating) ? 'star-gold' : 'star-muted' }}"></i>
                                @endfor
                            </div>
                            <small class="text-secondary">{{ $totalReview }} Ulasan</small>
                        </div>
                    </div>

                    <hr class="border-secondary border-opacity-25 my-3">

                    @auth
                        @if(!$book->reviews->contains('user_id', Auth::id()))
                            <button type="button" class="btn btn-info text-dark fw-bold w-100 rounded-3 py-2" data-bs-toggle="modal" data-bs-target="#modalTulisUlasan">
                                <i class="fa-solid fa-pen-to-square me-1"></i> Tulis Ulasan
                            </button>
                        @else
                            <div class="p-2 rounded-3 bg-dark bg-opacity-50 text-center border border-secondary border-opacity-25 small text-info">
                                <i class="fa-solid fa-circle-check me-1"></i> Ulasan terkirim
                            </div>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-info w-100 rounded-3 btn-sm">
                            Login untuk mengulas
                        </a>
                    @endauth
                </div>
            </div>

            <!-- DAFTAR FEEDBACK KANAN -->
            <div class="col-lg-8">
                @forelse($book->reviews as $review)
                    @php
                        $userName = $review->user->nama_depan 
                            ? $review->user->nama_depan . ' ' . $review->user->nama_belakang
                            : ($review->user->username ?? 'Pembaca Safae');
                        $initials = strtoupper(substr($userName, 0, 2));
                    @endphp

                    <div class="feedback-card">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="d-flex align-items-center gap-3">
                                <div class="user-avatar-circle">{{ $initials }}</div>
                                <div>
                                    <h6 class="fw-bold text-white mb-0" style="font-size: 0.95rem;">{{ $userName }}</h6>
                                    <small class="text-secondary" style="font-size: 0.75rem;">
                                        {{ $review->created_at ? $review->created_at->diffForHumans() : 'Baru saja' }}
                                    </small>
                                </div>
                            </div>
                            <div class="small">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa-solid fa-star {{ $i <= $review->rating ? 'star-gold' : 'star-muted' }}"></i>
                                @endfor
                            </div>
                        </div>
                        <p class="small mb-0" style="color: #cbd5e1;">{{ $review->komentar }}</p>
                    </div>
                @empty
                    <div class="dark-panel text-center py-4">
                        <i class="fa-regular fa-comments fa-2x text-secondary mb-2"></i>
                        <h6 class="fw-bold text-white mb-1">Belum Ada Ulasan</h6>
                        <small class="text-secondary">Jadilah orang pertama yang mengulas buku ini!</small>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- REKOMENDASI BUKU LAIN -->
    @if(isset($recommendedBooks) && $recommendedBooks->count() > 0)
        <div class="pt-3 border-top border-secondary border-opacity-25">
            <h5 class="fw-bold text-white mb-3">Anda Mungkin Juga Menyukai</h5>

            <div class="row row-cols-1 row-cols-md-2 g-3">
                @foreach($recommendedBooks as $rec)
                    @php
                        $recCover = $rec->image_path ? str_replace(['public/', 'storage/'], '', $rec->image_path) : null;
                    @endphp
                    <div class="col">
                        <a href="{{ route('book.preview', $rec->id) }}" class="rec-card">
                            @if($recCover)
                                <img src="{{ asset('storage/' . $recCover) }}" class="rec-cover" alt="{{ $rec->title }}" onerror="this.onerror=null; this.src='{{ asset($rec->image_path) }}';">
                            @else
                                <img src="https://via.placeholder.com/150" class="rec-cover" alt="No cover">
                            @endif
                            <div class="d-flex flex-column justify-content-center">
                                <div class="rec-title">{{ $rec->title }}</div>
                                <small class="text-secondary mb-2">{{ $rec->author }}</small>
                                <small class="text-info"><i class="fa-solid fa-list me-1"></i> {{ $rec->jumlah_halaman ?? 1 }} bab &bull; {{ $rec->genre }}</small>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>

<!-- MODAL TULIS ULASAN -->
@auth
<div class="modal fade modal-dark" id="modalTulisUlasan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-secondary border-opacity-25">
                <h5 class="modal-title fw-bold text-white">
                    <i class="fa-solid fa-star text-warning me-2"></i> Tulis Ulasan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('ulasan.store', $book->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-4 text-center">
                        <label class="form-label small text-secondary d-block mb-2">Pilih Rating Bintang</label>
                        <div class="rate-stars">
                            <input type="radio" id="star5" name="rating" value="5" required />
                            <label for="star5"><i class="fa-solid fa-star"></i></label>

                            <input type="radio" id="star4" name="rating" value="4" />
                            <label for="star4"><i class="fa-solid fa-star"></i></label>

                            <input type="radio" id="star3" name="rating" value="3" />
                            <label for="star3"><i class="fa-solid fa-star"></i></label>

                            <input type="radio" id="star2" name="rating" value="2" />
                            <label for="star2"><i class="fa-solid fa-star"></i></label>

                            <input type="radio" id="star1" name="rating" value="1" />
                            <label for="star1"><i class="fa-solid fa-star"></i></label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small text-secondary">Ulasan Kamu</label>
                        <textarea name="komentar" rows="4" class="form-control" placeholder="Tuliskan pendapatmu tentang buku ini..." required></textarea>
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

<script>
    function switchTab(tabName) {
        const ringkasanContent = document.getElementById('contentRingkasan');
        const ulasanContent = document.getElementById('contentUlasan');
        const ringkasanBtn = document.getElementById('tabRingkasanBtn');
        const ulasanBtn = document.getElementById('tabUlasanBtn');

        if (tabName === 'ringkasan') {
            ringkasanContent.style.display = 'block';
            ulasanContent.style.display = 'none';
            ringkasanBtn.classList.add('active');
            ulasanBtn.classList.remove('active');
        } else {
            ringkasanContent.style.display = 'none';
            ulasanContent.style.display = 'block';
            ringkasanBtn.classList.remove('active');
            ulasanBtn.classList.add('active');
        }
    }
</script>

@endsection