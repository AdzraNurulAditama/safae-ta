@extends('layouts.app')

@section('title', 'Bookmark Saya')

@section('content')
<div class="container py-4">
    <div class="d-flex align-items-center mb-4">
        <h3 class="fw-bold text-white mb-0">
            <i class="fa-solid fa-bookmark me-2 text-primary"></i>Bookmark Saya
        </h3>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($bookmarks->isEmpty())
        <div class="text-center py-5">
            <i class="fa-regular fa-bookmark fa-4x text-muted mb-3"></i>
            <h5 class="text-muted">Belum ada buku yang disimpan di bookmark.</h5>
            <a href="{{ url('/user/dashboard') }}" class="btn btn-primary rounded-pill mt-3 px-4">
                Cari Buku
            </a>
        </div>
    @else
        <div class="row row-cols-2 row-cols-md-4 row-cols-lg-5 g-4">
            @foreach($bookmarks as $bookmark)
                <div class="col">
                    <div class="card h-100 border-0 bg-dark text-white shadow-sm" style="border-radius: 16px; overflow: hidden;">
                        <div class="position-relative">
                            @if($bookmark->book && $bookmark->book->image_path)
                                <img src="{{ asset($bookmark->book->image_path) }}" class="card-img-top" alt="{{ $bookmark->book->title }}" style="height: 230px; object-fit: cover;">
                            @else
                                <div class="bg-secondary d-flex align-items-center justify-content-center" style="height: 230px;">
                                    <i class="fas fa-book fa-3x text-muted"></i>
                                </div>
                            @endif
                            <span class="badge bg-primary position-absolute top-0 end-0 m-2">
                                {{ $bookmark->book->genre ?? 'Umum' }}
                            </span>
                        </div>
                        
                        <div class="card-body d-flex flex-column justify-content-between p-3">
                            <div>
                                <h6 class="card-title fw-bold text-truncate mb-1">{{ $bookmark->book->title ?? 'Judul Tidak Tersedia' }}</h6>
                                <p class="card-text text-muted small mb-2">{{ $bookmark->book->author ?? '-' }}</p>
                            </div>
                            
                            <div class="d-flex gap-2 mt-3">
                                <a href="{{ url('/books/read/'.$bookmark->book_id) }}" class="btn btn-sm btn-primary w-100 rounded-pill">
                                    Baca
                                </a>
                                
                                <form action="{{ route('bookmark.remove', $bookmark->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" onclick="return confirm('Hapus dari bookmark?')" title="Hapus Bookmark">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection