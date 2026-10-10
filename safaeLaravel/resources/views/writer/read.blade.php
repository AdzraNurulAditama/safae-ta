@extends('layouts.app')

@section('title', 'Pratinjau Buku - ' . $book->title)

@section('content')
<style>
    .writer-reader-container { max-width: 900px; margin: 0 auto; }
    .glass-card { background: #1e293b; border: 1px solid #334155; border-radius: 20px; }
    .chapter-reader-box { background: #0f172a; border: 1px solid #334155; border-radius: 16px; color: #e2e8f0; line-height: 1.8; font-size: 1.1rem; }
    .btn-custom-primary { background: #38bdf8; color: #0f172a; font-weight: 700; border-radius: 10px; }
    .btn-custom-primary:hover { background: #7dd3fc; color: #0f172a; }
</style>

<div class="container-fluid writer-reader-container my-4">
    <!-- Header Navigasi Penulis -->
    <div class="glass-card p-4 mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div class="d-flex align-items-center gap-3">
            <img src="{{ $book->image_path ? asset('storage/'.$book->image_path) : 'https://via.placeholder.com/60x85?text=No+Cover' }}" style="width: 60px; height: 85px; object-fit: cover; border-radius: 8px;" alt="Cover">
            <div>
                <span class="badge bg-info bg-opacity-10 text-info mb-1">Mode Pratinjau Penulis</span>
                <h4 class="text-white fw-bold mb-0">{{ $book->title }}</h4>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ url('/penulis/buku') }}" class="btn btn-outline-secondary text-light px-3" style="border-radius: 10px;">
                <i class="fa-solid fa-arrow-left me-1"></i> Studio Utama
            </a>
            <a href="{{ url('/penulis/buku/'.$book->id.'/chapters') }}" class="btn btn-custom-primary px-3">
                <i class="fa-solid fa-list-check me-1"></i> Kelola Bab
            </a>
        </div>
    </div>

    <!-- Konten Daftar Bab / Baca -->
    <div class="d-flex flex-column gap-4">
        @forelse($chapters as $index => $chapter)
            <div class="chapter-reader-box p-4 p-md-5">
                <div class="d-flex justify-content-between align-items-center border-bottom border-secondary border-opacity-25 pb-3 mb-4">
                    <div>
                        <span class="text-primary fw-bold small text-uppercase">Bab {{ $chapter->chapter_number }}</span>
                        <h3 class="text-white fw-bold mb-0">{{ $chapter->title }}</h3>
                    </div>
                    <a href="{{ url('/penulis/buku/'.$book->id.'/chapter/'.$chapter->id.'/edit') }}" class="btn btn-sm btn-outline-light px-3" style="border-radius: 8px;">
                        <i class="fa-solid fa-pen-to-square me-1"></i> Edit Bab Ini
                    </a>
                </div>

                @if($chapter->image)
                    <div class="text-center mb-4">
                        <img src="{{ asset('storage/'.$chapter->image) }}" class="img-fluid rounded-4 shadow" style="max-height: 350px; object-fit: cover;" alt="Ilustrasi Bab">
                    </div>
                @endif

                <div class="chapter-content">
                    {!! nl2br(e($chapter->content)) !!}
                </div>
            </div>
        @empty
            <div class="glass-card p-5 text-center text-muted">
                <i class="fa-solid fa-book-open-reader fa-3x mb-3 text-secondary"></i>
                <h5 class="text-white">Belum Ada Bab yang Ditulis</h5>
                <p class="mb-3">Novel ini belum memiliki konten bab cerita.</p>
                <a href="{{ url('/penulis/buku/'.$book->id.'/chapter/tambah') }}" class="btn btn-custom-primary">Tulis Bab Pertama</a>
            </div>
        @endforelse
    </div>
</div>
@endsection