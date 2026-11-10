
@extends('layouts.app')
@section('title', 'Pratinjau Buku - ' . $book->title)
@section('content')

<style>
    /* HALAMAN PRATINJAU */
    .writer-reader-page {
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: #475569;
        padding: 24px 0 50px;
        background:
            radial-gradient(circle at 5% 5%, rgba(186, 230, 253, .25), transparent 28%),
            radial-gradient(circle at 95% 15%, rgba(221, 214, 254, .25), transparent 28%);
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
        background: rgba(255, 255, 255, .85);
        border: 1px solid #dbeafe;
        border-radius: 30px;
        color: #64748b;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        transition: .3s;
        box-shadow: 0 3px 10px rgba(148, 163, 184, .08);
    }

    .reader-back:hover {
        color: #6366f1;
        border-color: #c4b5fd;
        background: #f5f3ff;
        transform: translateX(-3px);
    }

    /* HEADER INFORMASI BUKU */
    .reader-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        padding: 22px;
        margin-bottom: 16px;
        background: linear-gradient(115deg, #e0f2fe, #ede9fe 60%, #fce7f3);
        border: 1px solid #dbeafe;
        border-radius: 20px;
        box-shadow: 0 8px 25px rgba(148, 163, 184, .10);
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
        border: 2px solid rgba(255, 255, 255, .9);
        box-shadow: 0 5px 14px rgba(100, 116, 139, .15);
    }

    .reader-cover-empty {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 75px;
        height: 105px;
        flex-shrink: 0;
        border-radius: 10px;
        background: #dbeafe;
        color: #60a5fa;
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
        background: rgba(255, 255, 255, .7);
        border: 1px solid #c4b5fd;
        border-radius: 20px;
        color: #7c3aed;
        font-size: 11px;
        font-weight: 800;
    }

    .reader-book-title {
        margin: 0 0 5px;
        color: #334155;
        font-size: 23px;
        font-weight: 800;
        overflow-wrap: anywhere;
    }

    .reader-book-author {
        margin: 0 0 7px;
        color: #64748b;
        font-size: 12px;
    }

    .reader-book-meta {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        color: #64748b;
        font-size: 12px;
    }

    .reader-book-meta i {
        color: #8b5cf6;
        margin-right: 4px;
    }

    /* TOMBOL KELOLA BAB */
    .reader-manage-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 11px 17px;
        background: linear-gradient(135deg, #93c5fd, #c4b5fd);
        border: 1px solid rgba(255, 255, 255, .7);
        border-radius: 11px;
        color: #3730a3;
        font-size: 13px;
        font-weight: 800;
        text-decoration: none;
        white-space: nowrap;
        transition: .3s;
        box-shadow: 0 4px 12px rgba(139, 92, 246, .12);
    }

    .reader-manage-btn:hover {
        background: linear-gradient(135deg, #bfdbfe, #ddd6fe);
        color: #4338ca;
        transform: translateY(-2px);
        box-shadow: 0 7px 16px rgba(139, 92, 246, .18);
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
        background: rgba(255, 255, 255, .9);
        border: 1px solid #e2e8f0;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(148, 163, 184, .07);
        transition: .3s;
    }

    .reader-overview-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 18px rgba(148, 163, 184, .13);
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
        color: #3b82f6;
        background: #dbeafe;
    }

    .reader-overview-icon.green {
        color: #16a34a;
        background: #dcfce7;
    }

    .reader-overview-icon.yellow {
        color: #d97706;
        background: #fef3c7;
    }

    .reader-overview-icon.gold {
        color: #b45309;
        background: #ffedd5;
    }

    .reader-overview-number {
        color: #334155;
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
        color: #334155;
        font-size: 19px;
        font-weight: 800;
    }

    .reader-section-title i {
        color: #8b5cf6;
    }

    .reader-section-count {
        padding: 5px 12px;
        background: #ede9fe;
        border: 1px solid #ddd6fe;
        border-radius: 20px;
        color: #7c3aed;
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
        background: rgba(255, 255, 255, .95);
        border: 1px solid #e2e8f0;
        border-radius: 19px;
        transition: .3s;
        box-shadow: 0 5px 16px rgba(148, 163, 184, .07);
    }

    .reader-chapter-card:hover {
        border-color: #c4b5fd;
        box-shadow: 0 12px 28px rgba(148, 163, 184, .14);
    }

    /* HEADER SETIAP BAB */
    .reader-chapter-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        padding: 20px 24px;
        border-bottom: 1px solid #e9e5f5;
        background: linear-gradient(110deg, #f0f9ff, #f5f3ff);
    }

    .reader-chapter-heading {
        min-width: 0;
    }

    .reader-chapter-number {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 7px;
        color: #818cf8;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    .reader-chapter-title {
        margin: 0 0 10px;
        color: #334155;
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
        color: #15803d;
        background: #dcfce7;
        border: 1px solid #bbf7d0;
    }

    .reader-status.draft {
        color: #b45309;
        background: #fef3c7;
        border: 1px solid #fde68a;
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
        color: #15803d;
        background: #dcfce7;
        border: 1px solid #bbf7d0;
    }

    .reader-access.premium {
        color: #b45309;
        background: #ffedd5;
        border: 1px solid #fed7aa;
    }

    /* TOMBOL EDIT BAB */
    .reader-edit-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 9px 14px;
        background: #fff;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        color: #64748b;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        white-space: nowrap;
        transition: .3s;
    }

    .reader-edit-btn:hover {
        color: #7c3aed;
        border-color: #c4b5fd;
        background: #f5f3ff;
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
        border: 1px solid #e2e8f0;
        border-radius: 13px;
        box-shadow: 0 8px 20px rgba(148, 163, 184, .13);
    }

    .reader-chapter-content {
        color: #475569;
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
        border-top: 1px solid #e9e5f5;
        color: #94a3b8;
        font-size: 11px;
    }

    .reader-chapter-footer i {
        color: #a78bfa;
        margin-right: 5px;
    }

    /* BELUM ADA BAB */
    .reader-empty {
        padding: 50px 20px;
        background: rgba(255, 255, 255, .9);
        border: 1px dashed #c4b5fd;
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
        background: #ede9fe;
        border-radius: 20px;
        color: #8b5cf6;
        font-size: 30px;
    }

    .reader-empty h3 {
        margin-bottom: 8px;
        color: #334155;
        font-size: 19px;
        font-weight: 800;
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
