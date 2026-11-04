@extends('layouts.layoutsAdmin')

@section('title', 'Edit Buku - ' . $book->title)

@push('styles')
<style>
    .edit-wrapper {
        color: #30264a;
        padding: 8px 0 30px;
    }

    /* Breadcrumb */
    .edit-navigation {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 25px;
    }

    .edit-navigation .breadcrumb {
        margin: 0;
        font-size: 13px;
    }

    .edit-navigation .breadcrumb a {
        color: #75658f;
        text-decoration: none;
        font-weight: 600;
    }

    .edit-navigation .breadcrumb a:hover {
        color: #7651bd;
    }

    .edit-navigation .breadcrumb-item.active {
        color: #493267;
        font-weight: 700;
    }

    .btn-back {
        background: #fff;
        border: 1px solid #ded5ed;
        color: #5b4384 !important;
        padding: 9px 17px;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        transition: .2s;
    }

    .btn-back:hover {
        background: #f3edfc;
        border-color: #c9b7e8;
    }

    /* Form Container */
    .form-container-premium {
        background: #fff;
        border: 1px solid #e8e0f1;
        border-radius: 17px;
        padding: 30px;
        box-shadow: 0 5px 20px rgba(70, 45, 110, .06);
    }

    .form-header {
        display: flex;
        align-items: center;
        gap: 15px;
        padding-bottom: 23px;
        margin-bottom: 25px;
        border-bottom: 1px solid #eee8f5;
    }

    .form-header-icon {
        width: 48px;
        height: 48px;
        background: #f0eafd;
        color: #7651bd;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .form-header h3 {
        color: #35234f;
        font-size: 21px;
        font-weight: 800;
        margin: 0 0 5px;
    }

    .form-header p {
        color: #82738f;
        font-size: 13px;
        margin: 0;
    }

    /* Form Section */
    .form-section {
        background: #fbfaff;
        border: 1px solid #eee8f5;
        border-radius: 13px;
        padding: 22px;
        margin-bottom: 23px;
    }

    .form-section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #493267;
        font-size: 15px;
        font-weight: 800;
        margin-bottom: 20px;
    }

    .form-section-title i {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f0eafd;
        color: #7651bd;
        border-radius: 8px;
        font-size: 13px;
    }

    /* Label */
    .edit-wrapper .form-label {
        display: block;
        color: #493b5e !important;
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 8px;
        letter-spacing: 0;
        text-transform: none;
    }

    .required-mark {
        color: #dc5260;
    }

    /* Input */
    .edit-wrapper .form-control,
    .edit-wrapper .form-select {
        background: #fff !important;
        color: #392b4e !important;
        border: 1px solid #ded5e9 !important;
        border-radius: 9px !important;
        padding: 11px 14px !important;
        font-size: 13px;
        font-weight: 500;
        box-shadow: none !important;
        transition: .2s;
    }

    .edit-wrapper .form-control::placeholder {
        color: #aa9eb9 !important;
        font-weight: 400;
    }

    .edit-wrapper .form-control:focus,
    .edit-wrapper .form-select:focus {
        background: #fff !important;
        color: #392b4e !important;
        border-color: #9673d0 !important;
        box-shadow: 0 0 0 3px rgba(118, 81, 189, .12) !important;
    }

    .edit-wrapper textarea.form-control {
        line-height: 1.7;
    }

    .edit-wrapper select option {
        color: #392b4e;
        background: #fff;
    }

    .form-help {
        color: #82738f;
        font-size: 11px;
        margin-top: 7px;
    }

    /* Cover Upload */
    .cover-upload-zone {
        display: flex;
        align-items: center;
        gap: 22px;
        padding: 20px;
        background: #fff;
        border: 1px dashed #cbbce0;
        border-radius: 12px;
    }

    .cover-preview-box {
        flex-shrink: 0;
        width: 105px;
        height: 145px;
        padding: 5px;
        background: #f4effb;
        border: 1px solid #e5dbf1;
        border-radius: 9px;
    }

    .cover-preview-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 6px;
    }

    .cover-placeholder {
        width: 105px;
        height: 145px;
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 8px;
        background: #f4effb;
        color: #957fb8;
        border: 1px dashed #cbbce0;
        border-radius: 9px;
        font-size: 11px;
        text-align: center;
    }

    .cover-upload-info {
        flex: 1;
        min-width: 0;
    }

    .cover-upload-info h6 {
        color: #493267;
        font-size: 14px;
        font-weight: 800;
        margin-bottom: 6px;
    }

    .cover-upload-info p {
        color: #82738f;
        font-size: 12px;
        margin-bottom: 12px;
    }

    .cover-upload-info .form-control {
        background: #fbfaff !important;
    }

    /* Alert Error */
    .alert-premium-danger {
        background: #fff2f3;
        border: 1px solid #f3cbd0;
        color: #a62f40;
        border-radius: 11px;
        padding: 17px 20px;
    }

    .alert-premium-danger .alert-heading {
        color: #a62f40;
        font-size: 14px;
        font-weight: 800;
    }

    .alert-premium-danger li {
        font-size: 12px;
        margin-bottom: 4px;
    }

    /* Footer */
    .form-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        border-top: 1px solid #eee8f5;
        padding-top: 22px;
        margin-top: 10px;
    }

    .footer-note {
        color: #82738f;
        font-size: 12px;
    }

    .footer-actions {
        display: flex;
        gap: 10px;
    }

    .btn-submit-premium {
        background: #7651bd;
        color: #fff !important;
        border: 1px solid #7651bd;
        font-size: 13px;
        font-weight: 800;
        padding: 11px 21px;
        border-radius: 9px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: .2s;
    }

    .btn-submit-premium:hover {
        background: #5e3c9e;
        border-color: #5e3c9e;
        transform: translateY(-2px);
        box-shadow: 0 5px 13px rgba(118, 81, 189, .2);
    }

    .btn-cancel-premium {
        background: #fff;
        color: #68577d !important;
        border: 1px solid #ded5e9;
        font-size: 13px;
        font-weight: 700;
        padding: 11px 20px;
        border-radius: 9px;
        text-decoration: none;
        transition: .2s;
    }

    .btn-cancel-premium:hover {
        background: #f4effb;
        color: #593b91 !important;
        border-color: #cbbce0;
    }

    @media (max-width: 768px) {
        .form-container-premium {
            padding: 20px;
        }

        .form-section {
            padding: 16px;
        }

        .form-header h3 {
            font-size: 18px;
        }

        .cover-upload-zone {
            flex-direction: column;
            align-items: flex-start;
        }

        .form-footer {
            align-items: stretch;
            flex-direction: column;
        }

        .footer-actions {
            width: 100%;
        }

        .footer-actions button,
        .footer-actions a {
            flex: 1;
            justify-content: center;
            text-align: center;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-0 edit-wrapper">

    {{-- BREADCRUMB --}}
    <div class="edit-navigation">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('/admin') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.genre.index') }}">Daftar Buku</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Edit Buku
                </li>
            </ol>
        </nav>

        <a href="{{ route('admin.genre.index', ['genre' => $book->genre]) }}" class="btn-back">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    {{-- ERROR VALIDASI --}}
    @if ($errors->any())
        <div class="alert alert-premium-danger mb-4 shadow-sm">
            <div class="alert-heading mb-2">
                <i class="fas fa-exclamation-circle me-2"></i>
                Terdapat kesalahan pada pengisian data
            </div>
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM UTAMA --}}
    <div class="form-container-premium">

        <div class="form-header">
            <div class="form-header-icon">
                <i class="fas fa-pen-to-square"></i>
            </div>
            <div>
                <h3>Edit Data Buku</h3>
                <p>Perbarui informasi buku sesuai dengan data terbaru.</p>
            </div>
        </div>

        <form method="POST"
              action="{{ route('admin.books.update', $book->id) }}"
              enctype="multipart/form-data">
            @csrf

            {{-- INFORMASI DASAR --}}
            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-book"></i>
                    Informasi Dasar Buku
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div>
                            <label for="title" class="form-label">
                                Judul Buku <span class="required-mark">*</span>
                            </label>
                            <input type="text"
                                   class="form-control"
                                   id="title"
                                   name="title"
                                   value="{{ old('title', $book->title) }}"
                                   required
                                   placeholder="Masukkan judul buku">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div>
                            <label for="author" class="form-label">
                                Penulis / Pengarang <span class="required-mark">*</span>
                            </label>
                            <input type="text"
                                   class="form-control"
                                   id="author"
                                   name="author"
                                   value="{{ old('author', $book->author) }}"
                                   required
                                   placeholder="Masukkan nama penulis">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div>
                            <label for="genre" class="form-label">
                                Kategori Genre <span class="required-mark">*</span>
                            </label>
                            <select class="form-select" id="genre" name="genre" required>
                                @foreach ($genre_options as $option)
                                    <option value="{{ $option }}"
                                        {{ old('genre', $book->genre) == $option ? 'selected' : '' }}>
                                        {{ $option }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div>
                            <label for="year" class="form-label">
                                Tahun Terbit <span class="required-mark">*</span>
                            </label>
                            <input type="number"
                                   class="form-control"
                                   id="year"
                                   name="year"
                                   value="{{ old('year', $book->year) }}"
                                   required
                                   placeholder="Contoh: 2024">
                        </div>
                    </div>

                    <div class="col-12">
                        <div>
                            <label for="description" class="form-label">
                                Sinopsis / Ringkasan <span class="required-mark">*</span>
                            </label>
                            <textarea class="form-control"
                                      id="description"
                                      name="description"
                                      rows="4"
                                      required
                                      placeholder="Tuliskan sinopsis atau ringkasan buku..."
                                      style="resize: vertical;">{{ old('description', $book->description) }}</textarea>
                            <div class="form-help">
                                Berikan gambaran singkat mengenai isi atau cerita buku.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ISI BUKU --}}
            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-file-lines"></i>
                    Isi Buku
                </div>

                <div>
                    <label for="content" class="form-label">
                        Isi Buku Lengkap <span class="required-mark">*</span>
                    </label>
                    <textarea class="form-control"
                              id="content"
                              name="content"
                              rows="12"
                              required
                              placeholder="Tulis atau tempel isi lengkap buku di sini...">{{ old('content', $book->content) }}</textarea>
                    <div class="form-help">
                        Periksa kembali isi buku sebelum menyimpan perubahan.
                    </div>
                </div>
            </div>

            {{-- COVER BUKU --}}
            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-image"></i>
                    Cover Buku
                </div>

                <div class="cover-upload-zone">
                    @if ($book->image_path)
                        <div class="cover-preview-box">
                            <img src="{{ asset($book->image_path) }}"
                                 alt="Cover Buku"
                                 onerror="this.src='{{ asset('images/default-book.png') }}'">
                        </div>
                    @else
                        <div class="cover-placeholder">
                            <i class="fas fa-image fa-2x"></i>
                            <span>Belum ada cover</span>
                        </div>
                    @endif

                    <div class="cover-upload-info">
                        <h6>Ganti Cover Buku</h6>
                        <p>Pilih gambar baru jika ingin memperbarui cover buku.</p>

                        <label for="image" class="form-label">
                            Pilih File Cover
                        </label>
                        <input type="file"
                               class="form-control"
                               id="image"
                               name="image"
                               accept="image/*">

                        <div class="form-help">
                            Biarkan kosong jika tidak ingin mengganti cover saat ini.
                        </div>
                    </div>
                </div>
            </div>

            {{-- TOMBOL AKSI --}}
            <div class="form-footer">
                <div class="footer-note">
                    <i class="fas fa-info-circle me-1"></i>
                    Pastikan semua informasi sudah benar.
                </div>

                <div class="footer-actions">
                    <a href="{{ route('admin.genre.index', ['genre' => $book->genre]) }}"
                       class="btn-cancel-premium">
                        Batal
                    </a>

                    <button type="submit" class="btn-submit-premium">
                        <i class="fas fa-save"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('toggleBtn')?.addEventListener('click', function() {
        document.getElementById('adminSidebar')?.classList.toggle('show');
    });
</script>
@endpush