@extends('layouts.app')

@section('title', 'Kelola Bab - ' . $book->title)

@section('content')
<style>
    .chapter-container { max-width: 1000px; margin: 0 auto; }
    .glass-card { background: #1e293b; border: 1px solid #334155; border-radius: 20px; }
    .chapter-item { background: #0f172a; border: 1px solid #334155; border-radius: 14px; transition: 0.2s; }
    .chapter-item:hover { border-color: #38bdf8; }
    .btn-custom-primary { background: #38bdf8; color: #0f172a; font-weight: 700; border-radius: 10px; }
    .btn-custom-primary:hover { background: #7dd3fc; color: #0f172a; }
</style>

<div class="container-fluid chapter-container my-4">
    <!-- Header Informasi Buku -->
    <div class="glass-card p-4 mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div class="d-flex align-items-center gap-3">
            <img src="{{ $book->image_path ? asset('storage/'.$book->image_path) : 'https://via.placeholder.com/70x100?text=No+Cover' }}" style="width: 70px; height: 100px; object-fit: cover; border-radius: 8px;" alt="Cover">
            <div>
                <span class="badge bg-primary bg-opacity-10 text-primary mb-1">{{ $book->genre }}</span>
                <h3 class="text-white fw-bold mb-1">{{ $book->title }}</h3>
                <p class="text-muted small mb-0">Penulis: {{ $book->author }}</p>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('writer.books.index') }}" class="btn btn-outline-secondary text-light px-3" style="border-radius: 10px;">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali
            </a>
            <a href="{{ url('/penulis/buku/'.$book->id.'/chapter/tambah') }}" class="btn btn-custom-primary px-3">
                <i class="fa-solid fa-plus me-1"></i> Tulis Bab Baru
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success border-0 rounded-3 mb-4" style="background:rgba(34,197,94,.1); color:#4ade80;">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Daftar Chapter / Bab -->
    <div class="d-flex flex-column gap-3">
        @forelse($chapters as $chapter)
            <div class="chapter-item p-3 d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-primary bg-opacity-10 text-primary fw-bold px-3 py-2 rounded-3 text-center" style="min-width: 65px;">
                        Bab {{ $chapter->chapter_number }}
                    </div>
                    <div>
                        <h5 class="text-white fw-bold mb-1">{{ $chapter->title }}</h5>
                        <div class="d-flex align-items-center gap-3 text-muted small">
                            <span><i class="fa-regular fa-clock me-1"></i> {{ $chapter->updated_at->diffForHumans() }}</span>
                            <span class="badge {{ $chapter->status == 'published' ? 'bg-success text-white' : 'bg-warning text-dark' }}">
                                {{ ucfirst($chapter->status) }}
                            </span>
                            @if($chapter->image)
                                <span class="text-info"><i class="fa-regular fa-image me-1"></i> Ada Ilustrasi</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ url('/penulis/buku/'.$book->id.'/chapter/'.$chapter->id.'/edit') }}" class="btn btn-sm btn-outline-light px-3" style="border-radius: 8px;">
                        <i class="fa-solid fa-pen-to-square me-1"></i> Edit Bab
                    </a>
                </div>
            </div>
        @empty
            <div class="glass-card p-5 text-center text-muted">
                <i class="fa-solid fa-book-open-reader fa-3x mb-3 text-secondary"></i>
                <h5 class="text-white">Belum Ada Bab Cerita</h5>
                <p class="mb-3">Mulai tulis bab pertama novel Anda sekarang.</p>
                <a href="{{ url('/penulis/buku/'.$book->id.'/chapter/tambah') }}" class="btn btn-custom-primary">Buat Bab 1</a>
            </div>
        @endforelse
    </div>
</div>
@endsection