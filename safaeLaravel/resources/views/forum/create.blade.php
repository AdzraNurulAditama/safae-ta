
@extends('layouts.app')

@section('title', 'Tambah Topik Forum - Safae')

@section('content')

<style>
    /* ================= HEADER & UTILITIES ================= */
    .page-title {
        color: #514d69;
        font-weight: 800;
        margin-bottom: 10px;
    }
    
    .form-container {
        max-width: 800px; /* Agar form tidak terlalu lebar di layar PC */
        margin: 0 auto;
    }

    /* ================= CARD ================= */
    .form-card {
        background: #ffffff;
        border: 1px solid #e5def5;
        border-radius: 20px;
        padding: 35px;
        box-shadow: 0 10px 30px rgba(185, 165, 232, 0.12);
    }

    /* ================= FORM ELEMENTS ================= */
    .form-label-modern {
        color: #514d69;
        font-weight: 600;
        font-size: 0.95rem;
        margin-bottom: 8px;
        display: inline-block;
    }

    .form-control-modern {
        background-color: #faf9fd;
        color: #514d69;
        border: 1px solid #ded6ef;
        border-radius: 14px;
        padding: 14px 18px;
        transition: 0.3s;
        width: 100%;
    }

    .form-control-modern:focus {
        border-color: #b9a5e8;
        box-shadow: 0 0 0 3px rgba(185, 165, 232, 0.15);
        outline: none;
        color: #514d69;
    }

    .form-control-modern::placeholder {
        color: #aaa3bc;
    }

    /* Custom File Input */
    .form-control-modern[type="file"] {
        padding: 10px 14px;
    }

    .form-control-modern::file-selector-button {
        background: #eee8f8;
        color: #514d69;
        border: none;
        padding: 8px 16px;
        border-radius: 10px;
        margin-right: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
    }

    .form-control-modern::file-selector-button:hover {
        background: #e5def5;
        color: #a48bdc;
    }

    /* ================= BUTTONS ================= */
    .btn-submit {
        background: #b9a5e8;
        color: #ffffff;
        border: none;
        border-radius: 14px;
        font-weight: 700;
        padding: 15px;
        font-size: 1.05rem;
        transition: 0.3s ease;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        width: 100%;
    }

    .btn-submit:hover {
        background: #a48bdc;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(185, 165, 232, 0.2);
    }

    .btn-back {
        color: #89839f;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: 0.3s;
    }

    .btn-back:hover {
        color: #a48bdc;
    }

    /* ================= ICON COLORS ================= */
    .page-title .text-primary {
        color: #b9a5e8 !important;
    }

    .form-label-modern .text-info {
        color: #82a9d8 !important;
    }

    .form-label-modern .text-success {
        color: #65a98c !important;
    }

    .text-muted {
        color: #89839f !important;
    }
</style>

<div class="container-fluid form-container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="page-title">
                <i class="fa-solid fa-pen-to-square me-2 text-primary"></i> Tambah Topik Baru
            </h3>
            <p class="text-muted m-0">Buat diskusi baru dan mulai berinteraksi dengan pembaca lain.</p>
        </div>
        <a href="{{ route('forum.index') }}" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="form-card">
        <form action="{{ route('forum.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="genre_id" value="{{ $genre_id }}">

            <div class="mb-4">
                <label class="form-label-modern">Judul Topik</label>
                <input type="text" class="form-control-modern" name="judul" placeholder="Tuliskan judul topik diskusimu di sini..." required>
            </div>

            <div class="mb-4">
                <label class="form-label-modern">Isi Topik</label>
                <textarea class="form-control-modern" name="isi" rows="6" placeholder="Ceritakan pendapatmu atau pertanyaanmu secara detail..." required></textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <label class="form-label-modern">
                        <i class="fa-regular fa-image me-1 text-info"></i> Upload Gambar <span class="text-muted fw-normal">(Opsional)</span>
                    </label>
                    <input type="file" class="form-control-modern" name="gambar" accept="image/*">
                </div>

                <div class="col-md-6 mb-5">
                    <label class="form-label-modern">
                        <i class="fa-regular fa-file-lines me-1 text-success"></i> Upload File <span class="text-muted fw-normal">(Opsional)</span>
                    </label>
                    <input type="file" class="form-control-modern" name="file">
                </div>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fa-solid fa-paper-plane"></i> Posting Topik
            </button>
            
        </form>
    </div>

</div>
@endsection
