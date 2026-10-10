@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')

<style>
    .edit-wrapper {
        max-width: 900px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .edit-card {
        background: #ffffff;
        border-radius: 24px;
        padding: 40px;
        box-shadow: 0 15px 40px rgba(0,0,0,0.08);
    }

    /* HEADER */

    .profile-header {
        display: flex;
        align-items: center;
        gap: 18px;
        padding: 20px 25px;
        border-radius: 18px;
        background: linear-gradient(135deg,rgb(126, 160, 211), #4f8cff);
        margin-bottom: 30px;
    }

    .header-icon {
        width: 65px;
        height: 65px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 28px;
    }

    .header-title {
        color: white;
        font-weight: 700;
        margin: 0;
    }

    .header-subtitle {
        color: rgba(255,255,255,0.85);
        margin: 0;
        font-size: 14px;
    }

    /* AVATAR */

    .edit-avatar {
        display: flex;
        align-items: center;
        gap: 25px;
        margin-bottom: 35px;
    }

    .edit-avatar img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid #f1f3f5;
        box-shadow: 0 8px 20px rgba(0,0,0,.08);
    }

    /* FORM */

    .form-label {
        font-weight: 600;
        color: #212529;
        margin-bottom: 8px;
    }

    .form-control {
        border-radius: 14px;
        border: 1px solid #dee2e6;
        padding: 12px 15px;
        font-size: 14px;
        transition: all .3s ease;
    }

    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 .2rem rgba(13,110,253,.15);
    }

    textarea.form-control {
        resize: none;
    }

    /* BUTTON */

    .btn-rounded {
        border-radius: 50px;
        padding: 11px 25px;
        font-weight: 600;
    }

    .btn-primary {
        background: linear-gradient(135deg, #0d6efd, #4f8cff);
        border: none;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
    }

    .btn-secondary:hover,
    .btn-primary:hover {
        transition: .3s;
    }

    @media (max-width: 768px) {

        .edit-card {
            padding: 25px;
        }

        .profile-header {
            flex-direction: column;
            text-align: center;
        }

        .edit-avatar {
            flex-direction: column;
            text-align: center;
        }

        .d-flex.justify-content-between {
            flex-direction: column;
        }

        .btn-rounded {
            width: 100%;
        }
    }
</style>

<div class="edit-wrapper">

    <div class="edit-card">

        <!-- HEADER -->
        <div class="profile-header">


            <div>
                <h3 class="header-title">
                    Edit Profil
                </h3>

                <p class="header-subtitle">
                    Perbarui informasi akun Safae kamu
                </p>
            </div>

        </div>

        <!-- FOTO PROFIL -->
        <div class="edit-avatar">

            <img src="{{ $profile->foto_profil
                ? asset('storage/' . $profile->foto_profil)
                : 'https://ui-avatars.com/api/?name='.$profile->username.'&background=0d6efd&color=fff' }}"
                 alt="Foto Profil">

            <div>

                <div class="profile-name">
                <i class="bi bi-person-circle"></i>
                {{ $profile->username }}
            </div>

                <div class="mt-2">
                    <small class="text-muted">
                        Ukuran disarankan 1:1 (JPG, PNG)
                    </small>
                </div>

            </div>

        </div>

        <!-- FORM -->
        <form method="POST"
              enctype="multipart/form-data"
              action="{{ route('profile.update') }}">

            @csrf

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Nama Pengguna
                    </label>

                    <input type="text"
                           name="username"
                           class="form-control"
                           value="{{ old('username', $profile->username) }}"
                           required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Social Media
                    </label>

                    <input type="text"
                           name="social_media"
                           class="form-control"
                           placeholder="Instagram / Twitter / LinkedIn"
                           value="{{ old('social_media', $profile->social_media) }}">
                </div>

                <div class="col-12 mb-3">

                    <label class="form-label">
                        Bio
                    </label>

                    <textarea name="bio"
                              rows="4"
                              class="form-control"
                              placeholder="Ceritakan sedikit tentang dirimu">{{ old('bio', $profile->bio) }}</textarea>

                </div>

                <div class="col-12 mb-4">

                    <label class="form-label">
                        Foto Profil Baru
                    </label>

                    <input type="file"
                           name="foto_profil"
                           class="form-control"
                           accept="image/*">

                </div>

            </div>

            <div class="d-flex justify-content-between gap-3">

                <a href="{{ route('profile') }}"
                   class="btn btn-secondary btn-rounded">

                    <i class="bi bi-arrow-left"></i>
                    Batal

                </a>

                <button type="submit"
                        class="btn btn-primary btn-rounded">

                    <i class="bi bi-check-circle"></i>
                    Simpan Perubahan

                </button>

            </div>

        </form>

    </div>

</div>

@endsection