@extends('layouts.layoutsAdmin')

@section('title', 'Edit Book')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/book-management.css') }}">
@endpush

@section('content')
<main class="col-lg-10 col-md-9 ms-sm-auto px-4">
    <section class="konten">
        <div class="isi">
            <div class="container mt-5">
                <h2>Edit Book</h2>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Whoops! Ada beberapa masalah:</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Edit Book: {{ $book['title'] }}</h4>
                    </div>
                    <div class="card-body">
                        {{-- Ubah form ke route Laravel --}}
                        <form method="POST" action="{{ url('/books/' . $book['id'] . '/update') }}" enctype="multipart/form-data">
                            @csrf {{-- Token Keamanan Laravel --}}

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title</label>
                                        {{-- Isi value dari $book --}}
                                        <input type="text" class="form-control" id="title" name="title" value="{{ $book['title'] }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="author" class="form-label">Author</label>
                                        <input type="text" class="form-control" id="author" name="author" value="{{ $book['author'] }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="genre" class="form-label">Genre</label>
                                        <select class="form-control" id="genre" name="genre" required>
                                            {{-- Loop dari $genre_options dan pilih $book['genre'] --}}
                                            @foreach ($genre_options as $option)
                                                <option value="{{ $option }}" {{ ($book['genre'] == $option) ? 'selected' : '' }}>{{ $option }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="year" class="form-label">Year</label>
                                        <input type="number" class="form-control" id="year" name="year" value="{{ $book['year'] }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="3" required>{{ $book['description'] }}</textarea>
                                        <small class="text-muted">Ringkasan singkat tentang buku</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="content" class="form-label">Content</label>
                                        <textarea class="form-control" id="content" name="content" rows="3" required>{{ $book['content'] }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Book Cover Image</label>
                                        @if(!empty($book['image_path']))
                                            <div class="mb-2">
                                                <img src="{{ $book['image_path'] }}" alt="Current Cover" class="img-thumbnail" style="max-height: 100px;">
                                                <p class="text-muted small">Current image</p>
                                            </div>
                                        @endif
                                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                        <div class="form-text">Leave empty to keep current image</div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" name="update" class="btn btn-primary">Update Book</button>
                            <a href="{{ url('/genre', ['genre' => $book['genre']]) }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@push('scripts')
  {{-- Script JS Anda --}}
  <script>
    document.querySelector('.sidebar-toggle').addEventListener('click', function() {
      document.querySelector('.sidebar').classList.toggle('active');
    });
    document.addEventListener('click', function(event) {
      const sidebar = document.querySelector('.sidebar');
      const toggleBtn = document.querySelector('.sidebar-toggle');
      if (window.innerWidth <= 768 && 
          !sidebar.contains(event.target) && 
          event.target !== toggleBtn && 
          !toggleBtn.contains(event.target)) {
        sidebar.classList.remove('active');
      }
    });
  </script>
@endpush