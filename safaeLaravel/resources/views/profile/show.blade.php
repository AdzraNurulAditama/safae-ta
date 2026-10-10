@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')

<style>
    .profile-wrapper {
        max-width: 900px;
        margin: 0 auto;
        padding: 50px 20px;
    }

    .profile-card {
        background: #fff;
        border-radius: 24px;
        padding: 100px 40px 40px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0,0,0,0.08);
    }


    /* FOTO PROFIL */

    .profile-avatar {
        position: absolute;
        top: 70px;
        left: 40px;
        z-index: 10;
    }

    .profile-avatar img {
        width: 130px;
        height: 130px;
        object-fit: cover;
        border-radius: 50%;
        border: 6px solid #fff;
        background: #f1f3f5;
        box-shadow: 0 10px 25px rgba(0,0,0,.15);
    }

    /* HEADER */

    .profile-header {
        margin-left: 130px;
        margin-bottom: 35px;
    }

    .profile-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg,#0d6efd,#4f8cff);
        color: white;
        padding: 8px 16px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 15px;
        box-shadow: 0 6px 15px rgba(13,110,253,.25);
    }


    .profile-subtitle {
        color: #6c757d;
        font-size: 15px;
        margin-bottom: 0;
    }

    /* INFO CARD */

    .profile-item {
        background: #f8f9fa;
        border-radius: 18px;
        padding: 18px;
        margin-bottom: 18px;
        transition: .3s;
        border: 1px solid #ececec;
    }

    .profile-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,.05);
    }

    .profile-item i {
        color: #0d6efd;
        font-size: 20px;
        margin-right: 10px;
    }

    .profile-item-title {
        font-weight: 700;
        margin-bottom: 5px;
        color: #212529;
    }

    .profile-item-content {
        color: #6c757d;
        word-break: break-word;
    }

    /* BUTTON */

    .btn-rounded {
        border-radius: 50px;
        padding: 10px 22px;
        font-weight: 600;
    }

    .btn-primary {
        background: linear-gradient(135deg,#0d6efd,#4f8cff);
        border: none;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
    }

    /* MOBILE */

    @media (max-width: 768px) {

        .profile-card {
            padding: 160px 25px 25px;
            text-align: center;
        }

        .profile-avatar {
            left: 50%;
            transform: translateX(-50%);
            top: 55px;
        }

        .profile-header {
            margin-left: 0;
            margin-top: 20px;
        }

        .profile-name {
            font-size: 28px;
        }

        .d-flex.flex-wrap {
            flex-direction: column;
        }

        .btn-rounded {
            width: 100%;
        }
    }
</style>

<div class="profile-wrapper">

    <div class="profile-card">

        <!-- FOTO PROFIL -->
        <div class="profile-avatar">
            <img
                src="{{ $profile->foto_profil
                    ? asset('storage/' . $profile->foto_profil)
                    : 'https://ui-avatars.com/api/?name='.$profile->username.'&background=0d6efd&color=fff' }}"
                alt="Foto Profil">
        </div>

        <!-- HEADER -->
        <div class="profile-header">

                <div class="profile-name">
                    <i class="bi bi-person-circle"></i>
                    {{ $profile->username }}
                </div>

            <p class="profile-subtitle">
                Selamat datang di perpustakaan digital Safae
            </p>

        </div>

        <!-- INFORMASI -->
        <div class="row">

            <div class="col-md-6">

                <div class="profile-item">

                    <div class="profile-item-title">
                        <i class="bi bi-link-45deg"></i>
                        Social Media
                    </div>

                    <div class="profile-item-content">
                        {{ $profile->social_media ?? 'Belum diisi' }}
                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="profile-item">

                    <div class="profile-item-title">
                        <i class="bi bi-person-lines-fill"></i>
                        Bio
                    </div>

                    <div class="profile-item-content">
                        {{ $profile->bio ?? 'Belum ada bio' }}
                    </div>

                </div>

            </div>

        </div>

        <!-- ACTION -->
        <div class="d-flex flex-wrap gap-3 mt-4">

            <a href="{{ route('profile.edit') }}"
               class="btn btn-primary btn-rounded">

                <i class="bi bi-pencil-square"></i>
                Edit Profil

            </a>

            <a href="{{ route('user.dashboard') }}"
               class="btn btn-secondary btn-rounded">

                <i class="bi bi-arrow-left"></i>
                Kembali

            </a>

        </div>

    </div>

</div>

@endsection
```
