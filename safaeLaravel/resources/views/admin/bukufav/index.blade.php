@extends('layouts.layoutsAdmin') 

@section('title', 'Kelola Buku Favorit')

@push('styles')
    <style>
        /* ================= PREMIUM SaaS OBSIDIAN DESIGN ================= */
        .page-wrapper {
            background: transparent;
            color: var(--text);
            padding: 10px 0;
        }

        /* Navigasi Label Header Kolom (Pengganti th) */
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
        .favorite-list-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* Row Card Baris Utama */
        .favorite-row-card {
            display: flex;
            align-items: center;
            background: var(--sidebar-bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 16px 24px;
            transition: all 0.2s ease-in-out;
        }
        .favorite-row-card:hover {
            border-color: rgba(6, 182, 212, 0.3);
            background: rgba(17, 24, 39, 0.6);
            transform: translateY(-1px);
        }

        /* Pembagian Lebar Kolom Flexbox yang Presisi dan Simetris */
        .col-fav-user { flex: 1.2; display: flex; align-items: center; gap: 12px; min-width: 0; }
        .col-fav-book { flex: 2; min-width: 0; padding-right: 15px; }
        .col-fav-author { flex: 1.3; color: #cbd5e1; font-size: 0.9rem; min-width: 0; }
        .col-fav-actions { flex: 1; display: flex; justify-content: flex-end; align-items: center; gap: 8px; }

        /* Sizing dan Tata Letak Gambar Cover Buku */
        .book-cover-preview {
            width: 38px;
            height: 54px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid var(--border);
            flex-shrink: 0;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        }

        /* Fallback Box jika File Gambar Kosong / Tidak Ditemukan */
        .book-icon-fallback {
            width: 38px;
            height: 54px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px dashed var(--border);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--muted);
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        /* Sizing Akurat Foto Profil User (Mencegah Kebesaran) */
        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid var(--border);
            flex-shrink: 0;
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
            .favorite-row-card { flex-direction: column; align-items: flex-start; gap: 12px; padding: 20px; }
            .col-fav-user, .col-fav-book, .col-fav-author, .col-fav-actions { width: 100%; padding: 0; }
            .col-fav-actions { justify-content: flex-start; margin-top: 5px; }
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
                <li class="breadcrumb-item active" style="color: var(--primary);" aria-current="page">Buku Favorit</li>
            </ol>
        </nav>
        <h2 class="fw-bold text-white m-0" style="font-size: 1.8rem; letter-spacing: -0.5px;">Kelola Buku Favorit User</h2>
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
        <div class="col-fav-user">User Penggemar</div>
        <div class="col-fav-book">Informasi Buku</div>
        <div class="col-fav-author">Penulis</div>
        <div class="col-fav-actions" style="text-align: right;">Aksi</div>
    </div>

    {{-- ================= MAIN LIST CONTAINER ================= --}}
    <div class="favorite-list-container">
        @forelse ($favorites as $fav)
            <div class="favorite-row-card shadow-sm">
                
                {{-- KOLOM 1: INFO PENGGUNA --}}
                <div class="col-fav-user">
                    @if($fav->user && !empty($fav->user->foto_profil))
                        <img src="{{ asset('storage/' . $fav->user->foto_profil) }}" class="user-avatar" alt="Profile">
                    @elseif($fav->user && !empty($fav->user->profile_image))
                        <img src="{{ asset('storage/' . $fav->user->profile_image) }}" class="user-avatar" alt="Profile">
                    @else
                        <div class="rounded-circle d-flex align-items-center justify-content-center text-muted"
                             style="width: 36px; height: 36px; background: rgba(255,255,255,0.03); border: 1px solid var(--border); flex-shrink: 0;">
                            <i class="fas fa-user"></i>
                        </div>
                    @endif
                    
                    <div class="text-truncate">
                        <div class="fw-bold text-white mb-0" style="font-size: 0.9rem;">{{ $fav->user->username ?? 'Unknown' }}</div>
                        <span class="text-muted font-monospace" style="font-size: 0.72rem; opacity: 0.7;">FAV_ID #{{ $fav->id }}</span>
                    </div>
                </div> {{-- Penutup tag div kolom 1 yang sebelumnya hilang --}}

                {{-- KOLOM 2: DETAIL DATA BUKU + COVER IMAGE PATH LOADER --}}
                <div class="col-fav-book">
                    <div class="d-flex align-items-center gap-3">
                    
                        @if($fav->book && !empty($fav->book->image_path))
    <img src="{{ asset(ltrim($fav->book->image_path, '/')) }}"
         class="book-cover-preview"
         alt="Cover">

@elseif($fav->book && !empty($fav->book->cover_image))
    <img src="{{ asset($fav->book->cover_image) }}"
         class="book-cover-preview"
         alt="Cover">

@else
    <div class="book-icon-fallback">
        <i class="fas fa-book"></i>
    </div>
@endif

                        <div class="text-truncate">
                            <div class="text-white fw-bold text-truncate" style="font-size: 0.95rem;" title="{{ $fav->book->title ?? 'Buku Telah Dihapus' }}">
                                {{ $fav->book->title ?? 'Buku Telah Dihapus' }}
                            </div>
                            <span class="text-muted small font-monospace" style="font-size: 0.75rem;">BOOK_ID: {{ $fav->book->id ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                {{-- KOLOM 3: PENULIS BUKU --}}
                <div class="col-fav-author text-truncate" title="{{ $fav->book->author ?? '-' }}">
                    <i class="fas fa-feather-alt opacity-40 me-2" style="font-size: 0.8rem;"></i>
                    <span>{{ $fav->book->author ?? '-' }}</span>
                </div>

                {{-- KOLOM 4: KELOMPOK TOMBOL AKSI --}}
                <div class="col-fav-actions">
                    {{-- DETAIL --}}
                    <a href="{{ route('admin.favorit.show', $fav->id) }}" class="btn-action-view">
                        <i class="fas fa-eye"></i> Detail
                    </a>

                    {{-- HAPUS --}}
                    <form action="{{ route('admin.favorit.destroy', $fav->id) }}" method="POST" class="m-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini dari daftar favorit user?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action-purge">
                            <i class="fas fa-times"></i> Hapus
                        </button>
                    </form>
                </div>

            </div>
        @empty
            {{-- TAMPILAN JIKA DATA KOSONG --}}
            <div class="text-center py-5" style="background: var(--sidebar-bg); border: 1px dashed var(--border); border-radius: 12px;">
                <div class="py-4 opacity-50">
                    <i class="fas fa-folder-open fa-2x mb-3 text-secondary"></i>
                    <div class="small fw-semibold text-muted">Belum ada data buku favorit yang tersimpan.</div>
                </div>
            </div>
        @endforelse
    </div>

</div>
@endsection