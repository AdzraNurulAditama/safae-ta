@extends('layouts.app')

@section('title', isset($chapter) ? 'Edit Bab - ' . $book->title : 'Tulis Bab Baru - ' . $book->title)

@section('content')
<style>
    .writer-studio-wrapper {
        max-width: 960px;
        margin: 2rem auto;
        padding: 0 1rem;
    }
    .studio-card {
        background: #111827;
        border: 1px solid #1f2937;
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        overflow: hidden;
    }
    .studio-header {
        background: linear-gradient(135deg, #1e1b4b 0%, #111827 100%);
        border-bottom: 1px solid #1f2937;
        padding: 2rem;
    }
    .form-label-custom {
        color: #e5e7eb;
        font-weight: 600;
        font-size: 0.95rem;
        margin-bottom: 0.5rem;
    }
    .form-control-custom, .form-select-custom {
        background-color: #030712 !important;
        color: #ffffff !important;
        border: 1px solid #374151 !important;
        border-radius: 12px;
        padding: 14px 18px;
        font-size: 1rem;
        transition: all 0.2s ease;
    }
    .form-control-custom:focus, .form-select-custom:focus {
        border-color: #38bdf8 !important;
        box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.15) !important;
        background-color: #030712 !important;
        color: #ffffff !important;
    }
    /* Memperbaiki warna teks placeholder agar terlihat jelas */
    .form-control-custom::placeholder {
        color: #6b7280 !important;
        opacity: 1;
    }
    .upload-box-custom {
        background: #030712;
        border: 2px dashed #374151;
        border-radius: 16px;
        padding: 35px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .upload-box-custom:hover {
        border-color: #38bdf8;
        background: rgba(56, 189, 248, 0.03);
    }
    .btn-save-custom {
        background: linear-gradient(135deg, #38bdf8 0%, #0284c7 100%);
        color: #030712;
        font-weight: 700;
        border: none;
        border-radius: 12px;
        padding: 16px;
        font-size: 1.05rem;
        box-shadow: 0 4px 15px rgba(56, 189, 248, 0.3);
        transition: all 0.2s ease;
    }
    .btn-save-custom:hover {
        background: linear-gradient(135deg, #7dd3fc 0%, #0284c7 100%);
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(56, 189, 248, 0.4);
        color: #030712;
    }
</style>

<div class="writer-studio-wrapper">
    <!-- Tombol Kembali & Badge Buku -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ url('/penulis/buku/'.$book->id.'/chapters') }}" class="text-secondary text-decoration-none fw-semibold d-flex align-items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Bab
        </a>
        <span class="badge bg-primary bg-opacity-10 text-info px-3 py-2 rounded-pill fw-bold border border-info border-opacity-25">
            <i class="fa-solid fa-book-open me-1"></i> {{ $book->title }}
        </span>
    </div>

    <div class="studio-card">
        <!-- Header Card -->
        <div class="studio-header">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-primary bg-opacity-10 text-info p-3 rounded-xl border border-info border-opacity-25" style="border-radius: 14px;">
                    <i class="fa-solid fa-pen-nib fa-2x"></i>
                </div>
                <div>
                    <h3 class="text-white fw-bold mb-1">
                        {{ isset($chapter) ? 'Edit Bab Cerita' : 'Tulis Bab Baru' }}
                    </h3>
                    <p class="text-secondary mb-0 small">Susun konten bab, atur status publikasi, dan tambahkan ilustrasi gambar.</p>
                </div>
            </div>
        </div>

        <!-- Form Body -->
        <div class="p-4 p-md-5">
            @if ($errors->any())
                <div class="alert alert-danger rounded-4 mb-4 p-4" style="background: rgba(239, 68, 68, 0.1); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3);">
                    <div class="fw-bold mb-1"><i class="fa-solid fa-triangle-exclamation me-2"></i> Terdapat beberapa kesalahan input:</div>
                    <ul class="mb-0 ps-3 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ url('/penulis/buku/'.$book->id.'/chapter/simpan/'.($chapter->id ?? '')) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-4">
                    <!-- Nomor Bab -->
                    <div class="col-md-4">
                        <label class="form-label-custom">Nomor Bab</label>
                        <input type="number" name="chapter_number" class="form-control form-control-custom" value="{{ old('chapter_number', $chapter->chapter_number ?? $nextChapterNumber) }}" required>
                    </div>

                    <!-- Judul Bab -->
                    <div class="col-md-8">
                        <label class="form-label-custom">Judul Bab</label>
                        <input type="text" name="title" class="form-control form-control-custom" placeholder="Contoh: Awal Mula Petualangan" value="{{ old('title', $chapter->title ?? '') }}" required>
                    </div>

                    <!-- Status Chapter -->
                    <div class="col-12">
                        <label class="form-label-custom">Status Publikasi Bab</label>
                        <select name="status" class="form-select form-select-custom" required>
                            <option value="draft" {{ (old('status', $chapter->status ?? '') == 'draft') ? 'selected' : '' }}>📝 Draf (Belum Ditampilkan ke Publik)</option>
                            <option value="published" {{ (old('status', $chapter->status ?? '') == 'published') ? 'selected' : '' }}>🚀 Published (Tampil untuk Pembaca)</option>
                        </select>
                    </div>

                    <!-- Konten Teks Bab -->
                    <div class="col-12">
                        <label class="form-label-custom">Isi Cerita / Konten Bab</label>
                        <textarea name="content" class="form-control form-control-custom" rows="14" placeholder="Tulis atau tempel isi bab cerita Anda di sini dengan nyaman..." required>{{ old('content', $chapter->content ?? '') }}</textarea>
                    </div>

                    <!-- Foto Ilustrasi Chapter -->
                    <div class="col-12">
                        <label class="form-label-custom">Ilustrasi Gambar Bab (Opsional)</label>
                        @if(isset($chapter) && $chapter->image)
                            <div class="mb-3 p-3 rounded-4 bg-dark border border-secondary border-opacity-25 d-inline-block">
                                <p class="text-secondary small mb-2">Ilustrasi saat ini:</p>
                                <img src="{{ asset('storage/' . $chapter->image) }}" alt="Ilustrasi Bab" style="max-height: 160px; border-radius: 10px; display: block;">
                            </div>
                        @endif
                        <div class="upload-box-custom" onclick="document.getElementById('chapterImageInput').click()">
                            <i class="fa-regular fa-image fa-3x text-info mb-2"></i>
                            <p class="text-white fw-bold mb-1">Klik untuk unggah atau ganti foto ilustrasi</p>
                            <small class="text-secondary">Format yang didukung: JPG, PNG, WEBP (Maksimal 2MB)</small>
                        </div>
                        <input type="file" name="chapter_image" id="chapterImageInput" class="d-none" accept="image/*" onchange="previewImage(event)">
                        
                        <div id="imagePreviewContainer" class="mt-3 text-center d-none p-3 rounded-4 bg-dark border border-secondary border-opacity-25">
                            <p class="text-info small mb-2">Pratinjau Gambar Baru:</p>
                            <img id="imagePreview" style="max-height: 200px; border-radius: 10px; display: inline-block;">
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="col-12 mt-5">
                        <button type="submit" class="btn btn-save-custom w-100">
                            <i class="fa-solid fa-floppy-disk me-2"></i> Simpan Bab Cerita
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imagePreview').src = e.target.result;
            document.getElementById('imagePreviewContainer').classList.remove('d-none');
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endsection