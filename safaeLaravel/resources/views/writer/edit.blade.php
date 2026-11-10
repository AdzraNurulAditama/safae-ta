
@extends('layouts.app')

@section('title', 'Edit Detail Buku - ' . $book->title)

@section('content')
<style>
    .writer-form-container {
        max-width: 850px;
        margin: 0 auto;
    }

    .form-card {
        background: rgba(255, 255, 255, .95);
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(148, 163, 184, .12);
    }

    .form-dark {
        background-color: #f8fafc !important;
        color: #334155 !important;
        border: 1px solid #dbe3ef !important;
        border-radius: 12px;
        padding: 14px 18px;
        transition: .3s;
    }

    .form-dark:focus {
        background-color: #fff !important;
        color: #334155 !important;
        border-color: #a5b4fc !important;
        box-shadow: 0 0 0 3px rgba(167, 139, 250, .15) !important;
    }

    .form-dark::placeholder {
        color: #94a3b8;
    }

    .form-dark option {
        background: #fff;
        color: #334155;
    }

    .writer-form-container .form-label {
        color: #475569;
        font-weight: 700;
        font-size: 13px;
        margin-bottom: 8px;
    }

    .writer-form-container h3 {
        color: #334155;
    }

    .writer-form-container .text-muted {
        color: #94a3b8 !important;
    }

    .writer-form-container .text-primary {
        color: #8b5cf6 !important;
    }

    .writer-form-container .text-info {
        color: #0ea5e9 !important;
    }

    .upload-box {
        background: linear-gradient(135deg, #f0f9ff, #f5f3ff);
        border: 2px dashed #c4b5fd;
        border-radius: 14px;
        padding: 30px;
        text-align: center;
        cursor: pointer;
        transition: .3s;
    }

    .upload-box:hover {
        border-color: #93c5fd;
        background: linear-gradient(135deg, #e0f2fe, #ede9fe);
    }

    .upload-box i {
        color: #a78bfa !important;
    }

    .upload-box p {
        color: #475569 !important;
    }

    .cover-preview {
        max-width: 180px;
        max-height: 250px;
        border-radius: 10px;
        object-fit: cover;
        border: 2px solid #e2e8f0;
        box-shadow: 0 5px 15px rgba(148, 163, 184, .15);
    }

    .writer-back {
        color: #64748b;
        transition: .3s;
    }

    .writer-back:hover {
        color: #8b5cf6;
    }

    .writer-submit-btn {
        background: linear-gradient(135deg, #93c5fd, #c4b5fd) !important;
        color: #3730a3 !important;
        border: none;
        border-radius: 12px;
        transition: .3s;
        box-shadow: 0 5px 14px rgba(139, 92, 246, .13);
    }

    .writer-submit-btn:hover {
        background: linear-gradient(135deg, #bfdbfe, #ddd6fe) !important;
        color: #3730a3 !important;
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(139, 92, 246, .2);
    }

    .writer-form-container .alert-danger {
        background: #fff1f2 !important;
        color: #be123c !important;
        border: 1px solid #fecdd3 !important;
    }

    .writer-info {
        display: block;
        color: #94a3b8;
        font-size: 11px;
        line-height: 1.6;
    }

    @media (max-width: 576px) {
        .form-card {
            padding: 22px !important;
        }

        .upload-box {
            padding: 22px 15px;
        }
    }
</style>

<div class="container-fluid writer-form-container my-4">

    <!-- NAVIGASI KEMBALI -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('writer.books.index') }}"
           class="writer-back text-decoration-none fw-semibold">
            <i class="fa-solid fa-arrow-left me-1"></i>
            Kembali ke Studio
        </a>
    </div>

    <!-- FORM EDIT BUKU -->
    <div class="card form-card p-4 p-md-5">

        <h3 class="fw-bold mb-1">
            <i class="fa-solid fa-pen-to-square text-primary me-2"></i>
            Edit Informasi Novel
        </h3>

        <p class="text-muted mb-4">
            Perbarui metadata utama buku atau poster sampul Anda.
        </p>

        <!-- VALIDASI ERROR -->
        @if ($errors->any())
            <div class="alert alert-danger rounded-3 mb-4">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('/penulis/buku/'.$book->id.'/update') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="row g-4">

                <!-- JUDUL NOVEL -->
                <div class="col-md-6">
                    <label class="form-label">Judul Novel</label>
                    <input
                        type="text"
                        name="title"
                        class="form-control form-dark"
                        value="{{ old('title', $book->title) }}"
                        required
                    >
                </div>

                <!-- NAMA PENULIS -->
                <div class="col-md-6">
                    <label class="form-label">Nama Penulis / Pena</label>
                    <input
                        type="text"
                        name="author"
                        class="form-control form-dark"
                        value="{{ old('author', $book->author) }}"
                        required
                    >
                </div>

                <!-- GENRE -->
                <div class="col-md-6">
                    <label class="form-label">Genre</label>
                    <select name="genre" class="form-select form-dark" required>
                        @foreach(['Novel', 'Romance', 'Fantasi', 'Horror', 'Misteri', 'Komedi', 'Pemrograman', 'Hobi'] as $genreOption)
                            <option value="{{ $genreOption }}"
                                {{ (old('genre', $book->genre) == $genreOption) ? 'selected' : '' }}>
                                {{ $genreOption }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- TAHUN -->
                <div class="col-md-6">
                    <label class="form-label">Tahun</label>
                    <input
                        type="number"
                        name="year"
                        class="form-control form-dark"
                        value="{{ old('year', $book->year) }}"
                        required
                    >
                </div>

                <!-- STATUS BUKU -->
                <div class="col-12">
                    <label class="form-label">Status Buku</label>

                    <select name="status" class="form-select form-dark" required>
                        <option value="draft"
                            {{ (old('status', $book->status) == 'draft') ? 'selected' : '' }}>
                            📝 Draf (Belum Ditampilkan ke Publik)
                        </option>

                        <option value="published"
                            {{ (old('status', $book->status) == 'published' || old('status', $book->status) == 'pending') ? 'selected' : '' }}>
                            🚀 Ajukan Publikasi (Menunggu Validasi Admin)
                        </option>
                    </select>

                    <small class="writer-info mt-2">
                        <i class="fa-solid fa-circle-info me-1 text-info"></i>
                        Memilih "Ajukan Publikasi" akan mengirimkan buku Anda ke antrean peninjauan admin sebelum tampil di katalog umum.
                    </small>
                </div>

                <!-- SINOPSIS -->
                <div class="col-12">
                    <label class="form-label">Sinopsis / Deskripsi Buku</label>

                    <textarea
                        name="description"
                        class="form-control form-dark"
                        rows="4"
                        required
                    >{{ old('description', $book->description) }}</textarea>
                </div>

                <!-- COVER BUKU -->
                <div class="col-12">
                    <label class="form-label">Cover Buku Utama</label>

                    @if($book->image_path)
                        <div class="mb-3">
                            <p class="text-muted small mb-2">Cover saat ini:</p>

                            <img
                                src="{{ asset('storage/' . $book->image_path) }}"
                                class="cover-preview mb-2"
                                alt="Cover Buku"
                            >
                        </div>
                    @endif

                    <div class="upload-box"
                         onclick="document.getElementById('coverInput').click()">

                        <i class="fa-solid fa-cloud-arrow-up fa-3x mb-2"></i>

                        <p class="fw-bold mb-1">
                            Klik untuk ganti cover buku
                        </p>

                        <small class="text-muted">
                            Format JPG, PNG, WEBP (Maksimal 2MB)
                        </small>
                    </div>

                    <input
                        type="file"
                        name="cover"
                        id="coverInput"
                        class="d-none"
                        accept="image/*"
                        onchange="previewCover(event)"
                    >

                    <!-- PREVIEW COVER BARU -->
                    <div id="coverPreviewContainer"
                         class="mt-3 text-center d-none">

                        <p class="text-muted small mb-2">Cover baru:</p>

                        <img
                            id="coverPreviewImg"
                            class="cover-preview mb-2"
                            alt="Preview Cover Baru"
                        >
                    </div>
                </div>

                <!-- TOMBOL SUBMIT -->
                <div class="col-12 mt-4">
                    <button
                        type="submit"
                        class="btn writer-submit-btn w-100 py-3 fw-bold"
                    >
                        <i class="fa-solid fa-floppy-disk me-1"></i>
                        Perbarui Informasi Buku
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

<script>
function previewCover(event) {
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            document.getElementById('coverPreviewImg').src = e.target.result;
            document.getElementById('coverPreviewContainer').classList.remove('d-none');
        }

        reader.readAsDataURL(file);
    }
}
</script>
@endsection
