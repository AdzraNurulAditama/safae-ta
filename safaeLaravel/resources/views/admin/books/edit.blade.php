@extends('layouts.layoutsAdmin')

@section('title', 'Edit Book - ' . $book->title)

@push('styles')
    <style>
        /* ================= PREMIUM OBSIDIAN TECH FORM STYLES ================= */
        .edit-wrapper {
            background: transparent;
            color: var(--text);
            padding: 10px 0;
        }

        /* Container Utama Modern Panel */
        .form-container-premium {
            background: var(--sidebar-bg);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 40px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }

        /* Garis Aksen Teknologi Atas */
        .form-container-premium::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--accent), transparent);
        }

        .section-title-premium {
            color: #fff;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 35px;
            display: flex;
            align-items: center;
            gap: 12px;
            letter-spacing: -0.5px;
        }

        /* Desain Label Form */
        .form-label {
            color: var(--muted);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }

        /* Input Box & Control Premium Glass */
        .form-control, .form-select {
            background-color: rgba(11, 15, 25, 0.5) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            color: var(--text) !important;
            border-radius: 10px !important;
            padding: 14px 18px !important;
            font-size: 0.95rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        /* Efek Glow Cyan Premium Saat Fokus */
        .form-control:focus, .form-select:focus {
            border-color: rgba(6, 182, 212, 0.6) !important;
            box-shadow: 0 0 15px rgba(6, 182, 212, 0.15) !important;
            background-color: rgba(11, 15, 25, 0.8) !important;
        }

        /* Hilangkan Outline Default Dropdown */
        .form-select {
            cursor: pointer;
        }

        /* Desain Khusus Area Upload & Preview Cover */
        .cover-upload-zone {
            background: rgba(11, 15, 25, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 24px;
        }
        
        .cover-preview-box {
            position: relative;
            background: rgba(0, 0, 0, 0.2);
            padding: 6px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .cover-preview-box img {
            width: 85px;
            height: 125px;
            object-fit: cover;
            border-radius: 6px;
        }

        /* Custom Alert Error */
        .alert-premium-danger {
            background: rgba(239, 68, 68, 0.06);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #fca5a5;
            border-radius: 10px;
            padding: 18px 24px;
        }

        .form-text {
            color: var(--muted) !important;
            font-size: 0.75rem;
            margin-top: 8px;
        }

        /* Tombol Aksi Simpan Kustom */
        .btn-submit-premium {
            background: var(--primary);
            color: #0b0f19;
            font-weight: 700;
            font-size: 0.95rem;
            padding: 12px 28px;
            border-radius: 10px;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.25s ease;
            cursor: pointer;
        }
        
        .btn-submit-premium:hover {
            background: #22d3ee;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(6, 182, 212, 0.25);
        }

        .btn-submit-premium:active {
            transform: translateY(0);
        }

        /* Tombol Batal Kustom */
        .btn-cancel-premium {
            font-size: 0.95rem;
            font-weight: 600;
            padding: 12px 24px;
            border-radius: 10px;
            transition: all 0.25s ease;
        }
        
        .btn-cancel-premium:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #fff !important;
        }
    </style>
@endpush

@section('content')
<div class="container-fluid px-0 edit-wrapper">
    
    {{-- ================= NAVIGASI ATAS / BREADCRUMB ================= --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="font-size: 0.8rem;">
                    <li class="breadcrumb-item"><a href="{{ url('/admin') }}" style="color: var(--muted); text-decoration: none;">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/genre') }}" style="color: var(--muted); text-decoration: none;">Daftar Buku</a></li>
                    <li class="breadcrumb-item active text-truncate" style="max-width: 200px; color: var(--primary);" aria-current="page">Edit Buku</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.genre.index', ['genre' => $book->genre]) }}" class="btn btn-sm btn-outline-secondary text-white border-secondary px-3 rounded-2 fw-semibold">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    {{-- ================= NOTIFIKASI ERROR VALIDASI ================= --}}
    @if ($errors->any())
        <div class="alert alert-premium-danger mb-4 shadow-sm">
            <div class="fw-bold small mb-2 d-flex align-items-center gap-2">
                <i class="fas fa-exclamation-circle text-danger fs-5"></i> 
                Terjadi kesalahan pengisian data:
            </div>
            <ul class="mb-0 ps-3 small opacity-90">
                @foreach ($errors->all() as $error)
                    <li class="mb-1">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ================= FORM PANEL UTAMA ================= --}}
    <div class="form-container-premium">
        <h3 class="section-title-premium">
            <i class="fa-solid fa-pen-to-square text-primary"></i>
            Edit Data Buku: <span class="text-muted fw-normal ms-1" style="font-size: 1.15rem;">{{ $book->title }}</span>
        </h3>

        <form method="POST" action="{{ route('admin.books.update', $book->id) }}" enctype="multipart/form-data">
            @csrf

            <div class="row g-4">
                {{-- BARIS KIRI --}}
                <div class="col-md-6">
                    <div class="mb-4">
                        <label for="title" class="form-label">Judul Buku</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $book->title) }}" required placeholder="Masukkan judul baru">
                    </div>

                    <div class="mb-4">
                        <label for="author" class="form-label">Penulis / Pengarang</label>
                        <input type="text" class="form-control" id="author" name="author" value="{{ old('author', $book->author) }}" required placeholder="Nama penulis">
                    </div>

                    <div class="mb-4">
                        <label for="genre" class="form-label">Kategori Genre</label>
                        <select class="form-select" id="genre" name="genre" required>
                            @foreach ($genre_options as $option)
                                <option value="{{ $option }}" {{ old('genre', $book->genre) == $option ? 'selected' : '' }}>
                                    {{ $option }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- BARIS KANAN --}}
                <div class="col-md-6">
                    <div class="mb-4">
                        <label for="year" class="form-label">Tahun Terbit</label>
                        <input type="number" class="form-control" id="year" name="year" value="{{ old('year', $book->year) }}" required placeholder="Contoh: 2024">
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label">Sinopsis / Ringkasan</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required placeholder="Tulis deskripsi singkat tentang alur cerita buku..." style="resize: none;">{{ old('description', $book->description) }}</textarea>
                    </div>
                </div>

                {{-- FULL WIDTH SEKTOR: ISI BUKU & COVER MANAJEMEN --}}
                <div class="col-12">
                    <div class="mb-4">
                        <label for="content" class="form-label">Isi Buku Lengkap (Manuskrip Teks)</label>
                        <textarea class="form-control" id="content" name="content" rows="10" required placeholder="Tulis atau tempel isi keseluruhan naskah buku disini...">{{ old('content', $book->content) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Perbarui Cover Buku</label>
                        <div class="cover-upload-zone">
                            @if ($book->image_path)
                                <div class="cover-preview-box shadow-sm">
                                    <img src="{{ asset($book->image_path) }}" alt="Current Cover" onerror="this.src='{{ asset('images/default-book.png') }}'">
                                </div>
                            @endif
                            <div class="flex-grow-1">
                                <label for="image" class="form-label mb-2 style-select-label" style="color: var(--text); opacity: 0.8; font-weight: 500; text-transform: none; letter-spacing: 0;"><i class="fas fa-cloud-upload-alt text-primary me-2"></i>Pilih Berkas Cover Baru</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                <div class="form-text">Biarkan kosong jika Anda tidak ingin mengganti gambar cover saat ini.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- FOOTER BUTTON ACTIONS --}}
            <div class="mt-4 pt-4 border-top d-flex align-items-center gap-2" style="border-color: var(--border) !important;">
                <button type="submit" class="btn-submit-premium shadow-sm">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>

                <a href="{{ route('admin.genre.index', ['genre' => $book->genre]) }}" class="btn btn-sm btn-outline-secondary text-white border-secondary btn-cancel-premium">
                    Batal
                </a>
            </div>
        </form>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // Penyelarasan kontrol klik menu sidebar responsif seluler bawaan template
    document.getElementById('toggleBtn')?.addEventListener('click', function() {
        document.getElementById('adminSidebar')?.classList.toggle('show');
    });
</script>
@endpush