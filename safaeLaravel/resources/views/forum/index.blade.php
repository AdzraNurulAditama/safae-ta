@extends('layouts.app')

@section('title', 'Forum Diskusi - Safae')

@section('content')

<style>
    /* ================= HEADER & UTILITIES ================= */
    .page-title {
        color: #f1f5f9;
        font-weight: 800;
        margin-bottom: 25px;
    }

    .alert-custom {
        background: rgba(34, 197, 94, 0.1);
        border: 1px solid rgba(34, 197, 94, 0.3);
        color: #4ade80;
        border-radius: 12px;
    }

    .alert-info-custom {
        background: rgba(56, 189, 248, 0.1);
        border: 1px solid rgba(56, 189, 248, 0.3);
        color: #38bdf8;
        border-radius: 12px;
    }

    /* ================= FORM SELECT ================= */
    .form-select-modern {
        background-color: #1e293b;
        color: #f8fafc;
        border: 1px solid #334155;
        border-radius: 14px;
        padding: 14px 20px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
        width: 100%;
        max-width: 400px;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath fill='none' stroke='%2394a3b8' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 16px 12px;
    }

    .form-select-modern:focus {
        border-color: #38bdf8;
        box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.15);
        outline: none;
    }

    /* ================= BUTTONS ================= */
    .btn-create {
        background: #38bdf8;
        color: #0f172a;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        padding: 12px 24px;
        transition: 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-create:hover {
        background: #7dd3fc;
        transform: translateY(-2px);
    }

    /* ================= TOPIC CARDS ================= */
    .topic-card {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 20px;
        transition: 0.3s ease;
        text-decoration: none;
    }

    .topic-card:hover {
        transform: translateY(-4px);
        border-color: #38bdf8;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    .topic-icon {
        width: 55px;
        height: 55px;
        min-width: 55px;
        border-radius: 14px;
        background: rgba(56, 189, 248, 0.1);
        color: #38bdf8;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .topic-content {
        flex: 1;
    }

    .topic-title {
        color: #f8fafc;
        font-size: 1.15rem;
        font-weight: 700;
        margin-bottom: 5px;
        transition: 0.3s;
    }

    .topic-card:hover .topic-title {
        color: #38bdf8;
    }

    .topic-meta {
        color: #94a3b8;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .topic-meta i {
        color: #64748b;
    }

    /* ================= EMPTY STATE ================= */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #94a3b8;
        background: #1e293b;
        border: 2px dashed #334155;
        border-radius: 20px;
        margin-top: 20px;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 20px;
        color: #475569;
    }
</style>

<div class="container-fluid">

    <h3 class="page-title">
        <i class="fa-solid fa-comments me-2 text-primary"></i> Forum Diskusi Buku
    </h3>

    @if(session('success'))
        <div class="alert alert-custom d-flex align-items-center mb-4">
            <i class="fa-solid fa-circle-check fa-lg me-3"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close btn-close-white ms-auto opacity-50" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="mb-5">
        <form method="GET" action="{{ route('forum.index') }}">
            <select name="genre_id" class="form-select-modern" onchange="this.form.submit()">
                <option value="">Pilih Genre untuk Diskusi...</option>
                @foreach($genres as $genre)
                    <option value="{{ $genre->id }}" {{ $selectedGenre == $genre->id ? 'selected' : '' }}>
                        {{ $genre->nama_genre }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    @if(!$currentGenre)
        <div class="empty-state">
            <i class="fa-solid fa-layer-group"></i>
            <h4 class="text-white fw-bold mb-2">Pilih Genre Terlebih Dahulu</h4>
            <p>Silakan pilih genre melalui menu di atas untuk mulai melihat atau membuat topik diskusi.</p>
        </div>
    @else
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3 border-bottom border-secondary pb-3">
            <div>
                <h5 class="text-white fw-bold mb-1">
                    Topik Diskusi: <span class="text-primary">{{ $currentGenre->nama_genre }}</span>
                </h5>
                <small class="text-muted">Diskusikan buku-buku favoritmu di genre ini.</small>
            </div>

            @auth
                <a href="{{ route('forum.create', $currentGenre->id) }}" class="btn-create text-decoration-none">
                    <i class="fa-solid fa-plus"></i> Tambah Topik Baru
                </a>
            @else
                <div class="alert alert-info-custom m-0 px-4 py-2">
                    <i class="fa-solid fa-lock me-2"></i> Login untuk membuat topik
                </div>
            @endauth
        </div>

        @if($topics->isEmpty())
            <div class="empty-state">
                <i class="fa-regular fa-comment-dots"></i>
                <h4 class="text-white fw-bold mb-2">Belum Ada Topik Diskusi</h4>
                <p>Jadilah yang pertama memulai pembicaraan menarik di genre {{ $currentGenre->nama_genre }}!</p>
            </div>
        @else
            <div class="topic-list">
                @foreach($topics as $topic)
                    <a href="{{ route('forum.detail', $topic->id) }}" class="topic-card">
                        
                        <div class="topic-icon">
                            <i class="fa-solid fa-book-open-reader"></i>
                        </div>

                        <div class="topic-content">
                            <div class="topic-title">
                                {{ $topic->judul }}
                            </div>
                            <div class="topic-meta">
                                <span>
                                    <i class="fa-solid fa-user me-1"></i> {{ $topic->user->nama_depan ?? 'User' }}
                                </span>
                                <span>
                                    <i class="fa-regular fa-clock me-1"></i> {{ $topic->created_at->diffForHumans() ?? 'Baru saja' }}
                                </span>
                            </div>
                        </div>

                        <div class="text-muted opacity-50 ms-auto d-none d-md-block">
                            <i class="fa-solid fa-chevron-right fa-lg"></i>
                        </div>

                    </a>
                @endforeach
            </div>
        @endif
    @endif

</div>

@endsection