@extends('layouts.app')

@section('title', 'Buat Buku Baru - Studio Penulis Safae')

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
            <i class="fa-solid fa-book text-primary me-2"></i> Buat Informasi Novel Baru
        </h3>
        <p class="text-muted mb-4">Lengkapi detail metadata novel Anda sebelum mulai menulis bab cerita.</p>

        @if ($errors->any())
            <div class="alert alert-danger rounded-3 mb-4" style="background: rgba(248,113,113,.1); color:#f87171; border:1px solid rgba(248,113,113,.3);">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('writer.books.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label text-white fw-semibold">Judul Novel</label>
                    <input type="text" name="title" class="form-control form-dark" placeholder="Masukkan judul novel..." value="{{ old('title') }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-white fw-semibold">Nama Penulis / Pena</label>
                    <input type="text" name="author" class="form-control form-dark" value="{{ old('author', Auth::user()->username ?? '') }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-white fw-semibold">Genre</label>
                    <select name="genre" class="form-select form-dark" required>
                        <option value="">-- Pilih Genre --</option>
                        <option value="Novel">Novel</option>
                        <option value="Romance">Romantis</option>
                        <option value="Fantasi">Fantasi</option>
                        <option value="Horror">Horror</option>
                        <option value="Misteri">Misteri</option>
                        <option value="Komedi">Komedi</option>
                        <option value="Pemrograman">Pemrograman</option>
                        <option value="Hobi">Hobi</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-white fw-semibold">Tahun</label>
                    <input type="number" name="year" class="form-control form-dark" value="{{ old('year', date('Y')) }}" required>
                </div>

                <div class="col-12">
                    <label class="form-label text-white fw-semibold">Status Buku</label>
                    <select name="status" class="form-select form-dark" required>
                        <option value="draft">📝 Draf (Belum Ditampilkan ke Publik)</option>
                        <option value="published">🚀 Published (Tampil di Katalog Umum)</option>
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label text-white fw-semibold">Sinopsis / Deskripsi Buku</label>
                    <textarea name="description" class="form-control form-dark" rows="4" placeholder="Tuliskan ringkasan cerita novel Anda..." required>{{ old('description') }}</textarea>
                </div>

                <div class="col-12">
                    <label class="form-label text-white fw-semibold">Cover Buku (Poster Utama)</label>
                    <div class="upload-box" onclick="document.getElementById('coverInput').click()">
                        <i class="fa-solid fa-cloud-arrow-up fa-3x text-muted mb-2"></i>
                        <p class="text-white fw-bold mb-1">Klik untuk unggah cover buku</p>
                        <small class="text-muted">Format JPG, PNG, WEBP (Maksimal 2MB)</small>
                    </div>
                    <input type="file" name="cover" id="coverInput" class="d-none" accept="image/*" onchange="previewCover(event)">
                    
                    <div id="coverPreviewContainer" class="mt-3 text-center d-none">
                        <img id="coverPreviewImg" class="cover-preview mb-2">
                        <div>
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearCover()">Hapus Cover</button>
                        </div>
                    </div>
                </div>

                <div class="col-12 mt-4">
                    <button type="submit" class="btn w-100 py-3 fw-bold text-dark" style="background: #38bdf8; border-radius: 12px;">
                        <i class="fa-solid fa-arrow-right me-1"></i> Lanjut ke Tulis Chapter
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
function clearCover() {
    document.getElementById('coverInput').value = '';
    document.getElementById('coverPreviewContainer').classList.add('d-none');
}
</script>
@endsection