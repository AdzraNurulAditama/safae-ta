
@extends('layouts.app')
@section('title', $buku->title . ' - Halaman ' . $page)
@section('content')

<style>
    .reader-page-wrapper {
        padding: 40px 15px 70px;
        color: #514d69;
    }

    .reader-container {
        max-width: 850px;
        margin: 0 auto;
        background: #fff;
        border: 1px solid #e9e3f5;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(130, 115, 170, 0.10);
        overflow: hidden;
    }

    .reader-header {
        background: linear-gradient(110deg, #eaf1ff, #f0ebff 55%, #fff0f4);
        border-bottom: 1px solid #e9e3f5;
        padding: 30px;
        text-align: center;
    }

    .reader-header h1 {
        font-weight: 800;
        color: #8978b9;
        font-size: 1.85rem;
        margin-bottom: 8px;
    }

    .meta-info {
        color: #858198;
        font-size: 0.9rem;
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        justify-content: center;
        align-items: center;
    }

    .meta-info i {
        color: #a394d0;
        margin-right: 4px;
    }

    .reader-body {
        padding: 45px 50px;
        background: #fff;
    }

    .reader-content {
        font-size: 1.15rem;
        line-height: 2.1;
        color: #625d78;
        margin-bottom: 40px;
        text-align: justify;
        white-space: pre-line;
    }

    .reader-footer {
        border-top: 1px solid #e9e3f5;
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
        background: #a99bd9;
        color: #fff;
        box-shadow: 0 4px 14px rgba(163, 148, 208, 0.2);
    }

    .btn-nav-main:hover {
        background: #91a9dc;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(145, 169, 220, 0.3);
    }

    .action-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 12px;
        background: #f5f2fc;
        padding: 16px;
        border-radius: 16px;
        border: 1px solid #e9e3f5;
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
        background: #fff;
        color: #77718e;
        border: 1px solid #e6e0f0;
    }

    .btn-action-card:hover {
        background: #f0ebff;
        color: #7662a9;
        border-color: #cfc3e9;
        transform: translateY(-2px);
    }

    .btn-action-card.yellow-accent {
        color: #c28e38;
        border-color: rgba(220, 173, 91, 0.35);
    }

    .btn-action-card.yellow-accent:hover {
        background: #fff5df;
        color: #a97829;
    }

    .btn-action-card.blue-accent {
        color: #829bd0;
        border-color: rgba(130, 155, 208, 0.35);
    }

    .btn-action-card.blue-accent:hover {
        background: #eaf1ff;
        color: #6e87bd;
    }

    /* TAMPILAN BAB PREMIUM TERKUNCI */
    .premium-lock {
        text-align: center;
        padding: 35px 20px 45px;
        margin-bottom: 35px;
        background: #f8f5ff;
        border: 1px solid #e5def4;
        border-radius: 20px;
    }

    .premium-lock-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 20px;
        border-radius: 22px;
        background: #fff2d8;
        color: #d9a441;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 32px;
    }

    .premium-lock h2 {
        color: #514d69;
        font-size: 1.6rem;
        font-weight: 800;
        margin-bottom: 12px;
    }

    .premium-lock-description {
        color: #89859d;
        line-height: 1.8;
        max-width: 500px;
        margin: 0 auto 25px;
    }

    .premium-payment-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
        max-width: 650px;
        margin: 0 auto;
    }

    .premium-payment-card {
        background: #fff;
        border: 1px solid #e9e3f5;
        border-radius: 16px;
        padding: 24px 16px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }

    .premium-payment-card > i {
        font-size: 27px;
        color: #91a9dc;
    }

    .premium-payment-card.money > i {
        color: #d9a441;
    }

    .premium-payment-card h3 {
        color: #514d69;
        font-size: 1.05rem;
        font-weight: 700;
        margin: 0;
    }

    .premium-payment-price {
        font-size: 1.45rem;
        font-weight: 800;
        color: #829bd0;
    }

    .premium-payment-card.money .premium-payment-price {
        color: #d9a441;
    }

    .premium-payment-card p {
        color: #9290a3;
        font-size: 0.85rem;
        margin: 0 0 8px;
    }

    .premium-payment-card form {
        width: 100%;
        margin-top: auto;
    }

    .premium-payment-button {
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 10px;
        background: #91a9dc;
        color: #fff;
        font-weight: 800;
        cursor: pointer;
        transition: 0.2s;
    }

    .premium-payment-button.money {
        background: #e5b454;
        color: #fff;
    }

    .premium-payment-button:hover {
        filter: brightness(1.05);
        transform: translateY(-2px);
    }

    .premium-payment-note {
        color: #9290a3;
        font-size: 0.8rem;
        margin-top: 22px;
        line-height: 1.7;
    }

    .reader-alert {
        padding: 13px 16px;
        border-radius: 12px;
        margin-bottom: 25px;
        font-size: 0.9rem;
    }

    .reader-alert.success {
        background: #e8f6ef;
        border: 1px solid #ccebdc;
        color: #43866c;
    }

    .reader-alert.error {
        background: #fff0f0;
        border: 1px solid #f3d0d0;
        color: #c56d75;
    }

    .reader-alert.info {
        background: #eaf1ff;
        border: 1px solid #d5e1fa;
        color: #718bbd;
    }

    /* MODAL TAMAT MEMBACA */
    .modal-backdrop.show {
        background-color: rgba(65, 57, 91, 0.45) !important;
        backdrop-filter: blur(8px);
    }

    .modal-content-custom {
        background: #fcfbff !important;
        border: 1px solid #e9e3f5 !important;
        border-radius: 24px !important;
        color: #514d69;
        box-shadow: 0 25px 60px rgba(100, 90, 130, 0.2);
        padding: 20px;
    }

    .finish-icon {
        width: 85px;
        height: 85px;
        margin: 0 auto 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        background: linear-gradient(135deg, #b9a9e5, #91a9dc);
        color: white;
        box-shadow: 0 0 30px rgba(163, 148, 208, 0.3);
    }

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

    .fb-choice:disabled {
        opacity: .6;
        cursor: default;
    }

    .fb-yes {
        background: #d8f0e2;
        color: #43866c;
    }

    .fb-yes:hover:not(:disabled) {
        background: #c4e9d3;
    }

    .fb-no {
        background: #eee9f7;
        color: #77718e;
    }

    .fb-no:hover:not(:disabled) {
        background: #e2daf1;
    }

    .fb-later {
        margin-top: 14px;
        background: none;
        border: 0;
        color: #9995a8;
        font-size: 0.85rem;
        cursor: pointer;
    }

    /* WARNA TEKS PADA MODAL */
    .modal-content-custom .text-white {
        color: #514d69 !important;
    }

    .modal-content-custom .text-muted {
        color: #89859d !important;
    }

    @media (max-width: 600px) {
        .reader-body {
            padding: 25px 18px;
        }

        .reader-header {
            padding: 25px 15px;
        }

        .reader-header h1 {
            font-size: 1.5rem;
        }

        .premium-payment-grid {
            grid-template-columns: 1fr;
        }

        .premium-lock {
            padding: 30px 15px;
        }

        .btn-nav-main {
            padding: 11px 15px;
            font-size: 0.85rem;
        }
    }
</style>

<div class="reader-page-wrapper">
    <div class="reader-container">

        <!-- HEADER -->
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

        <!-- BODY -->
        <div class="reader-body">

            @if(session('success'))
                <div class="reader-alert success">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="reader-alert error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if(session('info'))
                <div class="reader-alert info">
                    <i class="fa-solid fa-circle-info"></i>
                    {{ session('info') }}
                </div>
            @endif

            @if($isChapterLocked ?? false)

                <!-- BAB PREMIUM TERKUNCI -->
                <div class="premium-lock">
                    <div class="premium-lock-icon">
                        <i class="fa-solid fa-lock"></i>
                    </div>

                    <h2>Bab Premium Terkunci</h2>

                    <p class="premium-lock-description">
                        Bab "{{ $chapter->title }}" merupakan bagian dari buku premium.
                        Pilih salah satu metode berikut untuk membuka akses dan melanjutkan membaca.
                    </p>

                    <div class="premium-payment-grid">

                        <!-- OPSI 50 POIN -->
                        <div class="premium-payment-card">
                            <i class="fa-solid fa-coins"></i>
                            <h3>Tukar Poin</h3>
                            <div class="premium-payment-price">50 Poin</div>
                            <p>Buka bab ini saja</p>

                            <form action="{{ route('premium.chapter.unlock', ['chapter' => $chapter->id]) }}"
                                method="POST"
                                onsubmit="return confirm('Gunakan 50 poin untuk membuka bab ini?')">
                                @csrf

                                <button type="submit" class="premium-payment-button">
                                    <i class="fa-solid fa-unlock"></i> Buka Bab
                                </button>
                            </form>
                        </div>

                        <!-- OPSI SIMULASI PEMBAYARAN -->
                        <div class="premium-payment-card money">
                            <i class="fa-solid fa-wallet"></i>
                            <h3>Simulasi Pembayaran</h3>
                            <div class="premium-payment-price">Rp15.000</div>
                            <p>Buka seluruh bab premium buku ini</p>

                            <form action="{{ route('premium.book.simulate', ['book' => $buku->id]) }}"
                                  method="POST"
                                  onsubmit="return confirm('Lakukan simulasi pembayaran Rp15.000 untuk membuka semua bab? Tidak ada uang asli yang ditagihkan.')">
                                @csrf
                                <button type="submit" class="premium-payment-button money">
                                    <i class="fa-solid fa-crown"></i> Buka Semua Bab
                                </button>
                            </form>
                        </div>

                    </div>

                    <p class="premium-payment-note">
                        <i class="fa-solid fa-circle-info"></i>
                        Pembayaran Rp15.000 hanya simulasi.
                        Tidak ada transaksi uang sungguhan.
                    </p>
                </div>

            @else

                <!-- ILUSTRASI BAB -->
                @if(isset($chapter) && $chapter->image)
                    <div class="text-center mb-4">
                        <img
                            src="{{ asset('storage/' . preg_replace('#^(public/|storage/)#', '', $chapter->image)) }}"
                            class="img-fluid rounded-4 shadow"
                            style="max-height:400px;object-fit:cover;"
                            alt="Ilustrasi Bab"
                        >
                    </div>
                @endif

                <!-- ISI CERITA -->
                <div class="reader-content">
                    @if(!empty($halaman))
                        {!! $halaman !!}
                    @else
                        <p class="text-center text-muted">
                            Belum ada konten pada bab/halaman ini.
                        </p>
                    @endif
                </div>

            @endif

            <!-- FOOTER -->
            <div class="reader-footer">

                <!-- NAVIGASI -->
                <div class="nav-buttons-primary">
                    <div>
                        @if($page > 1)
                            <a href="{{ route('book.show', ['id' => $buku->id, 'page' => $page - 1]) }}"
                               class="btn-nav-main">
                                <i class="fa-solid fa-arrow-left"></i> Sebelumnya
                            </a>
                        @endif
                    </div>

                    <div>
                        @if($page < $totalHalaman)
                            <a href="{{ route('book.show', ['id' => $buku->id, 'page' => $page + 1]) }}"
                               class="btn-nav-main">
                                Selanjutnya <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- AKSI TAMBAHAN -->
                <div class="action-grid">

                    @unless($isChapterLocked ?? false)
                        <a href="{{ route('resume.create', $buku->id) }}"
                           class="btn-action-card blue-accent">
                            <i class="fa-solid fa-pen"></i> Tulis Resume
                        </a>
                    @endunless

                    <a href="{{ route('ulasan.index', ['id' => $buku->id]) }}"
                       class="btn-action-card yellow-accent">
                        <i class="fa-solid fa-star"></i> Beri Ulasan
                    </a>

                    @unless($isChapterLocked ?? false)
                        <a href="{{ route('komentar.index', ['bookId' => $buku->id, 'page' => $page]) }}"
                           class="btn-action-card yellow-accent">
                            <i class="fa-solid fa-comments"></i> Komentar
                        </a>
                    @endunless

                    <a href="{{ route('genre.index') }}"
                       class="btn-action-card">
                        <i class="fa-solid fa-list"></i> Daftar Buku
                    </a>

                </div>

            </div>
        </div>
    </div>
</div>

<!-- MODAL TAMAT MEMBACA -->
@if($page >= $totalHalaman && !($isChapterLocked ?? false))
    @php
        $nonfiksi = $buku->jenis_buku === 'nonfiksi';
        $sudahMenilai = auth()->check()
            ? \App\Models\BookFeedback::where('user_id', auth()->id())
                ->where('book_id', $buku->id)
                ->exists()
            : false;
    @endphp

    <div class="modal fade" id="finishReadModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-content-custom text-center p-3">
                <div class="modal-body">

                    <div class="finish-icon">🎉</div>

                    <h3 class="fw-bold text-white mb-3">
                        Selamat, Kamu Tamat Membaca!
                    </h3>

                    @unless($sudahMenilai)
                        <div id="fb-question">
                            <p class="text-muted mb-3"
                               style="line-height:1.6;font-size:0.95rem;">
                                {{ $nonfiksi
                                    ? 'Apakah buku ini membantu kamu?'
                                    : 'Apakah buku ini cocok untukmu?' }}
                            </p>

                            <div class="d-flex gap-2">
                                <button type="button"
                                        class="fb-choice fb-yes"
                                        data-cocok="1">
                                    {{ $nonfiksi ? 'Membantu' : 'Cocok untukku' }}
                                </button>

                                <button type="button"
                                        class="fb-choice fb-no"
                                        data-cocok="0">
                                    {{ $nonfiksi ? 'Kurang membantu' : 'Belum cocok' }}
                                </button>
                            </div>
                        </div>
                    @endunless

                    <div id="fb-thanks" class="{{ $sudahMenilai ? '' : 'd-none' }}">
                        <p class="text-muted mb-3"
                           style="line-height:1.6;font-size:0.95rem;">
                            {{ $sudahMenilai
                                ? 'Terima kasih sudah membaca buku ini sampai selesai.'
                                : 'Terima kasih atas penilaianmu!' }}
                        </p>

                        <a href="{{ route('books.finished', $buku->id) }}"
                           class="btn-nav-main justify-content-center w-100 py-3">
                            <i class="fa-solid fa-book"></i>
                            Lihat rekomendasi buku
                        </a>
                    </div>

                    <button type="button"
                            class="fb-later"
                            data-bs-dismiss="modal">
                        Lanjut berinteraksi
                    </button>

                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var modalElement = document.getElementById('finishReadModal');

            if (!modalElement || typeof bootstrap === 'undefined') {
                return;
            }

            var finishModal = new bootstrap.Modal(modalElement);
            var isModalShown = false;

            var buttons = document.querySelectorAll('#finishReadModal [data-cocok]');

            buttons.forEach(function (btn) {
                btn.addEventListener('click', async function () {
                    buttons.forEach(function (b) {
                        b.disabled = true;
                    });

                    try {
                        await fetch("{{ route('books.feedback', $buku->id) }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                cocok: btn.dataset.cocok === '1' ? 1 : 0
                            })
                        });
                    } catch (e) {
                        console.error(e);
                    }

                    var question = document.getElementById('fb-question');
                    var thanks = document.getElementById('fb-thanks');

                    if (question) {
                        question.classList.add('d-none');
                    }

                    if (thanks) {
                        thanks.classList.remove('d-none');
                    }
                });
            });

            @if($totalHalaman == 1)
                window.addEventListener('scroll', function () {
                    if (!isModalShown &&
                        (window.innerHeight + window.scrollY) >= document.body.offsetHeight - 150) {
                        finishModal.show();
                        isModalShown = true;
                    }
                });
            @else
                finishModal.show();
            @endif
        });
    </script>
@endif

@endsection
