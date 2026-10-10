@extends('layouts.layoutsAdmin')

@section('title', 'Kelola Forum')

@push('styles')
    <style>
        /* ================= PREMIUM SaaS OBSIDIAN DESIGN ================= */
        .page-wrapper {
            background: transparent;
            color: var(--text);
            padding: 10px 0;
        }

        /* Header Kolom (Pengganti th tabel) */
        .list-header-labels {
            display: flex;
            padding: 0 24px 12px;
            color: var(--muted);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
        }

        /* Container Daftar Baris */
        .forum-list-container {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        /* Baris Topik Bergaya Row Card */
        .forum-row-card {
            display: flex;
            align-items: center;
            background: var(--sidebar-bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 18px 24px;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .forum-row-card:hover {
            border-color: rgba(6, 182, 212, 0.25);
            background: rgba(17, 24, 39, 0.7);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        /* Pengaturan Lebar Kolom Flexbox */
        .col-topic-title { flex: 2.5; display: flex; align-items: center; gap: 16px; }
        .col-topic-author { flex: 1.2; display: flex; align-items: center; gap: 10px; color: #cbd5e1; font-size: 0.9rem; }
        .col-topic-date { flex: 1; color: var(--muted); font-size: 0.85rem; }
        .col-topic-actions { flex: 1.3; text-align: right; display: flex; justify-content: flex-end; gap: 8px; }

        /* Icon / Avatar Placeholder */
        .forum-icon-box {
            width: 40px;
            height: 40px;
            background: rgba(6, 182, 212, 0.05);
            border: 1px solid rgba(6, 182, 212, 0.15);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 1.1rem;
        }

        /* Tombol Aksi */
        .btn-action-view {
            background: rgba(6, 182, 212, 0.08);
            border: 1px solid rgba(6, 182, 212, 0.2);
            color: var(--primary) !important;
            font-weight: 600;
            padding: 6px 16px;
            border-radius: 8px;
            font-size: 0.85rem;
            transition: all 0.2s;
            text-decoration: none;
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
            padding: 6px 16px;
            border-radius: 8px;
            font-size: 0.85rem;
            transition: all 0.2s;
        }
        .btn-action-purge:hover {
            background: rgba(239, 68, 68, 0.1);
            border-color: #ef4444;
            color: #ef4444 !important;
        }

        /* Alert Modifikasi */
        .alert-console-success {
            background: rgba(16, 185, 129, 0.05);
            border: 1px solid rgba(16, 185, 129, 0.15);
            color: #a7f3d0;
            border-radius: 10px;
        }

        /* Responsif Mobile */
        @media (max-width: 992px) {
            .list-header-labels { display: none; }
            .forum-row-card { flex-direction: column; align-items: flex-start; gap: 12px; padding: 20px; }
            .col-topic-title { width: 100%; }
            .col-topic-author, .col-topic-date, .col-topic-actions { width: 100%; padding-left: 56px; }
            .col-topic-actions { justify-content: flex-start; margin-top: 5px; }
        }
    </style>
@endpush

@section('content')
<div class="container-fluid px-0 page-wrapper" style="max-width: 1300px;">

    {{-- ================= HEADER JUDUL HALAMAN ================= --}}
    <div class="mb-4">
        <nav aria-label="breadcrumb" class="mb-1">
            <ol class="breadcrumb mb-0" style="font-size: 0.8rem;">
                <li class="breadcrumb-item"><a href="{{ url('/admin') }}" style="color: var(--muted); text-decoration: none;">Dashboard</a></li>
                <li class="breadcrumb-item active" style="color: var(--primary);" aria-current="page">Kelola Forum</li>
            </ol>
        </nav>
        <h2 class="fw-bold text-white m-0" style="font-size: 1.8rem; letter-spacing: -0.5px;">Kelola Forum</h2>
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
        <div class="col-topic-title">Judul Topik</div>
        <div class="col-topic-author">Pembuat</div>
        <div class="col-topic-date">Tanggal</div>
        <div class="col-topic-actions">Aksi</div>
    </div>

    {{-- ================= MAIN LIST CONTAINER ================= --}}
    <div class="forum-list-container">
        @forelse($topics as $topic)
            <div class="forum-row-card shadow-sm">
                
                {{-- KOLOM 1: ICON & JUDUL TOPIK --}}
                <div class="col-topic-title">
                    <div class="forum-icon-box">
                        <i class="fa-regular fa-comments"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-white mb-0" style="font-size: 0.95rem; line-height: 1.4;">{{ $topic->judul }}</div>
                        <span class="text-muted font-monospace" style="font-size: 0.72rem; opacity: 0.7;">TOPIC_ID #{{ $topic->id }}</span>
                    </div>
                </div>

                {{-- KOLOM 2: PEMBUAT --}}
                <div class="col-topic-author">
                    <i class="far fa-user opacity-40" style="font-size: 0.85rem;"></i>
                    <span>{{ $topic->user->username ?? $topic->user->nama_depan ?? 'User' }}</span>
                </div>

                {{-- KOLOM 3: TANGGAL --}}
                <div class="col-topic-date font-monospace">
                    {{ $topic->created_at->format('d/m/Y') }}
                </div>

                {{-- KOLOM 4: TOMBOL AKSI --}}
                <div class="col-topic-actions">
                    {{-- DETAIL --}}
                    <a href="{{ route('admin.forum.detail', $topic->id) }}" class="btn-action-view">
                        Detail
                    </a>

                    {{-- HAPUS --}}
                    <form method="POST" action="{{ route('admin.forum.destroy', $topic->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus topik forum ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action-purge">
                            Hapus
                        </button>
                    </form>
                </div>

            </div>
        @empty
            {{-- TAMPILAN DATA KOSONG --}}
            <div class="text-center py-5" style="background: var(--sidebar-bg); border: 1px dashed var(--border); border-radius: 12px;">
                <div class="py-4 opacity-50">
                    <i class="fas fa-comment-slash fa-2.5x mb-3 text-secondary"></i>
                    <div class="small fw-semibold text-muted">Belum ada topik diskusi di forum ini.</div>
                </div>
            </div>
        @endforelse
    </div>

</div>
@endsection