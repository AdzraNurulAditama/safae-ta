@extends('layouts.app')

@section('title', 'Edit Profil - Safae')

@section('content')

<style>
    .edit-profile-wrapper {
        max-width: 900px;
        margin: 0 auto;
        padding: 20px 0 50px 0;
        color: #f1f5f9;
    }

    .edit-profile-card {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 24px;
        padding: 35px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
    }

    .form-dark-control {
        background: #0f172a;
        border: 1px solid #334155;
        color: #f8fafc;
        border-radius: 12px;
        padding: 12px 16px;
    }

    .form-dark-control:focus {
        background: #0f172a;
        border-color: #38bdf8;
        color: white;
        box-shadow: 0 0 0 0.25rem rgba(56, 189, 248, 0.15);
    }

    .avatar-preview-img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #38bdf8;
    }

    .btn-save-profile {
        background: #38bdf8;
        color: #0f172a;
        font-weight: 700;
        border: none;
        padding: 12px 28px;
        border-radius: 12px;
        transition: 0.2s;
    }

    .btn-save-profile:hover {
        background: #7dd3fc;
        color: #0f172a;
    }
</style>

<div class="edit-profile-wrapper">
    <div class="edit-profile-card">

        <div class="d-flex align-items-center justify-content-between mb-4 border-bottom border-secondary border-opacity-25 pb-3">
            <div>
                <h3 class="fw-bold text-white mb-1"><i class="fa-solid fa-user-pen text-info me-2"></i> Edit Profil</h3>
                <p class="text-secondary small mb-0">Perbarui informasi akun Safae kamu</p>
            </div>
        </div>

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf

            <!-- FOTO PROFIL SECTION -->
            <div class="d-flex align-items-center gap-4 mb-4 p-3 rounded-3 bg-dark bg-opacity-50 border border-secondary border-opacity-25">
                <img src="{{ $profile->foto_profil ? asset('storage/' . $profile->foto_profil) : 'https://ui-avatars.com/api/?name='.$profile->username.'&background=38bdf8&color=0f172a' }}" 
                     class="avatar-preview-img" 
                     alt="Foto Profil">
                
                <div>
                    <h6 class="fw-bold text-white mb-1">{{ $profile->username }}</h6>
                    <small class="text-secondary d-block mb-2">Ukuran disarankan 1:1 (JPG, PNG max 2MB)</small>
                </div>
            </div>

            <!-- FORM INPUT GRID -->
            <div class="row g-3">
                <div class="col-md-6 mb-2">
                    <label class="form-label text-white fw-bold small">Nama Pengguna</label>
                    <input type="text" name="username" class="form-control form-dark-control" value="{{ old('username', $profile->username) }}" required>
                </div>

                <div class="col-md-6 mb-2">
                    <label class="form-label text-white fw-bold small">Social Media</label>
                    <input type="text" name="social_media" class="form-control form-dark-control" placeholder="Instagram / Twitter / LinkedIn" value="{{ old('social_media', $profile->social_media) }}">
                </div>

                <div class="col-md-6 mb-2">
                    <label class="form-label text-white fw-bold small">Jurusan</label>
                    <input type="text" name="jurusan" class="form-control form-dark-control" placeholder="Masukkan jurusan" value="{{ old('jurusan', $profile->jurusan) }}">
                </div>

                <div class="col-md-6 mb-2">
                    <label class="form-label text-white fw-bold small">Semester</label>
                    <input type="text" name="semester" class="form-control form-dark-control" placeholder="Masukkan semester" value="{{ old('semester', $profile->semester) }}">
                </div>

                <div class="col-12 mb-2">
                    <label class="form-label text-white fw-bold small">Bio</label>
                    <textarea name="bio" rows="3" class="form-control form-dark-control" placeholder="Ceritakan sedikit tentang dirimu">{{ old('bio', $profile->bio) }}</textarea>
                </div>

                <div class="col-12 mb-4">
                    <label class="form-label text-white fw-bold small">Unggah Foto Profil Baru</label>
                    <input type="file" name="foto_profil" class="form-control form-dark-control" accept="image/*">
                </div>
            </div>

            <!-- TOMBOL AKSI -->
            <div class="d-flex justify-content-end gap-2 pt-3 border-top border-secondary border-opacity-25">
                <a href="{{ route('profile') }}" class="btn btn-outline-secondary rounded-3 px-4">
                    Batal
                </a>
                <button type="submit" class="btn-save-profile">
                    <i class="fa-solid fa-check me-1"></i> Simpan Perubahan
                </button>
            </div>

        </form>

    </div>
</div>

@endsection