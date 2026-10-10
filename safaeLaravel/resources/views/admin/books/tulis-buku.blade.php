@extends('layouts.layoutsAdmin')

@section('title', 'Tulis Buku Baru')

@section('content')
<main class="col-lg-10 col-md-9 ms-sm-auto px-4">
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="fas fa-pen-nib me-2"></i>Tulis Buku Baru</h4>
            </div>
            <div class="card-body">
                
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ url('/tulis-buku/store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Judul Buku</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Penulis</label>
                            <input type="text" name="author" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Genre</label>
                            <select name="genre" class="form-select" required>
                                <option value="">Pilih Genre...</option>
                                <option value="Pemrograman">Pemrograman</option>
                                <option value="Novel">Novel</option>
                                <option value="Hobi">Hobi</option>
                                <option value="Horror">Horror</option>
                                <option value="Romance">Romantis</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tahun Terbit</label>
                            <input type="number" name="year" class="form-control" value="{{ date('Y') }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi Singkat</label>
                        <textarea name="description" class="form-control" rows="3" required placeholder="Tulis ringkasan singkat tentang buku..."></textarea>
                        <small class="text-muted">Deskripsi ini akan muncul sebagai ringkasan buku</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Cover Buku</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Isi Buku (Konten)</label>
                        <textarea name="content" class="form-control" rows="10" required placeholder="Mulai menulis ceritamu di sini..."></textarea>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-paper-plane me-2"></i>Kirim Naskah
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection