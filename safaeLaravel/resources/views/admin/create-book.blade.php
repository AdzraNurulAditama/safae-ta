@extends('layouts.layoutsAdmin')

@section('title', 'Add New Book')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/book-management.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-sytle.css') }}">
@endpush


@section('content')
<main class="col-lg-10 col-md-9 ms-sm-auto px-4">
    <section class="konten">
        <div class="isi">
            <div class="container mt-5">
                <h2>Add New Book</h2>
                
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
                        <h4>Add New Book</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.buku.simpan') }}" enctype="multipart/form-data">
                            @csrf {{-- Token Keamanan Laravel --}}

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title</label>
                                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="author" class="form-label">Author</label>
                                        <input type="text" class="form-control" id="author" name="author" value="{{ old('author') }}" required>
                                    </div>
                                    <div class="mb-3"> 
                                        <label for="genre" class="form-label">Genre</label>
                                        <select class="form-select" id="genre" name="genre" required>
                                            <option value="" disabled selected>Select a genre</option>
                                            @foreach($genre_options as $option)
                                                <option value="{{ $option }}" {{ old('genre') == $option ? 'selected' : '' }}>{{ $option }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="year" class="form-label">Year</label>
                                        <input type="number" class="form-control" id="year" name="year" value="{{ old('year') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Book Cover Image</label>
                                        <input type="file" class="form-control" id="image" name="image" accept="image/*" onchange="previewImage(event)">
                                        <div id="imagePreview" class="mt-2"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                                <small class="text-muted">Ringkasan singkat tentang buku</small>
                            </div>
                            
                            <div class="mb-3">
                                <label for="content" class="form-label">Book Content</label>
                                <textarea class="form-control" id="content" name="content" rows="10" required>{{ old('content') }}</textarea>
                            </div>
                            
                            <button type="submit" name="add" class="btn btn-primary">Add Book</button>
                            <a href="{{ url('/genre') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@push('scripts')
  <script>
    function previewImage(event) {
      const input = event.target;
      const preview = document.getElementById('imagePreview');
      
      if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
          preview.innerHTML = `
            <div class="text-center">
              <img src="${e.target.result}" class="img-thumbnail" style="max-height: 200px; max-width: 100%;">
              <p class="text-success mt-2"><i class="fas fa-check-circle"></i> Gambar dipilih: ${input.files[0].name}</p>
            </div>
          `;
        };
        
        reader.readAsDataURL(input.files[0]);
      }
    }

    document.querySelector('.sidebar-toggle')?.addEventListener('click', function() {
      document.querySelector('.sidebar')?.classList.toggle('active');
    });
    
    document.addEventListener('click', function(event) {
      const sidebar = document.querySelector('.sidebar');
      const toggleBtn = document.querySelector('.sidebar-toggle');
      if (window.innerWidth <= 768 && 
          sidebar && !sidebar.contains(event.target) && 
          event.target !== toggleBtn && 
          toggleBtn && !toggleBtn.contains(event.target)) {
        sidebar.classList.remove('active');
      }
    });
  </script>
@endpush