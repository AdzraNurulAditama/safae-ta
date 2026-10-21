
@extends('layouts.app')
@section('title', 'Pratinjau Buku - ' . $book->title)
@section('content')
<style>
    /* HALAMAN PRATINJAU */
    .writer-reader-page {
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: #f1f5f9;
        padding: 24px 0 50px;
    }

    .writer-reader-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* NAVIGASI KEMBALI */
    .reader-back {
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

    .reader-back:hover {
        color: #38bdf8;
        border-color: #38bdf8;
        background: #1e3048;
    }

    /* HEADER INFORMASI BUKU */
    .reader-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        padding: 22px;
        margin-bottom: 16px;
        background: linear-gradient(115deg, #14214a, #0b3a5c 65%, #101a39);
        border: 1px solid rgba(125, 211, 252, 0.2);
        border-radius: 20px;
    }

    .reader-book-info {
        display: flex;
        align-items: center;
        gap: 15px;
        min-width: 0;
    }

    .reader-cover {
        width: 75px;
        height: 105px;
        flex-shrink: 0;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.12);
    }

    .reader-cover-empty {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 75px;
        height: 105px;
        flex-shrink: 0;
        border-radius: 10px;
        background: #1e3a5f;
        color: #38bdf8;
        font-size: 28px;
    }

    .reader-book-detail {
        min-width: 0;
    }

    .reader-mode {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 10px;
        margin-bottom: 7px;
        background: rgba(56, 189, 248, 0.12);
        border: 1px solid rgba(56, 189, 248, 0.2);
        border-radius: 20px;
        color: #7dd3fc;
        font-size: 11px;
        font-weight: 700;
    }

    .reader-book-title {
        margin: 0 0 5px;
        color: #fff;
        font-size: 23px;
        font-weight: 800;
        overflow-wrap: anywhere;
    }

    .reader-book-author {
        margin: 0 0 7px;
        color: #b5c4d8;
        font-size: 12px;
    }

    .reader-book-meta {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        color: #cbd5e1;
        font-size: 12px;
    }

    .reader-book-meta i {
        color: #38bdf8;
        margin-right: 4px;
    }

    /* TOMBOL KELOLA BAB */
    .reader-manage-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 11px 17px;
        background: #38bdf8;
        border-radius: 11px;
        color: #082f49;
        font-size: 13px;
        font-weight: 800;
        text-decoration: none;
        white-space: nowrap;
        transition: 0.3s;
    }

    .reader-manage-btn:hover {
        background: #7dd3fc;
        color: #082f49;
        transform: translateY(-2px);
    }

    /* RINGKASAN STATISTIK BAB */
    .reader-overview {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 10px;
        margin-bottom: 24px;
    }

    .reader-overview-card {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 13px 15px;
        background: #162033;
        border: 1px solid #29374e;
        border-radius: 15px;
    }

    .reader-overview-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        flex-shrink: 0;
        border-radius: 11px;
        font-size: 15px;
    }

    .reader-overview-icon.blue {
        color: #38bdf8;
        background: rgba(56, 189, 248, 0.13);
    }

    .reader-overview-icon.green {
        color: #4ade80;
        background: rgba(34, 197, 94, 0.13);
    }

    .reader-overview-icon.yellow {
        color: #facc15;
        background: rgba(234, 179, 8, 0.13);
    }

    .reader-overview-icon.gold {
        color: #fbbf24;
        background: rgba(251, 191, 36, 0.13);
    }

    .reader-overview-number {
        color: #fff;
        font-size: 20px;
        font-weight: 800;
        line-height: 1.2;
    }

    .reader-overview-label {
        color: #94a3b8;
        font-size: 11px;
    }

    /* JUDUL DAFTAR BACAAN */
    .reader-section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 14px;
    }

    .reader-section-title {
        display: flex;
        align-items: center;
        gap: 9px;
        margin: 0;
        color: #fff;
        font-size: 19px;
        font-weight: 800;
    }

    .reader-section-title i {
        color: #38bdf8;
    }

    .reader-section-count {
        padding: 5px 12px;
        background: rgba(56, 189, 248, 0.1);
        border: 1px solid rgba(56, 189, 248, 0.2);
        border-radius: 20px;
        color: #7dd3fc;
        font-size: 12px;
        font-weight: 700;
    }

    /* CARD BACAAN */
    .reader-chapter-list {
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    .reader-chapter-card {
        overflow: hidden;
        background: #162033;
        border: 1px solid #29374e;
        border-radius: 19px;
        transition: 0.3s;
    }

    .reader-chapter-card:hover {
        border-color: rgba(56, 189, 248, 0.4);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
    }

    /* HEADER SETIAP BAB */
    .reader-chapter-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        padding: 20px 24px;
        border-bottom: 1px solid #29374e;
        background: rgba(15, 23, 42, 0.35);
    }

    .reader-chapter-heading {
        min-width: 0;
    }

    .reader-chapter-number {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 7px;
        color: #38bdf8;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .reader-chapter-title {
        margin: 0 0 10px;
        color: #fff;
        font-size: 20px;
        font-weight: 800;
        overflow-wrap: anywhere;
    }

    .reader-chapter-badges {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 7px;
    }

    /* STATUS PUBLISHED DAN DRAFT */
    .reader-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
    }

    .reader-status.published {
        color: #4ade80;
        background: rgba(34, 197, 94, 0.12);
        border: 1px solid rgba(34, 197, 94, 0.2);
    }

    .reader-status.draft {
        color: #facc15;
        background: rgba(234, 179, 8, 0.12);
        border: 1px solid rgba(234, 179, 8, 0.2);
    }

    /* STATUS GRATIS DAN PREMIUM */
    .reader-access {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
    }

    .reader-access.free {
        color: #86efac;
        background: rgba(34, 197, 94, 0.1);
        border: 1px solid rgba(34, 197, 94, 0.2);
    }

    .reader-access.premium {
        color: #fbbf24;
        background: rgba(251, 191, 36, 0.1);
        border: 1px solid rgba(251, 191, 36, 0.25);
    }

    /* TOMBOL EDIT BAB */
    .reader-edit-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 9px 14px;
        background: transparent;
        border: 1px solid #334155;
        border-radius: 10px;
        color: #cbd5e1;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        transition: 0.3s;
    }

    .reader-edit-btn:hover {
        color: #38bdf8;
        border-color: #38bdf8;
        background: rgba(56, 189, 248, 0.08);
    }

    /* KONTEN CERITA */
    .reader-chapter-body {
        padding: 28px 35px 35px;
    }

    .reader-chapter-image {
        margin-bottom: 25px;
        text-align: center;
    }

    .reader-chapter-image img {
        display: block;
        max-width: 100%;
        max-height: 380px;
        width: auto;
        height: auto;
        margin: 0 auto;
        object-fit: contain;
        border: 1px solid #334155;
        border-radius: 13px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    .reader-chapter-content {
        color: #dce5f2;
        font-size: 15px;
        font-weight: 400;
        line-height: 2;
        overflow-wrap: anywhere;
        white-space: pre-line;
    }

    .reader-chapter-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 28px;
        padding-top: 16px;
        border-top: 1px solid #29374e;
        color: #94a3b8;
        font-size: 11px;
    }

    .reader-chapter-footer i {
        color: #38bdf8;
        margin-right: 5px;
    }

    /* BELUM ADA BAB */
    .reader-empty {
        padding: 50px 20px;
        background: #162033;
        border: 1px dashed #334155;
        border-radius: 20px;
        text-align: center;
    }

    .reader-empty-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 70px;
        height: 70px;
        margin: 0 auto 15px;
        background: rgba(56, 189, 248, 0.1);
        border-radius: 20px;
        color: #38bdf8;
        font-size: 30px;
    }

    .reader-empty h3 {
        margin-bottom: 8px;
        color: #fff;
        font-size: 19px;
        font-weight: 700;
    }

    .reader-empty p {
        margin-bottom: 18px;
        color: #94a3b8;
        font-size: 13px;
    }

    /* RESPONSIVE */
    @media (max-width: 900px) {
        .reader-overview {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 768px) {
        .writer-reader-container {
            padding: 0 12px;
        }

        .reader-header {
            flex-direction: column;
            align-items: stretch;
            padding: 18px;
        }

        .reader-manage-btn {
            width: 100%;
        }

        .reader-chapter-header {
            flex-direction: column;
            align-items: stretch;
            padding: 18px;
        }

        .reader-edit-btn {
            align-self: flex-start;
        }

        .reader-chapter-body {
            padding: 22px 18px;
        }
    }

    @media (max-width: 480px) {
        .reader-book-title {
            font-size: 18px;
        }

        .reader-cover,
        .reader-cover-empty {
            width: 65px;
            height: 90px;
        }

        .reader-overview-card {
            padding: 10px;
            gap: 9px;
        }

        .reader-overview-number {
            font-size: 18px;
        }

        .reader-overview-label {
            font-size: 10px;
        }

        .reader-chapter-title {
            font-size: 18px;
        }
    }
</style>

<div class="writer-reader-page">
    <div class="writer-reader-container">
        @php
            $totalBab = $chapters->count();
            $totalPublished = $chapters->where('status', 'published')->count();
            $totalDraft = $chapters->where('status', 'draft')->count();
            $totalGratis = $chapters->where('is_premium', 0)->count();
            $totalPremium = $chapters->where('is_premium', 1)->count();
            $coverPath = $book->image_path
                ? preg_replace('#^(public/|storage/)+#', '', $book->image_path)
                : null;
        @endphp

        <!-- TOMBOL KEMBALI -->
        <a href="{{ route('writer.books.index') }}" class="reader-back">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Studio Penulis
        </a>

        <!-- HEADER INFORMASI BUKU -->
        <div class="reader-header">
            <div class="reader-book-info">
                @if($coverPath)
                    <img src="{{ asset('storage/'.$coverPath) }}" class="reader-cover" alt="Cover {{ $book->title }}">
                @else
                    <div class="reader-cover-empty">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                @endif

                <div class="reader-book-detail">
                    <span class="reader-mode">
                        <i class="fa-solid fa-eye"></i> Mode Pratinjau Penulis
                    </span>
                    <h2 class="reader-book-title">{{ $book->title }}</h2>
                    <p class="reader-book-author">Penulis: {{ $book->author }}</p>
                    <div class="reader-book-meta">
                        <span>
                            <i class="fa-solid fa-tag"></i> {{ $book->genre ?? 'Tanpa Genre' }}
                        </span>
                        <span>
                            <i class="fa-solid fa-list"></i> {{ $totalBab }} Bab
                        </span>
                        <span>
                            <i class="fa-solid fa-circle-check"></i> {{ $totalPublished }} Terbit
                        </span>
                    </div>
                </div>
            </div>

            <a href="{{ url('/penulis/buku/'.$book->id.'/chapters') }}" class="reader-manage-btn">
                <i class="fa-solid fa-list-check"></i> Kelola Bab
            </a>
        </div>

        <!-- RINGKASAN STATUS BAB -->
        <div class="reader-overview">
            <div class="reader-overview-card">
                <div class="reader-overview-icon blue">
                    <i class="fa-solid fa-book-open"></i>
                </div>
                <div>
                    <div class="reader-overview-number">{{ $totalBab }}</div>
                    <div class="reader-overview-label">Total Bab</div>
                </div>
            </div>

            <div class="reader-overview-card">
                <div class="reader-overview-icon green">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div>
                    <div class="reader-overview-number">{{ $totalPublished }}</div>
                    <div class="reader-overview-label">Published</div>
                </div>
            </div>

            <div class="reader-overview-card">
                <div class="reader-overview-icon yellow">
                    <i class="fa-solid fa-file-pen"></i>
                </div>
                <div>
                    <div class="reader-overview-number">{{ $totalDraft }}</div>
                    <div class="reader-overview-label">Draft</div>
                </div>
            </div>

            <div class="reader-overview-card">
                <div class="reader-overview-icon gold">
                    <i class="fa-solid fa-crown"></i>
                </div>
                <div>
                    <div class="reader-overview-number">{{ $totalPremium }}</div>
                    <div class="reader-overview-label">Bab Premium</div>
                </div>
            </div>
        </div>

        <!-- DAFTAR BACAAN -->
        <div class="reader-section-header">
            <h3 class="reader-section-title">
                <i class="fa-solid fa-book-open-reader"></i> Pratinjau Isi Buku
            </h3>
            <span class="reader-section-count">{{ $totalBab }} Bab</span>
        </div>

        <!-- KONTEN SEMUA BAB -->
        <div class="reader-chapter-list">
            @forelse($chapters as $chapter)
                @php
                    $chapterPublished = $chapter->status === 'published';
                    $chapterPremium = (bool) $chapter->is_premium;
                    $chapterImage = $chapter->image
                        ? preg_replace('#^(public/|storage/)+#', '', $chapter->image)
                        : null;
                @endphp

                <div class="reader-chapter-card">
                    <!-- HEADER BAB -->
                    <div class="reader-chapter-header">
                        <div class="reader-chapter-heading">
                            <span class="reader-chapter-number">
                                <i class="fa-solid fa-bookmark"></i> Bab {{ $chapter->chapter_number }}
                            </span>
                            <h3 class="reader-chapter-title">{{ $chapter->title }}</h3>

                            <div class="reader-chapter-badges">
                                <!-- STATUS PUBLIKASI -->
                                @if($chapterPublished)
                                    <span class="reader-status published">
                                        <i class="fa-solid fa-circle-check"></i> Published
                                    </span>
                                @else
                                    <span class="reader-status draft">
                                        <i class="fa-solid fa-file-pen"></i> Draft
                                    </span>
                                @endif

                                <!-- STATUS AKSES -->
                                @if($chapterPremium)
                                    <span class="reader-access premium">
                                        <i class="fa-solid fa-crown"></i> Premium
                                    </span>
                                @else
                                    <span class="reader-access free">
                                        <i class="fa-solid fa-lock-open"></i> Gratis
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- EDIT BAB -->
                        <a href="{{ url('/penulis/buku/'.$book->id.'/chapter/'.$chapter->id.'/edit') }}" class="reader-edit-btn">
                            <i class="fa-solid fa-pen-to-square"></i> Edit Bab Ini
                        </a>
                    </div>

                    <!-- ISI CERITA -->
                    <div class="reader-chapter-body">
                        @if($chapterImage)
                            <div class="reader-chapter-image">
                                <img src="{{ asset('storage/'.$chapterImage) }}" alt="Ilustrasi Bab {{ $chapter->chapter_number }}">
                            </div>
                        @endif

                        <div class="reader-chapter-content">{{ $chapter->content }}</div>

                        <!-- FOOTER BAB -->
                        <div class="reader-chapter-footer">
                            <span>
                                <i class="fa-regular fa-clock"></i>
                                Terakhir diperbarui {{ $chapter->updated_at?->diffForHumans() ?? '-' }}
                            </span>
                            <span>
                                <i class="fa-solid fa-book-open"></i>
                                Bab {{ $chapter->chapter_number }} dari {{ $totalBab }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="reader-empty">
                    <div class="reader-empty-icon">
                        <i class="fa-solid fa-book-open-reader"></i>
                    </div>
                    <h3>Belum Ada Bab yang Ditulis</h3>
                    <p>Buku ini belum memiliki konten cerita. Mulai tulis bab pertamamu sekarang.</p>
                    <a href="{{ url('/penulis/buku/'.$book->id.'/chapter/tambah') }}" class="reader-manage-btn">
                        <i class="fa-solid fa-plus"></i> Tulis Bab Pertama
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
