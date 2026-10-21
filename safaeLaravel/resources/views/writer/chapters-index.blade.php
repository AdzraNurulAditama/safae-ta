
@extends('layouts.app')
@section('title', 'Kelola Bab - ' . $book->title)
@section('content')
<style>
    /* HALAMAN KELOLA BAB */
    .chapter-page {
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: #f1f5f9;
        padding: 24px 0 50px;
    }

    .chapter-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* TOMBOL KEMBALI */
    .chapter-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 15px;
        margin-bottom: 12px;
        background: #172236;
        border: 1px solid #2d3b52;
        border-radius: 30px;
        color: #a8b8ce;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: 0.3s;
    }

    .chapter-back:hover {
        color: #38bdf8;
        border-color: #38bdf8;
        background: #1e3048;
    }

    /* HEADER INFORMASI BUKU */
    .chapter-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        padding: 22px;
        margin-bottom: 18px;
        background: linear-gradient(115deg, #14214a, #0b3a5c 65%, #101a39);
        border: 1px solid rgba(125, 211, 252, 0.2);
        border-radius: 20px;
    }

    .chapter-book-info {
        display: flex;
        align-items: center;
        gap: 14px;
        min-width: 0;
    }

    .chapter-cover {
        width: 65px;
        height: 90px;
        flex-shrink: 0;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.12);
    }

    .chapter-cover-empty {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 65px;
        height: 90px;
        flex-shrink: 0;
        border-radius: 10px;
        background: #1e3a5f;
        color: #38bdf8;
        font-size: 25px;
    }

    .chapter-book-detail {
        min-width: 0;
    }

    .chapter-genre {
        display: inline-block;
        padding: 4px 10px;
        margin-bottom: 6px;
        background: rgba(56, 189, 248, 0.12);
        border: 1px solid rgba(56, 189, 248, 0.2);
        border-radius: 8px;
        color: #7dd3fc;
        font-size: 11px;
        font-weight: 700;
    }

    .chapter-book-title {
        margin: 0 0 4px;
        color: #fff;
        font-size: 20px;
        font-weight: 800;
        overflow-wrap: anywhere;
    }

    .chapter-author {
        margin: 0 0 7px;
        color: #a8b8ce;
        font-size: 12px;
    }

    .chapter-book-stats {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        color: #cbd5e1;
        font-size: 12px;
    }

    .chapter-book-stats i {
        color: #38bdf8;
        margin-right: 4px;
    }

    /* TOMBOL TAMBAH BAB */
    .chapter-add-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        padding: 12px 18px;
        background: #38bdf8;
        border: none;
        border-radius: 11px;
        color: #082f49;
        font-size: 13px;
        font-weight: 800;
        text-decoration: none;
        white-space: nowrap;
        transition: 0.3s;
    }

    .chapter-add-btn:hover {
        background: #7dd3fc;
        color: #082f49;
        transform: translateY(-2px);
    }

    /* NOTIFIKASI */
    .chapter-alert {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 13px 16px;
        margin-bottom: 18px;
        background: rgba(34, 197, 94, 0.1);
        border: 1px solid rgba(34, 197, 94, 0.2);
        border-radius: 12px;
        color: #4ade80;
        font-size: 13px;
        font-weight: 600;
    }

    /* JUDUL DAFTAR BAB */
    .chapter-section {
        margin-top: 8px;
    }

    .chapter-section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 12px;
    }

    .chapter-section-title {
        margin: 0;
        color: #fff;
        font-size: 17px;
        font-weight: 800;
    }

    .chapter-count {
        padding: 5px 12px;
        background: rgba(56, 189, 248, 0.1);
        border: 1px solid rgba(56, 189, 248, 0.2);
        border-radius: 20px;
        color: #7dd3fc;
        font-size: 12px;
        font-weight: 700;
    }

    /* RINGKASAN BAB */
    .chapter-summary {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 14px;
    }

    .chapter-summary-item {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 12px;
        background: #162033;
        border: 1px solid #29374e;
        border-radius: 9px;
        color: #a8b8ce;
        font-size: 12px;
        font-weight: 600;
    }

    .chapter-summary-item.free i {
        color: #4ade80;
    }

    .chapter-summary-item.premium i {
        color: #fbbf24;
    }

    .chapter-summary-item strong {
        color: #fff;
    }

    /* DAFTAR BAB */
    .chapter-list {
        display: flex;
        flex-direction: column;
        gap: 9px;
    }

    .chapter-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        padding: 13px 15px;
        background: #162033;
        border: 1px solid #29374e;
        border-radius: 14px;
        transition: 0.3s;
    }

    .chapter-item:hover {
        border-color: #38bdf8;
        background: #1a2940;
    }

    .chapter-item-left {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
    }

    .chapter-number {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 43px;
        height: 45px;
        flex-shrink: 0;
        background: rgba(56, 189, 248, 0.12);
        border-radius: 10px;
        color: #7dd3fc;
    }

    .chapter-number span {
        font-size: 10px;
        font-weight: 600;
        line-height: 1.2;
    }

    .chapter-number strong {
        font-size: 16px;
        font-weight: 800;
        line-height: 1.2;
    }

    .chapter-item-info {
        min-width: 0;
    }

    .chapter-item-title {
        margin: 0 0 6px;
        color: #fff;
        font-size: 13px;
        font-weight: 700;
        overflow-wrap: anywhere;
    }

    .chapter-item-meta {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 7px 10px;
        color: #94a3b8;
        font-size: 11px;
    }

    .chapter-item-meta i {
        margin-right: 3px;
    }

    /* STATUS PUBLISHED DAN DRAFT */
    .chapter-status {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 9px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 700;
    }

    .chapter-status.published {
        color: #4ade80;
        background: rgba(34, 197, 94, 0.12);
        border: 1px solid rgba(34, 197, 94, 0.2);
    }

    .chapter-status.draft {
        color: #facc15;
        background: rgba(234, 179, 8, 0.12);
        border: 1px solid rgba(234, 179, 8, 0.2);
    }

    /* STATUS BAB GRATIS DAN PREMIUM */
    .chapter-access {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 9px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 700;
    }

    .chapter-access.free {
        color: #86efac;
        background: rgba(34, 197, 94, 0.1);
        border: 1px solid rgba(34, 197, 94, 0.2);
    }

    .chapter-access.premium {
        color: #fbbf24;
        background: rgba(251, 191, 36, 0.1);
        border: 1px solid rgba(251, 191, 36, 0.25);
    }

    .chapter-illustration {
        color: #7dd3fc;
        font-size: 11px;
    }

    /* TOMBOL EDIT */
    .chapter-edit-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 9px 13px;
        background: transparent;
        border: 1px solid #334155;
        border-radius: 10px;
        color: #a8b8ce;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        transition: 0.3s;
    }

    .chapter-edit-btn:hover {
        color: #38bdf8;
        border-color: #38bdf8;
        background: rgba(56, 189, 248, 0.08);
    }

    /* BELUM ADA BAB */
    .chapter-empty {
        padding: 45px 20px;
        background: #162033;
        border: 1px dashed #334155;
        border-radius: 18px;
        text-align: center;
    }

    .chapter-empty-icon {
        margin-bottom: 12px;
        color: #64748b;
        font-size: 40px;
    }

    .chapter-empty h3 {
        margin-bottom: 8px;
        color: #fff;
        font-size: 18px;
        font-weight: 700;
    }

    .chapter-empty p {
        margin-bottom: 18px;
        color: #94a3b8;
        font-size: 13px;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .chapter-container {
            padding: 0 12px;
        }

        .chapter-header {
            flex-direction: column;
            align-items: stretch;
            padding: 18px;
        }

        .chapter-add-btn {
            width: 100%;
        }

        .chapter-item {
            align-items: flex-start;
        }

        .chapter-edit-btn {
            padding: 9px 11px;
        }
    }

    @media (max-width: 480px) {
        .chapter-item {
            flex-direction: column;
            align-items: stretch;
        }

        .chapter-edit-btn {
            width: 100%;
        }

        .chapter-book-title {
            font-size: 17px;
        }

        .chapter-item-meta {
            gap: 7px;
        }
    }
</style>

<div class="chapter-page">
    <div class="chapter-container">
        @php
            $totalBab = $chapters->count();
            $totalPublished = $chapters->where('status', 'published')->count();
            $totalGratis = $chapters->where('is_premium', 0)->count();
            $totalPremium = $chapters->where('is_premium', 1)->count();
            $coverPath = $book->image_path
                ? preg_replace('#^(public/|storage/)+#', '', $book->image_path)
                : null;
        @endphp

        <!-- TOMBOL KEMBALI -->
        <a href="{{ route('writer.books.index') }}" class="chapter-back">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Studio Penulis
        </a>

        <!-- HEADER INFORMASI BUKU -->
        <div class="chapter-header">
            <div class="chapter-book-info">
                @if($coverPath)
                    <img src="{{ asset('storage/'.$coverPath) }}" alt="Cover {{ $book->title }}" class="chapter-cover">
                @else
                    <div class="chapter-cover-empty">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                @endif
                <div class="chapter-book-detail">
                    <span class="chapter-genre">{{ $book->genre }}</span>
                    <h2 class="chapter-book-title">{{ $book->title }}</h2>
                    <p class="chapter-author">Penulis: {{ $book->author }}</p>
                    <div class="chapter-book-stats">
                        <span><i class="fa-solid fa-list"></i> {{ $totalBab }} Bab</span>
                        <span><i class="fa-solid fa-circle-check"></i> {{ $totalPublished }} Terbit</span>
                    </div>
                </div>
            </div>
            <a href="{{ url('/penulis/buku/'.$book->id.'/chapter/tambah') }}" class="chapter-add-btn">
                <i class="fa-solid fa-plus"></i> Tulis Bab Baru
            </a>
        </div>

        <!-- NOTIFIKASI -->
        @if(session('success'))
            <div class="chapter-alert">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        <!-- DAFTAR BAB -->
        <div class="chapter-section">
            <div class="chapter-section-header">
                <h3 class="chapter-section-title">Daftar Bab</h3>
                <span class="chapter-count">{{ $totalBab }} Bab</span>
            </div>

            <!-- RINGKASAN GRATIS DAN PREMIUM -->
            <div class="chapter-summary">
                <div class="chapter-summary-item free">
                    <i class="fa-solid fa-lock-open"></i>
                    <span>Bab Gratis: <strong>{{ $totalGratis }}</strong></span>
                </div>
                <div class="chapter-summary-item premium">
                    <i class="fa-solid fa-crown"></i>
                    <span>Bab Premium: <strong>{{ $totalPremium }}</strong></span>
                </div>
            </div>

            <div class="chapter-list">
                @forelse($chapters as $chapter)
                    <div class="chapter-item">
                        <div class="chapter-item-left">
                            <div class="chapter-number">
                                <span>Bab</span>
                                <strong>{{ $chapter->chapter_number }}</strong>
                            </div>
                            <div class="chapter-item-info">
                                <h4 class="chapter-item-title">{{ $chapter->title }}</h4>
                                <div class="chapter-item-meta">
                                    <span>
                                        <i class="fa-regular fa-clock"></i>
                                        {{ $chapter->updated_at?->diffForHumans() ?? '-' }}
                                    </span>

                                    <!-- STATUS PUBLIKASI -->
                                    <span class="chapter-status {{ $chapter->status == 'published' ? 'published' : 'draft' }}">
                                        <i class="fa-solid fa-circle" style="font-size:5px"></i>
                                        {{ $chapter->status == 'published' ? 'Published' : 'Draft' }}
                                    </span>

                                    <!-- STATUS AKSES BAB -->
                                    @if($chapter->is_premium)
                                        <span class="chapter-access premium">
                                            <i class="fa-solid fa-crown"></i> Premium
                                        </span>
                                    @else
                                        <span class="chapter-access free">
                                            <i class="fa-solid fa-lock-open"></i> Gratis
                                        </span>
                                    @endif

                                    <!-- ILUSTRASI BAB -->
                                    @if($chapter->image)
                                        <span class="chapter-illustration">
                                            <i class="fa-regular fa-image"></i> Ada Ilustrasi
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- TOMBOL EDIT BAB -->
                        <a href="{{ url('/penulis/buku/'.$book->id.'/chapter/'.$chapter->id.'/edit') }}" class="chapter-edit-btn">
                            <i class="fa-solid fa-pen-to-square"></i> Edit Bab
                        </a>
                    </div>
                @empty
                    <div class="chapter-empty">
                        <div class="chapter-empty-icon">
                            <i class="fa-solid fa-book-open-reader"></i>
                        </div>
                        <h3>Belum Ada Bab Cerita</h3>
                        <p>Mulai tulis bab pertama untuk karya kamu di Safae.</p>
                        <a href="{{ url('/penulis/buku/'.$book->id.'/chapter/tambah') }}" class="chapter-add-btn">
                            <i class="fa-solid fa-plus"></i> Buat Bab 1
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
