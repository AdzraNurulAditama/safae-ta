
@extends('layouts.layoutsAdmin')
@section('title', 'Kelola Buku Premium')
@section('content')
<link rel="stylesheet" href="{{ asset('css/admin-premium.css') }}">

<div class="ap-page">
    <div class="ap-header">
        <div>
            <span class="ap-eyebrow">
                <i class="fa-solid fa-crown"></i> SAFAE ADMIN
            </span>
            <h1>Kelola <span>Buku Premium</span></h1>
            <p>Kelola koleksi buku premium yang telah disetujui.</p>
        </div>
        <a href="{{ route('admin.premium.index') }}" class="ap-header-link">
            <i class="fa-solid fa-clipboard-list"></i>
            Lihat Pengajuan
        </a>
    </div>

    @foreach(['success', 'error', 'info'] as $type)
        @if(session($type))
            <div class="ap-alert {{ $type }}">
                <i class="fa-solid fa-circle-info"></i>
                {{ session($type) }}
            </div>
        @endif
    @endforeach

    <div class="ap-stats">
        <div class="ap-stat">
            <div class="ap-stat-icon purple">
                <i class="fa-solid fa-crown"></i>
            </div>
            <div>
                <strong>{{ number_format($totalPremium) }}</strong>
                <span>Buku Premium</span>
            </div>
        </div>
        <div class="ap-stat">
            <div class="ap-stat-icon blue">
                <i class="fa-solid fa-book-open"></i>
            </div>
            <div>
                <strong>{{ number_format($totalRegular) }}</strong>
                <span>Buku Reguler</span>
            </div>
        </div>
        <div class="ap-stat">
            <div class="ap-stat-icon yellow">
                <i class="fa-solid fa-hourglass-half"></i>
            </div>
            <div>
                <strong>{{ number_format($totalPending) }}</strong>
                <span>Menunggu Persetujuan</span>
            </div>
        </div>
    </div>

    <div class="ap-panel">
        <div class="ap-panel-header">
            <div>
                <h2><i class="fa-solid fa-layer-group"></i> Daftar Buku Premium</h2>
                <p>Cari berdasarkan judul buku atau nama penulis.</p>
            </div>
            <span class="ap-count">{{ $books->total() }} Buku</span>
        </div>

        <form method="GET" action="{{ route('admin.premium.books') }}" class="ap-filter">
            <div class="ap-search">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari judul buku atau penulis...">
            </div>
            <button type="submit" class="ap-btn primary">
                <i class="fa-solid fa-search"></i> Cari
            </button>
            @if(request('search'))
                <a href="{{ route('admin.premium.books') }}" class="ap-btn secondary">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </a>
            @endif
        </form>

        <div class="ap-book-grid">
            @forelse($books as $book)
                @php
                    $cover = $book->image_path
                        ? preg_replace('#^(public/|storage/)+#', '', $book->image_path)
                        : null;
                @endphp

                <div class="ap-book-card">
                    <div class="ap-book-main">
                        <div class="ap-cover">
                            @if($cover)
                                <img src="{{ asset('storage/'.$cover) }}" alt="Cover {{ $book->title }}">
                            @else
                                <div class="ap-cover-empty">
                                    <i class="fa-solid fa-book-open"></i>
                                </div>
                            @endif
                        </div>
                        <div class="ap-book-info">
                            <span class="ap-premium-badge">
                                <i class="fa-solid fa-crown"></i> PREMIUM
                            </span>
                            <h3>{{ $book->title }}</h3>
                            <p><i class="fa-solid fa-user-pen"></i>
                                {{ $book->author ?: ($book->user?->username ?? 'Penulis Safae') }}
                            </p>
                            <p><i class="fa-solid fa-tag"></i>
                                {{ $book->genre ?? 'Tanpa Genre' }}
                            </p>
                        </div>
                    </div>

                    <div class="ap-book-meta">
                        <span>
                            <i class="fa-solid fa-list"></i>
                            {{ $book->published_chapters_count }} Bab Terbit
                        </span>
                        <span>
                            <i class="fa-solid fa-eye"></i>
                            {{ number_format($book->reader_count ?? 0) }} Pembaca
                        </span>
                    </div>

                    <div class="ap-book-actions">
                        <button type="button" class="ap-btn secondary"
                            onclick="document.getElementById('ap-detail-{{ $book->id }}').showModal()">
                            <i class="fa-solid fa-circle-info"></i> Detail
                        </button>
                        <form action="{{ route('admin.premium.destroy', $book->id) }}"
                            method="POST"
                            onsubmit="return confirm('Cabut status premium buku ini? Buku tidak akan dihapus.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="ap-btn danger">
                                <i class="fa-solid fa-crown"></i> Cabut Premium
                            </button>
                        </form>
                    </div>
                </div>

                <dialog id="ap-detail-{{ $book->id }}" class="ap-dialog">
                    <div class="ap-dialog-header">
                        <h2>Detail Buku Premium</h2>
                        <button type="button"
                            onclick="this.closest('dialog').close()"
                            aria-label="Tutup">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <div class="ap-dialog-book">
                        @if($cover)
                            <img src="{{ asset('storage/'.$cover) }}" alt="{{ $book->title }}">
                        @endif
                        <div>
                            <h3>{{ $book->title }}</h3>
                            <p><strong>Penulis:</strong>
                                {{ $book->author ?: ($book->user?->username ?? '-') }}
                            </p>
                            <p><strong>Genre:</strong> {{ $book->genre ?? '-' }}</p>
                            <p><strong>Bab terbit:</strong> {{ $book->published_chapters_count }}</p>
                            <p><strong>Total bab:</strong> {{ $book->chapters_count }}</p>
                            <p><strong>Pembaca:</strong> {{ number_format($book->reader_count ?? 0) }}</p>
                            <p><strong>Status:</strong> Premium</p>
                        </div>
                    </div>
                    <div class="ap-description">
                        <strong>Deskripsi Buku</strong>
                        <p>{{ $book->description ?: 'Belum ada deskripsi.' }}</p>
                    </div>
                </dialog>
            @empty
                <div class="ap-empty">
                    <i class="fa-solid fa-book-open"></i>
                    <h3>Tidak Ada Buku Premium</h3>
                    <p>Belum ada buku yang sesuai dengan pencarian.</p>
                </div>
            @endforelse
        </div>

        @if($books->hasPages())
            <div class="ap-pagination">
                {{ $books->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
