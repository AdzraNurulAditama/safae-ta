@extends('layouts.layoutsAdmin')

@section('title', 'Kelola Reward')

@push('styles')
    <style>
        /* ================= PREMIUM HIGH-END CONSOLE DESIGN ================= */
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
        .reward-list-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* Row Card Baris Utama */
        .reward-row-card {
            display: flex;
            align-items: center;
            background: var(--sidebar-bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 14px 24px;
            transition: all 0.2s ease-in-out;
        }
        .reward-row-card:hover {
            border-color: rgba(6, 182, 212, 0.3);
            background: rgba(17, 24, 39, 0.6);
            transform: translateY(-1px);
        }

        /* Pembagian Lebar Kolom Flexbox Semuanya Simetris */
        .col-reward-user { flex: 2; display: flex; align-items: center; gap: 14px; min-width: 0; }
        .col-reward-points { flex: 0.8; display: flex; align-items: center; }
        .col-reward-actions { flex: 2.2; display: flex; justify-content: flex-end; align-items: center; gap: 12px; }

        /* Sizing Akurat Foto Profil User (Mencegah Kebesaran) */
        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid var(--border);
            flex-shrink: 0;
        }

        /* Badge Informasi Total Poin */
        .points-display-badge {
            background: rgba(6, 182, 212, 0.05);
            border: 1px solid rgba(6, 182, 212, 0.15);
            color: var(--primary);
            font-family: var(--font-mono, monospace);
            font-weight: 700;
            font-size: 1rem;
            padding: 6px 14px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        /* Form Input Baris Satuan Terpadu */
        .console-input-group {
            display: flex;
            align-items: center;
            background: rgba(11, 15, 25, 0.5);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 2px 2px 2px 12px;
            transition: border-color 0.2s;
            width: 220px;
        }
        .console-input-group:focus-within {
            border-color: rgba(6, 182, 212, 0.4);
        }

        /* Pembersihan Input Angka */
        .input-points-clean {
            background: transparent !important;
            border: none !important;
            color: #fff !important;
            font-family: var(--font-mono, monospace);
            font-size: 0.85rem;
            width: 100%;
            padding: 6px 8px 6px 0 !important;
            box-shadow: none !important;
        }
        .input-points-clean::placeholder {
            color: rgba(255, 255, 255, 0.2);
        }
        .input-points-clean::-webkit-outer-spin-button,
        .input-points-clean::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Tombol Operasi Minimalis Presisi */
        .btn-console-action {
            font-weight: 700;
            font-size: 0.75rem;
            padding: 6px 12px;
            border-radius: 6px;
            border: none;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            height: 28px;
            cursor: pointer;
        }

        .btn-console-add {
            background: rgba(16, 185, 129, 0.12);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }
        .btn-console-add:hover {
            background: #10b981;
            color: #0b0f19;
        }

        .btn-console-remove {
            background: rgba(239, 68, 68, 0.12);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }
        .btn-console-remove:hover {
            background: #ef4444;
            color: #fff;
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
            .reward-row-card { flex-direction: column; align-items: flex-start; gap: 14px; padding: 20px; }
            .col-reward-user, .col-reward-points, .col-reward-actions { width: 100%; }
            .col-reward-actions { justify-content: flex-start; flex-wrap: wrap; }
            .console-input-group { width: 100%; max-width: 260px; }
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
                <li class="breadcrumb-item active" style="color: var(--primary);" aria-current="page">Kelola Reward</li>
            </ol>
        </nav>
        <h2 class="fw-bold text-white m-0" style="font-size: 1.8rem; letter-spacing: -0.5px;">Kelola Reward User</h2>
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
        <div class="col-reward-user">Pengguna</div>
        <div class="col-reward-points">Total Poin</div>
        <div class="col-reward-actions">Modifikasi Poin</div>
    </div>

    {{-- ================= MAIN LIST CONTAINER ================= --}}
    <div class="reward-list-container">
        @forelse($users as $user)
            <div class="reward-row-card shadow-sm">
                
                {{-- KOLOM 1: INFO PENGGUNA --}}
                <div class="col-reward-user">
                    @if($user && !empty($user->foto_profil))
                        <img src="{{ asset('storage/' . $user->foto_profil) }}" class="user-avatar" alt="Profile">
                    @elseif($user && !empty($user->profile_image))
                        <img src="{{ asset('storage/' . $user->profile_image) }}" class="user-avatar" alt="Profile">
                    @else
                        <div class="rounded-circle d-flex align-items-center justify-content-center text-primary"
                            style="width: 36px; height: 36px; background: rgba(6, 182, 212, 0.05); border: 1px solid rgba(6, 182, 212, 0.12); flex-shrink: 0;">
                            <i class="fas fa-user-tag"></i>
                        </div>
                    @endif
                    <div class="text-truncate">
                        <div class="fw-bold text-white mb-0" style="font-size: 0.95rem;">{{ $user->username }}</div>
                        <span class="text-muted small d-block text-truncate" style="font-size: 0.8rem; max-width: 250px;">{{ $user->email }}</span>
                    </div>
                </div>

                {{-- KOLOM 2: TOTAL POIN SEKARANG --}}
                <div class="col-reward-points">
                    <div class="points-display-badge">
                        <i class="fas fa-coins opacity-60" style="font-size: 0.85rem;"></i>
                        <span>{{ $user->points ?? 0 }}</span>
                    </div>
                </div>

                {{-- KOLOM 3: SUB-PANEL DUA FORM AKSI HORIZONTAL SEJAJAR --}}
                <div class="col-reward-actions">
                    
                    {{-- FORM 1: OPERASI TAMBAH POIN --}}
                    <form action="{{ route('admin.reward.add', $user) }}" method="POST" class="m-0">
                        @csrf
                        <div class="console-input-group">
                            <i class="fas fa-plus text-success opacity-50 me-2" style="font-size: 0.75rem;"></i>
                            <input type="number" name="points" placeholder="Jumlah..." class="form-control input-points-clean" required min="1">
                            <button type="submit" class="btn-console-action btn-console-add me-1">
                                Tambah
                            </button>
                        </div>
                    </form>

                    {{-- FORM 2: OPERASI KURANG POIN --}}
                    <form action="{{ route('admin.reward.remove', $user) }}" method="POST" class="m-0">
                        @csrf
                        <div class="console-input-group">
                            <i class="fas fa-minus text-danger opacity-50 me-2" style="font-size: 0.75rem;"></i>
                            <input type="number" name="points" placeholder="Jumlah..." class="form-control input-points-clean" required min="1">
                            <button type="submit" class="btn-console-action btn-console-remove me-1">
                                Kurangi
                            </button>
                        </div>
                    </form>

                </div>

            </div>
        @empty
            {{-- TAMPILAN JIKA DATA USER KOSONG --}}
            <div class="text-center py-5" style="background: var(--sidebar-bg); border: 1px dashed var(--border); border-radius: 12px;">
                <div class="py-4 opacity-50">
                    <i class="fas fa-users-slash fa-2x mb-3 text-secondary"></i>
                    <div class="small fw-semibold text-muted">Belum ada data pengguna yang terdaftar.</div>
                </div>
            </div>
        @endforelse
    </div>

</div>
@endsection