
@extends('layouts.layoutsAdmin')
@section('title', 'Kelola Komentar')
@section('content')
<style>
    .comment-admin {
        max-width: 1350px;
        margin: 0 auto;
        padding: 12px 0 45px;
        color: #e2e8f0;
    }

    /* HEADER */
    .comment-admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
        padding: 28px;
        margin-bottom: 22px;
        background: linear-gradient(115deg, #14214a, #0b3a5c 65%, #101a39);
        border: 1px solid rgba(125, 211, 252, 0.2);
        border-radius: 20px;
    }

    .comment-admin-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        margin-bottom: 10px;
        color: #7dd3fc;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 1px;
    }

    .comment-admin-header h1 {
        margin: 0 0 7px;
        color: #fff;
        font-size: 28px;
        font-weight: 800;
    }

    .comment-admin-header h1 span {
        color: #38bdf8;
    }

    .comment-admin-header p {
        margin: 0;
        color: #b5c4d8;
        font-size: 13px;
    }

    .comment-header-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 70px;
        height: 70px;
        background: rgba(56, 189, 248, 0.12);
        border: 1px solid rgba(56, 189, 248, 0.2);
        border-radius: 20px;
        color: #38bdf8;
        font-size: 30px;
    }

    /* STATISTIK */
    .comment-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 22px;
    }

    .comment-stat-card {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 20px;
        background: #162033;
        border: 1px solid #29374e;
        border-radius: 16px;
    }

    .comment-stat-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 48px;
        height: 48px;
        flex-shrink: 0;
        border-radius: 14px;
        font-size: 19px;
    }

    .comment-stat-icon.blue {
        background: rgba(56, 189, 248, 0.12);
        color: #38bdf8;
    }

    .comment-stat-icon.green {
        background: rgba(34, 197, 94, 0.12);
        color: #4ade80;
    }

    .comment-stat-icon.purple {
        background: rgba(168, 85, 247, 0.12);
        color: #c084fc;
    }

    .comment-stat-value {
        margin-bottom: 3px;
        color: #fff;
        font-size: 25px;
        font-weight: 800;
    }

    .comment-stat-label {
        color: #94a3b8;
        font-size: 12px;
    }

    /* SEARCH DAN TOOLBAR */
    .comment-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        padding: 20px;
        margin-bottom: 18px;
        background: #162033;
        border: 1px solid #29374e;
        border-radius: 16px;
    }

    .comment-toolbar-title {
        margin: 0 0 4px;
        color: #fff;
        font-size: 16px;
        font-weight: 800;
    }

    .comment-toolbar-desc {
        margin: 0;
        color: #94a3b8;
        font-size: 11px;
    }

    .comment-search-form {
        display: flex;
        align-items: center;
        gap: 9px;
        width: 100%;
        max-width: 425px;
    }

    .comment-search-box {
        display: flex;
        align-items: center;
        gap: 10px;
        flex: 1;
        min-width: 0;
        padding: 0 13px;
        background: #0f172a;
        border: 1px solid #334155;
        border-radius: 11px;
        transition: 0.3s;
    }

    .comment-search-box:focus-within {
        border-color: #38bdf8;
        box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.08);
    }

    .comment-search-box i {
        color: #64748b;
        font-size: 13px;
    }

    .comment-search-box input {
        width: 100%;
        height: 43px;
        background: transparent;
        border: none;
        outline: none;
        color: #fff;
        font-size: 12px;
    }

    .comment-search-box input::placeholder {
        color: #64748b;
    }

    .comment-search-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        height: 43px;
        padding: 0 16px;
        background: #38bdf8;
        border: none;
        border-radius: 11px;
        color: #082f49;
        font-size: 12px;
        font-weight: 800;
        cursor: pointer;
        transition: 0.3s;
    }

    .comment-search-btn:hover {
        background: #7dd3fc;
    }

    .comment-reset-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 43px;
        height: 43px;
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 11px;
        color: #cbd5e1;
        text-decoration: none;
    }

    .comment-reset-btn:hover {
        color: #fff;
        border-color: #64748b;
    }

    /* NOTIFIKASI */
    .comment-alert {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 14px 18px;
        margin-bottom: 18px;
        background: rgba(34, 197, 94, 0.08);
        border: 1px solid rgba(34, 197, 94, 0.2);
        border-radius: 12px;
        color: #86efac;
        font-size: 13px;
    }

    /* TABEL KOMENTAR */
    .comment-table-card {
        overflow: hidden;
        background: #162033;
        border: 1px solid #29374e;
        border-radius: 18px;
    }

    .comment-table-scroll {
        overflow-x: auto;
    }

    .comment-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 850px;
    }

    .comment-table thead {
        background: #101a2b;
    }

    .comment-table th {
        padding: 16px 18px;
        color: #94a3b8;
        font-size: 11px;
        font-weight: 800;
        text-align: left;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }

    .comment-table td {
        padding: 17px 18px;
        border-top: 1px solid #29374e;
        vertical-align: middle;
    }

    .comment-table tbody tr {
        transition: 0.2s;
    }

    .comment-table tbody tr:hover {
        background: rgba(56, 189, 248, 0.04);
    }

    /* PENGGUNA */
    .comment-user {
        display: flex;
        align-items: center;
        gap: 11px;
        min-width: 160px;
    }

    .comment-avatar {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 43px;
        height: 43px;
        flex-shrink: 0;
        overflow: hidden;
        background: linear-gradient(135deg, #38bdf8, #818cf8);
        border: 2px solid rgba(56, 189, 248, 0.2);
        border-radius: 50%;
        color: #0f172a;
        font-size: 13px;
        font-weight: 800;
    }

    .comment-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .comment-username {
        max-width: 150px;
        overflow: hidden;
        color: #fff;
        font-size: 13px;
        font-weight: 700;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .comment-user-id {
        margin-top: 3px;
        color: #64748b;
        font-size: 11px;
    }

    /* ISI KOMENTAR */
    .comment-text {
        max-width: 270px;
        overflow: hidden;
        color: #cbd5e1;
        font-size: 12px;
        line-height: 1.7;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .comment-image-indicator {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        margin-top: 6px;
        color: #7dd3fc;
        font-size: 10px;
    }

    /* BUKU */
    .comment-book-title {
        max-width: 190px;
        overflow: hidden;
        color: #e2e8f0;
        font-size: 12px;
        font-weight: 700;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .comment-book-title i {
        color: #38bdf8;
        margin-right: 5px;
    }

    .comment-page-label {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        margin-top: 6px;
        color: #94a3b8;
        font-size: 11px;
    }

    .comment-date {
        color: #94a3b8;
        font-size: 11px;
        white-space: nowrap;
    }

    /* TOMBOL AKSI */
    .comment-actions {
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .comment-action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 9px 12px;
        border-radius: 9px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
        cursor: pointer;
        transition: 0.3s;
    }

    .comment-action-btn.detail {
        background: rgba(56, 189, 248, 0.1);
        border: 1px solid rgba(56, 189, 248, 0.25);
        color: #7dd3fc;
    }

    .comment-action-btn.detail:hover {
        background: rgba(56, 189, 248, 0.2);
        border-color: #38bdf8;
    }

    .comment-action-btn.delete {
        background: rgba(239, 68, 68, 0.08);
        border: 1px solid rgba(239, 68, 68, 0.2);
        color: #fca5a5;
    }

    .comment-action-btn.delete:hover {
        background: rgba(239, 68, 68, 0.16);
        border-color: #ef4444;
    }

    /* PAGINATION */
    .comment-pagination {
        padding: 20px;
        border-top: 1px solid #29374e;
    }

    .comment-pagination .pagination {
        justify-content: center;
        flex-wrap: wrap;
        gap: 5px;
        margin-bottom: 0;
    }

    .comment-pagination .page-link {
        background: #0f172a;
        border: 1px solid #334155;
        border-radius: 8px;
        color: #cbd5e1;
        font-size: 12px;
    }

    .comment-pagination .page-item.active .page-link {
        background: #38bdf8;
        border-color: #38bdf8;
        color: #082f49;
    }

    .comment-pagination .page-item.disabled .page-link {
        background: #111827;
        border-color: #29374e;
        color: #64748b;
    }

    /* EMPTY STATE */
    .comment-empty {
        padding: 60px 20px;
        text-align: center;
    }

    .comment-empty-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 70px;
        height: 70px;
        margin: 0 auto 15px;
        background: rgba(56, 189, 248, 0.1);
        border-radius: 20px;
        color: #38bdf8;
        font-size: 30px;
    }

    .comment-empty h3 {
        margin-bottom: 7px;
        color: #fff;
        font-size: 17px;
        font-weight: 800;
    }

    .comment-empty p {
        color: #94a3b8;
        font-size: 12px;
    }

    /* MODAL DETAIL */
    .comment-detail-modal .modal-content {
        background: #162033;
        border: 1px solid #334155;
        border-radius: 20px;
        color: #e2e8f0;
    }

    .comment-detail-modal .modal-header {
        padding: 20px 24px;
        background: #101a2b;
        border-bottom: 1px solid #29374e;
    }

    .comment-detail-modal .modal-title {
        color: #fff;
        font-size: 18px;
        font-weight: 800;
    }

    .comment-detail-modal .modal-body {
        padding: 24px;
    }

    .comment-detail-modal .modal-footer {
        padding: 15px 24px;
        border-top: 1px solid #29374e;
    }

    .comment-detail-modal .btn-close {
        filter: invert(1);
    }

    .comment-detail-user {
        display: flex;
        align-items: center;
        gap: 12px;
        padding-bottom: 18px;
        margin-bottom: 18px;
        border-bottom: 1px solid #29374e;
    }

    .comment-detail-username {
        color: #fff;
        font-size: 15px;
        font-weight: 800;
    }

    .comment-detail-meta {
        color: #94a3b8;
        font-size: 11px;
    }

    .comment-detail-info {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
        margin-bottom: 20px;
    }

    .comment-detail-info-card {
        padding: 13px;
        background: #0f172a;
        border: 1px solid #29374e;
        border-radius: 11px;
    }

    .comment-detail-info-label {
        margin-bottom: 5px;
        color: #94a3b8;
        font-size: 11px;
    }

    .comment-detail-info-value {
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        overflow-wrap: anywhere;
    }

    .comment-detail-section-title {
        margin-bottom: 10px;
        color: #e2e8f0;
        font-size: 12px;
        font-weight: 800;
    }

    .comment-detail-content {
        padding: 17px;
        margin-bottom: 20px;
        background: #0f172a;
        border: 1px solid #29374e;
        border-radius: 12px;
        color: #cbd5e1;
        font-size: 13px;
        line-height: 1.9;
        white-space: pre-wrap;
        overflow-wrap: anywhere;
    }

    .comment-detail-image {
        display: block;
        max-width: 100%;
        max-height: 350px;
        border: 1px solid #334155;
        border-radius: 12px;
        object-fit: contain;
    }

    /* RESPONSIVE */
    @media (max-width: 900px) {
        .comment-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 600px) {
        .comment-admin-header {
            padding: 20px;
        }

        .comment-admin-header h1 {
            font-size: 23px;
        }

        .comment-header-icon {
            display: none;
        }

        .comment-stats {
            grid-template-columns: 1fr;
        }

        .comment-toolbar {
            padding: 16px;
        }

        .comment-search-form {
            max-width: 100%;
        }

        .comment-search-btn {
            padding: 0 12px;
        }

        .comment-detail-info {
            grid-template-columns: 1fr;
        }

        .comment-detail-modal .modal-body {
            padding: 17px;
        }
    }
</style>

<div class="comment-admin">
    <!-- HEADER -->
    <div class="comment-admin-header">
        <div>
            <span class="comment-admin-eyebrow">
                <i class="fa-solid fa-shield-halved"></i>
                SAFAE COMMENT MANAGEMENT
            </span>
            <h1>Kelola <span>Komentar</span></h1>
            <p>Pantau komentar pembaca, lihat detail, dan kelola interaksi pada buku Safae.</p>
        </div>
        <div class="comment-header-icon">
            <i class="fa-solid fa-comments"></i>
        </div>
    </div>

    <!-- NOTIFIKASI -->
    @if(session('success'))
        <div class="comment-alert">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- STATISTIK -->
    <div class="comment-stats">
        <div class="comment-stat-card">
            <div class="comment-stat-icon blue">
                <i class="fa-solid fa-comments"></i>
            </div>
            <div>
                <div class="comment-stat-value">{{ number_format($totalKomentar) }}</div>
                <div class="comment-stat-label">Total Komentar</div>
            </div>
        </div>

        <div class="comment-stat-card">
            <div class="comment-stat-icon green">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <div class="comment-stat-value">{{ number_format($totalPengguna) }}</div>
                <div class="comment-stat-label">Pengguna Berkomentar</div>
            </div>
        </div>

        <div class="comment-stat-card">
            <div class="comment-stat-icon purple">
                <i class="fa-solid fa-list"></i>
            </div>
            <div>
                <div class="comment-stat-value">{{ number_format($komentar->total()) }}</div>
                <div class="comment-stat-label">Hasil Ditampilkan</div>
            </div>
        </div>
    </div>

    <!-- SEARCH -->
    <div class="comment-toolbar">
        <div>
            <h3 class="comment-toolbar-title">Daftar Komentar</h3>
            <p class="comment-toolbar-desc">Cari berdasarkan username pengguna dan lihat detail komentar.</p>
        </div>

        <form action="{{ route('admin.komentar.index') }}" method="GET" class="comment-search-form">
            <div class="comment-search-box">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari username pengguna...">
            </div>
            <button type="submit" class="comment-search-btn">
                <i class="fa-solid fa-search"></i> Cari
            </button>
            @if($search !== '')
                <a href="{{ route('admin.komentar.index') }}" class="comment-reset-btn" title="Reset Pencarian">
                    <i class="fa-solid fa-xmark"></i>
                </a>
            @endif
        </form>
    </div>

    <!-- TABEL -->
    <div class="comment-table-card">
        <div class="comment-table-scroll">
            <table class="comment-table">
                <thead>
                    <tr>
                        <th>Pengguna</th>
                        <th>Isi Komentar</th>
                        <th>Lokasi Bacaan</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($komentar as $k)
                        @php
                            $username = $k->user?->username ?? $k->username ?? 'Pengguna';
                            $initials = mb_strtoupper(mb_substr($username, 0, 2));
                            $foto = $k->user?->foto_profil ?: $k->user?->profile_image;
                            $fotoPath = $foto ? preg_replace('#^(public/|storage/)+#', '', $foto) : null;
                            $gambarPath = $k->image_path ? preg_replace('#^(public/|storage/)+#', '', $k->image_path) : null;
                        @endphp
                        <tr>
                            <!-- USER -->
                            <td>
                                <div class="comment-user">
                                    <div class="comment-avatar">
                                        @if($fotoPath)
                                            <img src="{{ asset('storage/'.$fotoPath) }}" alt="Foto {{ $username }}">
                                        @else
                                            {{ $initials }}
                                        @endif
                                    </div>
                                    <div>
                                        <div class="comment-username" title="{{ $username }}">{{ $username }}</div>
                                        <div class="comment-user-id">ID #{{ $k->user_id }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- KOMENTAR -->
                            <td>
                                <div class="comment-text" title="{{ $k->komentar }}">
                                    {{ $k->komentar }}
                                </div>
                                @if($gambarPath)
                                    <span class="comment-image-indicator">
                                        <i class="fa-regular fa-image"></i> Ada Lampiran
                                    </span>
                                @endif
                            </td>

                            <!-- BUKU -->
                            <td>
                                <div class="comment-book-title" title="{{ $k->book?->title ?? 'Buku tidak ditemukan' }}">
                                    <i class="fa-solid fa-book"></i>
                                    {{ $k->book?->title ?? 'Buku tidak ditemukan' }}
                                </div>
                                <span class="comment-page-label">
                                    <i class="fa-solid fa-bookmark"></i>
                                    Halaman {{ $k->page }}
                                </span>
                            </td>

                            <!-- TANGGAL -->
                            <td>
                                <div class="comment-date">
                                    {{ $k->created_at?->format('d M Y') ?? '-' }}
                                </div>
                                <div class="comment-user-id">
                                    {{ $k->created_at?->format('H:i') ?? '-' }}
                                </div>
                            </td>

                            <!-- AKSI -->
                            <td>
                                <div class="comment-actions">
                                    <button type="button" class="comment-action-btn detail" data-bs-toggle="modal" data-bs-target="#detailKomentar{{ $k->id }}">
                                        <i class="fa-solid fa-eye"></i> Detail
                                    </button>
                                    <form action="{{ route('admin.komentar.hapus', $k->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus komentar ini secara permanen?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="comment-action-btn delete">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="comment-empty">
                                    <div class="comment-empty-icon">
                                        <i class="fa-regular fa-comments"></i>
                                    </div>
                                    <h3>{{ $search !== '' ? 'Pengguna Tidak Ditemukan' : 'Belum Ada Komentar' }}</h3>
                                    <p>
                                        {{ $search !== '' ? 'Tidak ada komentar dari pengguna dengan username tersebut.' : 'Belum ada komentar yang masuk ke Safae.' }}
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        @if($komentar->hasPages())
            <div class="comment-pagination">
                {{ $komentar->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

    <!-- MODAL DETAIL KOMENTAR -->
    @foreach($komentar as $k)
        @php
            $username = $k->user?->username ?? $k->username ?? 'Pengguna';
            $initials = mb_strtoupper(mb_substr($username, 0, 2));
            $foto = $k->user?->foto_profil ?: $k->user?->profile_image;
            $fotoPath = $foto ? preg_replace('#^(public/|storage/)+#', '', $foto) : null;
            $gambarPath = $k->image_path ? preg_replace('#^(public/|storage/)+#', '', $k->image_path) : null;
        @endphp

        <div class="modal fade comment-detail-modal" id="detailKomentar{{ $k->id }}" tabindex="-1" aria-labelledby="detailKomentarLabel{{ $k->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailKomentarLabel{{ $k->id }}">
                            <i class="fa-solid fa-comment-dots me-2" style="color:#38bdf8;"></i>
                            Detail Komentar
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>

                    <div class="modal-body">
                        <!-- PROFIL PENGGUNA -->
                        <div class="comment-detail-user">
                            <div class="comment-avatar" style="width:52px;height:52px;">
                                @if($fotoPath)
                                    <img src="{{ asset('storage/'.$fotoPath) }}" alt="Foto {{ $username }}">
                                @else
                                    {{ $initials }}
                                @endif
                            </div>
                            <div>
                                <div class="comment-detail-username">{{ $username }}</div>
                                <div class="comment-detail-meta">
                                    ID Pengguna: {{ $k->user_id }}
                                </div>
                            </div>
                        </div>

                        <!-- INFORMASI -->
                        <div class="comment-detail-info">
                            <div class="comment-detail-info-card">
                                <div class="comment-detail-info-label">
                                    <i class="fa-solid fa-book me-1"></i> Judul Buku
                                </div>
                                <div class="comment-detail-info-value">
                                    {{ $k->book?->title ?? 'Buku tidak ditemukan' }}
                                </div>
                            </div>

                            <div class="comment-detail-info-card">
                                <div class="comment-detail-info-label">
                                    <i class="fa-solid fa-bookmark me-1"></i> Halaman Bacaan
                                </div>
                                <div class="comment-detail-info-value">
                                    Halaman {{ $k->page }}
                                </div>
                            </div>

                            <div class="comment-detail-info-card">
                                <div class="comment-detail-info-label">
                                    <i class="fa-regular fa-calendar me-1"></i> Tanggal Komentar
                                </div>
                                <div class="comment-detail-info-value">
                                    {{ $k->created_at?->format('d M Y, H:i') ?? '-' }}
                                </div>
                            </div>

                            <div class="comment-detail-info-card">
                                <div class="comment-detail-info-label">
                                    <i class="fa-solid fa-hashtag me-1"></i> ID Komentar
                                </div>
                                <div class="comment-detail-info-value">
                                    #{{ $k->id }}
                                </div>
                            </div>
                        </div>

                        <!-- ISI KOMENTAR LENGKAP -->
                        <div class="comment-detail-section-title">
                            <i class="fa-solid fa-align-left me-1" style="color:#38bdf8;"></i>
                            Isi Komentar
                        </div>
                        <div class="comment-detail-content">{{ $k->komentar }}</div>

                        <!-- GAMBAR KOMENTAR -->
                        @if($gambarPath)
                            <div class="comment-detail-section-title">
                                <i class="fa-regular fa-image me-1" style="color:#38bdf8;"></i>
                                Gambar Lampiran
                            </div>
                            <img src="{{ asset('storage/'.$gambarPath) }}" class="comment-detail-image" alt="Gambar Komentar">
                        @endif
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="comment-action-btn detail" data-bs-dismiss="modal">
                            <i class="fa-solid fa-xmark"></i> Tutup
                        </button>
                        <form action="{{ route('admin.komentar.hapus', $k->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus komentar ini secara permanen?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="comment-action-btn delete">
                                <i class="fa-solid fa-trash"></i> Hapus Komentar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
