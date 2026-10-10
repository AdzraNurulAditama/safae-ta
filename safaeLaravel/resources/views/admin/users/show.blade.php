@extends('layouts.layoutsAdmin')

@section('title', 'Detail User - ' . $user->username)

@push('styles')
    <style>
        /* ================= PREMIUM OBSIDIAN PROFILE STYLES ================= */
        .profile-wrapper {
            background: transparent;
            color: var(--text);
            padding: 10px 0;
        }

        /* Container Profil Utama */
        .profile-container-premium {
            background: var(--sidebar-bg);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            position: relative;
            overflow: hidden;
        }

        /* Garis Aksen Teknologi Atas */
        .profile-container-premium::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--accent), transparent);
        }

        /* Sektor Avatar & Identitas Atas */
        .avatar-display-zone {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding-bottom: 30px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            margin-bottom: 30px;
        }

        .avatar-display-zone img {
            width: 130px;
            height: 130px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
        }

        .avatar-display-placeholder {
            width: 130px;
            height: 130px;
            background: rgba(6, 182, 212, 0.05);
            border: 2px solid rgba(6, 182, 212, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            box-shadow: 0 10px 25px rgba(6, 182, 212, 0.1);
        }

        /* Kotak Grid Informasi */
        .info-node-box {
            background: rgba(11, 15, 25, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.03);
            border-radius: 12px;
            padding: 20px 24px;
            height: 100%;
        }

        .info-node-box small {
            display: block;
            color: var(--muted);
            font-size: 0.72rem;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.8px;
            margin-bottom: 6px;
        }

        .info-node-box h6 {
            color: #fff;
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0;
        }

        /* Badge Status Premium */
        .status-badge-active {
            background: rgba(16, 185, 129, 0.06);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.15);
            font-size: 0.72rem;
            font-weight: 700;
            padding: 5px 14px;
            border-radius: 6px;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            display: inline-block;
        }

        /* Tombol Batal / Kembali */
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
    </style>
@endpush

@section('content')
<div class="container-fluid px-0 profile-wrapper" style="max-width: 900px;">

    {{-- ================= ATAS: UTAMA NAVIGATION BARIS ================= --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="font-size: 0.8rem;">
                    <li class="breadcrumb-item"><a href="{{ url('/admin') }}" style="color: var(--muted); text-decoration: none;">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/users') }}" style="color: var(--muted); text-decoration: none;">Kelola User</a></li>
                    <li class="breadcrumb-item active text-truncate" style="max-width: 200px; color: var(--primary);" aria-current="page">Detail</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary text-white border-secondary btn-back-console">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    {{-- ================= UTAMA INTEGRATED PROFILE CONTAINER ================= --}}
    <div class="profile-container-premium">
        
        {{-- BLOK UTAMA AVATAR & AKUN INDEKS --}}
        <div class="avatar-display-zone">
            @if($user->foto_profil)
                <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="Foto Profil">
            @else
                <div class="avatar-display-placeholder">
                    <i class="fas fa-user fa-3x"></i>
                </div>
            @endif

            <h3 class="fw-bold text-white mt-3 mb-1" style="letter-spacing: -0.5px;">{{ $user->username }}</h3>
            <p class="text-muted mb-0" style="font-size: 0.95rem;">{{ $user->email }}</p>
        </div>

        {{-- METADATA GRID PARAMETER --}}
        <div class="row g-4 mb-5">
            <div class="col-md-6">
                <div class="info-node-box">
                    <small><i class="fas fa-id-badge text-primary me-1"></i> User ID</small>
                    <h6 class="font-monospace text-info">#{{ $user->id }}</h6>
                </div>
            </div>

            <div class="col-md-6">
                <div class="info-node-box">
                    <small><i class="fas fa-shield-alt text-success me-1"></i> Status Sistem</small>
                    <div class="mt-1">
                        <span class="status-badge-active">Aktif</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- PANEL TOMBOL AKSI MANAJEMEN DATA --}}
        <div class="pt-4 border-top d-flex justify-content-end gap-2" style="border-color: var(--border) !important;">
            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm px-4 py-2 fw-bold text-dark rounded-3">
                <i class="fas fa-edit me-2"></i> Edit User
            </a>

            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Sistem Fatal: Anda yakin ingin menghapus akun user ini secara permanen?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-outline-danger px-4 py-2 fw-bold rounded-3" style="color: #fca5a5; border-color: rgba(239, 68, 68, 0.4);">
                    <i class="fas fa-trash-alt me-2"></i> Hapus Akun
                </button>
            </form>
        </div>

    </div>

</div>
@endsection