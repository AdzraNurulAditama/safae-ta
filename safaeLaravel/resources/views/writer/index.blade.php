@extends('layouts.app')

@section('title', 'Studio Karya Saya - Safae')

@section('content')
<style>
    .writer-container {
        max-width: 1100px;
        margin: 0 auto;
    }
    .glass-card {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,.2);
    }
    .book-item-card {
        background: #0f172a;
        border: 1px solid #334155;
        border-radius: 16px;
        transition: all 0.3s ease;
    }
    .book-item-card:hover {
        border-color: #38bdf8;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(56, 189, 248, 0.1);
    }
    .cover-thumbnail {
        width: 90px;
        height: 130px;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid #334155;
        transition: opacity 0.2s;
    }
    .cover-thumbnail:hover {
        opacity: 0.85;
    }
    .book-title-link {
        color: #ffffff;
        text-decoration: none;
        transition: color 0.2s;
    }
    .book-title-link:hover {
        color: #38bdf8;
    }
    .badge-pub { background: rgba(34, 197, 94, 0.15); color: #4ade80; border: 1px solid rgba(34, 197, 94, 0.3); }
    .badge-draft { background: rgba(234, 179, 8, 0.15); color: #facc15; border: 1px solid rgba(234, 179, 8, 0.3); }
    .btn-primary-custom {
        background: #38bdf8;
        color: #0f172a;
        font-weight: 700;
        border-radius: 10px;
        padding: 8px 16px;
        transition: 0.2s;
        text-decoration: none;
    }
    .btn-primary-custom:hover { background: #7dd3fc; color: #0f172a; }
</style>

<div class="container-fluid writer-container my-4">
    <!-- Header Studio -->
    <div class="glass-card p-4 mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h3 class="fw-extrabold text-white mb-1">
                <i class="fa-solid fa-feather-pointed text-primary me-2"></i> Studio Penulis Novel
            </h3>
            <p class="text-muted mb-0">Kelola buku, draf cerita, dan tambah chapter baru secara berkala.</p>
        </div>
        <a href="{{ url('/penulis/buku/create') }}" class="btn-primary-custom d-flex align-items-center gap-2">
            <i class="fa-solid fa-plus"></i> Buat Buku Baru
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success border-0 rounded-4 mb-4" style="background:rgba(34,197,94,.1); color:#4ade80;">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
        </div>
    @endif

    <!-- List Buku -->
    <div class="row g-4">
        @forelse($books ?? [] as $book)
            <div class="col-12 col-md-6">
                <div class="book-item-card p-3 d-flex gap-3 align-items-center">
                    <!-- Cover Buku dibungkus link mengarah ke Halaman Baca Penulis -->
                    <a href="{{ url('/penulis/buku/'.$book->id.'/baca') }}" title="Baca Pratinjau Penulis">
                        <img src="{{ $book->image_path ? asset('storage/'.$book->image_path) : 'https://via.placeholder.com/90x130?text=No+Cover' }}" class="cover-thumbnail" alt="Cover Buku">
                    </a>
                    
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="badge {{ $book->status == 'published' ? 'badge-pub' : 'badge-draft' }} px-2 py-1 rounded-pill small">
                                {{ ucfirst($book->status ?? 'Draft') }}
                            </span>
                            <span class="text-muted small"><i class="fa-solid fa-layer-group me-1"></i>{{ $book->genre }}</span>
                        </div>
                        
                        <!-- Judul Buku dibungkus link mengarah ke Halaman Baca Penulis -->
                        <h5 class="mb-1">
                            <a href="{{ url('/penulis/buku/'.$book->id.'/baca') }}" class="book-title-link fw-bold" title="Baca Pratinjau Penulis">
                                {{ $book->title }}
                            </a>
                        </h5>
                        <p class="text-muted small mb-2 text-truncate" style="max-width: 250px;">{{ $book->description }}</p>

                        <div class="d-flex align-items-center gap-3 text-muted small mb-3">
                            <span><i class="fa-solid fa-book-open me-1 text-primary"></i> {{ $book->chapters_count ?? 0 }} Bab</span>
                        </div>

                        <div class="d-flex gap-2 align-items-center">
                            <a href="{{ url('/penulis/buku/'.$book->id.'/chapters') }}" class="btn btn-sm btn-primary-custom">
                                <i class="fa-solid fa-list-check me-1"></i> Kelola Bab
                            </a>
                            <a href="{{ url('/penulis/buku/'.$book->id.'/edit') }}" class="btn btn-sm btn-outline-secondary text-light px-3" style="border-radius: 10px;" title="Edit Detail Buku">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            
                            <!-- Tombol Hapus Buku -->
                            <form action="{{ url('/penulis/buku/'.$book->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini beserta seluruh bab di dalamnya?');" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger px-3" style="border-radius: 10px;" title="Hapus Buku">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="glass-card p-5 text-center text-muted">
                    <i class="fa-solid fa-book-tanakh fa-3x mb-3 text-secondary"></i>
                    <h5 class="text-white">Belum Ada Buku Terdaftar</h5>
                    <p class="mb-3">Silakan buat buku pertama Anda untuk mulai menulis novel per chapter.</p>
                    <a href="{{ url('/penulis/buku/create') }}" class="btn-primary-custom">Mulai Menulis Sekarang</a>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection