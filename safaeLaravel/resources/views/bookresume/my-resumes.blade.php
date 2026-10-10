@extends('layouts.app')

@section('title', 'My Resumes')

@section('content')

<style>
    .resume-page{
        min-height:100vh;
        background:
            radial-gradient(circle at top left, rgba(139,92,246,0.15), transparent 30%),
            radial-gradient(circle at bottom right, rgba(56,189,248,0.15), transparent 30%),
            #020617;
        padding:40px 20px;
    }

    .resume-card{
        background:rgba(255,255,255,0.05);
        border:1px solid rgba(255,255,255,0.08);
        border-radius:28px;
        overflow:hidden;
        transition:.35s;
        box-shadow:0 20px 40px rgba(0,0,0,0.3);
        backdrop-filter:blur(18px);
    }

    .resume-card:hover{
        transform:translateY(-6px);
        border-color:rgba(168,85,247,0.35);
    }

    .cover-wrapper{
        position:relative;
        overflow:hidden;
    }

    .cover-wrapper img{
        width:100%;
        height:300px;
        object-fit:cover;
        transition:.5s;
    }

    .resume-card:hover img{
        transform:scale(1.08);
    }

    .cover-overlay{
        position:absolute;
        inset:0;
        background:linear-gradient(to top, rgba(0,0,0,.9), rgba(0,0,0,.1));
    }

    .spoiler-badge{
        position:absolute;
        top:16px;
        right:16px;
        background:#ef4444;
        color:white;
        padding:8px 14px;
        border-radius:999px;
        font-size:.75rem;
        font-weight:700;
        z-index: 10;
    }

    .resume-content{
        padding:24px;
    }

    .resume-title{
        font-size:1.5rem;
        font-weight:800;
        color:white;
        line-height:1.4;
        margin-bottom:12px;
    }

    /* Efek hover ungu halus untuk link judul */
    .resume-title a {
        transition: color 0.2s ease;
    }

    .resume-title a:hover {
        color: #c084fc !important;
    }

    .book-title{
        color:#c084fc;
        font-size:.95rem;
        font-weight:700;
        margin-bottom:8px;
    }

    .resume-date{
        color:#94a3b8;
        font-size:.9rem;
        margin-bottom:20px;
    }

    .btn-custom{
        flex:1;
        border:none;
        padding:12px;
        border-radius:14px;
        font-weight:700;
        transition:.25s;
        text-align: center;
        text-decoration: none;
        display: inline-block;
    }

    .btn-edit{
        background:#7c3aed;
        color:white;
    }

    .btn-edit:hover{
        background:#8b5cf6;
        color:white;
    }

    .btn-delete{
        background:rgba(239,68,68,.1);
        color:#fca5a5;
        border:1px solid rgba(239,68,68,.2);
        width: 100%;
    }

    .btn-delete:hover{
        background:rgba(239,68,68,.18);
        color:#fca5a5;
    }

    .empty-box{
        background:rgba(255,255,255,.05);
        border:1px dashed rgba(255,255,255,.1);
        border-radius:30px;
        padding:80px 30px;
        text-align:center;
    }
</style>

<div class="resume-page">
    <div class="container">

        <div class="d-flex flex-wrap justify-content-between align-items-center mb-5 gap-3">
            <div>
                <h1 class="display-4 fw-black text-white mb-2">
                    Resume Saya
                </h1>
                <p class="text-secondary fs-5 mb-0">
                    Kumpulan resume dan pemikiran setelah membaca cerita.
                </p>
            </div>

            <div class="px-4 py-3 rounded-4 fw-bold"
                 style="
                    background:rgba(168,85,247,.15);
                    color:#d8b4fe;
                    border:1px solid rgba(168,85,247,.2);
                 ">
                {{ $resumes->count() }} Resume
            </div>
        </div>

        @if($resumes->count() == 0)
            <div class="empty-box">
                <div style="font-size:5rem;" class="mb-4">
                    📝
                </div>
                <h2 class="fw-bold text-white mb-3">
                    Belum Ada Resume
                </h2>
                <p class="text-secondary mb-0">
                    Selesaikan membaca buku lalu tulis resumemu.
                </p>
            </div>
@else

            <div class="row g-4">
                @foreach($resumes as $resume)
                    <div class="col-md-6 col-lg-4">
                        <div class="resume-card h-100">

                            <div class="cover-wrapper">
                                <img src="{{ $resume->book->image_path ? asset($resume->book->image_path) : 'https://via.placeholder.com/300x400?text=No+Cover' }}" alt="Cover Buku">
                                <div class="cover-overlay"></div>

                                @if($resume->has_spoiler)
                                    <div class="spoiler-badge">
                                        SPOILER
                                    </div>
                                @endif
                            </div>

                            <div class="resume-content">
                                <div class="book-title">
                                    {{ $resume->book->title }}
                                </div>

                                <div class="resume-title">
                                    <a href="{{ route('resume.show', $resume->id) }}" style="color: white; text-decoration: none;">
                                        {{ $resume->title ?? 'Tanpa Judul' }}
                                    </a>
                                </div>

                                <div class="resume-date">
                                    {{ $resume->created_at->format('d M Y') }}
                                </div>

                                <div class="d-flex gap-3 align-items-center">
                                    
                                    <a href="{{ route('resume.edit', $resume->id) }}" class="btn-custom btn-edit">
                                        Edit
                                    </a>

                                    <form action="{{ route('resume.destroy', $resume->id) }}" 
                                          method="POST" 
                                          class="flex-grow-1 m-0" 
                                          onsubmit="return confirm('Apakah kamu yakin ingin menghapus resume ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-custom btn-delete">
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-5">
                {{ $resumes->links() }}
            </div>
        @endif

    </div>
</div>

@endsection