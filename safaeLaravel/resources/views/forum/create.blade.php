@extends('layouts.app')

@section('title', 'Tambah Topik Forum - Safae')

@section('content')

<style>
    /* ================= HEADER & UTILITIES ================= */
    .page-title {
        color: #f1f5f9;
        font-weight: 800;
        margin-bottom: 10px;
    }
    
    .form-container {
        max-width: 800px; /* Agar form tidak terlalu lebar di layar PC */
        margin: 0 auto;
    }

    /* ================= CARD ================= */
    .form-card {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 20px;
        padding: 35px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    /* ================= FORM ELEMENTS ================= */
    .form-label-modern {
        color: #e2e8f0;
        font-weight: 600;
        font-size: 0.95rem;
        margin-bottom: 8px;
        display: inline-block;
    }

    .form-control-modern {
        background-color: #0f172a;
        color: #f8fafc;
        border: 1px solid #334155;
        border-radius: 14px;
        padding: 14px 18px;
        transition: 0.3s;
        width: 100%;
    }

    .form-control-modern:focus {
        border-color: #38bdf8;
        box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.15);
        outline: none;
        color: #fff;
    }

    .form-control-modern::placeholder {
        color: #64748b;
    }

    /* Custom File Input */
    .form-control-modern[type="file"] {
        padding: 10px 14px;
    }

    .form-control-modern::file-selector-button {
        background: #334155;
        color: #f1f5f9;
        border: none;
        padding: 8px 16px;
        border-radius: 10px;
        margin-right: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
    }

    .form-control-modern::file-selector-button:hover {
        background: #475569;
        color: #38bdf8;
    }

    /* ================= BUTTONS ================= */
    .btn-submit {
        background: #38bdf8;
        color: #0f172a;
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
        background: #7dd3fc;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(56, 189, 248, 0.2);
    }

    .btn-back {
        color: #94a3b8;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: 0.3s;
    }

    .btn-back:hover {
        color: #f1f5f9;
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