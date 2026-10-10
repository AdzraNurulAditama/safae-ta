@extends('layouts.layoutsAdmin')

@section('title', 'Kelola Promosi')

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
        .promo-list-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* Row Card Promosi */
        .promo-row-card {
            display: flex;
            align-items: center;
            background: var(--sidebar-bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 16px 24px;
            transition: all 0.2s ease-in-out;
        }
        .promo-row-card:hover {
            border-color: rgba(6, 182, 212, 0.3);
            background: rgba(17, 24, 39, 0.6);
            transform: translateY(-1px);
        }

        /* Pembagian Lebar Kolom Flexbox Simetris */
        .col-promo-title { flex: 2.5; min-width: 0; padding-right: 20px; }
        .col-promo-date { flex: 1.2; color: var(--muted); font-size: 0.85rem; font-family: var(--font-mono, monospace); display: flex; align-items: center; gap: 8px; }
        .col-promo-actions { flex: 1.3; display: flex; justify-content: flex-end; align-items: center; gap: 8px; }

        /* Tombol Utama Tambah Promosi */
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

        /* Tombol Kontrol */
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
            display: inline-flex;
            align-items: center;
            gap: 6px;
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
            display: inline-flex;
            align-items: center;
            gap: 6px;
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

        @media (max-width: 992px) {
            .list-header-labels { display: none; }
            .promo-row-card { flex-direction: column; align-items: flex-start; gap: 12px; padding: 20px; }
            .col-promo-title, .col-promo-date, .col-promo-actions { width: 100%; padding: 0; }
            .col-promo-actions { justify-content: flex-start; margin-top: 5px; }
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
                    <li class="breadcrumb-item active" style="color: var(--primary);" aria-current="page">Kelola Promosi</li>
                </ol>
            </nav>
            <h2 class="fw-bold text-white m-0" style="font-size: 1.8rem; letter-spacing: -0.5px;">Kelola Promosi</h2>
        </div>
        <div>
            <a href="{{ route('admin.promotions.create') }}" class="btn-console-create text-decoration-none shadow-sm">
                <i class="fas fa-plus"></i> Tambah Promosi
            </a>
        </div>
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
        <div class="col-promo-title">Judul Promosi</div>
        <div class="col-promo-date">Tanggal Event / Batas Waktu</div>
        <div class="col-promo-actions" style="text-align: right;">Aksi</div>
    </div>

    {{-- ================= MAIN LIST CONTAINER ================= --}}
    <div class="promo-list-container">
        @forelse($promotions as $promo)
            <div class="promo-row-card shadow-sm">
                
                {{-- KOLOM 1: JUDUL PROMOSI --}}
                <div class="col-promo-title">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center text-primary"
                             style="width: 36px; height: 36px; background: rgba(6, 182, 212, 0.05); border: 1px solid rgba(6, 182, 212, 0.12); flex-shrink: 0;">
                            <i class="fas fa-percentage" style="font-size: 0.85rem;"></i>
                        </div>
                        <div class="text-truncate">
                            <div class="text-white fw-bold text-truncate" style="font-size: 0.95rem;" title="{{ $promo->title }}">
                                {{ $promo->title }}
                            </div>
                            <span class="text-muted font-monospace" style="font-size: 0.72rem; opacity: 0.7;">PROMO_ID #{{ $promo->id }}</span>
                        </div>
                    </div>
                </div>

                {{-- KOLOM 2: TANGGAL EVENT --}}
                <div class="col-promo-date">
                    <i class="far fa-calendar-alt opacity-40" style="font-size: 0.85rem;"></i>
                    <span>{{ $promo->event_date ?? '-' }}</span>
                </div>

                {{-- KOLOM 3: TOMBOL KONTROL AKSI --}}
                <div class="col-promo-actions">
                    {{-- EDIT --}}
                    <a href="{{ route('admin.promotions.edit', $promo->id) }}" class="btn-action-edit">
                        <i class="fas fa-edit"></i> Edit
                    </a>

                    {{-- HAPUS --}}
                    <form action="{{ route('admin.promotions.destroy', $promo->id) }}" method="POST" class="m-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus promosi ini?')">
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
                    <i class="fas fa-bullhorn fa-2.5x mb-3 text-secondary"></i>
                    <div class="small fw-semibold text-muted">Belum ada data promosi yang aktif saat ini.</div>
                </div>
            </div>
        @endforelse
    </div>

</div>
@endsection