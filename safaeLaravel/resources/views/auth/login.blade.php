@extends('layouts.app')

@section('title', 'Login | Safae')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700;800&display=swap');

    .resume-page {
        min-height: 100vh;
        width: 100%;
        overflow-x: hidden;
        background:
            radial-gradient(circle at top left, rgba(139,92,246,0.15), transparent 30%),
            radial-gradient(circle at bottom right, rgba(56,189,248,0.15), transparent 25%),
            #020617;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        font-family: 'Space Grotesk', sans-serif;
    }

    .login-wrapper {
        width: 100%;
        max-width: 1100px;
        display: grid;
        grid-template-columns: 1fr 480px;
        background: rgba(255, 255, 255, 0.04);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 32px;
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.5);
        overflow: hidden;
        position: relative;
        z-index: 2;
    }

    /* LEFT SIDE */
    .left-panel {
        background:
            linear-gradient(135deg, rgba(139, 92, 246, 0.85), rgba(236, 72, 153, 0.9)),
            url('https://images.unsplash.com/photo-1512820790803-83ca734da794?q=80&w=1200&auto=format&fit=crop');
        background-size: cover;
        background-position: center;
        color: #fff;
        padding: 60px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
    }

    .overlay {
        position: absolute;
        inset: 0;
        background: rgba(2, 6, 23, 0.2);
    }

    .left-content {
        position: relative;
        z-index: 2;
    }

    .brand-badge {
        display: inline-block;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        color: #fff;
        border: 1px solid rgba(255, 255, 255, 0.25);
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
        max-width: 500px;
        color: rgba(255, 255, 255, 0.85);
        line-height: 1.7;
    }

    .feature-boxes {
        position: relative;
        z-index: 2;
        display: flex;
        gap: 12px;
        margin-top: 40px;
        flex-wrap: wrap;
    }

    .feature {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(5px);
        color: #fff;
        border: 1px solid rgba(255, 255, 255, 0.15);
        padding: 10px 16px;
        font-weight: 600;
        border-radius: 14px;
        font-size: 0.85rem;
    }

    /* RIGHT SIDE */
    .right-panel {
        padding: 55px 45px;
        position: relative;
        background: transparent;
    }

    .dots {
        position: absolute;
        top: 25px;
        right: 25px;
        font-size: 1.2rem;
        letter-spacing: 4px;
        font-weight: 800;
        color: rgba(255, 255, 255, 0.2);
    }

    .login-title {
        font-size: 2.2rem;
        font-weight: 800;
        color: #fff;
        margin-bottom: 8px;
        letter-spacing: -1px;
    }

    .login-subtitle {
        color: #94a3b8;
        margin-bottom: 35px;
    }

    .form-label {
        color: #e2e8f0;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .form-control {
        background: #1e293b;
        border: 1px solid #334155;
        color: #fff;
        border-radius: 16px;
        padding: 14px 16px;
        font-weight: 500;
        transition: .3s;
    }

    .form-control::placeholder {
        color: #64748b;
    }

    .form-control:focus {
        border-color: #8b5cf6;
        box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.25);
        background: #1e293b;
        color: #fff;
    }

    .input-group-custom {
        margin-bottom: 25px;
    }

    .btn-login {
        width: 100%;
        background: linear-gradient(135deg, #8b5cf6, #ec4899);
        border: none;
        color: #fff;
        font-weight: 700;
        padding: 16px;
        border-radius: 16px;
        transition: .3s ease;
        letter-spacing: 1px;
        box-shadow: 0 10px 25px rgba(139, 92, 246, 0.3);
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(139, 92, 246, 0.45);
        color: #fff;
    }

    .extra-links {
        margin-top: 25px;
        display: flex;
        justify-content: space-between;
        font-size: 0.9rem;
    }

    .extra-links a {
        color: #94a3b8;
        font-weight: 600;
        text-decoration: none;
        transition: .2s;
    }

    .extra-links a:hover {
        color: #c084fc;
    }

    .divider {
        display: flex;
        align-items: center;
        margin: 28px 0;
        color: #64748b;
        font-size: 0.85rem;
        font-weight: 700;
    }

    .divider::before,
    .divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #334155;
    }

    .divider span {
        padding: 0 15px;
    }

    .social-login {
        display: flex;
        gap: 15px;
    }

    .social-btn {
        flex: 1;
        border: 1px solid #334155;
        padding: 12px;
        background: rgba(255, 255, 255, 0.02);
        color: #e2e8f0;
        font-weight: 600;
        border-radius: 14px;
        transition: .2s;
    }

    .social-btn:hover {
        background: rgba(255, 255, 255, 0.08);
        color: #fff;
        border-color: #475569;
    }

    /* RESPONSIVE TABLET */
    @media(max-width: 992px){
        .login-wrapper {
            grid-template-columns: 1fr;
        }
        .left-panel {
            display: none;
        }
        .right-panel {
            padding: 45px 30px;
        }
    }

    /* RESPONSIVE MOBILE */
    @media(max-width: 500px){
        .right-panel {
            padding: 35px 20px;
        }
        .login-title {
            font-size: 1.8rem;
        }
        .extra-links {
            flex-direction: column;
            gap: 10px;
            text-align: center;
        }
        .social-login {
            flex-direction: column;
        }
    }
</style>

<div class="resume-page">
    <div class="login-wrapper">

        <div class="left-panel">
            <div class="overlay"></div>
            
            <div class="left-content">
                <div class="brand-badge">
                    SAFAE STORIES
                </div>

                <h1 class="left-title">
                    Tulis.<br>
                    Bagikan.<br>
                    Hidupkan Cerita.
                </h1>

                <p class="left-desc">
                    Platform baca-tulis modern untuk para penulis kreatif.
                    Simpan ide, publikasikan karya, dan bangun dunia cerita Anda sendiri bersama Safae.
                </p>
            </div>

            <div class="feature-boxes">
                <div class="feature">✍️ Editor Interaktif</div>
                <div class="feature">📚 Publish Cerita</div>
                <div class="feature">🔥 Trending Story</div>
            </div>
        </div>

        <div class="right-panel">
            <div class="dots">•••</div>

            <h2 class="login-title">
                WELCOME BACK
            </h2>

            <p class="login-subtitle">
                Masuk untuk melanjutkan sesi menulis Anda di Safae
            </p>

            <form method="POST" action="{{ route('login.submit') }}">
                @csrf

                <div class="input-group-custom">
                    <label class="form-label">Username</label>
                    <input type="text" 
                           name="username" 
                           class="form-control" 
                           placeholder="Masukkan username..." 
                           required>
                </div>

                <div class="input-group-custom">
                    <label class="form-label">Password</label>
                    <input type="password" 
                           name="password" 
                           class="form-control" 
                           placeholder="Masukkan password..." 
                           required>
                </div>

                <button type="submit" class="btn btn-login">
                    LOGIN SEKARANG
                </button>

                <div class="extra-links">
                    <a href="#">Lupa Password?</a>
                    <a href="{{ route('register') }}">Buat Akun Baru</a>
                </div>

                <div class="divider">
                    <span>ATAU</span>
                </div>

                <div class="social-login">
                    <button type="button" class="social-btn">
                        <i class="fa-brands fa-google me-2"></i>Google
                    </button>
                    <button type="button" class="social-btn">
                        <i class="fa-brands fa-github me-2"></i>GitHub
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>

@endsection