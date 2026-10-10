@extends('layouts.app')

@section('title', $buku->title . ' - Halaman ' . $page)

@section('content')

<style>
    /* Styling khusus Halaman Baca */
    .reader-container {
        max-width: 850px;
        margin: 0 auto;
        background: #1e293b;
        padding: 40px;
        border-radius: 20px;
        border: 1px solid #334155;
    }

    .reader-header h1 {
        font-weight: 800;
        color: #38bdf8;
        margin-bottom: 10px;
    }
    
    .meta-info {
        color: #94a3b8;
        font-size: 0.95rem;
        margin-bottom: 30px;
    }

    .meta-info i {
        margin-right: 5px;
        color: #38bdf8;
    }

    .reader-content {
        font-size: 1.25rem;
        line-height: 1.9;
        color: #e2e8f0;
        margin-bottom: 50px;
        text-align: justify;
    }

    /* Tombol Navigasi */
    .btn-reader {
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        transition: 0.3s;
        border: none;
        text-decoration: none;
    }

    .btn-blue {
        background: #38bdf8;
        color: #0f172a;
    }

    .btn-blue:hover {
        background: #7dd3fc;
        color: #0f172a;
    }
    
    .btn-yellow {
        background: #fbbf24;
        color: #0f172a;
    }

    .btn-yellow:hover {
        background: #fcd34d;
        color: #0f172a;
    }
    
    .btn-outline {
        border: 2px solid #334155;
        color: #94a3b8;
    }

    .btn-outline:hover {
        background: #334155;
        color: white;
    }

    .finish-box{
        width:100%;
        text-align:center;
        padding:35px 20px;
        border-radius:20px;
        background:rgba(56,189,248,0.08);
        border:1px solid rgba(56,189,248,0.15);
        margin-top:10px;
    }

    .finish-icon{
        width:85px;
        height:85px;
        margin:auto;
        border-radius:50%;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:2rem;
        background:linear-gradient(135deg,#38bdf8,#8b5cf6);
        color:white;
        margin-bottom:20px;
        box-shadow:0 0 30px rgba(56,189,248,.3);
    }

    .finish-title{
        font-size:2rem;
        font-weight:800;
        color:white;
        margin-bottom:12px;
    }

    .finish-text{
        color:#94a3b8;
        max-width:600px;
        margin:auto;
        margin-bottom:28px;
        line-height:1.7;
    }
</style>

<div class="container">

    <div class="reader-container">

        <!-- HEADER -->
        <div class="reader-header text-center">

            <h1>{{ $buku->title }}</h1>

            <div class="meta-info">

                <i class="fa-solid fa-user"></i>
                {{ $buku->author }}

                &nbsp; | &nbsp; 

                <i class="fa-solid fa-tag"></i>
                {{ $buku->genre }}

                &nbsp; | &nbsp;

                <i class="fa-solid fa-book-open"></i>
                Halaman {{ $page }} / {{ $totalHalaman }}

            </div>

        </div>

        <!-- CONTENT -->
        <div class="reader-content">

            <p>{{ $halaman }}</p>

        </div>

        <!-- BUTTONS -->
        <div class="buttons d-flex flex-wrap gap-2 justify-content-center pt-4 border-top border-secondary">

            <!-- PREVIOUS -->
            @if($page > 1)

                <a href="{{ route('book.show', ['id' => $buku->id, 'page' => $page - 1]) }}"
                   class="btn btn-reader btn-blue">

                    <i class="fa-solid fa-arrow-left me-2"></i>
                    Sebelumnya

                </a>

            @endif

            <!-- NEXT PAGE -->
            @if($page < $totalHalaman)

                <a href="{{ route('book.show', ['id' => $buku->id, 'page' => $page + 1]) }}"
                   class="btn btn-reader btn-blue">

                    Selanjutnya
                    <i class="fa-solid fa-arrow-right ms-2"></i>

                </a>

            @else

                <!-- FINISH READING -->
                <div class="finish-box">

                    <div class="finish-icon">
                        🎉
                    </div>

                    <div class="finish-title">
                        Selamat, Kamu Tamat Membaca!
                    </div>

                    <div class="finish-text">
                        Bagikan pendapat, teori, pesan moral,
                        atau momen favoritmu setelah menyelesaikan cerita ini.
                    </div>

                    <div class="d-flex flex-wrap justify-content-center gap-3">

                        <!-- RESUME -->
                        <a href="{{ route('resume.create', $buku->id) }}"
                           class="btn btn-reader btn-blue">

                            <i class="fa-solid fa-pen me-2"></i>
                            Tulis Resume

                        </a>

                        <!-- REVIEW -->
                        <a href="{{ route('ulasan.index', ['id' => $buku->id]) }}"
                           class="btn btn-reader btn-yellow">

                            <i class="fa-solid fa-star me-2"></i>
                            Beri Ulasan

                        </a>

                    </div>

                </div>

            @endif

            <!-- BOOK LIST -->
            <a href="{{ route('genre.index') }}"
               class="btn btn-reader btn-outline">

                <i class="fa-solid fa-list me-2"></i>
                Daftar Buku

            </a>

            <!-- COMMENTS -->
            <a href="{{ route('komentar.index', [
                    'bookId' => $buku->id,
                    'page' => $page
                ]) }}"
               class="btn btn-reader btn-yellow">

                <i class="fa-solid fa-comments me-2"></i>
                Komentar

            </a>

        </div>

    </div>

</div>

@endsection