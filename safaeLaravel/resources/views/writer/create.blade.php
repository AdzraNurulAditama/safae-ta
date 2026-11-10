
@extends('layouts.app')

@section('title', 'Buat Buku Baru - Studio Penulis Safae')

@section('content')

<style>
    /* =========================================
       CREATE BOOK - SAFae PASTEL THEME
    ========================================= */

    .writer-form-page {
        --text: #38425d;
        --text-soft: #8995aa;
        --border: #e7edf7;
        --blue: #78b9e5;
        --purple: #9c91dc;
        --pink: #e5a5c8;

        min-height: 100vh;
        padding: 20px 0 45px;

        background:
            radial-gradient(
                ellipse at 5% 5%,
                rgba(157, 211, 245, .35),
                transparent 42%
            ),
            radial-gradient(
                ellipse at 95% 10%,
                rgba(245, 190, 224, .30),
                transparent 42%
            ),
            radial-gradient(
                ellipse at 50% 75%,
                rgba(207, 197, 245, .25),
                transparent 45%
            ),
            radial-gradient(
                ellipse at 5% 95%,
                rgba(174, 224, 211, .25),
                transparent 40%
            );

        color: var(--text);
    }

    .writer-form-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 0 18px;
    }

    /* =========================================
       BACK BUTTON
    ========================================= */

    .writer-back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;

        color: #7189c8;
        font-size: 14px;
        font-weight: 700;

        text-decoration: none;
        transition: .25s;
    }

    .writer-back-link:hover {
        color: #5875b8;
        transform: translateX(-3px);
    }

    /* =========================================
       FORM CARD
    ========================================= */

    .writer-form-card {
        background: rgba(255,255,255,.88);

        border: 1px solid rgba(255,255,255,.95);
        border-radius: 25px;

        box-shadow: 0 12px 35px rgba(120,150,200,.12);

        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);

        overflow: hidden;
    }

    .writer-form-header {
        position: relative;
        overflow: hidden;

        padding: 28px 32px;

        background:
            radial-gradient(
                ellipse at 90% 0%,
                rgba(245,190,224,.6),
                transparent 50%
            ),
            radial-gradient(
                ellipse at 5% 100%,
                rgba(157,211,245,.65),
                transparent 55%
            ),
            linear-gradient(
                120deg,
                #e3f3ff,
                #eeeaff 55%,
                #fcebf5
            );

        border-bottom: 1px solid #edf0f8;
    }

    .writer-form-header h3 {
        position: relative;
        z-index: 1;

        color: #394461;
        font-size: 24px;
        font-weight: 800;

        margin-bottom: 7px;
    }

    .writer-form-header p {
        position: relative;
        z-index: 1;

        color: #77849e;
        font-size: 13.5px;
        margin-bottom: 0;
        line-height: 1.6;
    }

    .writer-form-header-icon {
        position: absolute;
        right: 35px;
        top: 50%;
        transform: translateY(-50%);

        width: 75px;
        height: 75px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 22px;

        background: rgba(255,255,255,.5);
        border: 1px solid rgba(255,255,255,.8);

        color: #819bd5;
        font-size: 32px;
    }

    .writer-form-body {
        padding: 32px;
    }

    /* =========================================
       SECTION LABEL
    ========================================= */

    .writer-form-section-title {
        display: flex;
        align-items: center;
        gap: 9px;

        color: #52617f;
        font-size: 14px;
        font-weight: 800;

        margin-bottom: 18px;
        padding-bottom: 12px;

        border-bottom: 1px solid #edf0f8;
    }

    .writer-form-section-title i {
        color: #86a8dd;
    }

    /* =========================================
       LABEL
    ========================================= */

    .writer-form-label {
        display: block;

        color: #53617c;
        font-size: 13px;
        font-weight: 700;

        margin-bottom: 9px;
    }

    .writer-required {
        color: #df8da9;
    }

    /* =========================================
       INPUT, SELECT, TEXTAREA
    ========================================= */

    .writer-form-control {
        width: 100%;
        min-height: 48px;

        padding: 12px 15px;

        background: #f8faff !important;
        color: #46516b !important;

        border: 1px solid #e5eaf5 !important;
        border-radius: 13px !important;

        font-size: 13.5px;
        font-weight: 500;

        outline: none;
        box-shadow: none !important;

        transition: .25s;
    }

    .writer-form-control::placeholder {
        color: #a8b2c4 !important;
    }

    .writer-form-control:focus {
        background: #ffffff !important;

        border-color: #9fc7ed !important;

        box-shadow: 0 0 0 4px rgba(120,185,229,.13) !important;
    }

    select.writer-form-control {
        cursor: pointer;
    }

    select.writer-form-control option {
        background: #ffffff;
        color: #46516b;
    }

    textarea.writer-form-control {
        min-height: 125px;
        resize: vertical;
        line-height: 1.7;
    }

    /* =========================================
       STATUS SELECT
    ========================================= */

    .writer-status-hint {
        display: flex;
        align-items: flex-start;
        gap: 8px;

        margin-top: 9px;

        color: #929db2;
        font-size: 11.5px;
        line-height: 1.6;
    }

    .writer-status-hint i {
        color: #87a9d9;
        margin-top: 2px;
    }

    /* =========================================
       UPLOAD COVER
    ========================================= */

    .writer-upload-box {
        position: relative;

        background:
            linear-gradient(
                135deg,
                rgba(235,246,255,.9),
                rgba(245,239,255,.9),
                rgba(255,241,248,.9)
            );

        border: 2px dashed #c8d9ee;
        border-radius: 18px;

        padding: 35px 20px;

        text-align: center;
        cursor: pointer;

        transition: .3s;
    }

    .writer-upload-box:hover {
        border-color: #8ebde7;

        background: linear-gradient(
            135deg,
            #e7f4ff,
            #f0eaff,
            #fcecf6
        );

        transform: translateY(-2px);
    }

    .writer-upload-icon {
        width: 62px;
        height: 62px;

        display: flex;
        align-items: center;
        justify-content: center;

        margin: 0 auto 13px;

        border-radius: 20px;

        background: rgba(255,255,255,.8);
        color: #80a9db;

        font-size: 25px;

        box-shadow: 0 5px 15px rgba(120,150,200,.08);
    }

    .writer-upload-title {
        color: #53617c;
        font-size: 14px;
        font-weight: 800;
        margin-bottom: 5px;
    }

    .writer-upload-description {
        color: #929db2;
        font-size: 12px;
        margin: 0;
    }

    .writer-upload-formats {
        display: inline-block;

        margin-top: 12px;
        padding: 5px 12px;

        background: rgba(255,255,255,.8);
        border-radius: 30px;

        color: #8298c6;
        font-size: 11px;
        font-weight: 700;
    }

    /* =========================================
       COVER PREVIEW
    ========================================= */

    .writer-cover-preview-container {
        margin-top: 20px;
        padding: 18px;

        background: #f8faff;
        border: 1px solid #e7edf7;
        border-radius: 16px;
    }

    .writer-cover-preview {
        max-width: 180px;
        max-height: 250px;

        border-radius: 12px;
        object-fit: cover;

        border: 3px solid #ffffff;

        box-shadow: 0 8px 20px rgba(100,130,180,.15);
    }

    .writer-preview-label {
        color: #53617c;
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 12px;
    }

    .writer-clear-cover {
        margin-top: 12px;

        background: #fff0f3;
        border: 1px solid #f5d5de;

        color: #d66c83;

        padding: 7px 14px;
        border-radius: 10px;

        font-size: 12px;
        font-weight: 700;

        transition: .2s;
    }

    .writer-clear-cover:hover {
        background: #ffe2e9;
    }

    /* =========================================
       ERROR MESSAGE
    ========================================= */

    .writer-error-box {
        padding: 15px 18px;

        background: #fff0f3;
        color: #c65e78;

        border: 1px solid #f5d5de;
        border-radius: 14px;

        font-size: 13px;
    }

    .writer-error-box ul {
        margin-bottom: 0;
    }

    /* =========================================
       FORM FOOTER / SUBMIT
    ========================================= */

    .writer-form-footer {
        margin-top: 30px;
        padding-top: 23px;

        border-top: 1px solid #edf0f8;
    }

    .writer-submit-button {
        width: 100%;
        min-height: 53px;

        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;

        background: linear-gradient(
            120deg,
            #83bce9,
            #9c9de7,
            #c8a7df
        );

        color: #ffffff;

        border: none;
        border-radius: 14px;

        font-size: 14px;
        font-weight: 800;

        box-shadow: 0 7px 18px rgba(130,155,210,.2);

        transition: .25s;
    }

    .writer-submit-button:hover {
        background: linear-gradient(
            120deg,
            #6faadd,
            #898bdc,
            #b994d5
        );

        transform: translateY(-2px);

        box-shadow: 0 10px 23px rgba(130,155,210,.27);
    }

    /* =========================================
       RESPONSIVE
    ========================================= */

    @media(max-width: 768px) {
        .writer-form-body {
            padding: 23px 19px;
        }

        .writer-form-header {
            padding: 24px 20px;
        }

        .writer-form-header-icon {
            display: none;
        }
    }

    @media(max-width: 480px) {
        .writer-form-container {
            padding: 0 12px;
        }

        .writer-form-header h3 {
            font-size: 20px;
        }

        .writer-form-body {
            padding: 20px 15px;
        }

        .writer-upload-box {
            padding: 27px 13px;
        }
    }
</style>


<div class="writer-form-page">

    <div class="container-fluid writer-form-container">

        <!-- KEMBALI -->

        <div class="mb-4">

            <a href="{{ route('writer.books.index') }}"
               class="writer-back-link">

                <i class="fa-solid fa-arrow-left"></i>

                Kembali ke Studio

            </a>

        </div>


        <!-- FORM CARD -->

        <div class="writer-form-card">


            <!-- HEADER -->

            <div class="writer-form-header">

                <div class="writer-form-header-icon">
                    <i class="fa-solid fa-book-open"></i>
                </div>

                <h3>
                    <i class="fa-solid fa-feather-pointed me-2"
                       style="color:#819bd5;"></i>

                    Buat Informasi Novel Baru
                </h3>

                <p>
                    Lengkapi detail metadata novel Anda sebelum mulai menulis bab cerita.
                </p>

            </div>


            <!-- BODY -->

            <div class="writer-form-body">


                <!-- VALIDATION ERROR -->

                @if ($errors->any())

                    <div class="writer-error-box mb-4">

                        <div class="fw-bold mb-2">

                            <i class="fa-solid fa-circle-exclamation me-2"></i>

                            Terdapat kesalahan pada formulir:

                        </div>

                        <ul class="ps-4">

                            @foreach ($errors->all() as $error)

                                <li>{{ $error }}</li>

                            @endforeach

                        </ul>

                    </div>

                @endif


                <form action="{{ route('writer.books.store') }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf


                    <!-- INFORMASI DASAR -->

                    <div class="writer-form-section-title">

                        <i class="fa-solid fa-circle-info"></i>

                        Informasi Dasar Buku

                    </div>


                    <div class="row g-4">

                        <!-- JUDUL -->

                        <div class="col-md-6">

                            <label class="writer-form-label">

                                Judul Novel

                                <span class="writer-required">*</span>

                            </label>

                            <input
                                type="text"
                                name="title"
                                class="form-control writer-form-control"
                                placeholder="Masukkan judul novel..."
                                value="{{ old('title') }}"
                                required>

                        </div>


                        <!-- PENULIS -->

                        <div class="col-md-6">

                            <label class="writer-form-label">

                                Nama Penulis / Pena

                                <span class="writer-required">*</span>

                            </label>

                            <input
                                type="text"
                                name="author"
                                class="form-control writer-form-control"
                                value="{{ old('author', Auth::user()->username ?? '') }}"
                                placeholder="Nama penulis"
                                required>

                        </div>


                        <!-- GENRE -->

                        <div class="col-md-6">

                            <label class="writer-form-label">

                                Genre

                                <span class="writer-required">*</span>

                            </label>

                            <select
                                name="genre"
                                class="form-select writer-form-control"
                                required>

                                <option value="">-- Pilih Genre --</option>

                                @foreach([
                                    'Novel' => 'Novel',
                                    'Romance' => 'Romantis',
                                    'Fantasi' => 'Fantasi',
                                    'Horror' => 'Horror',
                                    'Misteri' => 'Misteri',
                                    'Komedi' => 'Komedi',
                                    'Pemrograman' => 'Pemrograman',
                                    'Hobi' => 'Hobi'
                                ] as $value => $label)

                                    <option
                                        value="{{ $value }}"
                                        {{ old('genre') == $value ? 'selected' : '' }}>

                                        {{ $label }}

                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <!-- TAHUN -->

                        <div class="col-md-6">

                            <label class="writer-form-label">

                                Tahun

                                <span class="writer-required">*</span>

                            </label>

                            <input
                                type="number"
                                name="year"
                                class="form-control writer-form-control"
                                value="{{ old('year', date('Y')) }}"
                                placeholder="Tahun terbit"
                                required>

                        </div>


                        <!-- STATUS -->

                        <div class="col-12">

                            <label class="writer-form-label">

                                Status Buku

                                <span class="writer-required">*</span>

                            </label>

                            <select
                                name="status"
                                class="form-select writer-form-control"
                                required>

                                <option
                                    value="draft"
                                    {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>

                                    📝 Draft (Belum Ditampilkan ke Publik)

                                </option>

                                <option
                                    value="published"
                                    {{ old('status') == 'published' ? 'selected' : '' }}>

                                    🚀 Published (Tampil di Katalog Umum)

                                </option>

                            </select>

                            <div class="writer-status-hint">

                                <i class="fa-solid fa-circle-info"></i>

                                <span>
                                    Pilih Draft jika buku belum siap ditampilkan,
                                    atau Published jika ingin mengajukan publikasi buku.
                                </span>

                            </div>

                        </div>


                        <!-- SINOPSIS -->

                        <div class="col-12">

                            <label class="writer-form-label">

                                Sinopsis / Deskripsi Buku

                                <span class="writer-required">*</span>

                            </label>

                            <textarea
                                name="description"
                                class="form-control writer-form-control"
                                rows="4"
                                placeholder="Tuliskan ringkasan cerita novel Anda..."
                                required>{{ old('description') }}</textarea>

                        </div>


                    </div>


                    <!-- COVER -->

                    <div class="writer-form-section-title mt-5">

                        <i class="fa-solid fa-image"></i>

                        Cover Buku

                    </div>


                    <div class="mb-3">

                        <label class="writer-form-label">

                            Cover Buku (Poster Utama)

                        </label>


                        <div class="writer-upload-box"
                             onclick="document.getElementById('coverInput').click()">

                            <div class="writer-upload-icon">

                                <i class="fa-solid fa-cloud-arrow-up"></i>

                            </div>

                            <div class="writer-upload-title">

                                Klik untuk unggah cover buku

                            </div>

                            <p class="writer-upload-description">

                                Pilih gambar cover terbaik untuk karya Anda.

                            </p>

                            <span class="writer-upload-formats">

                                JPG · PNG · WEBP · Maksimal 2MB

                            </span>

                        </div>


                        <input
                            type="file"
                            name="cover"
                            id="coverInput"
                            class="d-none"
                            accept="image/jpeg,image/png,image/webp"
                            onchange="previewCover(event)">


                        <!-- PREVIEW -->

                        <div id="coverPreviewContainer"
                             class="writer-cover-preview-container text-center d-none">

                            <div class="writer-preview-label">

                                <i class="fa-solid fa-circle-check me-1"
                                   style="color:#58ae89;"></i>

                                Preview Cover Buku

                            </div>

                            <img
                                id="coverPreviewImg"
                                class="writer-cover-preview mb-2"
                                alt="Preview cover buku">

                            <div>

                                <button
                                    type="button"
                                    class="writer-clear-cover"
                                    onclick="clearCover()">

                                    <i class="fa-solid fa-trash-can me-1"></i>

                                    Hapus Cover

                                </button>

                            </div>

                        </div>

                    </div>


                    <!-- SUBMIT -->

                    <div class="writer-form-footer">

                        <button type="submit"
                                class="writer-submit-button">

                            <i class="fa-solid fa-arrow-right"></i>

                            Lanjut ke Tulis Chapter

                        </button>

                    </div>


                </form>

            </div>

        </div>

    </div>

</div>


<!-- =========================================
     PREVIEW COVER SCRIPT
========================================= -->

<script>

function previewCover(event) {

    const file = event.target.files[0];

    if (!file) {
        return;
    }

    const allowedTypes = [
        'image/jpeg',
        'image/png',
        'image/webp'
    ];

    if (!allowedTypes.includes(file.type)) {

        alert('Format cover harus JPG, PNG, atau WEBP.');

        event.target.value = '';

        return;
    }

    if (file.size > 2 * 1024 * 1024) {

        alert('Ukuran cover maksimal 2MB.');

        event.target.value = '';

        return;
    }

    const reader = new FileReader();

    reader.onload = function(e) {

        document.getElementById('coverPreviewImg').src = e.target.result;

        document.getElementById('coverPreviewContainer')
            .classList.remove('d-none');

    };

    reader.readAsDataURL(file);

}


function clearCover() {

    document.getElementById('coverInput').value = '';

    document.getElementById('coverPreviewImg').src = '';

    document.getElementById('coverPreviewContainer')
        .classList.add('d-none');

}

</script>

@endsection
