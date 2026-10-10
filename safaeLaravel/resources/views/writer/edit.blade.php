@extends('layouts.app')

@section('title', 'Edit Detail Buku - ' . $book->title)

@section('content')
<style>
    .writer-form-container {
        max-width: 850px;
        margin: 0 auto;
    }
    .form-card {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,.2);
    }
    .form-dark {
        background-color: #0f172a !important;
        color: #f8fafc !important;
        border: 1px solid #334155 !important;
        border-radius: 12px;
        padding: 14px 18px;
    }
    .form-dark:focus {
        border-color: #38bdf8 !important;
        box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.15) !important;
    }
    .upload-box {
        background: #0f172a;
        border: 2px dashed #334155;
        border-radius: 12px;
        padding: 30px;
        text-align: center;
        cursor: pointer;
        transition: 0.3s;
    }
    .upload-box:hover {
        border-color: #38bdf8;
        background: rgba(56, 189, 248, 0.05);
    }
    .cover-preview {
        max-width: 180px;
        max-height: 250px;
        border-radius: 10px;
        object-fit: cover;
        border: 1px solid #334155;
    }
</style>

<div class="container-fluid writer-form-container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('writer.books.index') }}" class="text-muted text-decoration-none fw-semibold">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Studio
        </a>
    </div>

    <div class="card form-card p-4 p-md-5">
        <h3 class="text-white fw-bold mb-1">
            <i class="fa-solid fa-pen-to-square text-primary me-2"></i> Edit Informasi Novel
        </h3>
        <p class="text-muted mb-4">Perbarui metadata utama buku atau poster sampul Anda.</p>

        @if ($errors->any())
            <div class="alert alert-danger rounded-3 mb-4" style="background: rgba(248,113,113,.1); color:#f87171; border:1px solid rgba(248,113,113,.3);">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('/penulis/buku/'.$book->id.'/update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label text-white fw-semibold">Judul Novel</label>
                    <input type="text" name="title" class="form-control form-dark" value="{{ old('title', $book->title) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-white fw-semibold">Nama Penulis / Pena</label>
                    <input type="text" name="author" class="form-control form-dark" value="{{ old('author', $book->author) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-white fw-semibold">Genre</label>
                    <select name="genre" class="form-select form-dark" required>
                        @foreach(['Novel', 'Romance', 'Fantasi', 'Horror', 'Misteri', 'Komedi', 'Pemrograman', 'Hobi'] as $genreOption)
                            <option value="{{ $genreOption }}" {{ (old('genre', $book->genre) == $genreOption) ? 'selected' : '' }}>
                                {{ $genreOption }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-white fw-semibold">Tahun</label>
                    <input type="number" name="year" class="form-control form-dark" value="{{ old('year', $book->year) }}" required>
                </div>

                <div class="col-12">
                    <label class="form-label text-white fw-semibold">Status Buku</label>
                    <select name="status" class="form-select form-dark" required>
                        <option value="draft" {{ (old('status', $book->status) == 'draft') ? 'selected' : '' }}>
                            📝 Draf (Belum Ditampilkan ke Publik)
                        </option>
                        <option value="published" {{ (old('status', $book->status) == 'published' || old('status', $book->status) == 'pending') ? 'selected' : '' }}>
                            🚀 Ajukan Publikasi (Menunggu Validasi Admin)
                        </option>
                    </select>
                    <small class="text-muted mt-1 d-block">
                        <i class="fa-solid fa-circle-info me-1 text-info"></i> Memilih "Ajukan Publikasi" akan mengirimkan buku Anda ke antrean peninjauan admin sebelum tampil di katalog umum.
                    </small>
                </div>

                <div class="col-12">
                    <label class="form-label text-white fw-semibold">Sinopsis / Deskripsi Buku</label>
                    <textarea name="description" class="form-control form-dark" rows="4" required>{{ old('description', $book->description) }}</textarea>
                </div>

                <div class="col-12">
                    <label class="form-label text-white fw-semibold">Cover Buku Utama</label>
                    @if($book->image_path)
                        <div class="mb-3">
                            <p class="text-muted small mb-1">Cover saat ini:</p>
                            <img src="{{ asset('storage/' . $book->image_path) }}" class="cover-preview mb-2" alt="Cover Buku">
                        </div>
                    @endif
                    <div class="upload-box" onclick="document.getElementById('coverInput').click()">
                        <i class="fa-solid fa-cloud-arrow-up fa-3x text-muted mb-2"></i>
                        <p class="text-white fw-bold mb-1">Klik untuk ganti cover buku</p>
                        <small class="text-muted">Format JPG, PNG, WEBP (Maksimal 2MB)</small>
                    </div>
                    <input type="file" name="cover" id="coverInput" class="d-none" accept="image/*" onchange="previewCover(event)">
                    
                    <div id="coverPreviewContainer" class="mt-3 text-center d-none">
                        <p class="text-muted small mb-1">Cover baru:</p>
                        <img id="coverPreviewImg" class="cover-preview mb-2">
                    </div>
                </div>

                <div class="col-12 mt-4">
                    <button type="submit" class="btn w-100 py-3 fw-bold text-dark" style="background: #38bdf8; border-radius: 12px;">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Perbarui Informasi Buku
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