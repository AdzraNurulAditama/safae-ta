
@extends('layouts.app')

@section('title', 'Edit Resume - ' . ($resume->book->title ?? 'Safae'))

@section('content')

<style>
    .edit-resume-wrapper {
        padding: 10px 0 50px 0;
        color: #514d69;
    }

    .edit-panel {
        background: #ffffff;
        border: 1px solid #e5def5;
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 10px 30px rgba(130, 110, 170, 0.10);
    }

    .book-header-box {
        background: #f5f1fc;
        border: 1px solid #e5def5;
        border-radius: 16px;
        padding: 20px;
        display: flex;
        gap: 18px;
        align-items: center;
        margin-bottom: 25px;
    }

    .book-header-cover {
        width: 65px;
        height: 90px;
        object-fit: cover;
        border-radius: 10px;
    }

    .form-dark-control {
        background: #faf9fe;
        border: 1px solid #ded6ef;
        color: #514d69;
        border-radius: 12px;
        padding: 12px 16px;
    }

    .form-dark-control:focus {
        background: #ffffff;
        border-color: #b9a5e8;
        color: #514d69;
        box-shadow: 0 0 0 0.25rem rgba(185, 165, 232, 0.20);
    }

    .btn-submit-resume {
        background: #b9a5e8;
        color: #ffffff;
        font-weight: 700;
        border: none;
        padding: 12px 24px;
        border-radius: 12px;
        transition: 0.2s;
    }

    .btn-submit-resume:hover {
        background: #a48bdc;
        color: #ffffff;
    }

    .edit-resume-wrapper .text-white {
        color: #514d69 !important;
    }

    .edit-resume-wrapper .text-secondary {
        color: #89839f !important;
    }

    .edit-resume-wrapper .text-info {
        color: #82a9d8 !important;
    }

    .edit-resume-wrapper .text-purple {
        color: #9b83d1 !important;
    }

    .edit-resume-wrapper .bg-purple.bg-opacity-25 {
        background-color: #eee8f8 !important;
    }

    .edit-resume-wrapper .border-danger {
        border-color: #f0cbd5 !important;
    }

    .edit-resume-wrapper .bg-danger.bg-opacity-10 {
        background-color: #fff1f4 !important;
    }

    .edit-resume-wrapper .text-warning {
        color: #d5a64d !important;
    }

    .edit-resume-wrapper .btn-outline-secondary {
        color: #81769f;
        border-color: #cfc5e3;
    }

    .edit-resume-wrapper .btn-outline-secondary:hover {
        background: #eee8f8;
        color: #62547f;
        border-color: #b9a5e8;
    }
</style>

<div class="edit-resume-wrapper">
    <div class="container-fluid" style="max-width: 900px;">

        <div class="d-flex align-items-center justify-content-between mb-4">
            <h3 class="fw-bold text-white mb-0">
                <i class="fa-solid fa-pen-to-square text-info me-2"></i> Perbarui Resume dan Kesanmu
            </h3>
            <a href="{{ route('resume.my') }}" class="btn btn-outline-secondary rounded-3 btn-sm">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="edit-panel">
            
            <!-- HEADER INFO BUKU -->
            <div class="book-header-box">
                <img src="{{ isset($resume->book->image_path) && $resume->book->image_path ? asset($resume->book->image_path) : 'https://via.placeholder.com/150' }}" class="book-header-cover" alt="Cover">
                <div>
                    <span class="badge bg-purple bg-opacity-25 text-purple mb-1 fs-6">{{ $resume->book->genre ?? 'Umum' }}</span>
                    <h5 class="fw-bold text-white mb-1">{{ $resume->book->title ?? 'Judul Buku' }}</h5>
                    <small class="text-secondary"><i class="fa-solid fa-user me-1"></i> {{ $resume->book->author ?? '-' }}</small>
                </div>
            </div>

            <!-- FORM EDIT RESUME -->
            <form action="{{ route('bookresume.update', $resume->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="form-label text-white fw-bold">Judul Resume</label>
                    <input type="text" name="title" class="form-control form-dark-control" value="{{ old('title', $resume->title) }}" required>
                </div>

                <div class="mb-4">
                    <label class="form-label text-white fw-bold">Isi Resume & Poin Penting</label>
                    <textarea name="content" rows="8" class="form-control form-dark-control" required>{{ old('content', $resume->content) }}</textarea>
                </div>

                <div class="form-check mb-4 p-3 rounded-3 border border-danger border-opacity-25 bg-danger bg-opacity-10">
                    <input class="form-check-input ms-0 me-2" type="checkbox" name="is_spoiler" value="1" id="isSpoiler" {{ $resume->is_spoiler ? 'checked' : '' }}>
                    <label class="form-check-label text-white fw-bold" for="isSpoiler">
                        <i class="fa-solid fa-triangle-exclamation text-warning me-1"></i> Mengandung Spoiler
                    </label>
                    <small class="d-block text-secondary mt-1">Centang jika resume ini menceritakan ending atau alur penting yang tidak boleh diketahui pembaca lain.</small>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('resume.my') }}" class="btn btn-outline-secondary rounded-3 px-4">Batal</a>
                    <button type="submit" class="btn-submit-resume">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>

        </div>

    </div>
</div>

@endsection
