@extends('layouts.app')
@section('content')
<div class="container py-4">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="{{ url('/search') }}" method="GET" class="search-container">
                <i class="fas fa-search search-icon"></i>
                <input type="text" name="q" class="search-input" placeholder="Cari judul buku, penulis, atau genre favoritmu...">
            </form>
        </div>
    </div>

    <div class="hero-section">
        <i class="fas fa-book-open hero-bg-icon"></i>
        <div class="row align-items-center hero-content">
            <div class="col-md-8">
                <span class="badge bg-warning text-dark mb-2">Buku Minggu Ini</span>
                <h1 class="fw-bold mb-3">Jelajahi Dunia Baru Lewat Membaca</h1>
                <p class="lead mb-4">Akses ribuan buku digital dari berbagai genre. Mulai dari pemrograman, novel, hingga pengembangan diri.</p>
                <a href="#all-books" class="btn btn-light text-primary fw-bold px-4 py-2 rounded-pill">Mulai Membaca</a>
            </div>
            <div class="col-md-4 d-none d-md-block text-center">
                <img src="https://cdn-icons-png.flaticon.com/512/2232/2232688.png" alt="Reading" style="max-width: 80%;">
            </div>
        </div>
    </div>

    
    <div class="mb-5">
        <div class="section-title">
            <span><i class="fas fa-history me-2 text-primary"></i>Lanjutkan Membaca</span>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <a href="#" class="text-decoration-none text-dark">
                    <div class="continue-card">
                        {{-- Contoh gambar statis --}}
                        <img src="https://via.placeholder.com/150x220" class="continue-img" alt="Cover">
                        <div class="w-100">
                            <h6 class="fw-bold mb-1">Belajar Laravel 10</h6>
                            <small class="text-muted">Chapter 4 dari 12</small>
                            <div class="progress">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 35%"></div>
                            </div>
                            <small class="text-primary fw-bold mt-1 d-block" style="font-size: 0.7rem">35% Selesai</small>
                        </div>
                    </div>
                </a>
            </div>
            {{-- Tambah card lain jika perlu --}}
        </div>
    </div>

    <div class="mb-4 overflow-auto">
        <div class="d-flex gap-2 pb-2">
            <a href="{{ url('/') }}" class="btn btn-dark rounded-pill px-4">Semua</a>
            @foreach($all_genres as $genre)
                <a href="{{ url('/?genre='.$genre) }}" class="btn btn-outline-secondary rounded-pill px-4 border-0 bg-white shadow-sm">{{ $genre }}</a>
            @endforeach
        </div>
    </div>

    <div class="mb-5" id="all-books">
        <div class="section-title">
            <span><i class="fas fa-fire me-2 text-danger"></i>Sedang Populer</span>
            <a href="#" class="view-all">Lihat Semua <i class="fas fa-chevron-right ms-1"></i></a>
        </div>

        <div class="row row-cols-2 row-cols-md-4 row-cols-lg-5 g-4">
            @forelse($books as $book)
            <div class="col">
                <a href="{{ url('/books/read/'.$book->id) }}" class="text-decoration-none">
                    <div class="book-card">
                        <div class="book-cover-wrapper">
                            @if($book->image_path)
                                <img src="{{ asset($book->image_path) }}" class="book-cover" alt="{{ $book->title }}">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center h-100 text-muted">
                                    <i class="fas fa-book fa-2x"></i>
                                </div>
                            @endif
                            
                            
                            <div class="book-badge">{{ $book->genre }}</div>
                        </div>
                        
                        <div class="book-info">
                            <div class="book-title">{{ $book->title }}</div>
                            <div class="book-author">{{ $book->author }}</div>
                            <div class="book-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span class="text-muted ms-1">(4.5)</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <img src="https://cdn-icons-png.flaticon.com/512/4076/4076432.png" width="100" class="mb-3">
                <h5 class="text-muted">Belum ada buku yang tersedia.</h5>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-5 d-flex justify-content-center">
            {{ $books->links() }}
        </div>
    </div>

    <div class="mb-5">
        <div class="section-title">
            <span><i class="fas fa-clock me-2 text-info"></i>Baru Ditambahkan</span>
        </div>
        <div class="row g-4">
            @foreach($books->take(3) as $book) 
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 overflow-hidden">
                    <div class="row g-0 h-100">
                        <div class="col-4">
                            @if($book->image_path)
                                <img src="{{ asset($book->image_path) }}" class="img-fluid h-100 w-100" style="object-fit: cover;" alt="...">
                            @else
                                <div class="bg-light h-100 d-flex align-items-center justify-content-center"><i class="fas fa-book"></i></div>
                            @endif
                        </div>
                        <div class="col-8">
                            <div class="card-body d-flex flex-column h-100 justify-content-center">
                                <h6 class="card-title fw-bold mb-1 text-truncate">{{ $book->title }}</h6>
                                <p class="card-text text-muted small mb-2">{{ $book->author }}</p>
                                <p class="card-text small text-secondary mb-2 line-clamp-2">
                                    {{ Str::limit($book->content, 60) }}
                                </p>
                                <a href="{{ url('/books/read/'.$book->id) }}" class="btn btn-sm btn-outline-primary rounded-pill w-max-content" style="width: fit-content;">Baca Sekarang</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>
@endsection