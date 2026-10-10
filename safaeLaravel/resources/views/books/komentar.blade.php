@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <a href="{{ route('book.show', [$bookId, $page]) }}" class="text-decoration-none text-muted fw-bold small d-inline-flex align-items-center transition-all hover-primary">
                <i class="fas fa-chevron-left me-2"></i> Kembali ke Bacaan
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-5 bg-white">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="fas fa-comments"></i>
                    </div>
                    <h5 class="fw-bold m-0 text-dark">Tulis Komentar Baru</h5>
                </div>

                <form action="{{ route('komentar.simpan') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="book_id" value="{{ $bookId }}">
                    <input type="hidden" name="page" value="{{ $page }}">

                    <div class="mb-3">
                        <textarea name="komentar" class="form-control border-light-subtle bg-light bg-opacity-50 rounded-3 p-3 text-secondary" rows="3" placeholder="Bagikan pendapat atau diskusikan bacaan ini dengan sopan..." style="resize: none;" required></textarea>
                    </div>

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div class="position-relative">
                            <label class="btn btn-sm btn-outline-secondary rounded-pill px-3 border-0 bg-light shadow-sm small cursor-pointer" style="font-size: 0.85rem;">
                                <i class="fas fa-image text-success me-1"></i> Tambah Gambar
                                <input type="file" name="image" accept="image/*" class="d-none" id="comment-image-input" onchange="updateFileName(this)">
                            </label>
                            <span id="file-name-preview" class="text-muted small ms-2 d-inline-block text-truncate" style="max-width: 150px;"></span>
                        </div>

                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
                            Kirim Komentar <i class="fas fa-paper-plane ms-1 small"></i>
                        </button>
                    </div>
                </form>
            </div>

            <div class="d-flex align-items-center justify-content-between border-bottom pb-2 mb-4">
                <div class="fw-bold text-secondary text-uppercase tracking-wider small">
                    <i class="fas fa-stream me-2 text-primary"></i> Semua Diskusi
                </div>
                <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3 py-1 fw-semibold">{{ count($komentar) }} Komentar</span>
            </div>

            <div class="d-flex flex-column gap-3">
                @forelse($komentar as $c)
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                        <div class="card-body p-4">
                            
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary text-white fw-bold rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 42px; height: 42px; font-size: 0.95rem; letter-spacing: 0.5px;">
                                        {{ strtoupper(substr($c->username, 0, 2)) }}
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="fw-bold text-dark m-0 mb-0" style="font-size: 0.95rem;">{{ $c->username }}</h6>
                                        <small class="text-muted" style="font-size: 0.75rem;">Pembaca Aktif</small>
                                    </div>
                                </div>

                                </div>

                            <div class="ps-md-5">
                                <p class="card-text text-secondary mb-3及" style="line-height: 1.6; white-space: pre-line; font-size: 0.95rem;">
                                    {{ $c->komentar }}
                                </p>

                                @if($c->image_path)
                                    <div class="mb-3 rounded-3 overflow-hidden border border-light-subtle d-inline-block" style="max-width: 100%;">
                                        <img src="{{ asset('uploads/' . $c->image_path) }}" class="img-fluid" style="max-height: 280px; object-fit: cover;" alt="Lampiran">
                                    </div>
                                @endif

                                @if(Auth::check() && Auth::id() == $c->user_id)
                                    <div class="d-flex gap-2 pt-2 border-top border-light-subtle">
                                        <a href="{{ route('komentar.edit', $c->id) }}" class="btn btn-sm btn-link text-warning text-decoration-none fw-semibold p-0 me-3 small">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </a>

                                        <form action="{{ route('komentar.hapus', $c->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus komentar ini?')" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-link text-danger text-decoration-none fw-semibold p-0 small">
                                                <i class="fas fa-trash-alt me-1"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="card border-0 shadow-sm rounded-4 py-5 text-center bg-white">
                        <div class="card-body">
                            <img src="https://cdn-icons-png.flaticon.com/512/4076/4076432.png" width="80" class="mb-3 opacity-75">
                            <h6 class="text-muted fw-bold">Belum ada diskusi di halaman ini.</h6>
                            <p class="text-muted small mb-0">Mulai ketikkan sesuatu untuk memicu obrolan!</p>
                        </div>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</div>

<style>
    .rounded-4 { border-radius: 1rem !important; }
    .cursor-pointer { cursor: pointer; }
    .hover-primary:hover { color: #0d6efd !important; transition: 0.2s; }
    .tracking-wider { letter-spacing: 0.05em; }
</style>

<script>
    function updateFileName(input) {
        const preview = document.getElementById('file-name-preview');
        if (input.files && input.files.length > 0) {
            preview.innerText = '📎 ' + input.files[0].name;
        } else {
            preview.innerText = '';
        }
    }
</script>
@endsection