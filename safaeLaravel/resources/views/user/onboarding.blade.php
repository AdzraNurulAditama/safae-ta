
@extends('layouts.app')

@section('title', 'Pilih Genre Favorit - Safae')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    .onboarding-page {
        min-height: 100vh;
        padding: 60px 20px;
        background: 
            radial-gradient(circle at 15% 10%, rgba(185, 165, 232, 0.18) 0%, transparent 45%),
            radial-gradient(circle at 85% 90%, rgba(130, 169, 216, 0.14) 0%, transparent 45%),
            #f5f1fc;
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: #514d69;
        position: relative;
        overflow: hidden;
    }

    /* Efek Ambient Glow Background */
    .onboarding-page::before {
        content: '';
        position: absolute;
        width: 500px;
        height: 500px;
        background: rgba(185, 165, 232, 0.08);
        filter: blur(120px);
        top: 20%;
        left: 50%;
        transform: translateX(-50%);
        z-index: 0;
        pointer-events: none;
    }

    .onboarding-container {
        max-width: 1050px;
        margin: auto;
        position: relative;
        z-index: 1;
    }

    .onboarding-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .header-icon {
        width: 80px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px;
        border-radius: 26px;
        background: linear-gradient(135deg, rgba(185, 165, 232, 0.20), rgba(130, 169, 216, 0.14));
        border: 1px solid rgba(185, 165, 232, 0.35);
        box-shadow: 0 0 30px rgba(185, 165, 232, 0.20);
        animation: floatIcon 4s ease-in-out infinite;
    }

    @keyframes floatIcon {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-6px); }
    }

    .header-icon i {
        font-size: 32px;
        background: linear-gradient(135deg, #b9a5e8, #82a9d8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .onboarding-header h2 {
        color: #514d69;
        font-size: clamp(28px, 4vw, 38px);
        font-weight: 800;
        letter-spacing: -0.5px;
        margin-bottom: 12px;
    }

    .onboarding-header p {
        max-width: 600px;
        margin: auto;
        color: #89839f;
        font-size: 15px;
        line-height: 1.7;
    }

    .onboarding-card {
        background: rgba(255, 255, 255, 0.96);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(229, 222, 245, 0.9);
        border-radius: 28px;
        padding: 40px;
        box-shadow: 0 30px 60px rgba(81, 77, 105, 0.10), inset 0 1px 0 rgba(255, 255, 255, 0.45);
    }

    .section-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 30px;
    }

    .section-heading h5 {
        color: #514d69;
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .section-heading p {
        color: #89839f;
        font-size: 13px;
        margin: 0;
    }

    /* Counter Badge yang Lebih Dinamis */
    .selection-counter {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 20px;
        border-radius: 16px;
        background: rgba(185, 165, 232, 0.12);
        border: 1px solid rgba(185, 165, 232, 0.2);
        color: #a48bdc;
        transition: all 0.3s ease;
    }

    .selection-counter.completed {
        background: rgba(101, 169, 140, 0.12);
        border-color: rgba(101, 169, 140, 0.3);
        color: #65a98c;
    }

    .counter-number {
        font-size: 18px;
        font-weight: 800;
    }

    .counter-label {
        font-size: 11px;
        opacity: 0.8;
    }

    /* Input & Select Keren */
    .form-control, .form-select {
        background-color: rgba(245, 241, 252, 0.95) !important;
        border: 1px solid rgba(229, 222, 245, 0.9) !important;
        color: #514d69 !important;
        border-radius: 14px;
        padding: 14px 18px;
        font-size: 14px;
        transition: all 0.25s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #b9a5e8 !important;
        box-shadow: 0 0 0 4px rgba(185, 165, 232, 0.15) !important;
        background-color: rgba(245, 241, 252, 1) !important;
    }

    .form-select option {
        background-color: #ffffff;
        color: #514d69;
    }

    /* Genre Card Grid Styling */
    .genre-option {
        display: block;
        position: relative;
        height: 100%;
        cursor: pointer;
    }

    .genre-option input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .genre-card {
        min-height: 140px;
        height: 100%;
        padding: 22px 14px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 14px;
        text-align: center;
        border: 1px solid rgba(229, 222, 245, 0.8);
        border-radius: 20px;
        background: rgba(245, 241, 252, 0.65);
        color: #89839f;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    /* Efek kilau gradien halus saat hover */
    .genre-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(185, 165, 232, 0.12), transparent 70%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .genre-icon {
        width: 52px;
        height: 52px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 16px;
        background: rgba(238, 232, 248, 0.8);
        border: 1px solid rgba(229, 222, 245, 0.8);
        color: #b9a5e8;
        font-size: 22px;
        position: relative;
        z-index: 1;
        transition: all 0.3s ease;
    }

    .genre-card span {
        font-size: 13px;
        font-weight: 600;
        position: relative;
        z-index: 1;
        transition: color 0.3s ease;
    }

    .genre-check {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: linear-gradient(135deg, #b9a5e8, #a48bdc);
        color: white;
        font-size: 11px;
        opacity: 0;
        transform: scale(0.4);
        transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
        z-index: 2;
        box-shadow: 0 4px 10px rgba(185, 165, 232, 0.20);
    }

    /* Hover State */
    .genre-option:hover .genre-card {
        border-color: rgba(185, 165, 232, 0.35);
        background: rgba(185, 165, 232, 0.06);
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(81, 77, 105, 0.08);
    }

    .genre-option:hover .genre-card::before {
        opacity: 1;
    }

    .genre-option:hover .genre-icon {
        background: rgba(185, 165, 232, 0.12);
        border-color: rgba(185, 165, 232, 0.2);
    }

    /* Checked State */
    .genre-option input:checked + .genre-card {
        border: 1.5px solid #b9a5e8;
        background: linear-gradient(145deg, rgba(185, 165, 232, 0.16), rgba(130, 169, 216, 0.10));
        color: #514d69;
        box-shadow: 0 0 30px rgba(185, 165, 232, 0.20), inset 0 0 15px rgba(185, 165, 232, 0.05);
        transform: translateY(-3px);
    }

    .genre-option input:checked + .genre-card .genre-icon {
        background: linear-gradient(135deg, #a48bdc, #a48bdc);
        color: #ffffff;
        border-color: transparent;
        box-shadow: 0 8px 20px rgba(164, 139, 220, 0.25);
    }

    .genre-option input:checked + .genre-card .genre-check {
        opacity: 1;
        transform: scale(1);
    }

    .genre-option.limit-reached {
        opacity: 0.35;
        cursor: not-allowed;
        filter: grayscale(40%);
    }

    .genre-option.limit-reached .genre-card {
        pointer-events: none;
        transform: none !important;
        box-shadow: none !important;
    }

    .onboarding-divider {
        border: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(229, 222, 245, 0.9), transparent);
        margin: 35px 0;
    }

    .selection-hint {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        color: #89839f;
        font-size: 13px;
        margin-bottom: 25px;
        text-align: center;
    }

    .selection-hint i {
        color: #b9a5e8;
    }

    /* Tombol Utama Bergaya Premium */
    .btn-onboarding {
        border: none;
        border-radius: 16px;
        padding: 16px 36px;
        min-width: 270px;
        background: linear-gradient(135deg, #b9a5e8, #a48bdc);
        color: white;
        font-size: 15px;
        font-weight: 700;
        letter-spacing: 0.3px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 10px 25px rgba(164, 139, 220, 0.25);
        position: relative;
        overflow: hidden;
    }

    .btn-onboarding::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.45), transparent);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .btn-onboarding:hover:not(:disabled) {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(164, 139, 220, 0.30);
        color: white;
    }

    .btn-onboarding:hover:not(:disabled)::after {
        opacity: 1;
    }

    .btn-onboarding:disabled {
        opacity: 0.35;
        cursor: not-allowed;
        box-shadow: none;
        transform: none;
    }

    .onboarding-note {
        color: #89839f;
        font-size: 12px;
        margin-top: 10px;
    }

    .custom-alert {
        background: rgba(207, 130, 151, 0.10);
        border: 1px solid rgba(207, 130, 151, 0.25);
        color: #cf8297;
        border-radius: 14px;
        padding: 16px 20px;
        margin-bottom: 30px;
        backdrop-filter: blur(10px);
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-state i {
        font-size: 40px;
        color: #89839f;
        margin-bottom: 18px;
    }

    .empty-state p {
        color: #514d69;
        font-weight: 600;
    }

    @media (max-width: 576px) {
        .onboarding-page {
            padding: 30px 12px;
        }
        .onboarding-card {
            padding: 24px 18px;
            border-radius: 20px;
        }
        .section-heading {
            align-items: flex-start;
            flex-direction: column;
            gap: 15px;
        }
        .selection-counter {
            width: 100%;
            justify-content: space-between;
        }
        .genre-card {
            min-height: 120px;
            padding: 16px 10px;
        }
        .genre-icon {
            width: 44px;
            height: 44px;
            font-size: 18px;
        }
        .btn-onboarding {
            width: 100%;
        }
    }

    /* Penyesuaian warna utility Bootstrap agar sesuai tema pastel Safae */
    .onboarding-page .text-white {
        color: #514d69 !important;
    }

    .onboarding-page .text-white-50 {
        color: #89839f !important;
    }

    .onboarding-page .text-info {
        color: #a48bdc !important;
    }
</style>

<div class="onboarding-page">
    <div class="onboarding-container">

        <!-- Header -->
        <div class="onboarding-header">
            <div class="header-icon">
                <i class="fas fa-book-reader"></i>
            </div>
            <h2>Temukan Cerita Favoritmu!</h2>
            <p>
                Setiap pembaca punya ketertarikan yang berbeda. 
                Lengkapi profil dan pilih tepat 3 genre buku favoritmu agar SAFAE 
                dapat menghadirkan kurasi bacaan terbaik yang paling sesuai.
            </p>
        </div>

        <div class="onboarding-card">

            @if ($errors->any())
                <div class="custom-alert">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if ($genres->isEmpty())
                <div class="empty-state">
                    <i class="fas fa-book-open d-block"></i>
                    <p>Belum ada genre buku yang tersedia.</p>
                    <small class="onboarding-note">
                        Silakan coba lagi setelah koleksi buku diperbarui.
                    </small>
                </div>
            @else
                <form action="{{ route('onboarding.store') }}" method="POST" id="onboardingForm">
                    @csrf

                    <!-- Bagian Profil -->
                    <div class="mb-2">
                        <h5 class="text-white fw-bold mb-3 d-flex align-items-center gap-2">
                            <i class="fas fa-user-edit text-info"></i>
                            Lengkapi Profilmu
                        </h5>

                        <div class="row g-3">
                            <div class="col-md-8">
                                <label for="jurusan" class="form-label text-white-50 small mb-2 fw-semibold">
                                    Program Studi / Jurusan
                                </label>
                                <input
                                    type="text"
                                    name="jurusan"
                                    id="jurusan"
                                    class="form-control"
                                    placeholder="Contoh: Sistem Informasi"
                                    value="{{ old('jurusan', Auth::user()->jurusan ?? '') }}"
                                    required
                                >
                            </div>

                            <div class="col-md-4">
                                <label for="semester" class="form-label text-white-50 small mb-2 fw-semibold">
                                    Semester
                                </label>
                                <select
                                    name="semester"
                                    id="semester"
                                    class="form-select"
                                    required
                                >
                                    <option value="">Pilih semester</option>
                                    @for ($i = 1; $i <= 14; $i++)
                                        <option
                                            value="{{ $i }}"
                                            {{ old('semester', Auth::user()->semester ?? '') == $i ? 'selected' : '' }}
                                        >
                                            Semester {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="onboarding-divider"></div>

                    <!-- Bagian Genre Header & Counter -->
                    <div class="section-heading">
                        <div>
                            <h5>Pilih Genre Favorit</h5>
                            <p>Wajib pilih tepat 3 genre untuk melanjutkan.</p>
                        </div>

                        <div class="selection-counter" id="counterWrapper">
                            <i class="fas fa-check-circle" id="counterIcon"></i>
                            <div>
                                <div class="counter-number" id="selectedCount">0/3</div>
                                <div class="counter-label">Genre dipilih</div>
                            </div>
                        </div>
                    </div>

                    <!-- Grid Genre -->
                    <div class="row g-3">
                        @foreach ($genres as $genre)
                            <div class="col-6 col-md-4 col-lg-3">
                                <label class="genre-option">
                                    <input
                                        type="checkbox"
                                        name="genres[]"
                                        value="{{ $genre }}"
                                        class="genre-checkbox"
                                        {{ in_array($genre, old('genres', [])) ? 'checked' : '' }}
                                    >

                                    <div class="genre-card">
                                        <div class="genre-check">
                                            <i class="fas fa-check"></i>
                                        </div>

                                        <div class="genre-icon">
                                            @php
                                                $namaGenre = strtolower($genre);
                                                $icon = 'fa-book';

                                                if (str_contains($namaGenre, 'romance') || str_contains($namaGenre, 'romantis')) {
                                                    $icon = 'fa-heart';
                                                } elseif (str_contains($namaGenre, 'fantasi') || str_contains($namaGenre, 'fantasy')) {
                                                    $icon = 'fa-wand-magic-sparkles';
                                                } elseif (str_contains($namaGenre, 'horor') || str_contains($namaGenre, 'horror')) {
                                                    $icon = 'fa-ghost';
                                                } elseif (str_contains($namaGenre, 'misteri') || str_contains($namaGenre, 'thriller')) {
                                                    $icon = 'fa-magnifying-glass';
                                                } elseif (str_contains($namaGenre, 'komedi')) {
                                                    $icon = 'fa-face-laugh';
                                                } elseif (str_contains($namaGenre, 'sejarah')) {
                                                    $icon = 'fa-landmark';
                                                } elseif (str_contains($namaGenre, 'pendidikan') || str_contains($namaGenre, 'akademik')) {
                                                    $icon = 'fa-graduation-cap';
                                                } elseif (str_contains($namaGenre, 'teknologi') || str_contains($namaGenre, 'komputer')) {
                                                    $icon = 'fa-laptop-code';
                                                } elseif (str_contains($namaGenre, 'sains') || str_contains($namaGenre, 'ilmiah')) {
                                                    $icon = 'fa-flask';
                                                } elseif (str_contains($namaGenre, 'biografi')) {
                                                    $icon = 'fa-user';
                                                } elseif (str_contains($namaGenre, 'motivasi') || str_contains($namaGenre, 'pengembangan diri')) {
                                                    $icon = 'fa-seedling';
                                                } elseif (str_contains($namaGenre, 'petualangan')) {
                                                    $icon = 'fa-compass';
                                                }
                                            @endphp
                                            <i class="fas {{ $icon }}"></i>
                    </div>

                                        <span>{{ $genre }}</span>
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <div class="onboarding-divider"></div>

                    <div class="selection-hint">
                        <i class="fas fa-info-circle"></i>
                        Pilih 3 genre favorit untuk membuka tombol lanjut.
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex flex-column align-items-center">
                        <button
                            type="submit"
                            class="btn btn-onboarding"
                            id="submitButton"
                            disabled
                        >
                            Mulai Jelajahi SAFAE
                            <i class="fas fa-arrow-right ms-2"></i>
                        </button>

                        <small class="onboarding-note">
                            Pilihan ini akan mengatur personalisasi halaman utama Anda.
                        </small>
                    </div>
                </form>
            @endif
        </div>

        <div class="text-center mt-4">
            <small class="onboarding-note text-white-50">
                Temukan bacaan baru, bagikan cerita, dan tumbuh bersama SAFAE.
            </small>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.genre-checkbox');
    const counter = document.getElementById('selectedCount');
    const counterWrapper = document.getElementById('counterWrapper');
    const submitButton = document.getElementById('submitButton');

    function updateSelection() {
        const selected = document.querySelectorAll('.genre-checkbox:checked');
        const total = selected.length;

        if (counter) {
            counter.textContent = total + '/3';
        }

        // Ubah warna counter menjadi hijau jika sudah pas 3
        if (counterWrapper) {
            if (total === 3) {
                counterWrapper.classList.add('completed');
            } else {
                counterWrapper.classList.remove('completed');
            }
        }

        if (submitButton) {
            submitButton.disabled = total !== 3;
        }

        checkboxes.forEach(function (checkbox) {
            const label = checkbox.closest('.genre-option');

            if (total >= 3 && !checkbox.checked) {
                label.classList.add('limit-reached');
            } else {
                label.classList.remove('limit-reached');
            }
        });
    }

    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', updateSelection);
    });

    updateSelection();
});
</script>
@endsection
