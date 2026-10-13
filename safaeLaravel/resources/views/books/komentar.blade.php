@extends('layouts.app')

@section('title', 'Diskusi Halaman ' . $page . ' - Safae')

@section('content')

<style>
    .comment-page-wrapper {
        padding: 10px 0 50px 0;
        color: #f1f5f9;
    }

    .dark-card {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .form-dark-control {
        background: #0f172a;
        border: 1px solid #334155;
        color: #f8fafc;
        border-radius: 14px;
        padding: 14px;
    }

    .form-dark-control:focus {
        background: #0f172a;
        border-color: #38bdf8;
        color: white;
        box-shadow: 0 0 0 0.25rem rgba(56, 189, 248, 0.15);
    }

    .form-dark-control::placeholder {
        color: #64748b;
    }

    .user-avatar-circle {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, #38bdf8, #818cf8);
        color: #0f172a;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .btn-submit-comment {
        background: #38bdf8;
        color: #0f172a;
        font-weight: 700;
        border: none;
        padding: 10px 24px;
        border-radius: 12px;
        transition: 0.2s;
    }

    .btn-submit-comment:hover {
        background: #7dd3fc;
        color: #0f172a;
    }

    .btn-upload-img {
        background: #0f172a;
        border: 1px solid #334155;
        color: #94a3b8;
        border-radius: 12px;
        padding: 8px 16px;
        cursor: pointer;
        transition: 0.2s;
    }

    .btn-upload-img:hover {
        background: #1e293b;
        color: #38bdf8;
        border-color: #38bdf8;
    }

    .comment-card {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 18px;
        padding: 20px;
        margin-bottom: 16px;
        transition: transform 0.2s ease, border-color 0.2s ease;
    }

    .comment-card:hover {
        border-color: #38bdf8;
        transform: translateY(-2px);
    }

    .attached-img {
        max-height: 280px;
        border-radius: 12px;
        border: 1px solid #334155;
        object-fit: cover;
    }
</style>

<div class="comment-page-wrapper">
    <div class="container-fluid" style="max-width: 900px;">

        <!-- TOMBOL KEMBALI -->
        <div class="mb-4">
            <a href="{{ route('book.show', ['id' => $bookId, 'page' => $page]) }}" class="btn btn-outline-secondary btn-sm rounded-3">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Bacaan (Halaman {{ $page }})
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success bg-opacity-10 border-success text-success mb-4 rounded-3">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            </div>
        @endif

        <!-- FORM TULIS KOMENTAR BARU -->
        <div class="dark-card mb-5">
            <div class="d-flex align-items-center mb-3">
                <div class="p-2 rounded-3 me-3 text-info" style="background: rgba(56, 189, 248, 0.12);">
                    <i class="fa-solid fa-comments fs-5"></i>
                </div>
                <h5 class="fw-bold text-white mb-0">Tulis Komentar Baru</h5>
            </div>

            <form action="{{ route('komentar.simpan') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="book_id" value="{{ $bookId }}">
                <input type="hidden" name="page" value="{{ $page }}">

                <div class="mb-3">
                    <textarea name="komentar" class="form-control form-dark-control" rows="3" placeholder="Bagikan pendapat atau diskusikan bacaan halaman {{ $page }} ini..." required></textarea>
                </div>

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-2">
                        <label class="btn-upload-img small mb-0">
                            <i class="fa-solid fa-image text-info me-1"></i> Tambah Gambar
                            <input type="file" name="image" accept="image/*" class="d-none" id="comment-image-input" onchange="updateFileName(this)">
                        </label>
                        <span id="file-name-preview" class="text-secondary small d-inline-block text-truncate" style="max-width: 200px;"></span>
                    </div>

                    <button type="submit" class="btn-submit-comment">
                        Kirim Komentar <i class="fa-solid fa-paper-plane ms-1"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- HEADER DAFTAR KOMENTAR -->
        <div class="d-flex align-items-center justify-content-between border-bottom border-secondary border-opacity-25 pb-3 mb-4">
            <div class="fw-bold text-white fs-6">
                <i class="fa-solid fa-comments me-2 text-info"></i> Semua Diskusi
            </div>
            <span class="badge bg-secondary bg-opacity-25 text-info px-3 py-2 rounded-3">
                {{ count($komentar) }} Komentar
            </span>
        </div>

        <!-- DAFTAR KOMENTAR -->
        <div class="d-flex flex-column gap-3">
            @forelse($komentar as $c)
                @php
                    $initials = strtoupper(substr($c->username ?? 'User', 0, 2));
                @endphp

                <div class="comment-card">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="user-avatar-circle">{{ $initials }}</div>
                            <div>
                                <h6 class="fw-bold text-white mb-0">{{ $c->username }}</h6>
                                <small class="text-secondary" style="font-size: 0.78rem;">
                                    <i class="fa-regular fa-clock me-1"></i>{{ $c->created_at ? $c->created_at->diffForHumans() : 'Baru saja' }}
                                </small>
                            </div>
                        </div>

                        <!-- TOMBOL ACTION EDIT & HAPUS -->
                        @if(Auth::check() && Auth::id() == $c->user_id)
                            <div class="d-flex gap-2">
                                <a href="{{ route('komentar.edit', $c->id) }}" class="btn btn-outline-info btn-sm rounded-2 py-1 px-2" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                <form action="{{ route('komentar.hapus', $c->id) }}" method="POST" onsubmit="return confirm('Hapus komentar ini?')" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-2 py-1 px-2" title="Hapus">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>

                    <div class="ps-md-5">
                        <p class="mb-3 lh-lg small text-slate-300" style="color: #cbd5e1; white-space: pre-line;">
                            {{ $c->komentar }}
                        </p>

                        @if($c->image_path)
                            <div class="mb-2">
                                <img src="{{ asset('uploads/' . $c->image_path) }}" class="img-fluid attached-img" alt="Lampiran">
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="dark-card text-center py-5">
                    <i class="fa-regular fa-comments fa-3x text-secondary mb-3"></i>
                    <h5 class="fw-bold text-white">Belum Ada Diskusi di Halaman Ini</h5>
                    <p class="text-secondary small mb-0">Mulai ketikkan sesuatu untuk memicu obrolan bersama pembaca lain!</p>
                </div>
            @endforelse
        </div>

    </div>
</div>

<script>
    function updateFileName(input) {
        const preview = document.getElementById('file-name-preview');
        if (input.files && input.files.length > 0) {
            preview.innerText = '📎 ' + input.files[0].name;
        } else {
            preview.innerText = '';
        }
    }
</script>

@endsection