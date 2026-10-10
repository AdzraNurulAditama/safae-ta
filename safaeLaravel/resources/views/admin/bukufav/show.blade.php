@extends('layouts.layoutsAdmin') 

@section('title', 'Detail Buku Favorit - ' . $favorite->book->title)

@push('styles')
    <style>
        /* ================= PREMIUM OBSIDIAN BOOK DETAIL ================= */
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
        }

        /* Garis Aksen Top Bar Console */
        .detail-panel-premium::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--accent), transparent);
        }

        /* Frame Gambar Cover Buku */
        .cover-display-frame {
            background: rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
            border-right: 1px solid var(--border);
            height: 100%;
            min-height: 380px;
        }

        .cover-display-image {
            max-width: 100%;
            max-height: 320px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* Placeholder jika cover kosong */
        .cover-fallback-box {
            width: 200px;
            height: 280px;
            background: rgba(255, 255, 255, 0.02);
            border: 1px dashed var(--border);
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 12px;
            color: var(--muted);
        }

        /* Panel Informasi Samping */
        .info-display-pane {
            padding: 40px;
        }

        /* Grid Data List */
        .meta-spec-group {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin-top: 25px;
            margin-bottom: 30px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
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

        /* Tombol Kembali */
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

        /* Penyesuaian Responsif */
        @media (max-width: 768px) {
            .cover-display-frame { border-right: none; border-bottom: 1px solid var(--border); min-height: auto; }
            .info-display-pane { padding: 30px; }
            .spec-item { flex-direction: column; gap: 4px; }
            .spec-label { width: 100%; }
        }
    </style>
@endpush

@section('content')
<div class="container-fluid px-0 page-wrapper" style="max-width: 1100px;">
    
    {{-- ================= HEADER NAVIGASI ATAS ================= --}}
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0" style="font-size: 0.8rem;">
                <li class="breadcrumb-item"><a href="{{ url('/admin') }}" style="color: var(--muted); text-decoration: none;">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.favorit.index') }}" style="color: var(--muted); text-decoration: none;">Buku Favorit</a></li>
                <li class="breadcrumb-item active text-truncate" style="max-width: 250px; color: var(--primary);" aria-current="page">Detail</li>
            </ol>
        </nav>
    </div>

    {{-- ================= PANEL UTAMA DETAIL DATA ================= --}}
    <div class="detail-panel-premium">
        <div class="row g-0">
            
            {{-- SEKTOR KIRI: TAMPILAN IMAGE COVER --}}
            <div class="col-md-4">
                <div class="cover-display-frame">
                    @if($favorite->book->image_path)
                        <img src="{{ asset($favorite->book->image_path) }}" class="cover-display-image" alt="Cover">
                    @else
                        <div class="cover-fallback-box">
                            <i class="fas fa-book-open fa-3x opacity-30"></i>
                            <span class="small opacity-60">Tidak ada gambar</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- SEKTOR KANAN: SPESIFIKASI DATA --}}
            <div class="col-md-8">
                <div class="info-display-pane">
                    
                    <h2 class="fw-bold text-white mb-2" style="font-size: 1.8rem; letter-spacing: -0.5px;">
                        {{ $favorite->book->title }}
                    </h2>
                    
                    {{-- Detail Informasi --}}
                    <div class="meta-spec-group">
                        
                        <div class="spec-item">
                            <div class="spec-label"><i class="fas fa-feather-alt me-2 text-info opacity-70"></i>Penulis</div>
                            <div class="spec-value fw-semibold text-white">{{ $favorite->book->author }}</div>
                        </div>

                        <div class="spec-item">
                            <div class="spec-label"><i class="fas fa-user me-2 text-info opacity-70"></i>User</div>
                            <div class="spec-value">{{ $favorite->user->username }}</div>
                        </div>

                        <div class="spec-item">
                            <div class="spec-label"><i class="fas fa-envelope me-2 text-info opacity-70"></i>Email</div>
                            <div class="spec-value">{{ $favorite->user->email }}</div>
                        </div>

                        <div class="spec-item">
                            <div class="spec-label"><i class="far fa-calendar-alt me-2 text-info opacity-70"></i>Ditambahkan</div>
                            <div class="spec-value" style="font-size: 0.95rem;">
                                {{ $favorite->created_at->format('d M Y') }}
                            </div>
                        </div>

                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="pt-2">
                        <a href="{{ route('admin.favorit.index') }}" class="btn btn-sm btn-outline-secondary text-white border-secondary btn-back-console text-decoration-none">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection