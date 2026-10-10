@extends('layouts.app')

@section('title', 'Tulis Buku Baru - Safae')

@section('content')

<style>

    /* ================= CONTAINER & CARD ================= */

    .writing-container{
        max-width:900px;
        margin:0 auto;
    }

    .writing-card{
        background:#1e293b;

        border:1px solid #334155;

        border-radius:20px;

        box-shadow:0 10px 30px rgba(0,0,0,.15);

        overflow:hidden;
    }

    .card-header-custom{
        background:transparent;

        border-bottom:1px solid #334155;

        padding:25px 30px;
    }

    .page-title{
        color:#f1f5f9;

        font-weight:800;

        margin-bottom:5px;
    }

    /* ================= INFO BOX ================= */

    .info-box{
        background:rgba(56,189,248,.1);

        border-left:4px solid #38bdf8;

        color:#e2e8f0;

        padding:15px 20px;

        border-radius:0 12px 12px 0;

        margin-bottom:25px;
    }

    /* ================= FORM ELEMENTS ================= */

    .form-label{
        color:#e2e8f0;

        font-weight:600;

        font-size:.95rem;

        margin-bottom:10px;
    }

    .form-control,
    .form-select{
        background-color:#0f172a;

        color:#f8fafc;

        border:1px solid #334155;

        border-radius:12px;

        padding:14px 18px;

        transition:.3s ease;
    }

    .form-control:focus,
    .form-select:focus{
        border-color:#38bdf8;

        box-shadow:0 0 0 3px rgba(56,189,248,.15);

        outline:none;

        color:#fff;
    }

    .form-control::placeholder{
        color:#64748b;
    }

    .form-select{
        appearance:none;

        background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath fill='none' stroke='%2394a3b8' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3E%3C/svg%3E");

        background-repeat:no-repeat;

        background-position:right 1rem center;

        background-size:16px 12px;
    }

    textarea.form-control{
        min-height:350px;

        line-height:1.8;

        resize:vertical;
    }

    /* ================= UPLOAD ================= */

    .upload-area{
        background:#0f172a;

        border:2px dashed #334155;

        border-radius:14px;

        padding:40px 20px;

        text-align:center;

        transition:.3s ease;

        cursor:pointer;

        color:#94a3b8;
    }

    .upload-area:hover{
        border-color:#38bdf8;

        background:rgba(56,189,248,.05);

        color:#38bdf8;
    }

    .preview-image{
        max-width:200px;
        max-height:280px;

        margin-top:20px;

        border-radius:12px;

        box-shadow:0 10px 25px rgba(0,0,0,.3);

        border:1px solid #334155;

        object-fit:cover;
    }

    /* ================= BUTTON ================= */

    .btn-submit{
        background:#38bdf8;

        color:#0f172a;

        border:none;

        padding:16px 30px;

        border-radius:14px;

        font-weight:700;

        font-size:1.05rem;

        transition:.3s ease;

        width:100%;

        display:flex;
        align-items:center;
        justify-content:center;

        gap:10px;
    }

    .btn-submit:hover{
        background:#7dd3fc;

        transform:translateY(-2px);

        box-shadow:0 10px 20px rgba(56,189,248,.2);
    }

    .btn-back{
        color:#94a3b8;

        text-decoration:none;

        font-weight:600;

        transition:.3s;
    }

    .btn-back:hover{
        color:#f1f5f9;
    }

    /* ================= ALERT ================= */

    .alert-success-custom{
        background:rgba(34,197,94,.1);

        border:1px solid rgba(34,197,94,.3);

        color:#4ade80;

        border-radius:12px;
    }

    .alert-danger-custom{
        background:rgba(248,113,113,.1);

        border:1px solid rgba(248,113,113,.3);

        color:#f87171;

        border-radius:12px;
    }

    /* ================= GUIDE SECTION ================= */

    .guide-card{
        background:rgba(255,255,255,.03);

        border:1px solid #334155;

        border-radius:18px;

        padding:20px;

        height:100%;

        transition:.25s ease;
    }

    .guide-card:hover{
        border-color:#38bdf8;

        transform:translateY(-4px);

        background:rgba(56,189,248,.05);
    }

    .guide-title{
        color:#f8fafc;

        font-weight:700;

        font-size:1.05rem;
    }

    .guide-text{
        color:#cbd5e1;

        font-size:.92rem;

        line-height:1.7;

        margin-top:8px;
    }

</style>

<div class="container-fluid writing-container">

    <!-- ================= FORM CARD ================= -->

    <div class="card writing-card mb-4">

        <div class="card-header-custom">

            <div class="d-flex align-items-center">

                <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">

                    <i class="fa-solid fa-pen-nib fa-2x text-primary"></i>

                </div>

                <div>

                    <h3 class="page-title">
                        Tulis Buku Baru
                    </h3>

                    <p class="mb-0 text-muted">
                        Bagikan imajinasi, cerita, dan karya Anda dengan dunia.
                    </p>

                </div>

            </div>

        </div>

        <div class="card-body p-4 p-md-5">

            @if (session('success'))

                <div class="alert alert-success-custom d-flex align-items-center mb-4">

                    <i class="fa-solid fa-circle-check fa-lg me-3"></i>

                    <div>
                        {{ session('success') }}
                    </div>

                </div>

            @endif

            @if ($errors->any())

                <div class="alert alert-danger-custom mb-4">

                    <div class="d-flex align-items-center mb-2">

                        <i class="fa-solid fa-triangle-exclamation fa-lg me-2"></i>

                        <strong>
                            Terjadi kesalahan:
                        </strong>

                    </div>

                    <ul class="mb-0 ps-4">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <div class="info-box">

                <i class="fa-solid fa-circle-info me-2 text-primary"></i>

                Buku yang Anda kirim akan melalui proses validasi oleh tim Safae sebelum dipublikasikan.

            </div>

            <form action="{{ url('/tulis-buku/store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="row g-4">

                    <!-- JUDUL -->
                    <div class="col-md-6">

                        <label class="form-label">

                            <i class="fa-solid fa-heading me-2 text-primary"></i>

                            Judul Buku

                        </label>

                        <input type="text"
                               name="title"
                               class="form-control"
                               placeholder="Masukkan judul yang menarik..."
                               value="{{ old('title') }}"
                               required>

                    </div>

                    <!-- AUTHOR -->
                    <div class="col-md-6">

                        <label class="form-label">

                            <i class="fa-solid fa-user-pen me-2 text-primary"></i>

                            Nama Penulis

                        </label>

                        <input type="text"
                               name="author"
                               class="form-control"
                               placeholder="Nama pena Anda"
                               value="{{ old('author', Auth::user()->username ?? '') }}"
                               required>

                    </div>

                    <!-- GENRE -->
                    <div class="col-md-6">

                        <label class="form-label">

                            <i class="fa-solid fa-layer-group me-2 text-primary"></i>

                            Genre

                        </label>

                        <select name="genre"
                                class="form-select"
                                required>

                            <option value="">-- Pilih Genre --</option>

                            <option value="Pemrograman">Pemrograman</option>
                            <option value="Novel">Novel</option>
                            <option value="Hobi">Hobi</option>
                            <option value="Horror">Horror</option>
                            <option value="Romance">Romantis</option>
                            <option value="Fantasi">Fantasi</option>
                            <option value="Komedi">Komedi</option>
                            <option value="Misteri">Misteri</option>

                        </select>

                    </div>

                    <!-- YEAR -->
                    <div class="col-md-6">

                        <label class="form-label">

                            <i class="fa-regular fa-calendar-days me-2 text-primary"></i>

                            Tahun Terbit

                        </label>

                        <input type="number"
                               name="year"
                               class="form-control"
                               value="{{ old('year', date('Y')) }}"
                               required>

                    </div>

                    <!-- DESCRIPTION -->
                    <div class="col-12">

                        <label class="form-label">

                            <i class="fa-solid fa-align-left me-2 text-primary"></i>

                            Deskripsi / Sinopsis

                        </label>

                        <textarea name="description"
                                  class="form-control"
                                  style="min-height:120px;"
                                  placeholder="Tuliskan sinopsis singkat..."
                                  required>{{ old('description') }}</textarea>

                    </div>

                    <!-- IMAGE -->
                    <div class="col-12">

                        <label class="form-label">

                            <i class="fa-regular fa-image me-2 text-primary"></i>

                            Cover Buku

                        </label>

                        <div class="upload-area"
                             onclick="document.getElementById('imageUpload').click()">

                            <i class="fa-solid fa-cloud-arrow-up fa-3x mb-3"
                               style="color:#475569;"></i>

                            <h5 class="text-white mb-1">
                                Klik untuk upload cover buku
                            </h5>

                            <small class="text-muted">
                                JPG, PNG, WEBP (Max 2MB)
                            </small>

                        </div>

                        <input type="file"
                               name="image"
                               id="imageUpload"
                               class="d-none"
                               accept="image/*"
                               onchange="previewImage(event)">

                        <div id="imagePreview"
                             class="text-center"></div>

                    </div>

                    <!-- CONTENT -->
                    <div class="col-12 mt-4">

                        <label class="form-label">

                            <i class="fa-solid fa-book-open-reader me-2 text-primary"></i>

                            Isi Buku / Naskah

                        </label>

                        <textarea name="content"
                                  class="form-control"
                                  placeholder="Mulai menulis cerita Anda..."
                                  required>{{ old('content') }}</textarea>

                    </div>

                    <!-- BUTTON -->
                    <div class="col-12 mt-5">

                        <button type="submit"
                                class="btn-submit">

                            <i class="fa-solid fa-paper-plane"></i>

                            Kirim Naskah Buku

                        </button>

                        <div class="text-center mt-4">

                            <a href="{{ route('user.dashboard') }}"
                               class="btn-back">

                                <i class="fa-solid fa-arrow-left me-1"></i>

                                Kembali ke Dashboard

                            </a>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <!-- ================= GUIDE ================= -->

    <div class="card writing-card mb-5">

        <div class="card-body p-4">

            <h5 class="text-white fw-bold mb-4">

                <i class="fa-regular fa-lightbulb me-2 text-warning"></i>

                Panduan Penulisan Safae

            </h5>

            <div class="row g-4">

                <!-- ITEM 1 -->
                <div class="col-md-4">

                    <div class="guide-card">

                        <div class="d-flex align-items-start">

                            <i class="fa-solid fa-circle-check text-success me-3 mt-1 fs-5"></i>

                            <div>

                                <strong class="guide-title">
                                    Judul Memikat
                                </strong>

                                <p class="guide-text mb-0">
                                    Buatlah judul yang eye-catching namun tetap merepresentasikan isi cerita Anda.
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- ITEM 2 -->
                <div class="col-md-4">

                    <div class="guide-card">

                        <div class="d-flex align-items-start">

                            <i class="fa-solid fa-circle-check text-success me-3 mt-1 fs-5"></i>

                            <div>

                                <strong class="guide-title">
                                    Resolusi Cover
                                </strong>

                                <p class="guide-text mb-0">
                                    Gunakan rasio potret seperti 3:4 dengan resolusi tinggi agar cover tetap tajam.
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- ITEM 3 -->
                <div class="col-md-4">

                    <div class="guide-card">

                        <div class="d-flex align-items-start">

                            <i class="fa-solid fa-circle-check text-success me-3 mt-1 fs-5"></i>

                            <div>

                                <strong class="guide-title">
                                    Orisinalitas
                                </strong>

                                <p class="guide-text mb-0">
                                    Pastikan naskah merupakan karya asli Anda dan tidak melanggar hak cipta.
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<script>

function previewImage(event){

    const reader = new FileReader();

    reader.onload = function(){

        const preview = document.getElementById('imagePreview');

        preview.innerHTML = `
            <img src="${reader.result}" class="preview-image">
            <div class="mt-3 text-success fw-bold">
                <i class="fa-solid fa-check-circle me-1"></i>
                Cover berhasil dipilih
            </div>
        `;
    }

    if(event.target.files[0]){
        reader.readAsDataURL(event.target.files[0]);
    }
}

</script>

@endsection