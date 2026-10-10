@extends('layouts.app')

@section('title', 'Buat Profil')

@section('content')
<div class="container py-5">
    <div class="card shadow-sm mx-auto border-0 rounded-4" style="max-width: 500px;">

        <div class="card-header bg-primary text-white text-center rounded-top-4 py-3">
            <h4 class="mb-0">Buat Profil Baru</h4>
        </div>

        <div class="card-body p-4">

            <form method="POST"
                  enctype="multipart/form-data"
                  action="{{ route('profile.store') }}">
                @csrf

                {{-- USERNAME --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Pengguna</label>
                    <input type="text"
                           name="username"
                           class="form-control"
                           required>
                </div>

                {{-- SOCIAL MEDIA --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Social Media</label>
                    <input type="text"
                           name="social_media"
                           class="form-control"
                           placeholder="Instagram / Twitter / LinkedIn">
                </div>

                {{-- BIO --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Bio</label>
                    <textarea name="bio"
                              class="form-control"
                              rows="3"
                              placeholder="Ceritakan sedikit tentang dirimu"></textarea>
                </div>

                {{-- FOTO PROFIL (STORAGE LINK READY) --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">Foto Profil</label>
                    <input type="file"
                           name="foto_profil"
                           class="form-control"
                           accept="image/*">
                    <small class="text-muted">
                        Format JPG / PNG, maksimal 2MB
                    </small>
                </div>

                {{-- ACTION --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('profile') }}"
                       class="btn btn-light rounded-pill px-4">
                        Batal
                    </a>

                    <button type="submit"
                            class="btn btn-primary rounded-pill px-4">
                        Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection
