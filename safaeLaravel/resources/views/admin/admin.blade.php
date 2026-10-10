@extends('layouts.layoutsAdmin')

@section('title', 'Admin Dashboard - Validasi Buku Masuk')

@push('styles')
<style>
    .admin-container {
        width: 100%;
        color: #f8fafc;
    }

    /* Kartu Statistik Ringkas */
    .metric-card-admin {
        background: #111827;
        border: 1px solid rgba(6, 182, 212, 0.15);
        border-radius: 14px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
        transition: border-color 0.25s, transform 0.2s;
    }

    .metric-card-admin:hover {
        transform: translateY(-2px);
        border-color: #06b6d4;
    }

    .metric-card-admin::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(to bottom, #06b6d4, #3b82f6);
    }

    .metric-number {
        font-size: 2.5rem;
        font-weight: 800;
        color: #06b6d4;
        line-height: 1;
        letter-spacing: -1px;
    }

    .metric-title {
        font-size: 0.75rem;
        font-weight: 700;
        color: #64748b;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    /* Panel Tabel Utama */
    .table-panel-admin {
        background: #111827;
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 16px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
    }

    .panel-header-admin {
        background: #1f2937 !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06) !important;
        padding: 20px 24px;
    }

    .table-admin {
        color: #cbd5e1 !important;
        margin-bottom: 0;
    }

    .table-admin thead th {
        background: #1f2937 !important;
        color: #94a3b8 !important;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        border-bottom: 2px solid rgba(255, 255, 255, 0.05) !important;
        padding: 16px;
    }

    .table-admin tbody td {
        padding: 14px 16px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.04) !important;
        background: transparent !important;
    }

    .table-admin tbody tr:hover td {
        background: rgba(6, 182, 212, 0.02) !important;
    }

    /* Desain Badge Status */
    .status-badge {
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
        display: inline-block;
    }

    .status-approved {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .status-rejected {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .status-pending {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
        border: 1px solid rgba(245, 158, 11, 0.2);
    }

    .status-genre {
        background: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
        border: 1px solid rgba(59, 130, 246, 0.2);
    }

    /* Tombol Aksi */
    .btn-action-tool {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: all 0.2s ease;
        font-size: 0.9rem;
    }

    .btn-tool-approve {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }

    .btn-tool-approve:hover {
        background: #10b981;
        color: #fff;
    }

    .btn-tool-reject {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .btn-tool-reject:hover {
        background: #ef4444;
        color: #fff;
    }

    /* Kotak Alert */
    .alert-admin-success {
        background: rgba(6, 182, 212, 0.04);
        border: 1px solid rgba(6, 182, 212, 0.25);
        color: #22d3ee;
        border-radius: 12px;
        padding: 14px 18px;
        font-size: 0.9rem;
    }
</style>
@endpush

@section('content')
<div class="admin-container">
    
    {{-- HEADER HALAMAN --}}
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom border-secondary border-opacity-10 pb-3">
        <div>
            <h1 class="h4 fw-bold text-white m-0">Validasi Buku Masuk</h1>
            <small class="text-muted">Persetujuan Penerbitan Konten Buku Baru</small>
        </div>
    </div>

    {{-- NOTIFIKASI SUKSES --}}
    @if(session('success'))
        <div class="alert alert-admin-success mb-4 d-flex align-items-center gap-2">
            <i class="fa-solid fa-check-circle text-primary"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- KARTU STATISTIK RINGKAS --}}
    <div class="row mb-4">
        <div class="col-xl-3 col-md-4">
            <div class="card metric-card-admin p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="metric-number">{{ sprintf('%02d', $books->count()) }}</div>
                        <div class="metric-title mt-2">Total Antrean</div>
                    </div>
                    <div class="p-3 rounded-3" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                        <i class="fas fa-server text-muted" style="font-size: 1.2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TABEL DATA UTAMA --}}
    <div class="card table-panel-admin overflow-hidden">
        <div class="panel-header-admin d-flex align-items-center justify-content-between">
            <h6 class="fw-bold text-white mb-0 small tracking-wider d-flex align-items-center gap-2">
                <i class="fa-solid fa-list-check text-primary"></i> Daftar Antrean Buku Masuk
            </h6>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-admin align-middle">
                    <thead>
                        <tr>
                            <th width="6%" class="text-center">No</th>
                            <th>Judul Buku</th>
                            <th>Penulis</th>
                            <th>Genre</th>
                            <th width="15%" class="text-center">Status</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse ($books as $book)
                        <tr>
                            <td class="text-center text-muted small">[{{ sprintf('%02d', $loop->iteration) }}]</td>

                            {{-- COVER + JUDUL BUKU --}}
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($book->image_path)
                                        <img src="{{ asset($book->image_path) }}"
                                             style="width: 40px; height: 56px; object-fit: cover"
                                             class="rounded me-3 border border-secondary border-opacity-10 shadow">
                                    @else
                                        <div class="rounded me-3 d-flex align-items-center justify-content-center border border-secondary border-opacity-10"
                                             style="width: 40px; height: 56px; background: #1e293b;">
                                            <i class="fas fa-book text-muted" style="font-size: 0.8rem;"></i>
                                        </div>
                                    @endif
                                    <span class="fw-bold text-white fs-6">{{ $book->title }}</span>
                                </div>
                            </td>

                            <td class="fw-semibold text-secondary" style="color: #cbd5e1 !important;">{{ $book->author }}</td>

                            <td>
                                <span class="status-badge status-genre">{{ $book->genre }}</span>
                            </td>

                            <td class="text-center">
                                @if($book->status === 'approved')
                                    <span class="status-badge status-approved">Approved</span>
                                @elseif($book->status === 'rejected')
                                    <span class="status-badge status-rejected">Rejected</span>
                                @else
                                    <span class="status-badge status-pending">Pending</span>
                                @endif
                            </td>

                            {{-- SAKELAR EKSEKUSI AKSI --}}
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">

                                    @if($book->status === 'pending')

                                        {{-- APPROVE --}}
                                        <form action="{{ url('/admin/validasi/'.$book->id.'/approve') }}" method="POST" class="m-0">
                                            @csrf
                                            <button type="submit"
                                                    class="btn-action-tool btn-tool-approve"
                                                    title="Setujui Buku"
                                                    onclick="return confirm('Apakah Anda yakin ingin menyetujui buku ini?')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>

                                        {{-- REJECT --}}
                                        <form action="{{ url('/admin/validasi/'.$book->id.'/reject') }}" method="POST" class="m-0">
                                            @csrf
                                            <button type="submit"
                                                    class="btn-action-tool btn-tool-reject"
                                                    title="Tolak Buku"
                                                    onclick="return confirm('Apakah Anda yakin ingin menolak buku ini?')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>

                                    @else
                                        <span class="small text-muted py-1 px-2 rounded-2" style="background: rgba(255,255,255,0.02); font-size: 0.75rem;">
                                            <i class="fa-solid fa-lock me-1"></i> Selesai
                                        </span>
                                    @endif

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5 small">
                                <div class="mb-2" style="font-size: 1.5rem;">📥</div>
                                Belum ada data antrean buku masuk saat ini.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection