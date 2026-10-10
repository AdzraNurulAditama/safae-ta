@extends('layouts.layoutsAdmin')

@section('title', 'Kelola Notifikasi')

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
        .notif-list-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* Row Card Notifikasi */
        .notif-row-card {
            display: flex;
            align-items: center;
            background: var(--sidebar-bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 16px 24px;
            transition: all 0.2s ease-in-out;
        }
        .notif-row-card:hover {
            border-color: rgba(6, 182, 212, 0.3);
            background: rgba(17, 24, 39, 0.6);
            transform: translateY(-1px);
        }

        /* Pembagian Lebar Kolom Flexbox Simetris */
        .col-notif-info { flex: 2.2; min-width: 0; padding-right: 20px; }
        .col-notif-status { flex: 0.8; display: flex; align-items: center; }
        .col-notif-date { flex: 1; color: var(--muted); font-size: 0.85rem; font-family: var(--font-mono, monospace); }
        .col-notif-actions { flex: 1.2; display: flex; justify-content: flex-end; align-items: center; }

        /* Badge Status Kustom */
        .badge-status {
            font-size: 0.75rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .status-unread {
            background: rgba(6, 182, 212, 0.1);
            color: var(--primary);
            border: 1px solid rgba(6, 182, 212, 0.2);
        }
        .status-read {
            background: rgba(16, 185, 129, 0.08);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.15);
        }

        /* Tombol Aksi */
        .btn-action-read {
            background: rgba(16, 185, 129, 0.12);
            border: 1px solid rgba(16, 185, 129, 0.25);
            color: #a7f3d0 !important;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 0.82rem;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-action-read:hover {
            background: #10b981;
            color: #0b0f19 !important;
            box-shadow: 0 0 10px rgba(16, 185, 129, 0.2);
        }

        /* Notifikasi Sukses */
        .alert-console-success {
            background: rgba(16, 185, 129, 0.05);
            border: 1px solid rgba(16, 185, 129, 0.15);
            color: #a7f3d0;
            border-radius: 10px;
        }

        @media (max-width: 992px) {
            .list-header-labels { display: none; }
            .notif-row-card { flex-direction: column; align-items: flex-start; gap: 12px; padding: 20px; }
            .col-notif-info, .col-notif-status, .col-notif-date, .col-notif-actions { width: 100%; padding: 0; }
            .col-notif-actions { justify-content: flex-start; margin-top: 5px; }
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
                <li class="breadcrumb-item active" style="color: var(--primary);" aria-current="page">Notifikasi Admin</li>
            </ol>
        </nav>
        <h2 class="fw-bold text-white m-0" style="font-size: 1.8rem; letter-spacing: -0.5px;">Kelola Notifikasi Admin</h2>
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
        <div class="col-notif-info">Konten Notifikasi</div>
        <div class="col-notif-status">Status</div>
        <div class="col-notif-date">Tanggal</div>
        <div class="col-notif-actions" style="text-align: right;">Aksi</div>
    </div>

    {{-- ================= MAIN LIST CONTAINER ================= --}}
    <div class="notif-list-container">
        @forelse($notifications as $notif)
            <div class="notif-row-card shadow-sm">
                
                {{-- KOLOM 1: INFO KONTEN NOTIFIKASI --}}
                <div class="col-notif-info">
                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                             style="width: 36px; height: 36px; background: {{ $notif->is_read ? 'rgba(255,255,255,0.02)' : 'rgba(6, 182, 212, 0.05)' }}; border: 1px solid var(--border); flex-shrink: 0; color: {{ $notif->is_read ? 'var(--muted)' : 'var(--primary)' }};">
                            <i class="fas {{ $notif->is_read ? 'fa-bell-slash' : 'fa-bell animate-pulse' }}" style="font-size: 0.85rem;"></i>
                        </div>
                        <div class="min-width-0">
                            <div class="fw-bold {{ $notif->is_read ? 'text-secondary' : 'text-white' }} mb-1" style="font-size: 0.95rem;">
                                {{ $notif->title }}
                            </div>
                            <p class="text-muted small mb-0 text-wrap" style="line-height: 1.4;">
                                {{ $notif->message }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- KOLOM 2: BADGE STATUS --}}
                <div class="col-notif-status">
                    @if($notif->is_read)
                        <span class="badge-status status-read">
                            <i class="fas fa-check-double" style="font-size: 0.7rem;"></i> Dibaca
                        </span>
                    @else
                        <span class="badge-status status-unread">
                            <i class="fas fa-circle" style="font-size: 0.5rem;"></i> Baru
                        </span>
                    @endif
                </div>

                {{-- KOLOM 3: TANGGAL --}}
                <div class="col-notif-date">
                    <span>{{ $notif->created_at->format('d M Y • H:i') }}</span>
                </div>

                {{-- KOLOM 4: TOMBOL AKSI INTERAKTIF --}}
                <div class="col-notif-actions">
                    @if(!$notif->is_read)
                        <form action="{{ route('admin.notifications.read', $notif->id) }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="btn-action-read">
                                <i class="fas fa-envelope-open"></i> Hubungkan Dibaca
                            </button>
                        </form>
                    @else
                        <span class="text-muted small font-monospace opacity-40" style="font-size: 0.8rem; padding-right: 14px;">
                            Selesai <i class="fas fa-check"></i>
                        </span>
                    @endif
                </div>

            </div>
        @empty
            {{-- DATA KOSONG --}}
            <div class="text-center py-5" style="background: var(--sidebar-bg); border: 1px dashed var(--border); border-radius: 12px;">
                <div class="py-4 opacity-50">
                    <i class="fas fa-bell-slash fa-2.5x mb-3 text-secondary"></i>
                    <div class="small fw-semibold text-muted">Kotak masuk notifikasi admin kosong.</div>
                </div>
            </div>
        @endforelse
    </div>

</div>
@endsection