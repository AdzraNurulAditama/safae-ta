@extends('layouts.layoutsAdmin')

@section('title', 'Tambah Riwayat Baca')

@push('styles')
    <style>
        /* ================= PREMIUM HIGH-END FORM DESIGN ================= */
        .page-wrapper {
            background: transparent;
            color: var(--text);
            padding: 10px 0;
        }

        /* Container Form Utama */
        .form-panel-premium {
            background: var(--sidebar-bg);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 35px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            position: relative;
        }

        /* Garis Aksen Atas Console */
        .form-panel-premium::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--accent), transparent);
        }

        /* Modifikasi Elemen Label */
        .form-label-custom {
            color: var(--muted);
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        /* Standardisasi Semua Komponen Input */
        .form-control-premium {
            background-color: rgba(11, 15, 25, 0.5) !important;
            color: #fff !important;
            border: 1px solid var(--border) !important;
            border-radius: 8px !important;
            padding: 12px 16px !important;
            font-size: 0.95rem !important;
            transition: all 0.2s ease-in-out !important;
        }
        .form-control-premium:focus {
            border-color: rgba(6, 182, 212, 0.4) !important;
            box-shadow: 0 0 10px rgba(6, 182, 212, 0.1) !important;
            outline: none !important;
        }

        /* Kustomisasi Khusus Input File Upload */
        .form-control-premium[type="file"] {
            padding: 9px 16px !important;
        }
        .form-control-premium[type="file"]::file-selector-button {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border);
            color: #fff;
            border-radius: 6px;
            padding: 4px 12px;
            margin-right: 12px;
            transition: background 0.2s;
        }
        .form-control-premium[type="file"]::file-selector-button:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        /* Komponen Tombol Aksi */
        .btn-console-save {
            background: var(--primary);
            color: #0b0f19;
            font-weight: 700;
            font-size: 0.9rem;
            padding: 12px 28px;
            border-radius: 8px;
            border: none;
            transition: all 0.2s ease;
        }
        .btn-console-save:hover {
            background: #22d3ee;
            box-shadow: 0 4px 12px rgba(6, 182, 212, 0.2);
            color: #0b0f19;
        }

        .btn-console-cancel {
            background: transparent;
            border: 1px solid var(--border);
            color: var(--muted);
            font-weight: 600;
            font-size: 0.9rem;
            padding: 12px 28px;
            border-radius: 8px;
            transition: all 0.2s ease;
            text-decoration: none;
        }
        .btn-console-cancel:hover {
            background: rgba(255, 255, 255, 0.03);
            color: #fff !important;
            border-color: var(--muted);
        }
    </style>
@endpush

@section('content')
<div class="container-fluid px-0 page-wrapper" style="max-width: 900px;">

    {{-- ================= HEADER NAVIGASI ATAS ================= --}}
    <div class="mb-4">
        <nav aria-label="breadcrumb" class="mb-1">
            <ol class="breadcrumb mb-0" style="font-size: 0.8rem;">
                <li class="breadcrumb-item"><a href="{{ url('/admin') }}" style="color: var(--muted); text-decoration: none;">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.kelolariwayat.index') }}" style="color: var(--muted); text-decoration: none;">Riwayat Baca</a></li>
                <li class="breadcrumb-item active" style="color: var(--primary);" aria-current="page">Tambah</li>
            </ol>
        </nav>
        <h2 class="fw-bold text-white m-0" style="font-size: 1.8rem; letter-spacing: -0.5px;">Tambah Riwayat Baca</h2>
    </div>

    {{-- ================= FORM PANEL UTAMA ================= --}}
    <div class="form-panel-premium shadow-sm">
        
        {{-- rute sudah diperbaiki menjadi admin.kelolariwayat.store --}}
        <form action="{{ route('admin.kelolariwayat.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- 1. PILIHAN INPUT: USER --}}
            <div class="mb-4">
                <label class="form-label form-label-custom">User</label>
                <select name="user_id" class="form-select form-control-premium" required>
                    <option value="" style="background: #111827;">-- Pilih User --</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" style="background: #111827;">
                            {{ $user->name ?? $user->username ?? ($user->nama_depan . ' ' . $user->nama_belakang) ?? 'User Tanpa Nama' }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- 2. PILIHAN INPUT: BUKU --}}
            <div class="mb-4">
                <label class="form-label form-label-custom">Buku</label>
                <select name="book_id" class="form-select form-control-premium" required>
                    <option value="" style="background: #111827;">-- Pilih Buku --</option>
                    @foreach ($books as $book)
                        <option value="{{ $book->id }}" style="background: #111827;">
                            {{ $book->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- 3. INPUT ANGKA: PROGRESS MEMBACA --}}
            <div class="mb-4">
                <label class="form-label form-label-custom">Progress (%)</label>
                <input type="number" class="form-control form-control-premium" name="progress" min="0" max="100" placeholder="Contoh: 45" required>
            </div>

            {{-- 4. INPUT TANGGAL: TERAKHIR BACA --}}
            <div class="mb-4">
                <label class="form-label form-label-custom">Tanggal Terakhir Baca</label>
                <input type="date" class="form-control form-control-premium" name="last_read_at" value="{{ date('Y-m-d') }}" required>
            </div>

            {{-- 5. INPUT FILE: BUKTI LAMPIRAN --}}
            <div class="mb-5">
                <label class="form-label form-label-custom">Bukti Progress</label>
                <input type="file" class="form-control form-control-premium" name="bukti_progress">
            </div>

            {{-- PANEL TOMBOL AKSI DI BAWAH --}}
            <div class="d-flex align-items-center justify-content-end gap-3 pt-3 border-top" style="border-color: rgba(255,255,255,0.04) !important;">
                <a href="{{ route('admin.kelolariwayat.index') }}" class="btn-console-cancel">
                    Batal
                </a>
                <button type="submit" class="btn-console-save shadow-sm">
                    Tambah Riwayat
                </button>
            </div>

        </form>

    </div>
</div>
@endsection