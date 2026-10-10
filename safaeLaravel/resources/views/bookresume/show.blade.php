@extends('layouts.app')

@section('title', $resume->title ?? 'Detail Resume')

@section('content')
<style>
    .resume-page {
        min-height: 100vh;
        width: 100%;
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

    .book-side-cover {
        width: 100px;
        height: 145px;
        object-fit: cover;
        border-radius: 12px;
    }

    .genre-badge {
        background: rgba(168,85,247,0.18);
        color: #d8b4fe;
        padding: 4px 12px;
        border-radius: 999px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .spoiler-alert-banner {
        background: rgba(239,68,68,0.12);
        border: 1px solid rgba(239,68,68,0.25);
        color: #fca5a5;
        border-radius: 18px;
        padding: 15px 20px;
        font-weight: 600;
    }

    /* Styling output teks editor Quill */
    .quill-content {
        color: #e2e8f0;
        font-size: 1.1rem;
        line-height: 1.8;
    }
    .quill-content blockquote {
        border-left: 4px solid #8b5cf6;
        padding-left: 15px;
        color: #94a3b8;
        font-style: italic;
    }
</style>

<div class="resume-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-9 col-lg-10">

                <div class="mb-4">
                    <a href="{{ route('resume.my') }}" class="btn text-secondary p-0 fw-bold">
                        <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Resume Saya
                    </a>
                </div>

                <div class="glass-card p-4 p-md-5">
                    
                    <div class="d-flex align-items-center gap-3 mb-4 p-3 rounded-4" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.04);">
                        <img src="{{ $resume->book->image_path ? asset($resume->book->image_path) : 'https://via.placeholder.com/300x400?text=No+Cover' }}" class="book-side-cover" alt="Cover">
                        <div>
                            <div class="text-secondary small mb-1">Resume Buku:</div>
                            <h4 class="text-white fw-bold m-0 fs-5">{{ $resume->book->title }}</h4>
                            <p class="text-muted small m-0 mb-2">Oleh {{ $resume->book->author }}</p>
                            <span class="genre-badge">{{ $resume->book->genre }}</span>
                        </div>
                    </div>

                    <h1 class="display-5 fw-extrabold text-white mb-2 fs-2">
                        {{ $resume->title ?? 'Tanpa Judul' }}
                    </h1>
                    
                    <div class="text-secondary small mb-4">
                        Dipublikasikan pada {{ $resume->created_at->format('d M Y • H:i') }} WIB
                    </div>

                    @if($resume->has_spoiler)
                        <div class="spoiler-alert-banner mb-4 d-flex align-items-center gap-2">
                            <span>⚠</span> 
                            <span>Resume ini mengandung <strong>Spoiler</strong> penting dari cerita buku terkait.</span>
                        </div>
                    @endif

                    <hr class="border-secondary my-4">

                    <div class="quill-content">
                        {!! $resume->content !!}
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection