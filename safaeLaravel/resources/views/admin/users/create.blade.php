@extends('layouts.layoutsAdmin')

@section('title', 'Tambah User')

@section('content')
<main class="col-lg-10 col-md-9 ms-sm-auto px-4 py-4">

    <div class="container" style="max-width: 900px;">

        {{-- HEADER --}}
        <div class="mb-4">
            <h2 class="fw-bold mb-1">Tambah User</h2>
            <p class="text-muted mb-0">
                Buat akun pengguna baru untuk sistem Safae
            </p>
        </div>

        <div class="row g-4">

            {{-- LEFT INFO --}}
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body text-center p-4">

                        <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex p-4 mb-3">
                            <i class="fas fa-user-plus fa-2x text-primary"></i>
                        </div>

                        <h5 class="fw-semibold">Akun Baru</h5>
                        <p class="text-muted small">
                            Admin dapat menambahkan akun khusus seperti penulis,
                            editor, atau admin sistem.
                        </p>

                        <hr>

                        <ul class="list-unstyled text-start small">
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                Username unik
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                Email aktif
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                Password minimal 6 karakter
                            </li>
                            <li>
                                <i class="fas fa-check-circle text-success me-2"></i>
                                Role ditentukan oleh admin
                            </li>
                        </ul>

                    </div>
                </div>
            </div>

            {{-- RIGHT FORM --}}
            <div class="col-md-8">
                <div class="card border-0 shadow-lg rounded-4">
                    <div class="card-body p-5">

                        <form action="{{ route('admin.users.store') }}" method="POST">
                            @csrf

                            {{-- USERNAME --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Username</label>
                                <input type="text"
                                       name="username"
                                       class="form-control form-control-lg @error('username') is-invalid @enderror"
                                       placeholder="Masukkan username"
                                       value="{{ old('username') }}"
                                       required>
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- EMAIL --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email"
                                       name="email"
                                       class="form-control form-control-lg @error('email') is-invalid @enderror"
                                       placeholder="contoh@email.com"
                                       value="{{ old('email') }}"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- PASSWORD --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Password</label>
                                <input type="password"
                                       name="password"
                                       class="form-control form-control-lg @error('password') is-invalid @enderror"
                                       placeholder="Minimal 6 karakter"
                                       required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- ROLE --}}
                            <div class="mb-5">
                                <label class="form-label fw-semibold">Role</label>
                                <select name="role"
                                        class="form-select form-select-lg @error('role') is-invalid @enderror"
                                        required>
                                    <option value="">-- Pilih Role --</option>
                                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- ACTION --}}
                            <div class="d-flex justify-content-end gap-3">
                                <a href="{{ route('admin.users.index') }}"
                                   class="btn btn-light px-4">
                                    Batal
                                </a>
                                <button class="btn btn-primary px-4">
                                    <i class="fas fa-save me-1"></i> Simpan User
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

        </div>

    </div>

</main>
@endsection
