@extends('layouts.app')

@section('title', 'Buku Favorit')

@section('content')
<link rel="stylesheet" href="{{ asset('css/favorite.css') }}">

<div class="container-fluid">
    <div class="d-flex align-items-center mb-4">
        <h3 class="favorite-header mb-0">
            <i class="fa-solid fa-heart text-danger me-2"></i> Buku Favorit Saya
        </h3>
    </div>

    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-4">
        @forelse ($favorites as $fav)
            <div class="col">
                <div class="book-card shadow-sm">
                    
                    <a href="{{ route('fullbacaan.show', $fav->book->id) }}" class="text-decoration-none">
                        <div class="card-img-wrapper">
                            <img src="{{ $fav->book->image_path ? asset($fav->book->image_path) : 'https://via.placeholder.com/300x400?text=No+Cover' }}" 
                                 alt="{{ $fav->book->title }}">
                        </div>
                        
                        <div class="card-body text-center">
                            <h6 class="book-title" title="{{ $fav->book->title }}">
                                {{ $fav->book->title }}
                            </h6>
                            <small class="text-muted">
                                <i class="fa-solid fa-user me-1"></i> {{ $fav->book->author }}
                            </small>
                        </div>
                    </a>

                    <div class="card-footer text-center">
                        <form action="{{ route('favorite.hapus') }}" method="POST">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ $fav->book->id }}">
                            <button class="btn btn-remove btn-sm w-100">
                                <i class="fa-solid fa-heart-crack me-1"></i> Hapus
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state shadow-sm">
                    <i class="fa-solid fa-book-heart fa-4x text-muted mb-3"></i>
                    <h4 class="text-white fw-bold mb-2">Belum ada buku favorit</h4>
                    <p class="text-muted mb-4">Jelajahi koleksi Safae dan simpan buku kesukaanmu di sini!</p>
                    <a href="{{ route('genre.index') }}" class="btn btn-primary rounded-pill px-4 py-2 fw-bold" style="background: #38bdf8; color: #0f172a; border: none;">
                        <i class="fa-solid fa-magnifying-glass me-2"></i> Mulai Eksplorasi
                    </a>
                </div>
            </div>
        @endforelse
    </div>
</div>

@endsection