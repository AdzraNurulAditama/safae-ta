
@extends('layouts.layoutsAdmin')
@section('title', 'Detail Buku Favorit')
@section('content')
<link rel="stylesheet" href="{{ asset('css/admin-buku-favorite.css') }}">

@php
    $cover = $book?->image_path ?: ($book?->cover_image ?? null);
    $cover = $cover ? preg_replace('#^(public/|storage/)+#', '', ltrim($cover, '/')) : null;
@endphp

<div class="bf-page">
    <a href="{{ route('admin.favorit.index') }}" class="bf-back">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Buku Favorit
    </a>

    <div class="bf-heading">
        <div>
            <span class="bf-kicker">
                <i class="fa-solid fa-heart"></i> SAFAE FAVORITE DETAIL
            </span>
            <h1>Detail <span>Buku Favorit</span></h1>
            <p>Informasi buku dan pengguna yang menambahkannya ke favorit.</p>
        </div>
    </div>

    <div class="bf-detail-panel">
        <div class="bf-detail-cover">
            @if($cover)
                <img src="{{ asset('storage/'.$cover) }}" alt="Cover {{ $book?->title }}">
            @else
                <div class="bf-detail-placeholder">
                    <i class="fa-solid fa-book-open"></i>
                    <span>Cover tidak tersedia</span>
                </div>
            @endif
        </div>

        <div class="bf-detail-content">
            <span class="bf-detail-label">
                <i class="fa-solid fa-book"></i> INFORMASI BUKU
            </span>
            <h2>{{ $book?->title ?? 'Buku tidak ditemukan' }}</h2>
            <p class="bf-detail-subtitle">
                {{ $book?->genre ?? 'Genre tidak tersedia' }}
            </p>

            <div class="bf-detail-stats">
                <div>
                    <i class="fa-solid fa-heart"></i>
                    <strong>{{ number_format($favoriteCount, 0, ',', '.') }}</strong>
                    <small>Total Favorit</small>
                </div>
                <div>
                    <i class="fa-solid fa-book-open"></i>
                    <strong>{{ number_format($chapterCount, 0, ',', '.') }}</strong>
                    <small>Jumlah Chapter</small>
                </div>
            </div>

            <div class="bf-detail-information">
                <div>
                    <span><i class="fa-solid fa-feather-pointed"></i> Penulis</span>
                    <strong>{{ $book?->author ?? '-' }}</strong>
                </div>
                <div>
                    <span><i class="fa-solid fa-layer-group"></i> Genre</span>
                    <strong>{{ $book?->genre ?? '-' }}</strong>
                </div>
                <div>
                    <span><i class="fa-solid fa-user"></i> Difavoritkan oleh</span>
                    <strong>{{ $favorite->user?->username ?? 'Pengguna tidak ditemukan' }}</strong>
                </div>
                <div>
                    <span><i class="fa-solid fa-envelope"></i> Email Pengguna</span>
                    <strong>{{ $favorite->user?->email ?? '-' }}</strong>
                </div>
                <div>
                    <span><i class="fa-regular fa-calendar"></i> Tanggal Favorit</span>
                    <strong>{{ $favorite->created_at?->format('d M Y, H:i') ?? '-' }}</strong>
                </div>
            </div>

            <div class="bf-detail-buttons">
                <a href="{{ route('admin.favorit.index') }}" class="bf-btn secondary">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </a>
                <form action="{{ route('admin.favorit.destroy', $favorite->id) }}"
                    method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus favorit pengguna ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bf-btn delete">
                        <i class="fa-solid fa-trash"></i> Hapus Favorit
                    </button>
                </form>
            </div>
        </div>
    </div>

    <section class="bf-panel bf-users-panel">
        <div class="bf-panel-head">
            <div>
                <h2><i class="fa-solid fa-users"></i> Pengguna yang Memfavoritkan Buku</h2>
                <p>Daftar pengguna yang menyimpan buku ini ke favorit.</p>
            </div>
            <span class="bf-count">{{ $favoriteUsers->count() }} favorit</span>
        </div>

        <div class="bf-favorite-users">
            @forelse($favoriteUsers as $item)
                @php
                    $avatar = $item->user?->foto_profil ?: ($item->user?->profile_image ?? null);
                    $avatar = $avatar ? preg_replace('#^(public/|storage/)+#', '', ltrim($avatar, '/')) : null;
                @endphp
                <div class="bf-favorite-user">
                    <div class="bf-user">
                        @if($avatar)
                            <img src="{{ asset('storage/'.$avatar) }}" alt="Foto pengguna" class="bf-avatar">
                        @else
                            <span class="bf-avatar bf-avatar-empty">
                                <i class="fa-solid fa-user"></i>
                            </span>
                        @endif
                        <div>
                            <strong>{{ $item->user?->username ?? 'Pengguna tidak ditemukan' }}</strong>
                            <small>{{ $item->user?->email ?? '-' }}</small>
                        </div>
                    </div>
                    <span class="bf-user-date">
                        <i class="fa-regular fa-calendar"></i>
                        {{ $item->created_at?->format('d M Y') ?? '-' }}
                    </span>
                </div>
            @empty
                <div class="bf-empty">
                    <i class="fa-regular fa-heart"></i>
                    <h3>Belum ada pengguna</h3>
                    <p>Buku ini belum memiliki data favorit lainnya.</p>
                </div>
            @endforelse
        </div>
    </section>
</div>
@endsection
