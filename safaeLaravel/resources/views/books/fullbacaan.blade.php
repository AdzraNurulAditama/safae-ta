@extends('layouts.app')

@section('title', $buku->title . ' - Halaman ' . $page)

@section('content')

<style>
    /* Styling Halaman Baca yang Rapi & Proporsional */
    .reader-page-wrapper {
        padding: 40px 15px 70px 15px;
    }

    .reader-container {
        max-width: 850px;
        margin: 0 auto;
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        overflow: hidden;
    }

    .reader-header {
        background: #0f172a;
        border-bottom: 1px solid #334155;
        padding: 30px;
        text-align: center;
    }

    .reader-header h1 {
        font-weight: 800;
        color: #38bdf8;
        font-size: 1.85rem;
        margin-bottom: 8px;
    }
    
    .meta-info {
        color: #94a3b8;
        font-size: 0.9rem;
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        justify-content: center;
        align-items: center;
    }

    .meta-info i {
        color: #38bdf8;
        margin-right: 4px;
    }

    .reader-body {
        padding: 45px 50px;
    }

    .reader-content {
        font-size: 1.15rem;
        line-height: 2.1;
        color: #e2e8f0;
        margin-bottom: 40px;
        text-align: justify;
        white-space: pre-line;
    }

    /* Kelompok Tombol Navigasi & Aksi */
    .reader-footer {
        border-top: 1px solid #334155;
        padding-top: 30px;
    }

    .nav-buttons-primary {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 25px;
    }

    .btn-nav-main {
        padding: 12px 28px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.95rem;
        transition: all 0.2s ease;
        border: none;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #38bdf8;
        color: #0f172a;
        box-shadow: 0 4px 14px rgba(56, 189, 248, 0.2);
    }

    .btn-nav-main:hover {
        background: #7dd3fc;
        color: #0f172a;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(56, 189, 248, 0.35);
    }

    .action-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 12px;
        background: #0f172a;
        padding: 16px;
        border-radius: 16px;
        border: 1px solid #334155;
    }

    .btn-action-card {
        padding: 10px 16px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.88rem;
        transition: all 0.2s ease;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: #1e293b;
        color: #cbd5e1;
        border: 1px solid #334155;
    }

    .btn-action-card:hover {
        background: #334155;
        color: #ffffff;
        border-color: #475569;
        transform: translateY(-2px);
    }

    .btn-action-card.yellow-accent {
        color: #fbbf24;
        border-color: rgba(251, 191, 36, 0.3);
    }

    .btn-action-card.yellow-accent:hover {
        background: rgba(251, 191, 36, 0.15);
        color: #fcd34d;
    }

    .btn-action-card.blue-accent {
        color: #38bdf8;
        border-color: rgba(56, 189, 248, 0.3);
    }

    .btn-action-card.blue-accent:hover {
        background: rgba(56, 189, 248, 0.15);
        color: #7dd3fc;
    }

    /* Perbaikan Styling Pop-Up Modal Tamat Membaca */
    .modal-backdrop.show {
        background-color: rgba(2, 6, 23, 0.8) !important;
        backdrop-filter: blur(8px);
    }

    .modal-content-custom {
        background: #0f172a !important;
        border: 1px solid #334155 !important;
        border-radius: 24px !important;
        color: #f8fafc;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.7);
        padding: 20px;
    }

    .finish-icon {
        width: 85px;
        height: 85px;
        margin: 0 auto 20px auto;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        background: linear-gradient(135deg, #38bdf8, #8b5cf6);
        color: white;
        box-shadow: 0 0 30px rgba(56, 189, 248, 0.4);
    }
</style>

<div class="reader-page-wrapper">
    <div class="reader-container">

        <!-- HEADER KONTEN -->
        <div class="reader-header">
            <h1>{{ $buku->title }}</h1>
            <div class="meta-info">
                <span><i class="fa-solid fa-user"></i> {{ $buku->author }}</span>
                <span>•</span>
                <span><i class="fa-solid fa-tag"></i> {{ $buku->genre }}</span>
                <span>•</span>
                <span><i class="fa-solid fa-book-open"></i> Halaman {{ $page }} / {{ max($totalHalaman ?? 1, 1) }}</span>
            </div>
        </div>

        <!-- BODY ISI CERITA & GAMBAR -->
        <div class="reader-body">
            
            {{-- Gambar Ilustrasi Bab --}}
            @if(isset($chapter) && $chapter->image)
                <div class="text-center mb-4">
                    <img src="{{ asset('storage/' . $chapter->image) }}" class="img-fluid rounded-4 shadow" style="max-height: 400px; object-fit: cover;" alt="Ilustrasi Bab">
                </div>
            @endif

            {{-- Teks Bacaan --}}
            <div class="reader-content">
                @if(!empty($halaman))
                        {!! $halaman !!} 
                                       @else
                    <p class="text-center text-muted">Belum ada konten pada bab/halaman ini.</p>
                @endif
            </div>

            <!-- FOOTER AREA (NAVIGASI & AKSI) -->
            <div class="reader-footer">
                
                <!-- 1. Tombol Navigasi Utama -->
                <div class="nav-buttons-primary">
                    <div>
                        @if($page > 1)
                            <a href="{{ route('book.show', ['id' => $buku->id, 'page' => $page - 1]) }}" class="btn-nav-main">
                                <i class="fa-solid fa-arrow-left"></i> Sebelumnya
                            </a>
                        @endif
                    </div>

                    <div>
                        @if($page < $totalHalaman)
                            <a href="{{ route('book.show', ['id' => $buku->id, 'page' => $page + 1]) }}" class="btn-nav-main">
                                Selanjutnya <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- 2. Grid Aksi Tambahan -->
                <div class="action-grid">
                    <a href="{{ route('resume.create', $buku->id) }}" class="btn-action-card blue-accent">
                        <i class="fa-solid fa-pen"></i> Tulis Resume
                    </a>

                    <a href="{{ route('ulasan.index', ['id' => $buku->id]) }}" class="btn-action-card yellow-accent">
                        <i class="fa-solid fa-star"></i> Beri Ulasan
                    </a>

                    <a href="{{ route('komentar.index', ['bookId' => $buku->id, 'page' => $page]) }}" class="btn-action-card yellow-accent">
                        <i class="fa-solid fa-comments"></i> Komentar
                    </a>

                    <a href="{{ route('genre.index') }}" class="btn-action-card">
                        <i class="fa-solid fa-list"></i> Daftar Buku
                    </a>
                </div>

            </div>

        </div>

    </div>
</div>

{{-- MODAL POP-UP TAMAT MEMBACA + FEEDBACK --}}
@if($page >= $totalHalaman)
@php
    $nonfiksi = $buku->jenis_buku === 'nonfiksi';
    $sudahMenilai = \App\Models\BookFeedback::where('user_id', auth()->id())
        ->where('book_id', $buku->id)
        ->exists();
@endphp

<style>
    .fb-choice {
        flex: 1;
        border: 0;
        border-radius: 12px;
        padding: 12px 8px;
        font-weight: 700;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .fb-choice:disabled { opacity: .6; cursor: default; }
    .fb-yes { background: #22c55e; color: #052e16; }
    .fb-yes:hover:not(:disabled) { background: #4ade80; }
    .fb-no { background: #334155; color: #e2e8f0; }
    .fb-no:hover:not(:disabled) { background: #475569; }
    .fb-later {
        margin-top: 14px;
        background: none;
        border: 0;
        color: #94a3b8;
        font-size: 0.85rem;
        cursor: pointer;
    }
</style>

<div class="modal fade" id="finishReadModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-custom text-center p-3">
            <div class="modal-body">
                <div class="finish-icon">🎉</div>
                <h3 class="fw-bold text-white mb-3">Selamat, Kamu Tamat Membaca!</h3>

                @unless($sudahMenilai)
                    <div id="fb-question">
                        <p class="text-muted mb-3" style="line-height: 1.6; font-size: 0.95rem;">
                            {{ $nonfiksi ? 'Apakah buku ini membantu kamu?' : 'Apakah buku ini cocok untukmu?' }}
                        </p>
                        <div class="d-flex gap-2">
                            <button type="button" class="fb-choice fb-yes" data-cocok="1">
                                {{ $nonfiksi ? 'Membantu' : 'Cocok untukku' }}
                            </button>
                            <button type="button" class="fb-choice fb-no" data-cocok="0">
                                {{ $nonfiksi ? 'Kurang membantu' : 'Belum cocok' }}
                            </button>
                        </div>
                    </div>
                @endunless

                <div id="fb-thanks" class="{{ $sudahMenilai ? '' : 'd-none' }}">
                    <p class="text-muted mb-3" style="line-height: 1.6; font-size: 0.95rem;">
                        {{ $sudahMenilai
                            ? 'Terima kasih sudah membaca buku ini sampai selesai.'
                            : 'Terima kasih atas penilaianmu!' }}
                    </p>
                    <a href="{{ route('books.finished', $buku->id) }}"
                       class="btn-nav-main justify-content-center w-100 py-3">
                        <i class="fa-solid fa-book"></i> Lihat rekomendasi buku
                    </a>
                </div>

                <button type="button" class="fb-later" data-bs-dismiss="modal">
                    Lanjut berinteraksi
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var finishModal = new bootstrap.Modal(document.getElementById('finishReadModal'));
        var isModalShown = false;

        // Kirim penilaian
        var buttons = document.querySelectorAll('#finishReadModal [data-cocok]');
        buttons.forEach(function (btn) {
            btn.addEventListener('click', async function () {
                buttons.forEach(function (b) { b.disabled = true; });
                try {
                    await fetch("{{ route('books.feedback', $buku->id) }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ cocok: btn.dataset.cocok === '1' ? 1 : 0 })
                    });
                } catch (e) {
                    console.error(e);
                }
                document.getElementById('fb-question').classList.add('d-none');
                document.getElementById('fb-thanks').classList.remove('d-none');
            });
        });

        @if($totalHalaman == 1)
            // 1 halaman: munculkan saat user scroll ke paling bawah
            window.addEventListener('scroll', function () {
                if (!isModalShown && (window.innerHeight + window.scrollY) >= document.body.offsetHeight - 150) {
                    finishModal.show();
                    isModalShown = true;
                }
            });
        @else
            // Lebih dari 1 halaman: langsung muncul di halaman terakhir
            finishModal.show();
        @endif
    });
</script>
@endif

@endsection