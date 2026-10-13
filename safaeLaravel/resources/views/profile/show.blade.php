@extends('layouts.app')

@section('title', 'Profil Saya - Safae')

@section('content')

<style>
    .profile-container {
        max-width: 1050px;
        margin: 0 auto;
        padding: 20px 0 60px 0;
        color: #f1f5f9;
    }

    /* HEADER PROFIL MODERN DARK */
    .profile-header-card {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 24px;
        padding: 30px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        margin-bottom: 30px;
    }

    .avatar-lg {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #38bdf8;
        box-shadow: 0 10px 25px rgba(56, 189, 248, 0.25);
    }

    .point-badge-pill {
        background: rgba(245, 158, 11, 0.15);
        border: 1px solid rgba(245, 158, 11, 0.4);
        color: #fbbf24;
        padding: 6px 16px;
        border-radius: 999px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
    }

    /* STATISTIK COUNTER STRIP */
    .stats-strip {
        background: #0f172a;
        border: 1px solid #334155;
        border-radius: 16px;
        padding: 15px 25px;
        display: flex;
        justify-content: space-around;
        align-items: center;
        margin-top: 25px;
    }

    .stat-item {
        text-align: center;
    }

    .stat-number {
        font-size: 1.5rem;
        font-weight: 800;
        color: #38bdf8;
        line-height: 1.1;
    }

    .stat-label {
        font-size: 0.8rem;
        color: #94a3b8;
        font-weight: 600;
        text-uppercase: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-divider {
        width: 1px;
        height: 35px;
        background: #334155;
    }

    /* CARDS SECTION */
    .section-card {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 20px;
        padding: 25px;
        height: 100%;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #f8fafc;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* PESAN TERAKHIR FORUM */
    .forum-message-box {
        background: #0f172a;
        border: 1px solid #334155;
        border-radius: 16px;
        padding: 18px;
    }

    .user-avatar-sm {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }

    /* DAFTAR BACAAN & KARYA GRID */
    .reading-book-card {
        background: #0f172a;
        border: 1px solid #334155;
        border-radius: 14px;
        padding: 10px;
        transition: 0.2s;
        text-decoration: none;
        color: white;
        display: block;
    }

    .reading-book-card:hover {
        border-color: #38bdf8;
        transform: translateY(-3px);
        color: white;
    }

    .book-cover-mini {
        width: 100%;
        height: 130px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 8px;
    }

    .book-title-mini {
        font-size: 0.82rem;
        font-weight: 700;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .btn-edit-profile {
        background: #38bdf8;
        color: #0f172a;
        font-weight: 700;
        padding: 8px 20px;
        border-radius: 12px;
        text-decoration: none;
        transition: 0.2s;
    }

    .btn-edit-profile:hover {
        background: #7dd3fc;
        color: #0f172a;
    }
</style>

<div class="profile-container">

    <!-- 1. HEADER PROFIL UTAMA -->
    <div class="profile-header-card">
        <div class="d-flex flex-column flex-md-row align-items-center gap-4">
            
            <!-- Foto Profil -->
            <img src="{{ $profile->foto_profil ? asset('storage/' . $profile->foto_profil) : 'https://ui-avatars.com/api/?name='.urlencode($profile->username).'&background=38bdf8&color=0f172a' }}" 
                 class="avatar-lg" 
                 alt="{{ $profile->username }}">

            <!-- Informasi & Nama -->
            <div class="flex-grow-1 text-center text-md-start">
                <div class="d-flex align-items-center justify-content-center justify-content-md-start gap-3 mb-2 flex-wrap">
                    <h2 class="fw-bold text-white mb-0">{{ $profile->username }}</h2>
                    <div class="point-badge-pill">
                        <i class="fa-solid fa-star"></i> {{ number_format($user->points ?? 0) }} Poin
                    </div>
                </div>

                <p class="text-secondary small mb-2">
                    {{ $profile->bio ?? 'Belum ada bio singkat.' }}
                </p>

                <div class="d-flex align-items-center justify-content-center justify-content-md-start gap-3 text-secondary small flex-wrap">
                    @if($profile->jurusan)
                        <span><i class="fa-solid fa-graduation-cap text-info me-1"></i> {{ $profile->jurusan }}</span>
                    @endif
                    @if($profile->semester)
                        <span><i class="fa-solid fa-calendar-days text-info me-1"></i> Semester {{ $profile->semester }}</span>
                    @endif
                    @if($profile->social_media)
                        <span><i class="fa-solid fa-link text-info me-1"></i> {{ $profile->social_media }}</span>
                    @endif
                </div>
            </div>

            <!-- Tombol Edit -->
            <div>
                <a href="{{ route('profile.edit') }}" class="btn-edit-profile">
                    <i class="fa-solid fa-pen-to-square me-1"></i> Edit Profil
                </a>
            </div>

        </div>

        <!-- STATISTIK STRIP -->
        <div class="stats-strip">
            <div class="stat-item">
                <div class="stat-number">{{ $karyaCount ?? 0 }}</div>
                <div class="stat-label">Karya</div>
            </div>

            <div class="stat-divider"></div>

            <div class="stat-item">
                <div class="stat-number">{{ $readingList->count() }}</div>
                <div class="stat-label">Daftar Bacaan</div>
            </div>

            <div class="stat-divider"></div>

            <div class="stat-item">
                <div class="stat-number text-warning">{{ number_format($user->points ?? 0) }}</div>
                <div class="stat-label">Total Poin</div>
            </div>
        </div>
    </div>

    <!-- 2. KONTEN BARIS PERTAMA (PESAN FORUM & DAFTAR BACAAN) -->
    <div class="row g-4 mb-4">
        
        <!-- PESAN TERAKHIR FORUM -->
        <div class="col-lg-5">
            <div class="section-card">
                <div class="section-title">
                    <i class="fa-solid fa-thumbtack text-info"></i> Pesan Terakhir Forum
                </div>

                @if($lastForumComment)
                    <div class="forum-message-box">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <img src="{{ $profile->foto_profil ? asset('storage/' . $profile->foto_profil) : 'https://ui-avatars.com/api/?name='.urlencode($profile->username) }}" 
                                 class="user-avatar-sm" alt="Avatar">
                            <div>
                                <h6 class="fw-bold text-white mb-0" style="font-size: 0.9rem;">{{ $profile->username }}</h6>
                                <small class="text-secondary" style="font-size: 0.75rem;">
                                    {{ $lastForumComment->created_at->diffForHumans() }}
                                </small>
                            </div>
                        </div>

                        <div class="p-2 rounded-3 bg-dark bg-opacity-50 mb-3 border border-secondary border-opacity-25">
                            <small class="text-info d-block fw-bold mb-1" style="font-size: 0.75rem;">Topik:</small>
                            <span class="text-white small fw-semibold">
                                {{ $lastForumComment->topic->judul ?? 'Topik Diskusi' }}
                            </span>
                        </div>

                        <p class="text-slate-300 small mb-3" style="color: #cbd5e1; white-space: pre-line;">
                            "{{ $lastForumComment->isi }}"
                        </p>

                        @if(isset($lastForumComment->topic_id))
                            <a href="{{ route('forum.detail', $lastForumComment->topic_id) }}" class="btn btn-sm btn-outline-info rounded-3 w-100">
                                Lihat Semua Percakapan
                            </a>
                        @endif
                    </div>
                @else
                    <div class="text-center py-4 text-secondary">
                        <i class="fa-regular fa-comments fa-2x mb-2 opacity-50"></i>
                        <p class="small mb-0">Belum pernah berdiskusi di forum.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- DAFTAR BACAAN (BUKU YANG DIBACA USER) -->
        <div class="col-lg-7">
            <div class="section-card">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="section-title mb-0">
                        <i class="fa-solid fa-book-bookmark text-info"></i> Daftar Bacaan
                    </div>
                    <small class="text-secondary">{{ $readingList->count() }} Cerita</small>
                </div>

                <h6 class="fw-bold text-white mb-3" style="font-size: 0.95rem;">
                    {{ $profile->username }}'s Reading List
                </h6>

                @if($readingList->isNotEmpty())
                    <div class="row row-cols-2 row-cols-sm-3 g-3">
                        @foreach($readingList as $progress)
                            @if($progress->book)
                                @php
                                    $bookCover = $progress->book->image_path ? str_replace(['public/', 'storage/'], '', $progress->book->image_path) : null;
                                @endphp
                                <div class="col">
                                    <a href="{{ route('book.preview', $progress->book->id) }}" class="reading-book-card">
                                        @if($bookCover)
                                            <img src="{{ asset('storage/' . $bookCover) }}" class="book-cover-mini" alt="{{ $progress->book->title }}" onerror="this.onerror=null; this.src='{{ asset($progress->book->image_path) }}';">
                                        @else
                                            <img src="https://via.placeholder.com/120x160" class="book-cover-mini" alt="No Cover">
                                        @endif
                                        <div class="book-title-mini" title="{{ $progress->book->title }}">
                                            {{ $progress->book->title }}
                                        </div>
                                        <small class="text-secondary d-block" style="font-size: 0.7rem;">
                                            {{ $progress->book->author }}
                                        </small>
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4 text-secondary">
                        <i class="fa-solid fa-book-open fa-2x mb-2 opacity-50"></i>
                        <p class="small mb-0">Belum ada buku yang dibaca.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>

    <!-- 3. KONTEN BARIS KEDUA (KARYA SAYA) -->
    <div class="row">
        <div class="col-12">
            <div class="section-card">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="section-title mb-0">
                        <i class="fa-solid fa-book text-info"></i> Karya Saya
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <small class="text-secondary me-2">{{ $karyaCount }} Karya</small>
                        <a href="{{ url('/tulis-buku') }}" class="btn btn-sm btn-info text-dark font-weight-bold fw-bold rounded-3">
                            <i class="fa-solid fa-plus me-1"></i> Tulis Karya Baru
                        </a>
                    </div>
                </div>

                @if($myBooks->isEmpty())
                    <div class="text-center py-4 text-secondary">
                        <i class="fa-solid fa-pen-nib fa-2x mb-2 opacity-50"></i>
                        <p class="small mb-0">Belum ada karya yang ditulis atau diunggah.</p>
                    </div>
                @else
                    <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 g-3">
                        @foreach($myBooks as $book)
                            @php
                                $cover = $book->image_path ? str_replace(['public/', 'storage/'], '', $book->image_path) : null;
                            @endphp
                            <div class="col">
                                <a href="{{ url('/penulis/buku/' . $book->id . '/chapters') }}" class="reading-book-card">
                                    @if($cover)
                                        <img src="{{ asset('storage/' . $cover) }}" class="book-cover-mini" alt="{{ $book->title }}" onerror="this.onerror=null; this.src='{{ asset($book->image_path) }}';">
                                    @else
                                        <img src="https://via.placeholder.com/120x160" class="book-cover-mini" alt="No Cover">
                                    @endif
                                    <div class="book-title-mini" title="{{ $book->title }}">{{ $book->title }}</div>
                                    
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <small class="text-secondary" style="font-size: 0.7rem;">
                                            {{ $book->chapters_count }} Bab
                                        </small>
                                        @if($book->status === 'published')
                                            <span class="badge bg-success" style="font-size: 0.6rem;">Published</span>
                                        @elseif($book->status === 'pending')
                                            <span class="badge bg-warning text-dark" style="font-size: 0.6rem;">Pending</span>
                                        @else
                                            <span class="badge bg-secondary" style="font-size: 0.6rem;">Draft</span>
                                        @endif
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>

@endsection