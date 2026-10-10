@extends('layouts.layoutsAdmin') 

@section('title', 'Kelola Riwayat Baca')

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
        .history-list-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* Row Card Baris Utama */
        .history-row-card {
            display: flex;
            align-items: center;
            background: var(--sidebar-bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 16px 24px;
            transition: all 0.2s ease-in-out;
        }
        .history-row-card:hover {
            border-color: rgba(6, 182, 212, 0.3);
            background: rgba(17, 24, 39, 0.6);
            transform: translateY(-1px);
        }

        /* Pembagian Lebar Kolom Flexbox yang Presisi dan Simetris */
        .col-hist-user { flex: 1.2; display: flex; align-items: center; gap: 12px; min-width: 0; }
        .col-hist-book { flex: 1.8; min-width: 0; padding-right: 15px; }
        .col-hist-progress { flex: 1.3; min-width: 0; padding-right: 20px; }
        .col-hist-date { flex: 1.2; color: var(--muted); font-size: 0.85rem; font-family: var(--font-mono, monospace); }
        .col-hist-actions { flex: 1; display: flex; justify-content: flex-end; align-items: center; gap: 8px; }

        /* Sizing Akurat Gambar Cover Buku (Mencegah Kebesaran) */
        .book-cover-preview {
            width: 38px;
            height: 54px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid var(--border);
            flex-shrink: 0;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        }

        /* Fallback Box jika File Gambar Kosong */
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

        /* Avatar Pengguna */
        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid var(--border);
            flex-shrink: 0;
        }

        /* Komponen Progress Bar Kustom */
        .progress-container-tech {
            width: 100%;
            max-width: 160px;
        }
        .progress-bar-rail {
            background: rgba(255, 255, 255, 0.05);
            height: 6px;
            border-radius: 4px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.02);
        }
        .progress-bar-fill {
            background: linear-gradient(90deg, var(--primary), #22d3ee);
            height: 100%;
            border-radius: 4px;
        }

        /* Tombol Utama Tambah Riwayat */
        .btn-console-create {
            background: var(--primary);
            color: #0b0f19;
            font-weight: 700;
            font-size: 0.85rem;
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-console-create:hover {
            background: #22d3ee;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(6, 182, 212, 0.2);
            color: #0b0f19;
        }

        /* Tombol Kontrol Aksi */
        .btn-action-edit {
            background: rgba(245, 158, 11, 0.08);
            border: 1px solid rgba(245, 158, 11, 0.2);
            color: #f59e0b !important;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 0.85rem;
            transition: all 0.2s;
            text-decoration: none;
        }
        .btn-action-edit:hover {
            background: #f59e0b;
            color: #0b0f19 !important;
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
            .history-row-card { flex-direction: column; align-items: flex-start; gap: 14px; padding: 20px; }
            .col-hist-user, .col-hist-book, .col-hist-progress, .col-hist-date, .col-hist-actions { width: 100%; padding: 0; }
            .col-hist-actions { justify-content: flex-start; margin-top: 5px; }
            .progress-container-tech { max-width: 100%; }
        }
    </style>
@endpush

@section('content')
<div class="container-fluid px-0 page-wrapper" style="max-width: 1300px;">

    {{-- ================= HEADER UTAMA HALAMAN ================= --}}
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
        <div>
            <nav aria-label="breadcrumb" class="mb-1">
                <ol class="breadcrumb mb-0" style="font-size: 0.8rem;">
                    <li class="breadcrumb-item"><a href="{{ url('/admin') }}" style="color: var(--muted); text-decoration: none;">Dashboard</a></li>
                    <li class="breadcrumb-item active" style="color: var(--primary);" aria-current="page">Riwayat Baca</li>
                </ol>
            </nav>
            <h2 class="fw-bold text-white m-0" style="font-size: 1.8rem; letter-spacing: -0.5px;">Kelola Riwayat Baca</h2>
        </div>
        <div>
            <a href="{{ route('admin.kelolariwayat.create') }}" class="btn-console-create text-decoration-none shadow-sm">
                <i class="fas fa-plus"></i> Tambah Riwayat
            </a>
        </div>
    </div>

    {{-- ================= NOTIFIKASI SUKSES SISTEM ================= --}}
    @if (session('success'))
        <div class="alert alert-console-success rounded-3 shadow-sm mb-4 py-3 px-4 small d-flex align-items-center gap-2">
            <i class="fas fa-check-circle text-success fs-5"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    {{-- ================= LABEL HEADER SUB-KOLOM ================= --}}
    <div class="list-header-labels">
        <div class="col-hist-user">User</div>
        <div class="col-hist-book">Judul Buku</div>
        <div class="col-hist-progress">Progress Membaca</div>
        <div class="col-hist-date">Terakhir Baca</div>
        <div class="col-text-end col-hist-actions">Aksi</div>
    </div>

    {{-- ================= MAIN LIST CONTAINER ================= --}}
    <div class="history-list-container">
        @forelse ($histories as $history)
            <div class="history-row-card shadow-sm">
                
                {{-- KOLOM 1: INFO PENGGUNA --}}
                <div class="col-hist-user">
                    @if($history->user && $history->user->foto_profil)
                        <img src="{{ asset('storage/' . $history->user->foto_profil) }}" class="user-avatar" alt="Profile">
                    @else
                        <div class="rounded-circle d-flex align-items-center justify-content-center text-muted"
                            style="width: 36px; height: 36px; background: rgba(255,255,255,0.03); border: 1px solid var(--border); flex-shrink: 0;">
                            <i class="fas fa-user-circle" style="font-size: 0.95rem;"></i>
                        </div>
                    @endif
                    <div class="text-truncate">
                        <div class="fw-bold text-white mb-0" style="font-size: 0.9rem;">
                            {{ $history->user->username ?? ($history->user->nama_depan . ' ' . $history->user->nama_belakang) ?? 'User' }}
                        </div>
                        <span class="text-muted font-monospace" style="font-size: 0.72rem; opacity: 0.7;">HIST_ID #{{ $history->id }}</span>
                    </div>
                </div>

                {{-- KOLOM 2: JUDUL BUKU + TATA LETAK COVER AMAN --}}
                <div class="col-hist-book">
                    <div class="d-flex align-items-center gap-3">

                        {{-- Logika disesuaikan dengan folder covers --}}
                        @if($history->book && !empty($history->book->image_path))
        <img src="{{ asset(ltrim($history->book->image_path, '/')) }}"
                        class="book-cover-preview"
                        alt="Cover">
                @elseif($history->book && !empty($history->book->cover_image))
                    <img src="{{ asset($history->book->cover_image) }}"
                        class="book-cover-preview"
                        alt="Cover">
                @else
                    <div class="book-icon-fallback">
                        <i class="fas fa-book"></i>
                    </div>
                @endif

                        <div class="text-truncate">
                            <div class="text-white fw-semibold text-truncate" title="{{ $history->book->title ?? '-' }}">
                                {{ $history->book->title ?? 'Buku Telah Dihapus' }}
                            </div>
                            <span class="text-muted small font-monospace" style="font-size: 0.75rem;">BOOK_ID: {{ $history->book->id ?? '-' }}</span>
                        </div>

                    </div>
                </div>

                {{-- KOLOM 3: PROGRESS MEMBACA + MINI VISUAL PROGRESS BAR --}}
                <div class="col-hist-progress">
                    <div class="progress-container-tech">
                        <div class="d-flex justify-content-between align-items-center mb-1" style="font-size: 0.8rem;">
                            <span class="text-muted">Status Progress</span>
                            <span class="text-white fw-bold font-monospace">{{ $history->progress }}%</span>
                        </div>
                        <div class="progress-bar-rail">
                            <div class="progress-bar-fill" style="width: {{ $history->progress }}%;"></div>
                        </div>
                    </div>
                </div>

                {{-- KOLOM 4: TANGGAL TERAKHIR BACA --}}
                <div class="col-hist-date">
                    <i class="far fa-clock opacity-40 me-1" style="font-size: 0.8rem;"></i>
                    <span>{{ $history->last_read_at ?? '-' }}</span>
                </div>

                {{-- KOLOM 5: TOMBOL OPERASI AKSI --}}
                <div class="col-hist-actions">
                    {{-- EDIT --}}
                    <a href="{{ route('admin.kelolariwayat.edit', $history->id) }}" class="btn-action-edit">
                        Edit
                    </a>

                    {{-- HAPUS --}}
                    <form action="{{ route('admin.kelolariwayat.destroy', $history->id) }}" method="POST" class="m-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan riwayat baca ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action-purge">
                            Hapus
                        </button>
                    </form>
                </div>

            </div>
        @empty
            {{-- TAMPILAN JIKA DATA KOSONG --}}
            <div class="text-center py-5" style="background: var(--sidebar-bg); border: 1px dashed var(--border); border-radius: 12px;">
                <div class="py-4 opacity-50">
                    <i class="fas fa-history fa-2x mb-3 text-secondary"></i>
                    <div class="small fw-semibold text-muted">Belum ada data catatan riwayat baca yang terekam.</div>
                </div>
            </div>
        @endforelse
    </div>

</div>
@endsection