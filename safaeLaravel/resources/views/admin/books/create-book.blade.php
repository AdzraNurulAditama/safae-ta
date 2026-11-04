@extends('layouts.layoutsAdmin')
@section('title', 'Tulis Buku Baru')

@push('styles')
<style>
    .write-page {
        color: #35264d;
        padding: 10px 0 35px;
    }

    /* Header */
    .write-header {
        background: linear-gradient(120deg, #7651bd, #9a7bd0);
        border-radius: 17px;
        padding: 27px 30px;
        margin-bottom: 25px;
        color: #fff;
        position: relative;
        overflow: hidden;
    }

    .write-header::after {
        content: "\f02d";
        font-family: "Font Awesome 6 Free";
        font-weight: 900;
        position: absolute;
        right: 35px;
        top: 50%;
        transform: translateY(-50%) rotate(-12deg);
        font-size: 95px;
        color: rgba(255,255,255,.12);
    }

    .write-header-content {
        position: relative;
        z-index: 1;
    }

    .write-header h3 {
        font-size: 23px;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .write-header p {
        font-size: 13px;
        color: rgba(255,255,255,.85);
        margin: 0;
    }

    .write-header-label {
        display: inline-block;
        background: rgba(255,255,255,.17);
        padding: 5px 11px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 700;
        margin-bottom: 12px;
        letter-spacing: .5px;
    }

    /* Main Card */
    .write-card {
        background: #fff;
        border: 1px solid #e9e1f2;
        border-radius: 17px;
        padding: 28px;
        box-shadow: 0 5px 20px rgba(70,45,110,.06);
    }

    /* Section */
    .write-section {
        background: #fbfaff;
        border: 1px solid #eee8f5;
        border-radius: 13px;
        padding: 22px;
        margin-bottom: 22px;
    }

    .section-heading {
        display: flex;
        align-items: center;
        gap: 11px;
        margin-bottom: 20px;
    }

    .section-icon {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f0eafd;
        color: #7651bd;
        border-radius: 9px;
        font-size: 14px;
        flex-shrink: 0;
    }

    .section-heading h5 {
        color: #493267;
        font-size: 15px;
        font-weight: 800;
        margin: 0 0 3px;
    }

    .section-heading p {
        color: #897b99;
        font-size: 11px;
        margin: 0;
    }

    /* Form */
    .write-page .form-label {
        color: #493b5e !important;
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .required-mark {
        color: #dc5260;
    }

    .write-page .form-control,
    .write-page .form-select {
        background: #fff !important;
        color: #392b4e !important;
        border: 1px solid #ded5e9 !important;
        border-radius: 9px !important;
        padding: 11px 14px !important;
        font-size: 13px;
        box-shadow: none !important;
        transition: .2s;
    }

    .write-page .form-control::placeholder {
        color: #aa9eb9 !important;
    }

    .write-page .form-control:focus,
    .write-page .form-select:focus {
        border-color: #9673d0 !important;
        box-shadow: 0 0 0 3px rgba(118,81,189,.12) !important;
    }

    .write-page .form-select option {
        color: #392b4e;
        background: #fff;
    }

    .form-hint {
        color: #897b99;
        font-size: 11px;
        margin-top: 7px;
    }

    /* Cover Upload */
    .cover-upload-area {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 20px;
        background: #fff;
        border: 1px dashed #cbbce0;
        border-radius: 12px;
    }

    .cover-preview {
        width: 105px;
        height: 145px;
        flex-shrink: 0;
        background: #f1ebfa;
        border: 1px solid #e3d9f0;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .cover-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: none;
    }

    .cover-placeholder {
        text-align: center;
        color: #9b87ba;
        font-size: 11px;
    }

    .cover-placeholder i {
        display: block;
        font-size: 27px;
        margin-bottom: 8px;
    }

    .cover-upload-info {
        flex: 1;
        min-width: 0;
    }

    .cover-upload-info h6 {
        color: #493267;
        font-size: 14px;
        font-weight: 800;
        margin-bottom: 5px;
    }

    .cover-upload-info p {
        color: #897b99;
        font-size: 12px;
        margin-bottom: 12px;
    }

    /* Writing Area */
    .writing-textarea {
        min-height: 320px;
        line-height: 1.9 !important;
        resize: vertical;
        padding: 18px !important;
    }

    .writing-note {
        display: flex;
        align-items: flex-start;
        gap: 9px;
        background: #f3effb;
        border: 1px solid #e7ddf4;
        border-radius: 9px;
        padding: 12px 14px;
        color: #705a91;
        font-size: 11px;
        margin-top: 13px;
    }

    .writing-note i {
        margin-top: 2px;
        color: #8968c3;
    }

    /* Alert */
    .write-page .alert-success {
        background: #eaf8ef;
        color: #207747;
        border: 1px solid #ccebd7;
        border-radius: 10px;
        font-size: 13px;
    }

    .write-page .alert-danger {
        background: #fff2f3;
        color: #a62f40;
        border: 1px solid #f3cbd0;
        border-radius: 10px;
        font-size: 13px;
    }

    /* Footer */
    .write-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        padding-top: 20px;
        border-top: 1px solid #eee8f5;
    }

    .footer-info {
        color: #897b99;
        font-size: 12px;
    }

    .btn-submit-write {
        background: #7651bd;
        color: #fff !important;
        border: 1px solid #7651bd;
        padding: 12px 23px;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 800;
        transition: .2s;
    }

    .btn-submit-write:hover {
        background: #5e3c9e;
        border-color: #5e3c9e;
        transform: translateY(-2px);
        box-shadow: 0 5px 14px rgba(118,81,189,.2);
    }

    @media (max-width: 768px) {
        .write-header {
            padding: 23px;
        }

        .write-header::after {
            right: 15px;
            font-size: 65px;
        }

        .write-card {
            padding: 17px;
        }

        .write-section {
            padding: 16px;
        }

        .cover-upload-area {
            flex-direction: column;
            align-items: flex-start;
        }

        .write-footer {
            align-items: stretch;
            flex-direction: column;
        }

        .btn-submit-write {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<main class="container-fluid px-0 write-page">

    {{-- HEADER --}}
    <div class="write-header">
        <div class="write-header-content">
            <span class="write-header-label">
                <i class="fas fa-feather-alt me-1"></i> RUANG KREATIVITAS
            </span>
            <h3>Mulai Cerita Barumu</h3>
            <p>Tuangkan ide dan kreativitasmu menjadi sebuah karya yang bisa dibaca banyak orang.</p>
        </div>
    </div>

    {{-- NOTIFIKASI --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <div class="fw-bold mb-2">
                <i class="fas fa-exclamation-circle me-2"></i>
                Periksa kembali data yang kamu masukkan.
            </div>
            <ul class="mb-0 ps-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM --}}
    <div class="write-card">

        <form action="{{ url('/tulis-buku/store') }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf

            {{-- INFORMASI BUKU --}}
            <div class="write-section">
                <div class="section-heading">
                    <div class="section-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <div>
                        <h5>Informasi Buku</h5>
                        <p>Lengkapi informasi dasar dari karya yang ingin kamu tulis.</p>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label">
                            Judul Buku <span class="required-mark">*</span>
                        </label>
                        <input type="text"
                               name="title"
                               class="form-control"
                               value="{{ old('title') }}"
                               placeholder="Masukkan judul buku"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            Penulis <span class="required-mark">*</span>
                        </label>
                        <input type="text"
                               name="author"
                               class="form-control"
                               value="{{ old('author') }}"
                               placeholder="Masukkan nama penulis"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            Genre <span class="required-mark">*</span>
                        </label>
                        <select name="genre" class="form-select" required>
                            <option value="">Pilih Genre...</option>
                            <option value="Pemrograman" {{ old('genre') == 'Pemrograman' ? 'selected' : '' }}>Pemrograman</option>
                            <option value="Novel" {{ old('genre') == 'Novel' ? 'selected' : '' }}>Novel</option>
                            <option value="Hobi" {{ old('genre') == 'Hobi' ? 'selected' : '' }}>Hobi</option>
                            <option value="Horror" {{ old('genre') == 'Horror' ? 'selected' : '' }}>Horror</option>
                            <option value="Romance" {{ old('genre') == 'Romance' ? 'selected' : '' }}>Romantis</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            Tahun Terbit <span class="required-mark">*</span>
                        </label>
                        <input type="number"
                               name="year"
                               class="form-control"
                               value="{{ old('year', date('Y')) }}"
                               placeholder="Contoh: 2026"
                               required>
                    </div>

                    <div class="col-12">
                        <label class="form-label">
                            Deskripsi Singkat <span class="required-mark">*</span>
                        </label>
                        <textarea name="description"
                                  class="form-control"
                                  rows="4"
                                  required
                                  placeholder="Ceritakan gambaran singkat mengenai buku yang kamu tulis..."
                                  style="resize: vertical;">{{ old('description') }}</textarea>
                        <div class="form-hint">
                            Deskripsi ini akan ditampilkan sebagai ringkasan buku.
                        </div>
                    </div>
                </div>
            </div>

            {{-- COVER BUKU --}}
            <div class="write-section">
                <div class="section-heading">
                    <div class="section-icon">
                        <i class="fas fa-image"></i>
                    </div>
                    <div>
                        <h5>Cover Buku</h5>
                        <p>Tambahkan gambar agar bukumu lebih menarik.</p>
                    </div>
                </div>

                <div class="cover-upload-area">
                    <div class="cover-preview">
                        <img id="coverPreview" src="" alt="Preview Cover">
                        <div class="cover-placeholder" id="coverPlaceholder">
                            <i class="fas fa-image"></i>
                            Preview Cover
                        </div>
                    </div>

                    <div class="cover-upload-info">
                        <h6>Unggah Cover Buku</h6>
                        <p>Pilih gambar dari perangkatmu untuk dijadikan cover buku.</p>

                        <label class="form-label" for="image">Pilih Gambar</label>
                        <input type="file"
                               name="image"
                               id="image"
                               class="form-control"
                               accept="image/*">

                        <div class="form-hint">
                            Format gambar dapat disesuaikan dengan ketentuan upload pada sistem.
                        </div>
                    </div>
                </div>
            </div>

            {{-- ISI BUKU --}}
            <div class="write-section">
                <div class="section-heading">
                    <div class="section-icon">
                        <i class="fas fa-feather-pointed"></i>
                    </div>
                    <div>
                        <h5>Mulai Menulis</h5>
                        <p>Tuangkan cerita dan ide kreatifmu di bagian ini.</p>
                    </div>
                </div>

                <label class="form-label">
                    Isi Buku <span class="required-mark">*</span>
                </label>

                <textarea name="content"
                          class="form-control writing-textarea"
                          rows="12"
                          required
                          placeholder="Mulai tulis ceritamu di sini...">{{ old('content') }}</textarea>

                <div class="writing-note">
                    <i class="fas fa-lightbulb"></i>
                    <span>
                        Kamu bisa mulai dengan paragraf pembuka, kemudian lanjutkan cerita sesuai ide dan kreativitasmu.
                    </span>
                </div>
            </div>

            {{-- TOMBOL KIRIM --}}
            <div class="write-footer">
                <div class="footer-info">
                    <i class="fas fa-info-circle me-1"></i>
                    Pastikan informasi buku sudah lengkap sebelum dikirim.
                </div>

                <button type="submit" class="btn btn-submit-write">
                    <i class="fas fa-paper-plane me-2"></i>
                    Kirim Naskah
                </button>
            </div>

        </form>
    </div>
</main>

@endsection

@push('scripts')
<script>
    // Preview cover sebelum diunggah
    document.getElementById('image')?.addEventListener('change', function(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('coverPreview');
        const placeholder = document.getElementById('coverPlaceholder');

        if (file) {
            if (!file.type.startsWith('image/')) {
                alert('Silakan pilih file gambar.');
                event.target.value = '';
                preview.style.display = 'none';
                placeholder.style.display = 'block';
                return;
            }

            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
            placeholder.style.display = 'none';
        } else {
            preview.src = '';
            preview.style.display = 'none';
            placeholder.style.display = 'block';
        }
    });
</script>
@endpush