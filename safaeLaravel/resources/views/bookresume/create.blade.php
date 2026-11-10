
@extends('layouts.app')

@section('title', 'Tulis Resume - ' . ($book->title ?? 'Safae'))

@section('content')

<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">

<style>
    .create-resume-wrapper {
        padding: 10px 0 50px 0;
        color: #514d69;
    }

    .resume-panel {
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

    /* Quill Editor Pastel Theme */
    .ql-toolbar.ql-snow {
        background: #f5f1fc;
        border-color: #ded6ef !important;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }

    .ql-toolbar .ql-stroke {
        stroke: #81769f !important;
    }

    .ql-toolbar .ql-fill {
        fill: #81769f !important;
    }

    .ql-toolbar .ql-picker {
        color: #81769f !important;
    }

    .ql-container.ql-snow {
        background: #ffffff;
        border-color: #ded6ef !important;
        border-bottom-left-radius: 12px;
        border-bottom-right-radius: 12px;
        color: #514d69;
        font-size: 0.95rem;
        min-height: 250px;
    }

    .ql-editor.ql-blank::before {
        color: #aaa3bd !important;
    }

    .ql-snow .ql-picker-options {
        background: #ffffff;
        border-color: #ded6ef !important;
    }

    .ql-snow .ql-picker-item {
        color: #514d69;
    }

    .ql-snow .ql-picker-label:hover,
    .ql-snow .ql-picker-item:hover,
    .ql-snow button:hover .ql-stroke,
    .ql-snow button.ql-active .ql-stroke {
        color: #9b83d1 !important;
        stroke: #9b83d1 !important;
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

    .create-resume-wrapper .text-white {
        color: #514d69 !important;
    }

    .create-resume-wrapper .text-secondary {
        color: #89839f !important;
    }

    .create-resume-wrapper .text-info {
        color: #82a9d8 !important;
    }

    .create-resume-wrapper .text-success {
        color: #65a98c !important;
    }

    .create-resume-wrapper .bg-success.bg-opacity-25 {
        background-color: #e4f4eb !important;
    }

    .create-resume-wrapper .border-danger {
        border-color: #f0cbd5 !important;
    }

    .create-resume-wrapper .bg-danger.bg-opacity-10 {
        background-color: #fff1f4 !important;
    }

    .create-resume-wrapper .text-warning {
        color: #d5a64d !important;
    }

    .create-resume-wrapper .btn-outline-secondary {
        color: #81769f;
        border-color: #cfc5e3;
    }

    .create-resume-wrapper .btn-outline-secondary:hover {
        background: #eee8f8;
        color: #62547f;
        border-color: #b9a5e8;
    }
</style>

<div class="create-resume-wrapper">
    <div class="container-fluid" style="max-width: 900px;">

        <div class="d-flex align-items-center justify-content-between mb-4">
            <h3 class="fw-bold text-white mb-0">
                <i class="fa-solid fa-pen-nib text-info me-2"></i> Tulis Resume & Impresi Buku
            </h3>
            <a href="{{ route('resume.my') }}" class="btn btn-outline-secondary rounded-3 btn-sm">
                <i class="fa-solid fa-arrow-left me-1"></i> Batal
            </a>
        </div>

        <div class="resume-panel">
            
            <!-- HEADER INFO BUKU -->
            <div class="book-header-box">
                <img src="{{ $book->image_path ? asset($book->image_path) : 'https://via.placeholder.com/150' }}" class="book-header-cover" alt="Cover Buku">
                <div>
                    <span class="badge bg-success bg-opacity-25 text-success mb-1 fs-6">
                        🎉 Buku Selesai Dibaca
                    </span>
                    <h5 class="fw-bold text-white mb-1">{{ $book->title ?? 'Judul Buku' }}</h5>
                    <small class="text-secondary">
                        <i class="fa-solid fa-user me-1"></i> {{ $book->author ?? '-' }} &bull; 
                        <span class="text-info">{{ $book->genre ?? 'Umum' }}</span>
                    </small>
                </div>
            </div>

            <!-- FORM TULIS RESUME -->
            <form action="{{ route('resume.store', $book->id) }}" method="POST" id="resumeForm">
                @csrf

                <div class="mb-4">
                    <label class="form-label text-white fw-bold">Judul Resume</label>
                    <input type="text" name="title" class="form-control form-dark-control" placeholder="Contoh: Ending paling emosional yang pernah aku baca" value="{{ old('title') }}" required>
                </div>

                <div class="mb-4">
                    <label class="form-label text-white fw-bold">Isi Resume & Poin Penting</label>
                    <div id="editor"></div>
                    <input type="hidden" name="content" id="content">
                </div>

                <div class="form-check mb-4 p-3 rounded-3 border border-danger border-opacity-25 bg-danger bg-opacity-10">
                    <input class="form-check-input ms-0 me-2" type="checkbox" name="has_spoiler" value="1" id="hasSpoiler" {{ old('has_spoiler') ? 'checked' : '' }}>
                    <label class="form-check-label text-white fw-bold" for="hasSpoiler">
                        <i class="fa-solid fa-triangle-exclamation text-warning me-1"></i> Mengandung Spoiler
                    </label>
                    <small class="d-block text-secondary mt-1">Centang jika resume ini menceritakan ending, plot twist, atau kejutan cerita lainnya.</small>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('resume.my') }}" class="btn btn-outline-secondary rounded-3 px-4">Batal</a>
                    <button type="submit" class="btn-submit-resume">
                        <i class="fa-solid fa-paper-plane me-1"></i> Publish Resume
                    </button>
                </div>
            </form>

        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const quill = new Quill('#editor', {
            theme: 'snow',
            placeholder: 'Tuliskan pemikiran, pelajaran, atau kutipan berkesan dari buku ini...',
            modules: {
                toolbar: [
                    [{ header: [1, 2, false] }],
                    ['bold', 'italic', 'underline'],
                    ['blockquote'],
                    [{ list: 'ordered' }, { list: 'bullet' }],
                    ['link'],
                    ['clean']
                ]
            }
        });

        const form = document.getElementById('resumeForm');
        form.addEventListener('submit', function() {
            document.querySelector('#content').value = quill.root.innerHTML;
        });
    });
</script>

@endsection
