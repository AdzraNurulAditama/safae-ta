
@extends('layouts.app')

@section('title', 'Kelola Bab - ' . $book->title)

@section('content')

<style>
    /* =========================================
       KELOLA BAB - SAFae PASTEL THEME
    ========================================= */

    .chapter-page {
        --text: #38425d;
        --text-soft: #8995aa;
        --border: #e7edf7;
        --blue: #78b9e5;
        --purple: #9c91dc;
        --pink: #e5a5c8;
        --green: #65b995;

        font-family: 'Plus Jakarta Sans', 'Space Grotesk', sans-serif;
        color: var(--text);
        padding: 20px 0 50px;

        background:
            radial-gradient(
                ellipse at 5% 5%,
                rgba(157, 211, 245, .35),
                transparent 42%
            ),
            radial-gradient(
                ellipse at 95% 10%,
                rgba(245, 190, 224, .30),
                transparent 42%
            ),
            radial-gradient(
                ellipse at 50% 75%,
                rgba(207, 197, 245, .25),
                transparent 45%
            ),
            radial-gradient(
                ellipse at 5% 95%,
                rgba(174, 224, 211, .25),
                transparent 40%
            );

        border-radius: 20px;
        min-height: 100vh;
    }

    .chapter-container {
        max-width: 1050px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* =========================================
       TOMBOL KEMBALI
    ========================================= */

    .chapter-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;

        padding: 10px 16px;
        margin-bottom: 15px;

        background: rgba(255,255,255,.85);
        border: 1px solid #e6edf8;
        border-radius: 30px;

        color: #7189c8;
        font-size: 12px;
        font-weight: 700;

        text-decoration: none;
        box-shadow: 0 4px 12px rgba(120,150,200,.06);

        transition: .25s;
    }

    .chapter-back:hover {
        color: #5875b8;
        border-color: #b8d9f4;
        background: #ffffff;
        transform: translateX(-3px);
    }

    /* =========================================
       HEADER INFORMASI BUKU
    ========================================= */

    .chapter-header {
        position: relative;
        overflow: hidden;

        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;

        padding: 24px;
        margin-bottom: 22px;

        background:
            radial-gradient(
                ellipse at 90% 0%,
                rgba(245,190,224,.65),
                transparent 50%
            ),
            radial-gradient(
                ellipse at 5% 100%,
                rgba(157,211,245,.65),
                transparent 55%
            ),
            linear-gradient(
                120deg,
                #e3f3ff,
                #eeeaff 55%,
                #fcebf5
            );

        border: 1px solid rgba(255,255,255,.95);
        border-radius: 23px;

        box-shadow: 0 12px 30px rgba(120,150,200,.10);
    }

    .chapter-book-info {
        display: flex;
        align-items: center;
        gap: 16px;
        min-width: 0;
        position: relative;
        z-index: 1;
    }

    .chapter-cover,
    .chapter-cover-empty {
        width: 70px;
        height: 98px;
        flex-shrink: 0;

        object-fit: cover;
        border-radius: 11px;

        border: 2px solid rgba(255,255,255,.95);
        box-shadow: 0 5px 15px rgba(100,130,180,.15);
    }

    .chapter-cover-empty {
        display: flex;
        align-items: center;
        justify-content: center;

        background: linear-gradient(
            145deg,
            #dceeff,
            #eee5ff,
            #fceafa
        );

        color: #819bd5;
        font-size: 27px;
    }

    .chapter-book-detail {
        min-width: 0;
    }

    .chapter-genre {
        display: inline-block;

        padding: 5px 11px;
        margin-bottom: 7px;

        background: rgba(255,255,255,.65);
        border: 1px solid rgba(255,255,255,.9);
        border-radius: 8px;

        color: #7189c8;
        font-size: 11px;
        font-weight: 700;
    }

    .chapter-book-title {
        margin: 0 0 5px;

        color: #394461;
        font-size: 21px;
        font-weight: 800;

        overflow-wrap: anywhere;
    }

    .chapter-author {
        margin: 0 0 9px;
        color: #77849e;
        font-size: 12px;
    }

    .chapter-book-stats {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;

        color: #71809b;
        font-size: 12px;
        font-weight: 600;
    }

    .chapter-book-stats i {
        color: #78aee1;
        margin-right: 4px;
    }

    /* =========================================
       TOMBOL TAMBAH BAB
    ========================================= */

    .chapter-add-btn {
        position: relative;
        z-index: 1;

        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;

        padding: 12px 18px;

        background: linear-gradient(
            120deg,
            #83bce9,
            #9c9de7,
            #c8a7df
        );

        border: none;
        border-radius: 12px;

        color: #ffffff;
        font-size: 13px;
        font-weight: 800;

        text-decoration: none;
        white-space: nowrap;

        box-shadow: 0 5px 16px rgba(130,155,210,.2);
        transition: .25s;
    }

    .chapter-add-btn:hover {
        background: linear-gradient(
            120deg,
            #6faadd,
            #898bdc,
            #b994d5
        );

        color: #ffffff;
        transform: translateY(-2px);
    }

    /* =========================================
       NOTIFIKASI
    ========================================= */

    .chapter-alert {
        display: flex;
        align-items: center;
        gap: 10px;

        padding: 14px 17px;
        margin-bottom: 20px;

        background: #e7f8ef;
        border: 1px solid #c9eedb;
        border-radius: 13px;

        color: #39976c;
        font-size: 13px;
        font-weight: 600;
    }

    /* =========================================
       JUDUL DAFTAR BAB
    ========================================= */

    .chapter-section {
        margin-top: 8px;
    }

    .chapter-section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 14px;
    }

    .chapter-section-title {
        margin: 0;
        color: #38425d;
        font-size: 19px;
        font-weight: 800;
    }

    .chapter-count {
        padding: 6px 13px;

        background: linear-gradient(
            120deg,
            #e2f1ff,
            #eee8ff
        );

        border: 1px solid #dce8fb;
        border-radius: 20px;

        color: #7189cf;
        font-size: 12px;
        font-weight: 700;
    }

    /* =========================================
       RINGKASAN BAB GRATIS DAN PREMIUM
    ========================================= */

    .chapter-summary {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 16px;
    }

    .chapter-summary-item {
        display: inline-flex;
        align-items: center;
        gap: 8px;

        padding: 9px 13px;

        background: rgba(255,255,255,.85);
        border: 1px solid #e8edf8;
        border-radius: 11px;

        color: #7b879e;
        font-size: 12px;
        font-weight: 600;

        box-shadow: 0 3px 10px rgba(120,150,200,.05);
    }

    .chapter-summary-item.free i {
        color: #58ae89;
    }

    .chapter-summary-item.premium i {
        color: #e4ad4c;
    }

    .chapter-summary-item strong {
        color: #46516b;
    }

    /* =========================================
       DAFTAR BAB
    ========================================= */

    .chapter-list {
        display: flex;
        flex-direction: column;
        gap: 11px;
    }

    .chapter-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;

        padding: 15px 16px;

        background: rgba(255,255,255,.88);
        border: 1px solid rgba(255,255,255,.95);
        border-radius: 16px;

        box-shadow: 0 5px 18px rgba(120,150,200,.06);

        transition: .25s;
    }

    .chapter-item:hover {
        border-color: #c9dff5;
        background: #ffffff;

        box-shadow: 0 10px 25px rgba(120,150,200,.12);

        transform: translateY(-2px);
    }

    .chapter-item-left {
        display: flex;
        align-items: center;
        gap: 13px;
        min-width: 0;
    }

    .chapter-number {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;

        width: 46px;
        height: 48px;
        flex-shrink: 0;

        background: linear-gradient(
            145deg,
            #e0f1ff,
            #eee8ff
        );

        border: 1px solid #e3eafa;
        border-radius: 12px;

        color: #7189cf;
    }

    .chapter-number span {
        font-size: 10px;
        font-weight: 600;
        line-height: 1.2;
    }

    .chapter-number strong {
        font-size: 17px;
        font-weight: 800;
        line-height: 1.2;
    }

    .chapter-item-info {
        min-width: 0;
    }

    .chapter-item-title {
        margin: 0 0 7px;

        color: #38425d;
        font-size: 14px;
        font-weight: 800;

        overflow-wrap: anywhere;
    }

    .chapter-item-meta {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 7px 10px;

        color: #929db2;
        font-size: 11px;
    }

    .chapter-item-meta i {
        margin-right: 3px;
    }

    /* =========================================
       STATUS PUBLISHED DAN DRAFT
    ========================================= */

    .chapter-status {
        display: inline-flex;
        align-items: center;
        gap: 5px;

        padding: 4px 9px;

        border-radius: 20px;
        font-size: 10px;
        font-weight: 700;
    }

    .chapter-status.published {
        color: #39976c;
        background: #e2f7ec;
        border: 1px solid #c8eedb;
    }

    .chapter-status.draft {
        color: #b68b35;
        background: #fff5dc;
        border: 1px solid #f5e6b9;
    }

    /* =========================================
       STATUS AKSES BAB
    ========================================= */

    .chapter-access {
        display: inline-flex;
        align-items: center;
        gap: 5px;

        padding: 4px 9px;

        border-radius: 20px;
        font-size: 10px;
        font-weight: 700;
    }

    .chapter-access.free {
        color: #39976c;
        background: #e4f7ec;
        border: 1px solid #cceedd;
    }

    .chapter-access.premium {
        color: #c18c30;
        background: #fff5df;
        border: 1px solid #f3e4bc;
    }

    .chapter-illustration {
        color: #7299cd;
        font-size: 11px;
    }

    /* =========================================
       TOMBOL AKSI BAB
    ========================================= */

    .chapter-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
    }

    .chapter-edit-btn,
    .chapter-delete-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;

        padding: 9px 13px;

        border-radius: 10px;

        font-size: 12px;
        font-weight: 700;

        text-decoration: none;
        white-space: nowrap;

        transition: .25s;
    }

    .chapter-edit-btn {
        background: #eff6ff;
        border: 1px solid #d9e9fa;
        color: #6d98cf;
    }

    .chapter-edit-btn:hover {
        background: #e1f0ff;
        border-color: #b8d9f4;
        color: #527fb8;
    }

    .chapter-delete-form {
        margin: 0;
    }

    .chapter-delete-btn {
        background: #fff0f3;
        border: 1px solid #f5d5de;
        color: #d66c83;

        cursor: pointer;
    }

    .chapter-delete-btn:hover {
        background: #fce0e7;
        border-color: #e9a6b6;
        color: #c95470;
    }

    /* =========================================
       BELUM ADA BAB
    ========================================= */

    .chapter-empty {
        padding: 50px 20px;

        background: rgba(255,255,255,.88);
        border: 1px dashed #d9e5f5;
        border-radius: 20px;

        text-align: center;

        box-shadow: 0 6px 20px rgba(120,150,200,.06);
    }

    .chapter-empty-icon {
        display: flex;
        align-items: center;
        justify-content: center;

        width: 70px;
        height: 70px;

        margin: 0 auto 15px;

        background: linear-gradient(
            135deg,
            #e0f1ff,
            #eee5ff,
            #fceafa
        );

        border-radius: 22px;

        color: #829bd6;
        font-size: 30px;
    }

    .chapter-empty h3 {
        margin-bottom: 8px;

        color: #38425d;
        font-size: 19px;
        font-weight: 800;
    }

    .chapter-empty p {
        margin-bottom: 18px;

        color: #8995aa;
        font-size: 13px;
    }

    /* =========================================
       RESPONSIVE
    ========================================= */

    @media(max-width: 768px) {

        .chapter-container {
            padding: 0 12px;
        }

        .chapter-header {
            flex-direction: column;
            align-items: stretch;
            padding: 19px;
        }

        .chapter-add-btn {
            width: 100%;
        }

        .chapter-item {
            align-items: flex-start;
        }

        .chapter-actions {
            flex-wrap: wrap;
        }
    }

    @media(max-width: 480px) {

        .chapter-item {
            flex-direction: column;
            align-items: stretch;
        }

        .chapter-actions {
            width: 100%;
        }

        .chapter-actions a,
        .chapter-actions button {
            flex: 1;
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

            <i class="fa-solid fa-arrow-left"></i>

            Kembali ke Studio Penulis

        </a>


        <!-- HEADER INFORMASI BUKU -->

        <div class="chapter-header">

            <div class="chapter-book-info">

                @if($coverPath)

                    <img
                        src="{{ asset('storage/'.$coverPath) }}"
                        alt="Cover {{ $book->title }}"
                        class="chapter-cover">

                @else

                    <div class="chapter-cover-empty">

                        <i class="fa-solid fa-book-open"></i>

                    </div>

                @endif


                <div class="chapter-book-detail">

                    <span class="chapter-genre">
                        {{ $book->genre }}
                    </span>

                    <h2 class="chapter-book-title">
                        {{ $book->title }}
                    </h2>

                    <p class="chapter-author">
                        Penulis: {{ $book->author }}
                    </p>

                    <div class="chapter-book-stats">

                        <span>
                            <i class="fa-solid fa-list"></i>
                            {{ $totalBab }} Bab
                        </span>

                        <span>
                            <i class="fa-solid fa-circle-check"></i>
                            {{ $totalPublished }} Terbit
                        </span>

                    </div>

                </div>

            </div>


            <a href="{{ url('/penulis/buku/'.$book->id.'/chapter/tambah') }}"
               class="chapter-add-btn">

                <i class="fa-solid fa-plus"></i>

                Tulis Bab Baru

            </a>

        </div>


        <!-- NOTIFIKASI -->

        @if(session('success'))

            <div class="chapter-alert">

                <i class="fa-solid fa-circle-check"></i>

                {{ session('success') }}

            </div>

        @endif


        <!-- DAFTAR BAB -->

        <div class="chapter-section">

            <div class="chapter-section-header">

                <h3 class="chapter-section-title">
                    <i class="fa-solid fa-book-open me-2"
                       style="color:#83bce9;"></i>

                    Daftar Bab
                </h3>

                <span class="chapter-count">
                    {{ $totalBab }} Bab
                </span>

            </div>


            <!-- RINGKASAN BAB -->

            <div class="chapter-summary">

                <div class="chapter-summary-item free">

                    <i class="fa-solid fa-lock-open"></i>

                    <span>
                        Bab Gratis:
                        <strong>{{ $totalGratis }}</strong>
                    </span>

                </div>


                <div class="chapter-summary-item premium">

                    <i class="fa-solid fa-crown"></i>

                    <span>
                        Bab Premium:
                        <strong>{{ $totalPremium }}</strong>
                    </span>

                </div>

            </div>


            <!-- LIST BAB -->

            <div class="chapter-list">

                @forelse($chapters as $chapter)

                    <div class="chapter-item">

                        <div class="chapter-item-left">

                            <!-- NOMOR BAB -->

                            <div class="chapter-number">

                                <span>Bab</span>

                                <strong>
                                    {{ $chapter->chapter_number }}
                                </strong>

                            </div>


                            <!-- INFORMASI BAB -->

                            <div class="chapter-item-info">

                                <h4 class="chapter-item-title">
                                    {{ $chapter->title }}
                                </h4>


                                <div class="chapter-item-meta">

                                    <span>

                                        <i class="fa-regular fa-clock"></i>

                                        {{ $chapter->updated_at?->diffForHumans() ?? '-' }}

                                    </span>


                                    <!-- STATUS PUBLIKASI -->

                                    <span class="chapter-status {{ $chapter->status == 'published' ? 'published' : 'draft' }}">

                                        <i class="fa-solid fa-circle"
                                           style="font-size:5px"></i>

                                        {{ $chapter->status == 'published' ? 'Published' : 'Draft' }}

                                    </span>


                                    <!-- STATUS AKSES -->

                                    @if($chapter->is_premium)

                                        <span class="chapter-access premium">

                                            <i class="fa-solid fa-crown"></i>

                                            Premium

                                        </span>

                                    @else

                                        <span class="chapter-access free">

                                            <i class="fa-solid fa-lock-open"></i>

                                            Gratis

                                        </span>

                                    @endif


                                    <!-- ILUSTRASI -->

                                    @if($chapter->image)

                                        <span class="chapter-illustration">

                                            <i class="fa-regular fa-image"></i>

                                            Ada Ilustrasi

                                        </span>

                                    @endif

                                </div>

                            </div>

                        </div>


                        <!-- TOMBOL AKSI -->

                        <div class="chapter-actions">

                            <!-- EDIT -->

                            <a href="{{ url('/penulis/buku/'.$book->id.'/chapter/'.$chapter->id.'/edit') }}"
                               class="chapter-edit-btn">

                                <i class="fa-solid fa-pen-to-square"></i>

                                Edit Bab

                            </a>


                            <!-- HAPUS -->

                            <form
                                action="{{ route('writer.chapters.destroy', [
                                    'book' => $book->id,
                                    'chapter' => $chapter->id
                                ]) }}"
                                method="POST"
                                class="delete-chapter-form">

                                @csrf

                                @method('DELETE')

                                <button
                                    type="button"
                                    class="chapter-delete-btn"
                                    onclick="confirmDeleteChapter(this)">

                                    <i class="fa-solid fa-trash"></i>

                                    Hapus

                                </button>

                            </form>

                        </div>

                    </div>

                @empty

                    <!-- BELUM ADA BAB -->

                    <div class="chapter-empty">

                        <div class="chapter-empty-icon">

                            <i class="fa-solid fa-book-open-reader"></i>

                        </div>

                        <h3>Belum Ada Bab Cerita</h3>

                        <p>
                            Mulai tulis bab pertama untuk karya kamu di Safae.
                        </p>

                        <a href="{{ url('/penulis/buku/'.$book->id.'/chapter/tambah') }}"
                           class="chapter-add-btn">

                            <i class="fa-solid fa-plus"></i>

                            Buat Bab 1

                        </a>

                    </div>

                @endforelse

            </div>

        </div>

    </div>

</div>


<!-- SWEETALERT -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDeleteChapter(button) {

        const form = button.closest('form');

        Swal.fire({
            title: 'Hapus Bab?',
            text: 'Bab yang dihapus tidak dapat dikembalikan. Apakah kamu yakin ingin menghapus bab ini?',

            icon: 'warning',

            showCancelButton: true,

            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',

            reverseButtons: true,

            background: '#ffffff',
            color: '#38425d',

            confirmButtonColor: '#e87991',
            cancelButtonColor: '#8ba9d8',

            customClass: {
                popup: 'chapter-delete-popup',
                confirmButton: 'chapter-confirm-delete',
                cancelButton: 'chapter-cancel-delete'
            }

        }).then((result) => {

            if (result.isConfirmed) {
                form.submit();
            }

        });

    }
</script>

@endsection
