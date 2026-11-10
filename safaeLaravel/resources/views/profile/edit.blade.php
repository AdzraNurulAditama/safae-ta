
@extends('layouts.app')

@section('title', 'Edit Profil - Safae')

@section('content')

<style>
    .edit-profile-wrapper {
        max-width: 900px;
        margin: 0 auto;
        padding: 20px 0 50px 0;
        color: #514d69;
    }

    .edit-profile-card {
        background: #ffffff;
        border: 1px solid #e5def5;
        border-radius: 24px;
        padding: 35px;
        box-shadow: 0 15px 35px rgba(164, 139, 220, 0.12);
    }

    .form-dark-control {
        background: #f5f1fc;
        border: 1px solid #ded6ef;
        color: #514d69;
        border-radius: 12px;
        padding: 12px 16px;
    }

    .form-dark-control:focus {
        background: #ffffff;
        border-color: #b9a5e8;
        color: #514d69;
        box-shadow: 0 0 0 0.25rem rgba(185, 165, 232, 0.15);
    }

    .avatar-preview-img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #b9a5e8;
    }

    .btn-save-profile {
        background: #b9a5e8;
        color: #ffffff;
        font-weight: 700;
        border: none;
        padding: 12px 28px;
        border-radius: 12px;
        transition: 0.2s;
    }

    .btn-save-profile:hover {
        background: #a48bdc;
        color: #ffffff;
    }

    .edit-profile-wrapper .text-white {
        color: #514d69 !important;
    }

    .edit-profile-wrapper .text-secondary {
        color: #89839f !important;
    }

    .edit-profile-wrapper .text-info {
        color: #a48bdc !important;
    }

    .edit-profile-wrapper .bg-dark {
        background-color: #f5f1fc !important;
    }

    .edit-profile-wrapper .border-secondary {
        border-color: #ded6ef !important;
    }

    .edit-profile-wrapper .btn-outline-secondary {
        color: #89839f;
        border-color: #ded6ef;
    }

    .edit-profile-wrapper .btn-outline-secondary:hover {
        background: #eee8f8;
        color: #514d69;
        border-color: #b9a5e8;
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
