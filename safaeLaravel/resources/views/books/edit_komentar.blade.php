
@extends('layouts.app')
@section('title', 'Edit Komentar - Safae')
@section('content')
<style>
    /* HALAMAN EDIT KOMENTAR */
    .edit-comment-page {
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: #514d69;
        padding: 30px 20px 60px;
    }

    .edit-comment-container {
        max-width: 750px;
        margin: 0 auto;
    }

    /* TOMBOL KEMBALI */
    .edit-comment-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 15px;
        margin-bottom: 16px;
        background: #f5f1fc;
        border: 1px solid #e5def5;
        border-radius: 30px;
        color: #81769f;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: 0.3s;
    }

    .edit-comment-back:hover {
        color: #a48bdc;
        border-color: #b9a5e8;
        background: #eee8f8;
    }

    /* HEADER */
    .edit-comment-header {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 25px;
        margin-bottom: 18px;
        background: linear-gradient(115deg, #eee8f8, #e5f1fc 65%, #f5f1fc);
        border: 1px solid #ded6ef;
        border-radius: 20px;
    }

    .edit-comment-header-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 55px;
        height: 55px;
        flex-shrink: 0;
        background: #e5dcf8;
        border: 1px solid #d8c9f2;
        border-radius: 16px;
        color: #a48bdc;
        font-size: 23px;
    }

    .edit-comment-header h1 {
        margin: 0 0 5px;
        color: #51416f;
        font-size: 25px;
        font-weight: 800;
    }

    .edit-comment-header p {
        margin: 0;
        color: #81769f;
        font-size: 12px;
        line-height: 1.6;
    }

    /* CARD FORM */
    .edit-comment-card {
        overflow: hidden;
        background: #ffffff;
        border: 1px solid #e5def5;
        border-radius: 20px;
    }

    .edit-comment-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        padding: 20px 25px;
        background: #faf8fe;
        border-bottom: 1px solid #e5def5;
    }

    .edit-comment-card-title {
        display: flex;
        align-items: center;
        gap: 9px;
        margin: 0;
        color: #514d69;
        font-size: 15px;
        font-weight: 700;
    }

    .edit-comment-card-title i {
        color: #a48bdc;
    }

    .edit-comment-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 11px;
        background: #eee8f8;
        border: 1px solid #ded6ef;
        border-radius: 20px;
        color: #8065b5;
        font-size: 11px;
        font-weight: 700;
    }

    .edit-comment-form {
        padding: 25px;
    }

    /* INFORMASI KOMENTAR */
    .edit-comment-info {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 24px;
    }

    .edit-comment-info-item {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 12px;
        background: #faf8fe;
        border: 1px solid #e5def5;
        border-radius: 10px;
        color: #81769f;
        font-size: 12px;
    }

    .edit-comment-info-item i {
        color: #a48bdc;
    }

    .edit-comment-info-item strong {
        color: #514d69;
        font-weight: 700;
    }

    /* LABEL FORM */
    .edit-comment-group {
        margin-bottom: 23px;
    }

    .edit-comment-label {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 10px;
        color: #625b78;
        font-size: 13px;
        font-weight: 700;
    }

    .edit-comment-label i {
        color: #a48bdc;
    }

    .edit-comment-required {
        color: #cf8297;
    }

    /* TEXTAREA */
    .edit-comment-textarea {
        display: block;
        width: 100%;
        min-height: 170px;
        padding: 16px;
        background: #faf9fd;
        border: 1px solid #ded6ef;
        border-radius: 13px;
        outline: none;
        color: #514d69;
        font-family: inherit;
        font-size: 13px;
        line-height: 1.8;
        resize: vertical;
        transition: 0.3s;
    }

    .edit-comment-textarea::placeholder {
        color: #aaa3bc;
    }

    .edit-comment-textarea:focus {
        border-color: #b9a5e8;
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(185, 165, 232, 0.15);
    }

    .edit-comment-textarea.is-invalid {
        border-color: #cf8297;
    }

    .edit-comment-help {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        margin-top: 8px;
        color: #89839f;
        font-size: 11px;
    }

    .edit-comment-error {
        margin-top: 7px;
        color: #cf8297;
        font-size: 12px;
    }

    /* GAMBAR SAAT INI */
    .edit-comment-image-box {
        padding: 17px;
        background: #faf8fe;
        border: 1px solid #e5def5;
        border-radius: 14px;
    }

    .edit-comment-image-title {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 13px;
        color: #625b78;
        font-size: 12px;
        font-weight: 600;
    }

    .edit-comment-image-title i {
        color: #a48bdc;
    }

    .edit-comment-current-image {
        display: block;
        max-width: 100%;
        max-height: 260px;
        width: auto;
        height: auto;
        border: 1px solid #e5def5;
        border-radius: 12px;
        object-fit: contain;
    }

    .edit-comment-image-note {
        margin: 10px 0 0;
        color: #89839f;
        font-size: 11px;
        line-height: 1.6;
    }

    /* UPLOAD GAMBAR */
    .edit-comment-upload {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 25px 15px;
        background: #faf9fd;
        border: 2px dashed #d8c9f2;
        border-radius: 14px;
        text-align: center;
        cursor: pointer;
        transition: 0.3s;
    }

    .edit-comment-upload:hover {
        border-color: #b9a5e8;
        background: #f5f1fc;
    }

    .edit-comment-upload-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 45px;
        height: 45px;
        background: #eee8f8;
        border-radius: 13px;
        color: #a48bdc;
        font-size: 20px;
    }

    .edit-comment-upload-title {
        color: #625b78;
        font-size: 13px;
        font-weight: 700;
    }

    .edit-comment-upload-subtitle {
        color: #89839f;
        font-size: 11px;
        overflow-wrap: anywhere;
    }

    .edit-comment-file {
        position: absolute;
        width: 100%;
        height: 100%;
        inset: 0;
        opacity: 0;
        cursor: pointer;
    }

    .edit-comment-file:focus-visible {
        outline: 2px solid #b9a5e8;
        outline-offset: -3px;
    }

    /* PREVIEW GAMBAR BARU */
    .edit-comment-preview {
        display: none;
        margin-top: 15px;
        padding: 15px;
        background: #faf8fe;
        border: 1px solid #e5def5;
        border-radius: 13px;
    }

    .edit-comment-preview.active {
        display: block;
    }

    .edit-comment-preview-title {
        margin-bottom: 10px;
        color: #8065b5;
        font-size: 12px;
        font-weight: 700;
    }

    .edit-comment-preview img {
        display: block;
        max-width: 100%;
        max-height: 250px;
        border-radius: 10px;
        object-fit: contain;
    }

    /* TOMBOL FORM */
    .edit-comment-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 10px;
        padding-top: 20px;
        border-top: 1px solid #e5def5;
    }

    .edit-comment-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 42px;
        padding: 11px 18px;
        border-radius: 11px;
        font-family: inherit;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        transition: 0.3s;
    }

    .edit-comment-btn.cancel {
        background: transparent;
        border: 1px solid #ded6ef;
        color: #81769f;
    }

    .edit-comment-btn.cancel:hover {
        background: #f5f1fc;
        border-color: #c5b5e8;
        color: #625b78;
    }

    .edit-comment-btn.save {
        background: #b9a5e8;
        border: 1px solid #b9a5e8;
        color: #ffffff;
    }

    .edit-comment-btn.save:hover {
        background: #a48bdc;
        border-color: #a48bdc;
        transform: translateY(-2px);
    }

    /* RESPONSIVE */
    @media (max-width: 600px) {
        .edit-comment-page {
            padding: 18px 12px 40px;
        }

        .edit-comment-header {
            padding: 18px;
        }

        .edit-comment-header h1 {
            font-size: 21px;
        }

        .edit-comment-card-header {
            padding: 16px;
        }

        .edit-comment-form {
            padding: 17px;
        }

        .edit-comment-actions {
            flex-direction: column-reverse;
        }

        .edit-comment-btn {
            width: 100%;
        }
    }
</style>

<div class="edit-comment-page">
    <div class="edit-comment-container">
        @php
            $imagePath = $komentar->image_path
                ? preg_replace('#^(public/|storage/)+#', '', $komentar->image_path)
                : null;
        @endphp

        <!-- TOMBOL KEMBALI -->
        <a href="{{ route('komentar.index', [$komentar->book_id, $komentar->page]) }}" class="edit-comment-back">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Komentar
        </a>

        <!-- HEADER -->
        <div class="edit-comment-header">
            <div class="edit-comment-header-icon">
                <i class="fa-solid fa-comment-dots"></i>
            </div>
            <div>
                <h1>Edit Komentar</h1>
                <p>Perbarui isi komentar atau ganti gambar yang sudah kamu kirim sebelumnya.</p>
            </div>
        </div>

        <!-- CARD FORM -->
        <div class="edit-comment-card">
            <div class="edit-comment-card-header">
                <h3 class="edit-comment-card-title">
                    <i class="fa-solid fa-pen-to-square"></i> Form Edit Komentar
                </h3>
                <span class="edit-comment-badge">
                    <i class="fa-solid fa-message"></i> Komentar Saya
                </span>
            </div>

            <form action="{{ route('komentar.update', $komentar->id) }}" method="POST" enctype="multipart/form-data" class="edit-comment-form">
                @csrf
                <input type="hidden" name="book_id" value="{{ $komentar->book_id }}">
                <input type="hidden" name="page" value="{{ $komentar->page }}">

                <!-- INFORMASI KOMENTAR -->
                <div class="edit-comment-info">
                    <div class="edit-comment-info-item">
                        <i class="fa-solid fa-book"></i>
                        <span>Buku ID: <strong>{{ $komentar->book_id }}</strong></span>
                    </div>
                    <div class="edit-comment-info-item">
                        <i class="fa-solid fa-bookmark"></i>
                        <span>Halaman: <strong>{{ $komentar->page }}</strong></span>
                    </div>
                </div>

                <!-- ISI KOMENTAR -->
                <div class="edit-comment-group">
                    <label for="komentar" class="edit-comment-label">
                        <i class="fa-solid fa-comment-dots"></i>
                        Isi Komentar <span class="edit-comment-required">*</span>
                    </label>
                    <textarea name="komentar" id="komentar" class="edit-comment-textarea @error('komentar') is-invalid @enderror" placeholder="Tulis komentar kamu di sini..." required>{{ old('komentar', $komentar->komentar) }}</textarea>
                    <div class="edit-comment-help">
                        <span>Ubah komentar sesuai keinginan kamu.</span>
                        <span id="commentCharCount">0 karakter</span>
                    </div>
                    @error('komentar')
                        <div class="edit-comment-error">
                            <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- GAMBAR SAAT INI MENGGUNAKAN STORAGE -->
                @if($imagePath)
                    <div class="edit-comment-group">
                        <label class="edit-comment-label">
                            <i class="fa-regular fa-image"></i> Gambar Saat Ini
                        </label>
                        <div class="edit-comment-image-box">
                            <div class="edit-comment-image-title">
                                <i class="fa-solid fa-image"></i> Gambar yang sudah diunggah
                            </div>
                            <img src="{{ asset('storage/'.$imagePath) }}" class="edit-comment-current-image" alt="Gambar Komentar">
                            <p class="edit-comment-image-note">
                                Gambar ini akan tetap digunakan jika kamu tidak mengunggah gambar baru.
                            </p>
                        </div>
                    </div>
                @endif

                <!-- GANTI GAMBAR -->
                <div class="edit-comment-group">
                    <label for="commentImageInput" class="edit-comment-label">
                        <i class="fa-solid fa-cloud-arrow-up"></i> Ganti Gambar
                        <span style="color:#89839f;font-weight:400">(Opsional)</span>
                    </label>
                    <div class="edit-comment-upload">
                        <div class="edit-comment-upload-icon">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                        </div>
                        <span class="edit-comment-upload-title">Klik untuk memilih gambar</span>
                        <span class="edit-comment-upload-subtitle" id="uploadFileName">JPG, JPEG, PNG, atau WEBP</span>
                        <input type="file" name="image" id="commentImageInput" class="edit-comment-file" accept="image/jpeg,image/png,image/webp" aria-label="Pilih gambar komentar baru">
                    </div>
                    @error('image')
                        <div class="edit-comment-error">
                            <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                        </div>
                    @enderror

                    <!-- PREVIEW GAMBAR BARU -->
                    <div class="edit-comment-preview" id="commentImagePreview">
                        <div class="edit-comment-preview-title">
                            <i class="fa-solid fa-eye"></i> Preview Gambar Baru
                        </div>
                        <img id="commentPreviewImg" alt="Preview Gambar Baru">
                    </div>
                </div>

                <!-- TOMBOL AKSI -->
                <div class="edit-comment-actions">
                    <a href="{{ route('komentar.index', [$komentar->book_id, $komentar->page]) }}" class="edit-comment-btn cancel">
                        <i class="fa-solid fa-xmark"></i> Batal
                    </a>
                    <button type="submit" class="edit-comment-btn save">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const textarea = document.getElementById('komentar');
        const charCount = document.getElementById('commentCharCount');
        const imageInput = document.getElementById('commentImageInput');
        const imagePreview = document.getElementById('commentImagePreview');
        const previewImg = document.getElementById('commentPreviewImg');
        const fileName = document.getElementById('uploadFileName');
        let previewUrl = null;

        function updateCharCount() {
            charCount.textContent = textarea.value.length + ' karakter';
        }

        updateCharCount();
        textarea.addEventListener('input', updateCharCount);

        imageInput.addEventListener('change', function () {
            const file = this.files[0];

            if (previewUrl) {
                URL.revokeObjectURL(previewUrl);
                previewUrl = null;
            }

            if (file && file.type.startsWith('image/')) {
                previewUrl = URL.createObjectURL(file);
                previewImg.src = previewUrl;
                imagePreview.classList.add('active');
                fileName.textContent = file.name;
            } else {
                previewImg.removeAttribute('src');
                imagePreview.classList.remove('active');
                fileName.textContent = 'JPG, JPEG, PNG, atau WEBP';
            }
        });

        window.addEventListener('pagehide', function () {
            if (previewUrl) {
                URL.revokeObjectURL(previewUrl);
            }
        });
    });
</script>
@endsection
