@extends('layouts.layoutsAdmin')

@section('title', 'Kelola User')

@push('styles')
    <style>
        /* ================= PREMIUM SaaS OBSIDIAN DESIGN ================= */
        .page-wrapper {
            background: transparent;
            color: var(--text);
            padding: 10px 0;
        }

        /* Toolbar Kontrol Atas */
        .console-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        /* Search Bar Minimalis Tanpa Border Tebal */
        .search-wrapper {
            position: relative;
            width: 100%;
            max-width: 320px;
        }
        .search-wrapper i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: 0.9rem;
        }
        .search-input-premium {
            background: var(--sidebar-bg) !important;
            border: 1px solid var(--border) !important;
            color: var(--text) !important;
            padding: 12px 16px 12px 42px !important;
            border-radius: 10px !important;
            font-size: 0.9rem;
            width: 100%;
            transition: all 0.2s ease;
        }
        .search-input-premium:focus {
            border-color: rgba(6, 182, 212, 0.4) !important;
            box-shadow: 0 0 15px rgba(6, 182, 212, 0.08) !important;
            outline: none;
        }

        /* Header Kolom (Pengganti th) */
        .list-header-labels {
            display: flex;
            padding: 0 24px 12px;
            color: var(--muted);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
        }

        /* Wrapper List Data */
        .user-list-container {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        /* Baris Pengguna Bergaya Card Grid */
        .user-row-card {
            display: flex;
            align-items: center;
            background: var(--sidebar-bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 18px 24px;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .user-row-card:hover {
            border-color: rgba(6, 182, 212, 0.25);
            background: rgba(17, 24, 39, 0.7);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        /* Pengaturan Lebar Kolom Flexbox */
        .col-user-profile { flex: 2; display: flex; align-items: center; gap: 16px; }
        .col-user-email { flex: 2; color: #94a3b8; font-size: 0.9rem; }
        .col-user-status { flex: 1; }
        .col-user-action { flex: 0 0 50px; text-align: right; }

        /* Foto Profil Lingkaran Bersih */
        .avatar-box img {
            width: 44px;
            height: 44px;
            object-fit: cover;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .avatar-placeholder {
            width: 44px;
            height: 44px;
            background: rgba(6, 182, 212, 0.06);
            border: 1px solid rgba(6, 182, 212, 0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
        }

        /* Badge Status */
        .status-badge-active {
            background: rgba(16, 185, 129, 0.06);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.15);
            font-size: 0.72rem;
            font-weight: 700;
            padding: 5px 12px;
            border-radius: 6px;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            display: inline-block;
        }

        /* Tombol Tiga Titik Aksi */
        .btn-action-more {
            background: rgba(11, 15, 25, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.05);
            color: var(--muted);
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }
        .btn-action-more:hover, .btn-action-more:focus {
            background: rgba(11, 15, 25, 0.8);
            border-color: rgba(255, 255, 255, 0.15);
            color: #fff;
        }

        /* Dropdown Menu Gelap Premium */
        .dropdown-premium-menu {
            background: var(--sidebar-bg) !important;
            border: 1px solid var(--border) !important;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5) !important;
            border-radius: 10px !important;
            padding: 6px !important;
        }
        .dropdown-premium-menu .dropdown-item {
            color: #cbd5e1 !important;
            font-size: 0.85rem;
            padding: 10px 16px;
            border-radius: 6px;
            transition: all 0.2s;
        }
        .dropdown-premium-menu .dropdown-item:hover {
            background: rgba(255, 255, 255, 0.04) !important;
            color: #fff !important;
        }
        .dropdown-premium-menu .dropdown-divider {
            border-color: var(--border) !important;
            margin: 6px 0;
        }

        /* Tombol Tambah User */
        .btn-add-premium {
            background: var(--primary);
            color: #0b0f19;
            font-weight: 700;
            font-size: 0.9rem;
            padding: 12px 24px;
            border-radius: 8px;
            border: none;
            transition: all 0.25s ease;
        }
        .btn-add-premium:hover {
            background: #22d3ee;
            box-shadow: 0 4px 15px rgba(6, 182, 212, 0.25);
            transform: translateY(-1px);
        }

        /* Responsif Seluler */
        @media (max-width: 768px) {
            .console-toolbar { flex-direction: column; align-items: stretch; gap: 15px; }
            .search-wrapper { max-width: 100%; }
            .list-header-labels { display: none; }
            .user-row-card { flex-direction: column; align-items: flex-start; gap: 12px; padding: 20px; }
            .col-user-action { align-self: flex-end; margin-top: -30px; }
        }
    </style>
@endpush

@section('content')
<div class="container-fluid px-0 page-wrapper" style="max-width: 1300px;">

    {{-- ================= ATAS: UTAMA HEADER SECTION ================= --}}
    <div class="mb-4">
        <h2 class="fw-bold text-white mb-1" style="font-size: 1.8rem; letter-spacing: -0.5px;">Kelola User</h2>
        <p class="text-muted mb-0" style="font-size: 0.9rem;">Manajemen data akun dan hak akses pengguna sistem</p>
    </div>

    {{-- ================= NOTIFIKASI SUKSES SISTEM ================= --}}
    @if(session('success'))
        <div class="alert rounded-3 mb-4 py-3 px-4 small d-flex align-items-center gap-2" style="background: rgba(16, 185, 129, 0.06); border: 1px solid rgba(16, 185, 129, 0.15); color: #a7f3d0;">
            <i class="fas fa-check-circle text-success fs-5"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    {{-- ================= TOOLBAR AKSI (SEARCH & ADD BUTTON) ================= --}}
    <div class="console-toolbar">
        <div class="search-wrapper">
            <i class="fas fa-search"></i>
            <input type="text" class="search-input-premium" placeholder="Cari nama, email, atau ID user...">
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-add-premium d-flex align-items-center gap-2 shadow-sm">
            <i class="fas fa-user-plus"></i> Tambah User
        </a>
    </div>

    {{-- ================= LABEL HEADER SUB-KOLOM ================= --}}
    <div class="list-header-labels">
        <div class="col-user-profile">Pengguna</div>
        <div class="col-user-email">Alamat Email</div>
        <div class="col-user-status">Status Sistem</div>
        <div class="col-user-action"></div>
    </div>

    {{-- ================= MAIN LIST CONTAINER ================= --}}
    <div class="user-list-container">
        @forelse($users as $user)
            <div class="user-row-card shadow-sm">
                
                {{-- KOLOM PROFIL & ID --}}
                <div class="col-user-profile">
                    @if($user->foto_profil)
                        <div class="avatar-box">
                            <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="{{ $user->username }}">
                        </div>
                    @else
                        <div class="avatar-placeholder">
                            <i class="fas fa-user" style="font-size: 0.85rem;"></i>
                        </div>
                    @endif
                    <div>
                        <div class="fw-bold text-white mb-0" style="font-size: 0.95rem;">{{ $user->username }}</div>
                        <span class="text-muted font-monospace" style="font-size: 0.72rem; opacity: 0.75;">ID #{{ $user->id }}</span>
                    </div>
                </div>

                {{-- KOLOM EMAIL --}}
                <div class="col-user-email">
                    {{ $user->email }}
                </div>

                {{-- KOLOM STATUS --}}
                <div class="col-user-status">
                    <span class="status-badge-active">Aktif</span>
                </div>

                {{-- KOLOM AKSI (DROPDOWN) --}}
                <div class="col-user-action">
                    <div class="dropdown">
                        <button class="btn btn-action-more" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-h"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-premium-menu shadow-sm py-1">
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('admin.users.show', $user->id) }}">
                                    <i class="fas fa-eye text-info" style="width: 14px;"></i> Detail
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('admin.users.edit', $user->id) }}">
                                    <i class="fas fa-edit text-warning" style="width: 14px;"></i> Edit
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="dropdown-item text-danger d-flex align-items-center gap-2">
                                        <i class="fas fa-trash-alt" style="width: 14px;"></i> Hapus
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        @empty
            {{-- DATA KOSONG TEMPLATE --}}
            <div class="text-center py-5 background-clean" style="background: var(--sidebar-bg); border: 1px dashed var(--border); border-radius: 12px;">
                <div class="py-4 opacity-50">
                    <i class="fas fa-users-slash fa-2.5x mb-3 text-secondary"></i>
                    <div class="small fw-semibold text-muted">Belum ada entitas pengguna yang terdaftar.</div>
                </div>
            </div>
        @endforelse
    </div>

</div>
@endsection