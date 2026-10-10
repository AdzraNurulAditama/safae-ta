@extends('layouts.app')

@section('title', 'Edit Resume - ' . $book->title)

@section('content')

<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">

<style>
    .resume-page {
        min-height: 100vh;
        width: 100%;
        overflow-x: hidden;
        background:
            radial-gradient(circle at top left, rgba(139,92,246,0.15), transparent 30%),
            radial-gradient(circle at bottom right, rgba(56,189,248,0.15), transparent 30%),
            #020617;
        padding: 40px 20px;
    }

    .glass-card {
        background: rgba(255,255,255,0.06);
        backdrop-filter: blur(18px);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 30px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.4);
    }

    .book-cover-small {
        width: 130px;
        height: 190px;
        object-fit: cover;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        flex-shrink: 0;
    }

    .genre-badge {
        background: rgba(168,85,247,0.18);
        color: #d8b4fe;
        padding: 6px 14px;
        border-radius: 999px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .resume-title {
        width: 100%;
        background: #1e293b;
        border: 1px solid #334155;
        color: white;
        border-radius: 18px;
        padding: 18px 20px;
        font-size: 1rem;
        transition: .3s;
    }

    .resume-title:focus {
        outline: none;
        border-color: #8b5cf6;
        box-shadow: 0 0 0 4px rgba(139,92,246,0.2);
    }

    #editor {
        background: white;
        color: black;
        border-radius: 0 0 20px 20px; 
        min-height: 350px;
        overflow: hidden;
    }

    .ql-toolbar {
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
        background: #f8fafc;
        border-color: transparent !important;
    }

    .ql-container {
        border-bottom-left-radius: 20px;
        border-bottom-right-radius: 20px;
        font-size: 1rem;
        min-height: 280px;
        border-color: transparent !important;
    }

    .spoiler-box {
        background: rgba(239,68,68,0.08);
        border: 1px solid rgba(239,68,68,0.2);
        border-radius: 20px;
        padding: 18px;
    }

    .publish-btn {
        width: 100%;
        border: none;
        padding: 18px;
        border-radius: 20px;
        background: linear-gradient(135deg, #8b5cf6, #ec4899);
        color: white;
        font-weight: 700;
        font-size: 1.05rem;
        transition: .3s;
        box-shadow: 0 15px 35px rgba(139,92,246,0.3);
    }

    .publish-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 45px rgba(139,92,246,0.45);
    }

    .complete-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(16,185,129,0.12);
        color: #6ee7b7;
        padding: 8px 16px;
        border-radius: 999px;
        font-weight: 700;
        font-size: 0.9rem;
    }

    @media(max-width: 768px) {
        .book-cover-small {
            width: 100px;
            height: 150px;
        }
    }
</style>

<div class="resume-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-9 col-lg-10">

                <div class="glass-card p-4 mb-4 d-flex flex-column flex-md-row align-items-center align-items-md-start gap-4">
                    <img src="{{ $book->image_path ? asset($book->image_path) : 'https://via.placeholder.com/300x400?text=No+Cover' }}" alt="Cover Buku" class="book-cover-small">
                    
                    <div class="w-100 text-center text-md-start d-flex flex-column justify-content-center h-100 mt-2 mt-md-0">
                        <div class="mb-3">
                            <span class="complete-badge">🎉 Mengedit Resume</span>
                        </div>
                        <h1 class="fw-bold text-white mb-2 fs-3">
                            {{ $book->title }}
                        </h1>
                        <p class="text-secondary mb-3">
                            {{ $book->author }}
                        </p>
                        <div>
                            <span class="genre-badge">{{ $book->genre }}</span>
                        </div>
                    </div>
                </div>

                <div class="glass-card overflow-hidden">
                    <div class="p-4 p-md-5 border-bottom border-secondary">
                        <h2 class="display-6 fw-bold text-white mb-3 fs-3">
                            Perbarui Resume dan Kesanmu
                        </h2>
                        <p class="text-secondary mb-0">
                            Lakukan penyesuaian pada pesan moral, teori, atau ulasan yang ingin kamu ubah dari buku ini.
                        </p>
                    </div>

                        <form action="{{ route('bookresume.update', $resume->id) }}" method="POST" class="p-4 p-md-5">                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="form-label text-white fw-bold mb-3">
                                Judul Resume
                            </label>
                            <input type="text" 
                                   name="title" 
                                   class="resume-title" 
                                   value="{{ old('title', $resume->title) }}"
                                   placeholder="Contoh: Ending paling emosional yang pernah aku baca">
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-white fw-bold mb-3">
                                Isi Resume
                            </label>
                            <div id="editor">{!! old('content', $resume->content) !!}</div>
                            <input type="hidden" name="content" id="content">
                        </div>

                        <div class="mb-5">
                            <label class="spoiler-box d-flex align-items-start gap-3" style="cursor: pointer;">
                                <input type="checkbox" 
                                       name="has_spoiler" 
                                       class="form-check-input mt-1"
                                       {{ old('has_spoiler', $resume->has_spoiler) ? 'checked' : '' }}>
                                <div>
                                    <div class="fw-bold text-danger mb-1 fs-6">
                                        ⚠ Spoiler Alert
                                    </div>
                                    <div class="text-secondary" style="font-size: 0.95rem;">
                                        Centang jika resumemu mengandung spoiler penting 
                                        seperti ending, plot twist, atau kematian karakter.
                                    </div>
                                </div>
                            </label>
                        </div>

                        <button type="submit" class="publish-btn">
                            <i class="fa-solid fa-pen-to-square me-2"></i>
                            Simpan Perubahan
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script>
    const quill = new Quill('#editor', {
        theme: 'snow',
        placeholder: 'Tulis pemikiranmu tentang buku ini...',
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

    const form = document.querySelector('form');
    form.addEventListener('submit', function() {
        document.querySelector('#content').value = quill.root.innerHTML;
    });
</script>

@endsection