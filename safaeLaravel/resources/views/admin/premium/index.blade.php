```blade
@extends('layouts.layoutsAdmin')

@section('title', 'Pengajuan Buku Premium')

@section('content')

<link rel="stylesheet" href="{{ asset('css/admin-premium.css') }}">


<div class="ap-page">

    {{-- HEADER --}}
    <div class="ap-header">
        <div>
            <span class="ap-eyebrow">
                <i class="fa-solid fa-clipboard-check"></i> SAFAE ADMIN
            </span>

            <h1>Pengajuan <span>Buku Premium</span></h1>
            <p>Periksa dan kelola pengajuan premium dari penulis Safae.</p>
        </div>

        <a href="{{ route('admin.premium.books') }}" class="ap-header-link">
            <i class="fa-solid fa-crown"></i> Kelola Buku Premium
        </a>
    </div>

    {{-- ALERT --}}
    @foreach(['success', 'error', 'info'] as $type)
        @if(session($type))
            <div class="ap-alert {{ $type }}">
                <i class="fa-solid fa-circle-info"></i>
                {{ session($type) }}
            </div>
        @endif
    @endforeach

    {{-- STATISTIK --}}
    <div class="ap-stats ap-stats-four">

        <div class="ap-stat">
            <div class="ap-stat-icon blue">
                <i class="fa-solid fa-file-lines"></i>
            </div>
            <div>
                <strong>{{ $totalRequests }}</strong>
                <span>Total Pengajuan</span>
            </div>
        </div>

        <div class="ap-stat">
            <div class="ap-stat-icon yellow">
                <i class="fa-solid fa-clock"></i>
            </div>
            <div>
                <strong>{{ $totalPending }}</strong>
                <span>Menunggu</span>
            </div>
        </div>

        <div class="ap-stat">
            <div class="ap-stat-icon green">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <strong>{{ $totalApproved }}</strong>
                <span>Disetujui</span>
            </div>
        </div>

        <div class="ap-stat">
            <div class="ap-stat-icon red">
                <i class="fa-solid fa-circle-xmark"></i>
            </div>
            <div>
                <strong>{{ $totalRejected }}</strong>
                <span>Ditolak</span>
            </div>
        </div>

    </div>

    {{-- PANEL DAFTAR PENGAJUAN --}}
    <div class="ap-panel">

        <div class="ap-panel-header">
            <div>
                <h2>
                    <i class="fa-solid fa-inbox"></i> Daftar Pengajuan
                </h2>
                <p>Tinjau buku sebelum menyetujui status premium.</p>
            </div>

            <span class="ap-count">
                {{ $requests->total() }} Pengajuan
            </span>
        </div>

        {{-- FILTER --}}
        <form method="GET"
              action="{{ route('admin.premium.index') }}"
              class="ap-filter">

            <div class="ap-search">
                <i class="fa-solid fa-magnifying-glass"></i>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari judul buku atau penulis..."
                >
            </div>

            <select name="status" class="ap-select">
                <option value="">Semua Status</option>

                <option value="pending"
                    @selected(request('status') === 'pending')>
                    Menunggu
                </option>

                <option value="approved"
                    @selected(request('status') === 'approved')>
                    Disetujui
                </option>

                <option value="rejected"
                    @selected(request('status') === 'rejected')>
                    Ditolak
                </option>
            </select>

            <button type="submit" class="ap-btn primary">
                <i class="fa-solid fa-filter"></i> Terapkan
            </button>

            @if(request('search') || request('status'))
                <a href="{{ route('admin.premium.index') }}"
                   class="ap-btn secondary">
                    Reset
                </a>
            @endif

        </form>

        {{-- TABEL PENGAJUAN --}}
        <div class="ap-table-wrap">

            <table class="ap-table">

                <thead>
                    <tr>
                        <th>Buku</th>
                        <th>Penulis</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($requests as $item)

                        @php
                            $book = $item->book;

                            $cover = $book?->image_path
                                ? preg_replace('#^(public/|storage/)+#', '', $book->image_path)
                                : null;

                            $coverUrl = $cover
                                ? asset('storage/'.$cover)
                                : null;

                            $modalId = 'detailPremium'.$item->id;
                        @endphp

                        <tr>

                            {{-- BUKU --}}
                            <td>
                                <div class="ap-table-book">

                                    @if($coverUrl)
                                        <img
                                            src="{{ $coverUrl }}"
                                            alt="{{ $book?->title }}"
                                        >
                                    @else
                                        <div class="ap-table-cover-empty">
                                            <i class="fa-solid fa-book"></i>
                                        </div>
                                    @endif

                                    <div>
                                        <strong>
                                            {{ $book?->title ?? 'Buku tidak tersedia' }}
                                        </strong>

                                        <small>
                                            {{ $book?->genre ?? '-' }}
                                        </small>
                                    </div>

                                </div>
                            </td>

                            {{-- PENULIS --}}
                            <td>
                                {{ $book?->author ?: ($item->user?->username ?? '-') }}
                            </td>

                            {{-- TANGGAL --}}
                            <td>
                                {{ $item->created_at?->format('d M Y') ?? '-' }}
                            </td>

                            {{-- STATUS --}}
                            <td>
                                <span class="ap-status {{ $item->status }}">
                                    {{ match($item->status) {
                                        'pending' => 'Menunggu',
                                        'approved' => 'Disetujui',
                                        'rejected' => 'Ditolak',
                                        default => ucfirst($item->status)
                                    } }}
                                </span>
                            </td>

                            {{-- AKSI --}}
                            <td>
                                <div class="ap-table-actions">

                                    {{-- DETAIL --}}
                                    @if($book)
                                        <button
                                            type="button"
                                            class="ap-btn ap-btn-detail"
                                            onclick="openPremiumDetail('{{ $modalId }}')">

                                            <i class="fa-solid fa-eye"></i>
                                            Detail

                                        </button>
                                    @endif

                                    {{-- SETUJUI DAN TOLAK --}}
                                    @if($item->status === 'pending' && $book)

                                        <form
                                            action="{{ route('admin.premium.approve', $item->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Setujui pengajuan premium buku ini?')">

                                            @csrf

                                            <button class="ap-btn success" type="submit">
                                                <i class="fa-solid fa-check"></i>
                                                Setujui
                                            </button>

                                        </form>

                                        <form
                                            action="{{ route('admin.premium.reject', $item->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Tolak pengajuan premium buku ini?')">

                                            @csrf

                                            <button class="ap-btn danger" type="submit">
                                                <i class="fa-solid fa-xmark"></i>
                                                Tolak
                                            </button>

                                        </form>

                                    @else

                                       <span class="ap-status ap-status-processed">
                                        <i class="fa-solid fa-circle-check"></i>
                                        Selesai Diproses
                                    </span>

                                    @endif

                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="ap-table-empty">
                                Belum ada pengajuan premium yang sesuai.
                            </td>
                        </tr>

                    @endforelse

                </tbody>
            </table>

        </div>

        {{-- PAGINATION --}}
        @if($requests->hasPages())
            <div class="ap-pagination">
                {{ $requests->links() }}
            </div>
        @endif

    </div>
</div>


{{-- ======================================
     POPUP DETAIL BUKU PREMIUM
====================================== --}}

@foreach($requests as $item)

    @php
        $book = $item->book;

        $cover = $book?->image_path
            ? preg_replace('#^(public/|storage/)+#', '', $book->image_path)
            : null;

        $coverUrl = $cover
            ? asset('storage/'.$cover)
            : null;

        $modalId = 'detailPremium'.$item->id;
    @endphp

    @if($book)

        <div
            class="ap-detail-modal"
            id="{{ $modalId }}"
            onclick="closePremiumDetailOutside(event, '{{ $modalId }}')">

            <div class="ap-detail-content">

                {{-- HEADER DETAIL --}}
                <div class="ap-detail-header">

                    <div>
                        <h2>
                            <i class="fa-solid fa-book-open"
                               style="color:#06b6d4;"></i>
                            Preview Buku Premium
                        </h2>

                        <p>
                            Informasi lengkap buku yang diajukan oleh penulis.
                        </p>
                    </div>

                    <button
                        type="button"
                        class="ap-detail-close"
                        onclick="closePremiumDetail('{{ $modalId }}')">

                        <i class="fa-solid fa-xmark"></i>

                    </button>

                </div>


                {{-- HERO BUKU --}}
                <div class="ap-detail-hero">

                    @if($coverUrl)

                        <img
                            src="{{ $coverUrl }}"
                            class="ap-detail-cover"
                            alt="{{ $book->title }}">

                    @else

                        <div class="ap-detail-cover-empty">
                            <i class="fa-solid fa-book"></i>
                        </div>

                    @endif

                    <div class="ap-detail-hero-info">

                        <span class="ap-detail-label">
                            <i class="fa-solid fa-crown"></i>
                            PENGAJUAN BUKU PREMIUM
                        </span>

                        <h3>{{ $book->title }}</h3>

                        <div class="ap-detail-author">
                            <i class="fa-solid fa-user-pen"></i>

                            {{ $book->author ?: ($item->user?->username ?? 'Penulis tidak diketahui') }}
                        </div>

                        <div class="ap-detail-tags">

                            <span class="ap-detail-tag">
                                <i class="fa-solid fa-layer-group"></i>
                                {{ $book->genre ?? 'Tanpa Genre' }}
                            </span>

                            <span class="ap-detail-tag">
                                <i class="fa-solid fa-calendar"></i>
                                {{ $book->year ?? 'Tahun tidak tersedia' }}
                            </span>

                        </div>

                        <span class="ap-detail-status {{ $item->status }}">

                            @if($item->status === 'pending')

                                <i class="fa-solid fa-clock"></i>
                                Menunggu Persetujuan

                            @elseif($item->status === 'approved')

                                <i class="fa-solid fa-circle-check"></i>
                                Telah Disetujui

                            @elseif($item->status === 'rejected')

                                <i class="fa-solid fa-circle-xmark"></i>
                                Telah Ditolak

                            @else

                                {{ ucfirst($item->status) }}

                            @endif

                        </span>

                    </div>

                </div>


                {{-- BODY DETAIL --}}
                <div class="ap-detail-body">

                    {{-- INFORMASI BUKU --}}
                    <div class="ap-detail-section">

                        <div class="ap-detail-section-title">

                            <div class="ap-detail-icon">
                                <i class="fa-solid fa-circle-info"></i>
                            </div>

                            <div>
                                <h4>Informasi Buku</h4>
                                <p>Identitas buku yang diajukan penulis.</p>
                            </div>

                        </div>

                        <div class="ap-detail-grid">

                            <div class="ap-detail-info">
                                <span>Tanggal Pengajuan</span>
                                <strong>
                                    {{ $item->created_at?->format('d M Y') ?? '-' }}
                                </strong>
                            </div>

                            <div class="ap-detail-info">
                                <span>Waktu Pengajuan</span>
                                <strong>
                                    {{ $item->created_at?->format('H:i') ?? '-' }} WIB
                                </strong>
                            </div>

                        </div>

                    </div>


                    {{-- SINOPSIS --}}
                    <div class="ap-detail-section">

                        <div class="ap-detail-section-title">

                            <div class="ap-detail-icon">
                                <i class="fa-solid fa-align-left"></i>
                            </div>

                            <div>
                                <h4>Sinopsis Buku</h4>
                                <p>Gambaran umum cerita atau isi buku.</p>
                            </div>

                        </div>

                        <div class="ap-detail-description">

                            @if($book->description)

                                {{ $book->description }}

                            @else

                                <span class="ap-detail-empty">
                                    Penulis belum menambahkan sinopsis buku.
                                </span>

                            @endif

                        </div>

                    </div>


                    {{-- ISI BUKU --}}
                    <div class="ap-detail-section">

                        <div class="ap-detail-section-title">

                            <div class="ap-detail-icon">
                                <i class="fa-solid fa-book-open"></i>
                            </div>

                            <div>
                                <h4>Isi Buku</h4>
                                <p>Pratinjau isi tulisan yang tersedia pada buku.</p>
                            </div>

                        </div>

                        <div class="ap-detail-content-text">

                            @if($book->content)

                                {{ $book->content }}

                            @else

                                <span class="ap-detail-empty">
                                    Isi buku belum tersedia pada bagian ini.
                                </span>

                            @endif

                        </div>

                    </div>

                </div>


                {{-- FOOTER DETAIL --}}
                <div class="ap-detail-footer">

                    <span>
                        <i class="fa-solid fa-shield-halved"></i>
                        Periksa informasi buku sebelum mengambil keputusan.
                    </span>

                    <button
                        type="button"
                        onclick="closePremiumDetail('{{ $modalId }}')">

                        <i class="fa-solid fa-xmark"></i>
                        Tutup Detail

                    </button>

                </div>

            </div>

        </div>

    @endif

@endforeach


{{-- JAVASCRIPT DETAIL --}}
<script>
    function openPremiumDetail(id) {
        const modal = document.getElementById(id);

        if (modal) {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }

    function closePremiumDetail(id) {
        const modal = document.getElementById(id);

        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    function closePremiumDetailOutside(event, id) {
        if (event.target.id === id) {
            closePremiumDetail(id);
        }
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            document.querySelectorAll('.ap-detail-modal.active').forEach(function(modal) {
                modal.classList.remove('active');
            });

            document.body.style.overflow = '';
        }
    });
</script>

@endsection
```