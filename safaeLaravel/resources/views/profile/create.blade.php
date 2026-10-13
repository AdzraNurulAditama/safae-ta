@extends('layouts.app')

@section('title', 'Buat Profil - Safae')

@section('content')

<style>
    .create-profile-wrapper {
        max-width: 600px;
        margin: 0 auto;
        padding: 30px 0 50px 0;
        color: #f1f5f9;
    }

    .create-profile-card {
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

    .btn-create-profile {
        background: #38bdf8;
        color: #0f172a;
        font-weight: 700;
        border: none;
        padding: 12px;
        border-radius: 12px;
        width: 100%;
        transition: 0.2s;
    }

    .btn-create-profile:hover {
        background: #7dd3fc;
        color: #0f172a;
    }
</style>

<div class="create-profile-wrapper">
    <div class="create-profile-card">

        <div class="text-center mb-4 pb-3 border-bottom border-secondary border-opacity-25">
            <h4 class="fw-bold text-white mb-1"><i class="fa-solid fa-user-plus text-info me-2"></i> Buat Profil Baru</h4>
            <p class="text-secondary small mb-0">Lengkapi data diri kamu di perpustakaan digital Safae</p>
        </div>

        <form method="POST" action="{{ route('profile.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label text-white fw-bold small">Nama Pengguna</label>
                <input type="text" name="username" class="form-control form-dark-control" placeholder="Masukkan nama pengguna" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-white fw-bold small">Social Media</label>
                <input type="text" name="social_media" class="form-control form-dark-control" placeholder="Instagram / Twitter / LinkedIn">
            </div>

            <div class="mb-3">
                <label class="form-label text-white fw-bold small">Bio</label>
                <textarea name="bio" rows="3" class="form-control form-dark-control" placeholder="Ceritakan sedikit tentang dirimu"></textarea>
            </div>

            <div class="mb-4">
                <label class="form-label text-white fw-bold small">Foto Profil</label>
                <input type="file" name="foto_profil" class="form-control form-dark-control" accept="image/*">
                <small class="text-secondary mt-1 d-block">Format JPG / PNG, maksimal 2MB</small>
            </div>

            <div class="d-flex justify-content-between gap-3 pt-2">
                <a href="{{ route('profile') }}" class="btn btn-outline-secondary rounded-3 w-50">
                    Batal
                </a>
                <button type="submit" class="btn-create-profile w-50">
                    Simpan Profil
                </button>
            </div>

        </form>

    </div>
</div>

@endsection