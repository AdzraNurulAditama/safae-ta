
@extends('layouts.app')

@section('title', $topic->judul . ' - Safae Forum')

@section('content')

<style>
    /* ================= CONTAINER & UTILITIES ================= */
    .forum-container {
        max-width: 850px;
        margin: 0 auto;
    }

    .btn-back {
        color: #89839f;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: 0.3s;
        margin-bottom: 20px;
    }
    .btn-back:hover { color: #a48bdc; transform: translateX(-5px); }

    /* ================= MAIN TOPIC CARD ================= */
    .topic-card {
        background: #ffffff;
        border: 1px solid #e5def5;
        border-radius: 20px;
        padding: 35px;
        box-shadow: 0 10px 30px rgba(185, 165, 232, 0.12);
        margin-bottom: 40px;
    }

    .topic-title {
        color: #a48bdc;
        font-weight: 800;
        font-size: 1.75rem;
        margin-bottom: 15px;
        line-height: 1.3;
    }

    .topic-meta {
        display: flex;
        align-items: center;
        gap: 15px;
        color: #89839f;
        font-size: 0.9rem;
        padding-bottom: 20px;
        border-bottom: 1px solid #e5def5;
        margin-bottom: 25px;
    }
    .topic-meta i { color: #b9a5e8; }

    .topic-body {
        color: #514d69;
        font-size: 1.1rem;
        line-height: 1.8;
        white-space: pre-wrap; /* Menjaga format enter/paragraf */
    }

    .topic-image {
        width: 100%;
        max-height: 450px;
        object-fit: cover;
        border-radius: 16px;
        margin-top: 25px;
        border: 1px solid #e5def5;
    }

    /* ================= ATTACHMENT BOX ================= */
    .attachment-box {
        background: rgba(130, 169, 216, 0.08);
        border: 1px dashed #82a9d8;
        border-radius: 12px;
        padding: 15px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 25px;
    }
    
    .btn-download {
        background: #82a9d8;
        color: #ffffff;
        font-weight: 600;
        padding: 8px 16px;
        border-radius: 10px;
        text-decoration: none;
        transition: 0.3s;
    }
    .btn-download:hover { background: #6e98ca; }

    /* ================= ACTION BUTTONS ================= */
    .action-bar {
        display: flex;
        gap: 10px;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #e5def5;
    }

    .btn-action {
        padding: 8px 16px;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        transition: 0.3s;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-edit {
        background: #fff4d9;
        color: #b58a32;
        border: 1px solid #f0dcae;
    }
    .btn-edit:hover { background: #d5a64d; color: #ffffff; }
    
    .btn-delete {
        background: #fff1f4;
        color: #cf8297;
        border: 1px solid #f2d2dc;
    }
    .btn-delete:hover { background: #cf8297; color: #ffffff; }

    /* ================= COMMENTS SECTION ================= */
    .section-title {
        color: #514d69;
        font-weight: 700;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .comment-card {
        background: #f8f5ff;
        border: 1px solid #d8c9f2;
        border-left: 5px solid #b9a5e8;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 15px;
        display: flex;
        gap: 15px;
        box-shadow: 0 4px 12px rgba(164, 139, 220, 0.10);
    }

    .comment-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: #e5dcf8;
        border: 1px solid #d5c7ef;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #8065b5;
        font-weight: bold;
        flex-shrink: 0;
    }

    .comment-content { flex: 1; }

    .comment-author {
        color: #51416f;
        font-weight: 700;
        font-size: 1rem;
        margin-bottom: 5px;
    }

    .comment-text {
        color: #625b78;
        font-size: 0.95rem;
        line-height: 1.6;
    }

    .empty-comment {
        text-align: center;
        padding: 30px;
        color: #89839f;
        background: #faf8fe;
        border: 1px dashed #cbbce9;
        border-radius: 16px;
        margin-bottom: 20px;
    }

    /* ================= COMMENT FORM ================= */
    .form-control-modern {
        background-color: #ffffff;
        color: #514d69;
        border: 1px solid #d8c9f2;
        border-radius: 14px;
        padding: 15px;
        width: 100%;
        resize: vertical;
        transition: 0.3s;
    }

    .form-control-modern:focus {
        background-color: #ffffff;
        border-color: #a48bdc;
        box-shadow: 0 0 0 3px rgba(185, 165, 232, 0.2);
        outline: none;
        color: #514d69;
    }

    .form-control-modern::placeholder {
        color: #aaa3bc;
    }

    .btn-submit {
        background: #b9a5e8;
        color: #ffffff;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        padding: 12px 24px;
        transition: 0.3s ease;
        width: 100%;
    }
    .btn-submit:hover { background: #a48bdc; }

    /* ================= COMMENT FORM CARD ================= */
    .topic-card[style*="padding: 25px"] {
        background: #f8f5ff;
        border: 1px solid #d8c9f2;
        box-shadow: 0 6px 18px rgba(164, 139, 220, 0.12);
    }

    .topic-card[style*="padding: 25px"] h5 {
        color: #51416f !important;
    }

    /* ================= COLOR UTILITIES ================= */
    .text-primary {
        color: #b9a5e8 !important;
    }

    .text-info {
        color: #82a9d8 !important;
    }

    .text-white {
        color: #514d69 !important;
    }

    .text-muted {
        color: #89839f !important;
    }

    .text-primary:hover {
        color: #a48bdc !important;
    }
</style>

<div class="container-fluid forum-container">

    <a href="/forum?genre_id={{ $topic->genre_id }}" class="btn-back">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Topik
    </a>

    <div class="topic-card">
        <h1 class="topic-title">{{ $topic->judul }}</h1>

        <div class="topic-meta">
            <span><i class="fa-solid fa-user-pen me-1"></i> {{ $topic->user->nama_depan ?? $topic->user->name }}</span>
            <span><i class="fa-regular fa-clock me-1"></i> {{ $topic->created_at->format('d M Y, H:i') }}</span>
        </div>

        <div class="topic-body">
            {{ $topic->isi }}
        </div>

        @if($topic->gambar)
            <img src="{{ asset('uploads/topics/' . $topic->gambar) }}" class="topic-image" alt="Lampiran Gambar">
        @endif

        @if($topic->file)
            <div class="attachment-box">
                <div>
                    <i class="fa-solid fa-file-lines fa-lg text-info me-2"></i>
                    <span class="text-white fw-medium">Lampiran File</span>
                </div>
                <a href="{{ asset('uploads/topics/' . $topic->file) }}" target="_blank" class="btn-download">
                    <i class="fa-solid fa-download me-1"></i> Download
                </a>
            </div>
        @endif

        {{-- EDIT & HAPUS --}}
        @auth
            @if(Auth::id() == $topic->user_id)
                <div class="action-bar">
                    <a href="{{ route('forum.edit', $topic->id) }}" class="btn-action btn-edit">
                        <i class="fa-solid fa-pen-to-square"></i> Edit
                    </a>

                    <form action="{{ route('forum.destroy', $topic->id) }}" method="POST" class="m-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action btn-delete" onclick="return confirm('Apakah kamu yakin ingin menghapus topik ini?')">
                            <i class="fa-solid fa-trash-can"></i> Hapus
                        </button>
                    </form>
                </div>
            @endif
        @endauth
    </div>

    <h4 class="section-title">
        <i class="fa-regular fa-comments text-primary"></i> Komentar ({{ $topic->comments->count() }})
    </h4>

    <div class="mb-4">
        @forelse($topic->comments as $comment)
            <div class="comment-card shadow-sm">
                <div class="comment-avatar">
                    {{ strtoupper(substr($comment->user->nama_depan ?? $comment->user->name ?? 'U', 0, 1)) }}
                </div>
                <div class="comment-content">
                    <div class="comment-author">
                        {{ $comment->user->nama_depan ?? $comment->user->name }}
                        <span class="text-muted fw-normal ms-2" style="font-size: 0.8rem;">
                            {{ $comment->created_at->diffForHumans() }}
                        </span>
                    </div>
                    <div class="comment-text">
                        {{ $comment->isi }}
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-comment">
                <i class="fa-regular fa-comment-dots fa-2x mb-2 opacity-50"></i>
                <p class="mb-0">Belum ada komentar. Jadilah yang pertama memberikan tanggapan!</p>
            </div>
        @endforelse
    </div>

    @auth
        <div class="topic-card" style="padding: 25px;">
            <h5 class="text-white fw-bold mb-3">Tulis Komentar</h5>
            <form method="POST" action="{{ route('forum.comment') }}">
                @csrf
                <input type="hidden" name="topic_id" value="{{ $topic->id }}">
                
                <textarea name="isi" class="form-control-modern mb-3" rows="3" placeholder="Tuliskan pendapat atau tanggapanmu di sini..." required></textarea>
                
                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-paper-plane me-2"></i> Kirim Komentar
                </button>
            </form>
        </div>
    @else
        <div class="topic-card text-center p-4">
            <p class="text-muted mb-0">
                <i class="fa-solid fa-lock me-1"></i> Silakan <a href="{{ route('login') }}" class="text-primary text-decoration-none fw-bold">Login</a> untuk memberikan komentar.
            </p>
        </div>
    @endauth

</div>

@endsection
