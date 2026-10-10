@extends('layouts.layoutsAdmin')

@section('title', 'Edit User - ' . $user->username)

@push('styles')
    <style>
        /* ================= PREMIUM OBSIDIAN FORM STYLES ================= */
        .edit-user-wrapper {
            background: transparent;
            color: var(--text);
            padding: 10px 0;
        }

        /* Container Form Utama */
        .form-container-premium {
            background: var(--sidebar-bg);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 40px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        /* Garis Aksen di Atas Form */
        .form-container-premium::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--accent), transparent);
        }

        /* Area Foto Profil Header */
        .avatar-edit-zone {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding-bottom: 30px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            margin-bottom: 35px;
        }

        .avatar-edit-zone img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
        }

        .avatar-edit-placeholder {
            width: 120px;
            height: 120px;
            background: rgba(6, 182, 212, 0.05);
            border: 2px solid rgba(6, 182, 212, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            box-shadow: 0 10px 25px rgba(6, 182, 212, 0.1);
        }

        /* Desain Input dan Label Form */
        .form-label {
            color: var(--muted);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 10px;
        }

        .form-control, .form-select {
            background-color: rgba(11, 15, 25, 0.5) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            color: var(--text) !important;
            border-radius: 10px !important;
            padding: 12px 18px !important;
            font-size: 0.95rem;
            transition: all 0.3s ease !important;
        }

        .form-control:focus, .form-select:focus {
            border-color: rgba(6, 182, 212, 0.6) !important;
            box-shadow: 0 0 15px rgba(6, 182, 212, 0.15) !important;
            background-color: rgba(11, 15, 25, 0.8) !important;
        }

        /* Desain Input Non-Aktif (Disabled) */
        .form-control:disabled {
            background-color: rgba(0, 0, 0, 0.25) !important;
            border-color: rgba(255, 255, 255, 0.03) !important;
            color: var(--muted) !important;
            cursor: not-allowed;
            opacity: 0.7;
        }

        /* ================= CUSTOM FILE UPLOAD COMPONENT ================= */
        .premium-upload-container {
            display: flex;
            align-items: center;
            gap: 16px;
            background-color: rgba(11, 15, 25, 0.3);
            border: 1px dashed rgba(255, 255, 255, 0.12);
            border-radius: 12px;
            padding: 14px;
            transition: all 0.2s ease;
        }
        .premium-upload-container:hover {
            border-color: rgba(6, 182, 212, 0.4);
            background-color: rgba(11, 15, 25, 0.5);
        }

        /* Thumbnail Mini di dalam Input */
        .upload-preview-box {
            width: 54px;
            height: 54px;
            border-radius: 8px;
            overflow: hidden;
            flex-shrink: 0;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .upload-preview-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .upload-preview-box i {
            color: var(--muted);
            font-size: 1.2rem;
        }

        /* Tombol Upload Tiruan */
        .btn-fake-upload {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }
        .btn-fake-upload:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.2);
        }

        /* Alert Error */
        .alert-premium-danger {
            background: rgba(239, 68, 68, 0.06);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #fca5a5;
            border-radius: 10px;
            padding: 16px 20px;
        }

        .form-text, .text-muted {
            color: var(--muted) !important;
            font-size: 0.75rem;
            margin-top: 6px;
        }

        /* Tombol Aksi */
        .btn-submit-premium {
            background: var(--primary);
            color: #0b0f19;
            font-weight: 700;
            font-size: 0.95rem;
            padding: 12px 28px;
            border-radius: 10px;
            border: none;
            transition: all 0.25s ease;
        }

        .btn-submit-premium:hover {
            background: #22d3ee;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(6, 182, 212, 0.25);
        }

        .btn-cancel-premium {
            font-size: 0.95rem;
            font-weight: 600;
            padding: 12px 24px;
            border-radius: 10px;
            transition: all 0.25s ease;
        }

        .btn-cancel-premium:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #fff !important;
        }
    </style>
@endpush

@section('content')
<div class="container-fluid px-0 edit-user-wrapper" style="max-width: 900px;">

    {{-- ================= NAVIGASI BREADCRUMB ================= --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="font-size: 0.8rem;">
                    <li class="breadcrumb-item"><a href="{{ url('/admin') }}" style="color: var(--muted); text-decoration: none;">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/users') }}" style="color: var(--muted); text-decoration: none;">Kelola User</a></li>
                    <li class="breadcrumb-item active text-truncate" style="max-width: 200px; color: var(--primary);" aria-current="page">Edit: {{ $user->username }}</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary text-white border-secondary px-3 rounded-2 fw-semibold">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    {{-- ================= VALIDASI ERROR ================= --}}
    @if ($errors->any())
        <div class="alert alert-premium-danger mb-4 shadow-sm">
            <div class="fw-bold small mb-2 d-flex align-items-center gap-2">
                <i class="fas fa-exclamation-circle text-danger fs-5"></i> 
                Ada beberapa kesalahan pengisian data:
            </div>
            <ul class="mb-0 ps-3 small opacity-90">
                @foreach ($errors->all() as $error)
                    <li class="mb-1">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ================= FORM PANEL UTAMA ================= --}}
    <div class="form-container-premium">
        
        {{-- HEADER IDENTITAS USER --}}
        <div class="avatar-edit-zone">
            @if ($user->foto_profil)
                <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="{{ $user->username }}" id="main-avatar-preview">
            @else
                <div class="avatar-edit-placeholder" id="main-avatar-placeholder">
                    <i class="fas fa-user fa-3x"></i>
                </div>
            @endif

            <h4 class="fw-bold text-white mt-3 mb-1" style="letter-spacing: -0.5px;">{{ $user->username }}</h4>
            <small class="text-muted">ID User: #{{ $user->id }}</small>
        </div>

        {{-- FORM INPUT DATA --}}
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-4">
                {{-- INPUT USERNAME --}}
                <div class="col-md-6">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" 
                           id="username"
                           name="username" 
                           class="form-control @error('username') is-invalid @enderror" 
                           value="{{ old('username', $user->username) }}" 
                           required>
                    @error('username')
                        <div class="invalid-feedback small mt-2">{{ $message }}</div>
                    @enderror
                </div>

                {{-- INPUT EMAIL (READ-ONLY) --}}
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                    <div class="form-text">Alamat email tidak dapat diubah.</div>
                </div>

                {{-- DROPDOWN ROLE --}}
                <div class="col-md-6">
                    <label for="role" class="form-label">Role</label>
                    <select id="role" name="role" class="form-select @error('role') is-invalid @enderror" required>
                        <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback small mt-2">{{ $message }}</div>
                    @enderror
                </div>

                {{-- INPUT FILE FOTO PROFIL CUSTOM --}}
                <div class="col-md-6">
                    <label class="form-label">Foto Profil</label>
                    
                    <div class="premium-upload-container">
                        <div class="upload-preview-box" id="mini-preview-container">
                            @if ($user->foto_profil)
                                <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="Preview" id="mini-preview-img">
                            @else
                                <i class="fas fa-image" id="mini-preview-icon"></i>
                            @endif
                        </div>
                        
                        <div>
                            <label for="foto_profil" class="btn-fake-upload">
                                <i class="fas fa-cloud-upload-alt"></i> Pilih Foto Baru
                            </label>
                            <input type="file" 
                                   id="foto_profil"
                                   name="foto_profil" 
                                   class="d-none @error('foto_profil') is-invalid @enderror" 
                                   accept="image/*"
                                   onchange="previewImage(this)">
                            <div class="form-text text-muted mb-0">Format JPG / PNG, maksimal 2MB.</div>
                        </div>
                    </div>

                    @error('foto_profil')
                        <div class="text-danger small mt-2" style="font-size: 0.8rem;">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- TOMBOL AKSI --}}
            <div class="mt-5 pt-4 border-top d-flex justify-content-end align-items-center gap-2" style="border-color: var(--border) !important;">
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary text-white border-secondary btn-cancel-premium">
                    Batal
                </a>
                
                <button type="submit" class="btn-submit-premium shadow-sm">
                    <i class="fas fa-save me-2"></i> Simpan Perubahan
                </button>
            </div>

        </form>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // Fungsi realtime preview gambar saat file dipilih
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                // 1. Update preview mini di dalam kotak upload
                var miniContainer = document.getElementById('mini-preview-container');
                miniContainer.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                
                // 2. Update preview besar di bagian atas (header profil) jika ada elemen img
                var mainImg = document.getElementById('main-avatar-preview');
                if (mainImg) {
                    mainImg.src = e.target.result;
                } else {
                    // Jika sebelumnya pakai placeholder ikon, ganti jadi tag img
                    var placeholder = document.getElementById('main-avatar-placeholder');
                    if (placeholder) {
                        placeholder.outerHTML = `<img src="${e.target.result}" alt="Foto Profil" id="main-avatar-preview">`;
                    }
                }
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    document.getElementById('toggleBtn')?.addEventListener('click', function() {
        document.getElementById('adminSidebar')?.classList.toggle('show');
    });
</script>
@endpush