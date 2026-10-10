@extends('layouts.app')

@section('title', 'Buku Premium')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/favorite.css') }}">
<link rel="stylesheet" href="{{ asset('css/buku-premium.css') }}">

<div class="container-fluid">

    {{-- ================= HEADER UTAMA HALAMAN ================= --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="favorite-header mb-1 text-white" style="color: #ffffff !important;">
                <i class="fa-solid fa-crown text-warning me-2"></i> Buku Premium
            </h3>
            <p class="text-white small mb-0" style="opacity: 0.85; font-size: 0.9rem; color: #ffffff !important;">Tukarkan poin reward membaca kamu untuk membuka akses konten-konten premium eksklusif.</p>
        </div>

        {{-- Badge Informasi Poin User --}}
        <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-3 shadow-sm" 
             style="background: rgba(6, 182, 212, 0.05); border: 1px solid rgba(6, 182, 212, 0.15); color: #38bdf8;">
            <i class="fa-solid fa-coins opacity-80"></i>
            <span class="text-white-50" style="font-size: 0.85rem; color: rgba(255,255,255,0.5) !important;">Poin Kamu:</span>
            <strong class="font-monospace text-white" style="font-size: 1.05rem; color: #ffffff !important;">{{ number_format(auth()->user()->points ?? 0) }}</strong>
        </div>
    </div>

    {{-- ================= NOTIFIKASI ALERT SISTEM ================= --}}
    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center gap-2 mb-4 py-3 rounded-3 shadow-sm" style="background: rgba(16, 185, 129, 0.08); border: 1px solid rgba(16, 185, 129, 0.15); color: #a7f3d0;">
            <i class="fa-solid fa-circle-check text-success fs-5"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger d-flex align-items-center gap-2 mb-4 py-3 rounded-3 shadow-sm" style="background: rgba(239, 68, 68, 0.08); border: 1px solid rgba(239, 68, 68, 0.15); color: #fca5a5;">
            <i class="fa-solid fa-triangle-exclamation text-danger fs-5"></i>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    {{-- ================= KONDISI 1: JIKA DATA KOSONG ================= --}}
    @if($books->count() == 0)
        <div class="col-12">
            <div class="empty-state shadow-sm text-center py-5">
                <i class="fa-solid fa-crown fa-4x text-muted mb-3 opacity-30"></i>
                <h4 class="text-white fw-bold mb-2">Belum Ada Buku Premium</h4>
                <p class="text-white-50 mb-4">Daftar buku premium belum tersedia atau masih dalam proses peninjauan sistem admin.</p>
                <a href="{{ route('genre.index') }}" class="btn btn-secondary rounded-pill px-4 py-2 fw-bold" style="background: rgba(255,255,255,0.03); border: 1px solid var(--border); color: #fff;">
                    <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Eksplorasi
                </a>
            </div>
        </div>

    {{-- ================= KONDISI 2: TAMPILAN GRID LIST BUKU ================= --}}
    @else
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-4">
            @foreach($books as $book)
                @php
                    $sudahDitukar = \App\Models\PenukaranPoint::where('user_id', auth()->id())
                                      ->where('book_id', $book->id)
                                      ->exists();

                    // Menggabungkan variabel cover dari kodemu
                    $cover = $book->image_path ?? $book->cover_image;

                    // Logika dinamis pemecah path agar gambar dari seeder / upload admin tidak duplikat storage/
                    $finalPath = '';
                    if ($cover) {
                        if (str_contains($cover, 'storage/')) {
                            // Jika sudah ada kata storage/ di database, langsung di-load murni
                            $finalPath = asset(ltrim($cover, '/'));
                        } else {
                            // Jika murni nama folder seeder seperti images/kkn.jpeg
                            $finalPath = asset('storage/' . ltrim($cover, '/'));
                        }
                    }
                @endphp
                
                <div class="col">
                    <div class="book-card shadow-sm d-flex flex-column h-100 position-relative" style="background: #1e293b; border: 1px solid rgba(255,255,255,0.05); border-radius: 12px; overflow: hidden;">
                        
                        {{-- Lapisan Lencana Status Buku Premium / Kepemilikan --}}
                        <span class="badge position-absolute top-0 start-0 m-2 px-2 py-1 rounded-2 shadow-sm d-flex align-items-center gap-1" 
                              style="z-index: 5; font-size: 0.68rem; font-weight: 700; background: linear-gradient(135deg, #f59e0b, #d97706); color: #0f172a;">
                            <i class="fa-solid fa-crown"></i> Premium
                        </span>

                        @if($sudahDitukar)
                            <span class="badge bg-success position-absolute top-0 end-0 m-2 px-2 py-1 rounded-2 shadow-sm d-flex align-items-center gap-1" 
                                  style="z-index: 5; font-size: 0.68rem; font-weight: 700;">
                                <i class="fa-solid fa-circle-check"></i> Dimiliki
                            </span>
                        @endif

                        {{-- AREA COVER: Menggabungkan kode styling tinggi kontainer milikmu secara simetris --}}
                        <div class="d-flex align-items-center justify-content-center" style="height: 240px; overflow: hidden; background: rgba(255, 255, 255, 0.02); border-bottom: 1px solid rgba(255,255,255,0.05); width: 100%;">
                            @if($cover)
                                <img src="{{ $finalPath }}" style="width:100%; height:100%; object-fit:cover;" alt="{{ $book->title }}">
                            @else
                                <div class="text-center" style="opacity: 0.5;">
                                    <i class="fa-solid fa-book-bookmark text-white mb-2" style="font-size: 3.5rem; color: #ffffff !important;"></i>
                                    <div class="font-monospace text-uppercase tracking-wider text-muted" style="font-size: 0.65rem; letter-spacing: 1px; color: rgba(255,255,255,0.4) !important;">Safae Content</div>
                                </div>
                            @endif
                        </div>
                        
                        {{-- Detail Informasi Konten Buku --}}
                        <div class="card-body p-3 text-center d-flex flex-column flex-grow-1 justify-content-between">
                            <div>
                                <h6 class="book-title text-white fw-bold mb-1 text-truncate" title="{{ $book->title }}" style="color: #ffffff !important; font-size: 1rem;">
                                    {{ $book->title }}
                                </h6>
                                <p class="mb-2 text-truncate text-white small" style="opacity: 0.85; color: #ffffff !important;">
                                    <i class="fa-solid fa-feather-alt opacity-70 me-1"></i> {{ $book->author }}
                                </p>
                                <p class="text-start mb-3 style-desc text-white" style="font-size: 0.78rem; line-height: 1.4; opacity: 0.7; color: rgba(255,255,255,0.7) !important;">
                                    {{ \Illuminate\Support\Str::limit($book->description, 65) }}
                                </p>
                            </div>

                            {{-- Row Label Tag Harga Poin Reward --}}
                            <div class="d-flex align-items-center justify-content-center gap-1 text-warning font-monospace fw-bold mb-1" style="font-size: 0.95rem; color: #fbbf24 !important;">
                                <i class="fa-solid fa-star" style="font-size: 0.75rem;"></i>
                                <span>{{ number_format($book->premium_point ?? 100) }} Poin</span>
                            </div>
                        </div>

                        {{-- Bagian Footer / Tombol Logika Transaksi atau Baca --}}
                        <div class="card-footer p-2 text-center bg-transparent border-0 mt-auto">
                            @if($sudahDitukar)
                                <a href="{{ route('book.show', $book->id) }}" class="btn btn-sm w-100 fw-bold d-flex align-items-center justify-content-center gap-2" 
                                   style="background: #38bdf8; color: #0f172a; border: none; padding: 7px 0; border-radius: 6px;">
                                    <i class="fa-solid fa-book-open"></i> Baca Buku
                                </a>
                            @else
                                <form action="{{ route('premium.tukar', $book->id) }}" method="POST" class="m-0" onsubmit="return confirm('Apakah kamu yakin ingin menukarkan poin untuk membaca buku premium ini?')">
                                    @csrf
                                    <button type="submit" class="btn btn-sm w-100 fw-bold d-flex align-items-center justify-content-center gap-2" 
                                            style="background: rgba(245, 158, 11, 0.12); border: 1px solid rgba(245, 158, 11, 0.2); color: #f59e0b; padding: 7px 0; border-radius: 6px; cursor: pointer;">
                                        <i class="fa-solid fa-cart-shopping"></i> Tukarkan Poin
                                    </button>
                                </form>
                            @endif
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection