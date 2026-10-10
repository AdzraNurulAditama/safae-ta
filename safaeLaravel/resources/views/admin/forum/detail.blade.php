@extends('layouts.layoutsAdmin')

@section('title', 'Detail Forum - ' . $topic->judul)

@push('styles')
    <style>
        /* ================= PREMIUM OBSIDIAN FORUM DETAIL ================= */
        .forum-wrapper {
            background: transparent;
            color: var(--text);
            padding: 10px 0;
        }

        /* Container Topik Utama */
        .topic-panel-premium {
            background: var(--sidebar-bg);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 35px;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        }

        /* Garis Aksen Khas Admin Console */
        .topic-panel-premium::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--accent), transparent);
        }

        /* Metadata Teks */
        .meta-text-box {
            display: flex;
            flex-wrap: wrap;
            gap: 24px;
            color: var(--muted);
            font-size: 0.85rem;
            margin-bottom: 25px;
            padding-bottom: 18px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        .meta-text-box span {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .meta-text-box span i {
            color: var(--primary);
        }

        /* Isi Konten Utama */
        .topic-body-content {
            color: #cbd5e1;
            line-height: 1.8;
            font-size: 1.05rem;
            text-align: justify;
        }

        /* Lampiran Media Gambar & File */
        .topic-media-attached img {
            max-width: 100%;
            max-height: 400px;
            object-fit: cover;
            border: 1px solid var(--border);
            border-radius: 8px;
        }
        .btn-attachment-tech {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border);
            color: var(--text);
            padding: 10px 18px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.2s ease-in-out;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-attachment-tech:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(6, 182, 212, 0.4);
            color: #fff;
        }

        /* Section Urutan Komentar */
        .comment-section-title {
            font-size: 0.85rem;
            color: var(--muted);
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .comment-row-card {
            background: rgba(17, 24, 39, 0.4);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 20px 24px;
            margin-bottom: 12px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            transition: border-color 0.2s ease;
        }
        .comment-row-card:hover {
            border-color: rgba(255, 255, 255, 0.08);
        }

        .comment-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .comment-body {
            color: #cbd5e1;
            font-size: 0.95rem;
            line-height: 1.6;
            margin: 4px 0 4px;
        }

        /* Overrides Tombol Batal/Kembali */
        .btn-back-console {
            font-size: 0.85rem;
            font-weight: 600;
            padding: 10px 18px;
            border-radius: 8px;
            transition: all 0.25s ease;
        }
        .btn-back-console:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #fff !important;
        }
    </style>
@endpush

@section('content')
<div class="container-fluid px-0 forum-wrapper">
    
    {{-- ================= HEADER NAVIGASI ATAS ================= --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="font-size: 0.8rem;">
                    <li class="breadcrumb-item"><a href="{{ url('/admin') }}" style="color: var(--muted); text-decoration: none;">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.forum.index') }}" style="color: var(--muted); text-decoration: none;">Kelola Forum</a></li>
                    <li class="breadcrumb-item active text-truncate" style="max-width: 200px; color: var(--primary);" aria-current="page">Detail Topik</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.forum.index') }}" class="btn btn-sm btn-outline-secondary text-white border-secondary btn-back-console">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    {{-- ================= PANEL UTAMA TOPIK DISKUSI ================= --}}
    <div class="topic-panel-premium shadow-sm">
        
        {{-- Judul Topik --}}
        <h2 class="fw-bold text-white mb-3" style="font-size: 1.8rem; letter-spacing: -0.5px;">
            {{ $topic->judul }}
        </h2>

        {{-- Metadata Baris --}}
        <div class="meta-text-box">
            <span>
                <i class="fas fa-tag"></i> Genre: <strong class="text-white">{{ $topic->genre->nama_genre ?? '-' }}</strong>
            </span>
            <span>
                <i class="fas fa-user"></i> Oleh: <span class="text-white">{{ $topic->user->nama_depan ?? 'User' }}</span>
            </span>
            <span>
                <i class="far fa-clock"></i> {{ $topic->created_at->format('d M Y H:i') }}
            </span>
        </div>

        {{-- Isi Narasi Topik --}}
        <div class="topic-body-content">
            <p class="mb-0">{{ $topic->isi }}</p>
        </div>

        {{-- Lampiran File/Gambar Pendukung --}}
        @if($topic->gambar || $topic->file)
            <div class="mt-4 pt-3 border-top d-flex flex-column gap-3" style="border-color: rgba(255,255,255,0.03);">
                @if($topic->gambar)
                    <div class="topic-media-attached">
                        <img src="{{ asset('uploads/topics/'.$topic->gambar) }}" class="rounded img-fluid" alt="Attached Image">
                    </div>
                @endif

                @if($topic->file)
                    <div>
                        <a href="{{ asset('uploads/topics/'.$topic->file) }}" target="_blank" class="btn btn-attachment-tech text-decoration-none">
                            <i class="fas fa-file-alt text-info"></i> Lihat Berkas Lampiran
                        </a>
                    </div>
                @endif
            </div>
        @endif
    </div>

    {{-- ================= SEKTOR DAFTAR KOMENTAR ================= --}}
    <div class="comment-section-title">
        <i class="fa-solid fa-comments text-primary"></i> Komentar ({{ $topic->comments->count() }})
    </div>

    @foreach($topic->comments as $comment)
        <div class="comment-row-card shadow-sm">
            <div class="comment-header">
                <div>
                    <strong class="text-white" style="font-size: 0.95rem;">{{ $comment->user->nama_depan ?? 'User' }}</strong>
                    <small class="text-muted ms-2">{{ $comment->created_at->format('d M Y H:i') }}</small>
                </div>
                
                {{-- Tombol Moderasi Admin --}}
                <form action="{{ route('admin.forum.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus komentar ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-link text-danger p-0 text-decoration-none small fw-semibold" style="font-size: 0.85rem;">
                        <i class="fas fa-trash-alt me-1"></i> Hapus
                    </button>
                </form>
            </div>
            
            <div class="comment-body">
                <p class="mb-0">{{ $comment->isi }}</p>
            </div>
        </div>
    @endforeach

</div>
@endsection