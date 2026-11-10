
@extends('layouts.app')

@section('title', 'Daftar Akun | Safae')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700;800&display=swap');

    .resume-page {
        min-height: 100vh;
        width: 100%;
        overflow-x: hidden;
        background:
            radial-gradient(circle at top left, rgba(185, 165, 232, 0.20), transparent 30%),
            radial-gradient(circle at bottom right, rgba(130, 169, 216, 0.18), transparent 25%),
            #f5f1fc;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        font-family: 'Space Grotesk', sans-serif;
    }

    /* MAIN CARD */
    .register-wrapper {
        width: 100%;
        max-width: 1150px;
        display: grid;
        grid-template-columns: 1fr 580px;
        background: rgba(255, 255, 255, 0.96);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid #e5def5;
        border-radius: 32px;
        box-shadow: 0 30px 60px rgba(81, 77, 105, 0.12);
        overflow: hidden;
        position: relative;
        z-index: 2;
    }

    /* LEFT PANEL */
    .left-panel {
        background:
            linear-gradient(135deg, rgba(185, 165, 232, 0.88), rgba(130, 169, 216, 0.88)),
            url('https://images.unsplash.com/photo-1455390582262-044cdead277a?q=80&w=1200&auto=format&fit=crop');
        background-size: cover;
        background-position: center;
        position: relative;
        padding: 60px;
        color: #fff;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .overlay {
        position: absolute;
        inset: 0;
        background: rgba(81, 77, 105, 0.12);
    }

    .left-content,
    .left-bottom {
        position: relative;
        z-index: 2;
    }

    .brand-badge {
        display: inline-block;
        background: rgba(255, 255, 255, 0.20);
        backdrop-filter: blur(10px);
        color: #fff;
        border: 1px solid rgba(255, 255, 255, 0.35);
        padding: 8px 18px;
        font-weight: 800;
        letter-spacing: 2px;
        border-radius: 999px;
        margin-bottom: 30px;
        font-size: 0.85rem;
    }

    .left-title {
        font-size: 3rem;
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 20px;
    }

    .left-desc {
        font-size: 1rem;
        line-height: 1.8;
        max-width: 500px;
        color: rgba(255, 255, 255, 0.92);
    }

    .feature-boxes {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 40px;
    }

    .feature {
        background: rgba(255, 255, 255, 0.20);
        backdrop-filter: blur(5px);
        color: #fff;
        border: 1px solid rgba(255, 255, 255, 0.30);
        padding: 10px 16px;
        font-weight: 600;
        border-radius: 14px;
        font-size: 0.85rem;
    }

    /* RIGHT PANEL */
    .right-panel {
        background: #ffffff;
        padding: 50px 40px;
        position: relative;
    }

    .dots {
        position: absolute;
        top: 25px;
        right: 25px;
        letter-spacing: 4px;
        font-size: 1.2rem;
        font-weight: 800;
        color: #ded6ef;
    }

    .register-title {
        font-size: 2.3rem;
        font-weight: 800;
        color: #514d69;
        letter-spacing: -1px;
        margin-bottom: 10px;
    }

    .register-subtitle {
        color: #89839f;
        margin-bottom: 35px;
    }

    .form-label {
        color: #514d69;
        font-weight: 600;
        margin-bottom: 8px;
        font-size: 0.95rem;
    }

    .form-control {
        background: #f5f1fc;
        border: 1px solid #e5def5;
        color: #514d69;
        border-radius: 16px;
        padding: 14px 16px;
        font-weight: 500;
        transition: .3s;
    }

    .form-control::placeholder {
        color: #aaa3bc;
    }

    .form-control:focus {
        border-color: #b9a5e8;
        box-shadow: 0 0 0 4px rgba(185, 165, 232, 0.18);
        background: #f5f1fc;
        color: #514d69;
    }

    .input-group-custom {
        margin-bottom: 22px;
    }

    .btn-register {
        width: 100%;
        background: linear-gradient(135deg, #b9a5e8, #a48bdc);
        border: none;
        color: #fff;
        font-weight: 700;
        padding: 16px;
        border-radius: 16px;
        transition: .3s ease;
        letter-spacing: 1px;
        box-shadow: 0 10px 25px rgba(164, 139, 220, 0.25);
    }

    .btn-register:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(164, 139, 220, 0.35);
        color: #fff;
    }

    .login-link {
        text-align: center;
        margin-top: 25px;
        color: #89839f;
        font-size: 0.95rem;
    }

    .login-link a {
        color: #a48bdc;
        text-decoration: none;
        font-weight: 700;
        transition: .2s;
    }

    .login-link a:hover {
        color: #8f75ca;
        text-decoration: underline;
    }

    /* ERROR BOX ALERT */
    .custom-alert {
        border: 1px solid rgba(207, 130, 151, 0.30);
        background: rgba(207, 130, 151, 0.10);
        color: #cf8297;
        padding: 15px 20px;
        margin-bottom: 25px;
        border-radius: 16px;
        font-weight: 600;
    }

    .custom-alert ul {
        margin: 0;
        padding-left: 20px;
    }

    /* RESPONSIVE TABLET */
    @media(max-width: 992px){
        .register-wrapper {
            grid-template-columns: 1fr;
        }
        .left-panel {
            display: none;
        }
        .right-panel {
            padding: 40px 25px;
        }
    }

    /* RESPONSIVE MOBILE */
    @media(max-width: 576px){
        body {
            padding: 15px;
        }
        .register-title {
            font-size: 1.9rem;
        }
        .right-panel {
            padding: 35px 20px;
        }
    }
</style>

<div class="resume-page">
    <div class="register-wrapper">

        <div class="left-panel">
            <div class="overlay"></div>

            <div class="left-content">
                <div class="brand-badge">
                    SAFAE STORIES
                </div>

                <h1 class="left-title">
                    Mulai Cerita<br>
                    Pertamamu<br>
                    Hari Ini.
                </h1>

                <p class="left-desc">
                    Bergabung bersama ribuan penulis lainnya di Safae.
                    Tulis cerita, bagikan imajinasi, dan bangun dunia kreatifmu sendiri.
                </p>
            </div>

            <div class="left-bottom">
                <div class="feature-boxes">
                    <div class="feature">✍️ Menulis Cerita</div>
                    <div class="feature">📚 Publish Novel</div>
                    <div class="feature">🔥 Komunitas Kreatif</div>
                </div>
            </div>
        </div>

        <div class="right-panel">
            <div class="dots">•••</div>

            <h2 class="register-title">
                BUAT AKUN
            </h2>

            <p class="register-subtitle">
                Daftar dan mulai perjalanan menulismu di Safae
            </p>

            @if($errors->any())
                <div class="custom-alert">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.submit') }}">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group-custom">
                            <label class="form-label">Nama Depan</label>
                            <input type="text" 
                                   name="nama_depan" 
                                   class="form-control" 
                                   placeholder="John" 
                                   required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="input-group-custom">
                            <label class="form-label">Nama Belakang</label>
                            <input type="text" 
                                   name="nama_belakang" 
                                   class="form-control" 
                                   placeholder="Doe" 
                                   required>
                        </div>
                    </div>
                </div>

                <div class="input-group-custom">
                    <label class="form-label">Username</label>
                    <input type="text" 
                           name="username" 
                           class="form-control" 
                           placeholder="Pilih username unik" 
                           required>
                </div>

                <div class="input-group-custom">
                    <label class="form-label">Email</label>
                    <input type="email" 
                           name="email" 
                           class="form-control" 
                           placeholder="nama@email.com" 
                           required>
                </div>

                <div class="input-group-custom">
                    <label class="form-label">Nomor Telepon</label>
                    <input type="text" 
                           name="telepon" 
                           class="form-control" 
                           placeholder="08xxxxxxxxx" 
                           required>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group-custom">
                            <label class="form-label">Password</label>
                            <input type="password" 
                                   name="password" 
                                   class="form-control" 
                                   placeholder="••••••••" 
                                   required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="input-group-custom">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" 
                                   name="password_confirmation" 
                                   class="form-control" 
                                   placeholder="••••••••" 
                                   required>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-register">
                    DAFTAR SEKARANG
                </button>
            </form>

            <div class="login-link">
                Sudah punya akun? 
                <a href="{{ route('login') }}">Masuk di sini</a>
            </div>
        </div>

    </div>
</div>

@endsection
