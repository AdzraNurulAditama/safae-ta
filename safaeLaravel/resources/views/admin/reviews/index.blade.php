@extends('layouts.layoutsAdmin')

@section('title', 'Kelola Ulasan')

@push('styles')
    <style>
        /* ================= PREMIUM SaaS OBSIDIAN DESIGN ================= */
        .page-wrapper {
            background: transparent;
            color: var(--text);
            padding: 10px 0;
        }

        /* Navigasi Label Header Kolom */
        .list-header-labels {
            display: flex;
            padding: 0 24px 12px;
            color: var(--muted);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
            border-bottom: 1px solid var(--border);
            margin-bottom: 16px;
        }

        /* Container Utama */
        .review-list-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* Row Card Review */
        .review-row-card {
            display: flex;
            align-items: center;
            background: var(--sidebar-bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 16px 24px;
            transition: all 0.2s ease-in-out;
        }
        .review-row-card:hover {
            border-color: rgba(6, 182, 212, 0.3);
            background: rgba(17, 24, 39, 0.6);
            transform: translateY(-1px);
        }

        /* Pembagian Lebar Kolom Flexbox yang Simetris */
        .col-rev-user { flex: 1.2; display: flex; align-items: center; gap: 12px; min-width: 0; }
        .col-rev-book { flex: 1.8; min-width: 0; padding-right: 15px; }
        .col-rev-rating { flex: 1; display: flex; align-items: center; gap: 5px; }
        .col-rev-date { flex: 1; color: var(--muted); font-size: 0.85rem; }
        .col-rev-actions { flex: 1.2; display: flex; justify-content: flex-end; align-items: center; gap: 8px; }

        /* Sizing Akurat untuk Foto Profil User (Mencegah Kebesaran) */
        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid var(--border);
            flex-shrink: 0;
        }

        /* Komponen Rating Bintang */
        .rating-star-active {
            color: #f59e0b;
            font-size: 0.9rem;
        }

        /* Tombol Kontrol */
        .btn-action-view {
            background: rgba(6, 182, 212, 0.08);
            border: 1px solid rgba(6, 182, 212, 0.2);
            color: var(--primary) !important;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 0.85rem;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-action-view:hover {
            background: var(--primary);
            color: #0b0f19 !important;
            box-shadow: 0 0 10px rgba(6, 182, 212, 0.2);
        }

        .btn-action-purge {
            background: transparent;
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #fca5a5 !important;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 0.85rem;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
        }
        .btn-action-purge:hover {
            background: rgba(239, 68, 68, 0.1);
            border-color: #ef4444;
            color: #ef4444 !important;
        }

        /* Alert Notifikasi Sukses */
        .alert-console-success {
            background: rgba(16, 185, 129, 0.05);
            border: 1px solid rgba(16, 185, 129, 0.15);
            color: #a7f3d0;
            border-radius: 10px;
        }

        /* Penyesuaian Responsif Mobile */
        @media (max-width: 992px) {
            .list-header-labels { display: none; }
            .review-row-card { flex-direction: column; align-items: flex-start; gap: 12px; padding: 20px; }
            .col-rev-user, .col-rev-book, .col-rev-rating, .col-rev-date, .col-rev-actions { width: 100%; padding: 0; }
            .col-rev-actions { justify-content: flex-start; margin-top: 5px; }
        }
    </style>
@endpush

@section('content')
<div class="container-fluid px-0 page-wrapper" style="max-width: 1300px;">

    {{-- ================= HEADER UTAMA HALAMAN ================= --}}
    <div class="mb-4">
        <nav aria-label="breadcrumb" class="mb-1">
            <ol class="breadcrumb mb-0" style="font-size: 0.8rem;">
                <li class="breadcrumb-item"><a href="{{ url('/admin') }}" style="color: var(--muted); text-decoration: none;">Dashboard</a></li>
                <li class="breadcrumb-item active" style="color: var(--primary);" aria-current="page">Kelola Ulasan</li>
            </ol>
        </nav>
        <h2 class="fw-bold text-white m-0" style="font-size: 1.8rem; letter-spacing: -0.5px;">Kelola Ulasan Buku</h2>
    </div>

    {{-- ================= NOTIFIKASI SUKSES SISTEM ================= --}}
    @if(session('success'))
        <div class="alert alert-console-success rounded-3 shadow-sm mb-4 py-3 px-4 small d-flex align-items-center gap-2">
            <i class="fas fa-check-circle text-success fs-5"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    {{-- ================= LABEL HEADER SUB-KOLOM ================= --}}
    <div class="list-header-labels">
        <div class="col-rev-user">User</div>
        <div class="col-rev-book">Judul Buku</div>
        <div class="col-rev-rating">Rating</div>
        <div class="col-rev-date">Tanggal</div>
        <div class="col-rev-actions" style="text-align: right;">Aksi</div>
    </div>

    {{-- ================= MAIN LIST CONTAINER ================= --}}
    <div class="review-list-container">
        @forelse ($reviews as $review)
            <div class="review-row-card shadow-sm">
                
                {{-- KOLOM 1: INFO USER --}}
                <div class="col-rev-user">
                    @if($review->user && !empty($review->user->foto_profil))
                        <img src="{{ asset('storage/' . $review->user->foto_profil) }}" class="user-avatar" alt="Profile">
                    @else
                        <div class="rounded-circle d-flex align-items-center justify-content-center text-muted"
                             style="width: 32px; height: 32px; background: rgba(255,255,255,0.03); border: 1px solid var(--border); flex-shrink: 0;">
                            <i class="fas fa-user"></i>
                        </div>
                    @endif

                    <div class="text-truncate">
                        <div class="fw-bold text-white mb-0" style="font-size: 0.9rem;">
                            {{ $review->user->username ?? $review->user->nama_depan ?? 'User' }}
                        </div>
                        <span class="text-muted font-monospace" style="font-size: 0.72rem; opacity: 0.7;">ID #{{ $review->id }}</span>
                    </div>
                </div>

                {{-- KOLOM 2: JUDUL BUKU --}}
                <div class="col-rev-book text-truncate">
                    <div class="text-white fw-semibold text-truncate" style="font-size: 0.95rem;" title="{{ $review->book->title ?? 'Tidak ada' }}">
                        <i class="fas fa-book opacity-40 me-2" style="font-size: 0.85rem;"></i>
                        {{ $review->book->title ?? 'Buku Telah Dihapus' }}
                    </div>
                </div>

                {{-- KOLOM 3: RATING SCORE BINTANG --}}
                <div class="col-rev-rating">
                    <i class="fas fa-star rating-star-active"></i>
                    <span class="text-white fw-bold font-monospace" style="font-size: 0.95rem;">{{ $review->rating }}</span>
                    <span class="text-muted" style="font-size: 0.8rem;">/ 5</span>
                </div>

                {{-- KOLOM 4: TANGGAL --}}
                <div class="col-rev-date">
                    {{ $review->created_at->format('d M Y') }}
                </div>

                {{-- KOLOM 5: TOMBOL KONTROL UTAMA --}}
                <div class="col-rev-actions">
                    {{-- DETAIL --}}
                    <a href="{{ route('admin.reviews.show', $review->id) }}" class="btn-action-view">
                        <i class="fas fa-eye"></i> Detail
                    </a>

                    {{-- HAPUS --}}
                    <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" class="m-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ulasan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action-purge">
                            <i class="fas fa-trash-alt"></i> Hapus
                        </button>
                    </form>
                </div>

            </div>
        @empty
            {{-- TAMPILAN JIKA DATA KOSONG --}}
            <div class="text-center py-5" style="background: var(--sidebar-bg); border: 1px dashed var(--border); border-radius: 12px;">
                <div class="py-4 opacity-50">
                    <i class="fas fa-comment-slash fa-2x mb-3 text-secondary"></i>
                    <div class="small fw-semibold text-muted">Belum ada ulasan buku yang tersimpan.</div>
                </div>
            </div>
        @endforelse
    </div>

</div>
@endsection