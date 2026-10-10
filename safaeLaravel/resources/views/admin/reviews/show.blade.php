@extends('layouts.layoutsAdmin')

@section('title', 'Detail Ulasan - ' . ($review->book->title ?? 'Buku'))

@push('styles')
    <style>
        /* ================= PREMIUM OBSIDIAN REVIEW DETAIL ================= */
        .page-wrapper {
            background: transparent;
            color: var(--text);
            padding: 10px 0;
        }

        /* Container Card Utama */
        .detail-panel-premium {
            background: var(--sidebar-bg);
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            position: relative;
            padding: 40px;
        }

        /* Garis Aksen Top Bar Console */
        .detail-panel-premium::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, #f59e0b, var(--accent), transparent);
        }

        /* Grid Data List Metadata */
        .meta-spec-group {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin-top: 20px;
            margin-bottom: 25px;
        }

        .spec-item {
            display: flex;
            align-items: flex-start;
            font-size: 0.95rem;
        }

        .spec-label {
            width: 140px;
            color: var(--muted);
            font-weight: 600;
            flex-shrink: 0;
        }

        .spec-value {
            color: #e2e8f0;
        }

        /* Boks Wadah Isi Ulasan Text */
        .review-text-bubble {
            background: rgba(11, 15, 25, 0.4);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 20px;
            color: #cbd5e1;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        /* Komponen Rating */
        .rating-star-active {
            color: #f59e0b;
            font-size: 0.95rem;
        }

        /* Tombol Aksi */
        .btn-back-console {
            font-size: 0.85rem;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.25s ease;
        }
        .btn-back-console:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #fff !important;
        }

        .btn-purge-console {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.25);
            color: #fca5a5;
            font-size: 0.85rem;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.25s ease;
        }
        .btn-purge-console:hover {
            background: #ef4444;
            color: #fff;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
        }

        /* Penyesuaian Responsif */
        @media (max-width: 768px) {
            .detail-panel-premium { padding: 30px; }
            .spec-item { flex-direction: column; gap: 4px; }
            .spec-label { width: 100%; }
        }
    </style>
@endpush

@section('content')
<div class="container-fluid px-0 page-wrapper" style="max-width: 1000px;">
    
    {{-- ================= HEADER NAVIGASI ATAS ================= --}}
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0" style="font-size: 0.8rem;">
                <li class="breadcrumb-item"><a href="{{ url('/admin') }}" style="color: var(--muted); text-decoration: none;">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.reviews.index') }}" style="color: var(--muted); text-decoration: none;">Ulasan</a></li>
                <li class="breadcrumb-item active text-truncate" style="color: var(--primary);" aria-current="page">Detail</li>
            </ol>
        </nav>
    </div>

    {{-- ================= PANEL UTAMA DETAIL DATA ================= --}}
    <div class="detail-panel-premium shadow-sm">
        
        <span class="text-warning font-monospace small fw-bold uppercase tracking-wider" style="font-size: 0.75rem;">
            Review Data Record
        </span>
        
        <h3 class="fw-bold text-white mt-1 mb-4" style="font-size: 1.6rem; letter-spacing: -0.5px;">
            Ulasan oleh: {{ $review->user->nama_depan ?? $review->user->name ?? $review->user->username ?? 'User' }}
        </h3>

        {{-- Detail Grid Informasi Spec --}}
        <div class="meta-spec-group border-top pt-3" style="border-color: rgba(255,255,255,0.05) !important;">
            
            <div class="spec-item">
                <div class="spec-label"><i class="fas fa-book me-2 text-warning opacity-70"></i>Buku</div>
                <div class="spec-value fw-semibold text-white">{{ $review->book->title ?? 'Tidak ada' }}</div>
            </div>

            <div class="spec-item">
                <div class="spec-label"><i class="fas fa-star me-2 text-warning opacity-70"></i>Rating</div>
                <div class="spec-value font-monospace">
                    <i class="fas fa-star rating-star-active me-1"></i>
                    <span class="text-white fw-bold">{{ $review->rating }}</span> <span class="text-muted">/ 5</span>
                </div>
            </div>

            <div class="spec-item">
                <div class="spec-label"><i class="far fa-calendar-alt me-2 text-warning opacity-70"></i>Tanggal</div>
                <div class="spec-value font-monospace text-muted" style="font-size: 0.9rem;">
                    {{ $review->created_at->format('d M Y • H:i') }}
                </div>
            </div>

        </div>

        {{-- Komponen Kotak Ulasan Konten --}}
        <div class="form-label-custom text-uppercase small fw-bold mb-2 tracking-wider" style="color: var(--muted); font-size: 0.75rem;">
            Isi Ulasan Pengguna
        </div>
        <div class="review-text-bubble shadow-inner">
            {{ $review->komentar }}
        </div>

        {{-- Kelompok Aksi Tombol Kontrol Bawah --}}
        <div class="d-flex align-items-center justify-content-between pt-3 border-top" style="border-color: rgba(255,255,255,0.04) !important;">
            
            <a href="{{ route('admin.reviews.index') }}" class="btn btn-sm btn-outline-secondary text-white border-secondary btn-back-console text-decoration-none">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>

            <form action="{{ route('admin.reviews.destroy', $review->id) }}" 
                  method="POST" 
                  class="m-0"
                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus ulasan ini secara permanen?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-purge-console">
                    <i class="fas fa-trash-alt me-2"></i> Hapus Ulasan
                </button>
            </form>

        </div>

    </div>
</div>
@endsection