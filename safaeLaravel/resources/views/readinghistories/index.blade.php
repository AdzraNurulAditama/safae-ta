@extends('layouts.app')

@section('title', 'Riwayat Baca - Safae')

@section('content')

<style>
    /* Styling khusus Riwayat Baca */
    .history-header {
        color: #f1f5f9;
        font-weight: 800;
        margin-bottom: 30px;
    }

    .history-card {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 20px;
        transition: 0.3s;
        display: flex;
        flex-direction: column;
        height: 100%;
        overflow: hidden;
    }

    .history-card:hover {
        transform: translateY(-5px);
        border-color: #38bdf8;
        box-shadow: 0 10px 20px rgba(56, 189, 248, 0.1);
    }

    .card-img-wrapper {
        height: 220px;
        position: relative;
        overflow: hidden;
        background: #0f172a;
    }

    .card-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
        opacity: 0.9;
    }

    .history-card:hover .card-img-wrapper img {
        transform: scale(1.05);
        opacity: 1;
    }

    .card-body {
        padding: 20px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .book-title {
        color: #f1f5f9;
        font-weight: 700;
        font-size: 1.15rem;
        margin-bottom: 8px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .info-text {
        color: #94a3b8;
        font-size: 0.85rem;
        margin-bottom: 5px;
    }

    .info-text i { width: 16px; text-align: center; margin-right: 5px; color: #64748b; }

    /* Badge Progress */
    .progress-badge {
        background: rgba(56, 189, 248, 0.1);
        color: #38bdf8;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        display: inline-block;
        margin-top: 10px;
        margin-bottom: 15px;
    }

    .card-footer {
        background: transparent !important;
        border-top: 1px solid #334155;
        padding: 15px 20px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    
    /* Tombol Aksi */
    .btn-continue {
        background: #38bdf8;
        color: #0f172a;
        border-radius: 12px;
        font-weight: 600;
        transition: 0.3s;
        border: none;
        padding: 10px;
    }
    .btn-continue:hover { background: #7dd3fc; }

    .btn-remove {
        border-radius: 12px;
        font-weight: 600;
        transition: 0.3s;
        color: #f87171;
        border: 1px solid #f87171;
        background: transparent;
        padding: 8px;
    }
    .btn-remove:hover { background: #ef4444; color: #fff; }

    /* Tampilan Kosong */
    .empty-state {
        background: #1e293b;
        border: 2px dashed #334155;
        border-radius: 20px;
        padding: 60px 20px;
        text-align: center;
    }

    /* Custom Alert */
    .alert-custom {
        background: rgba(34, 197, 94, 0.1);
        border: 1px solid rgba(34, 197, 94, 0.3);
        color: #4ade80;
        border-radius: 12px;
    }
</style>

<div class="container-fluid">

    <div class="d-flex align-items-center mb-4">
        <h3 class="history-header mb-0">
            <i class="fa-solid fa-clock-rotate-left text-info me-2"></i> Riwayat Baca
        </h3>
    </div>

    @if(session('success'))
        <div class="alert alert-custom d-flex align-items-center shadow-sm mb-4">
            <i class="fa-solid fa-circle-check fa-lg me-3"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close btn-close-white ms-auto opacity-50" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($histories->count() == 0)
        <div class="empty-state shadow-sm">
            <i class="fa-solid fa-book-open-reader fa-4x text-muted mb-3"></i>
            <h4 class="text-white fw-bold mb-2">Belum ada riwayat baca</h4>
            <p class="text-muted mb-4">Kamu belum membaca buku apapun. Yuk, mulai baca buku sekarang!</p>
            <a href="{{ route('genre.index') }}" class="btn btn-continue px-4">
                <i class="fa-solid fa-book me-2"></i> Cari Buku
            </a>
        </div>
    @else
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-4">
            @foreach($histories as $history)
                <div class="col">
                    <div class="history-card shadow-sm">

                        <div class="card-img-wrapper">
                            @if ($history->book && $history->book->image_path)
                                <img src="{{ asset($history->book->image_path) }}" alt="{{ $history->book->title }}">
                            @else
                                <div class="d-flex flex-column align-items-center justify-content-center h-100 text-muted">
                                    <i class="fa-solid fa-image fa-3x mb-2"></i>
                                    <small>No Cover</small>
                                </div>
                            @endif
                        </div>

                        <div class="card-body">
                            <h5 class="book-title" title="{{ $history->book->title ?? 'Buku tidak ditemukan' }}">
                                {{ $history->book->title ?? 'Buku tidak ditemukan' }}
                            </h5>

                            <div class="info-text">
                                <i class="fa-solid fa-user"></i> {{ $history->book->author ?? '-' }}
                            </div>
                            <div class="info-text">
                                <i class="fa-solid fa-tag"></i> {{ $history->book->genre ?? '-' }}
                            </div>

                            <div>
                                <span class="progress-badge">
                                    <i class="fa-solid fa-bookmark me-1"></i> Halaman {{ $history->progress }}
                                </span>
                            </div>

                            <div class="mt-auto pt-2">
                                <div class="info-text mb-0" style="font-size: 0.75rem;">
                                    <i class="fa-regular fa-clock"></i> Terakhir dibaca: <br>
                                    <span class="ms-4 text-white opacity-75">{{ $history->last_read_at ?? '-' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            @if($history->book)
                                <a href="{{ route('book.show', ['id' => $history->book->id, 'page' => $history->progress]) }}" class="btn btn-continue w-100 text-decoration-none">
                                    <i class="fa-solid fa-play me-1"></i> Lanjutkan
                                </a>
                            @endif

                            <form action="{{ route('reading.history.delete', $history->id) }}" method="POST" onsubmit="return confirm('Apakah kamu yakin ingin menghapus riwayat baca buku ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-remove w-100">
                                    <i class="fa-solid fa-trash-can me-1"></i> Hapus Riwayat
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>

@endsection