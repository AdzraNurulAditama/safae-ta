@extends('layouts.layoutsAdmin')

@section('title', 'Tambah Promosi')

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

        /* Elemen Label Bersih */
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
                <li class="breadcrumb-item"><a href="{{ route('admin.promotions.index') }}" style="color: var(--muted); text-decoration: none;">Promosi</a></li>
                <li class="breadcrumb-item active" style="color: var(--primary);" aria-current="page">Tambah</li>
            </ol>
        </nav>
        <h2 class="fw-bold text-white m-0" style="font-size: 1.8rem; letter-spacing: -0.5px;">Tambah Promosi Baru</h2>
    </div>

    {{-- ================= FORM PANEL UTAMA ================= --}}
    <div class="form-panel-premium shadow-sm">
        
        <form action="{{ route('admin.promotions.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- 1. INPUT JUDUL --}}
            <div class="mb-4">
                <label class="form-label form-label-custom">Judul Promosi</label>
                <input type="text" name="title" class="form-control form-control-premium" placeholder="Masukkan judul promosi..." required>
            </div>

            {{-- 2. INPUT GAMBAR --}}
            <div class="mb-4">
                <label class="form-label form-label-custom">Gambar Banner / Poster</label>
                <input type="file" name="image" class="form-control form-control-premium" required>
            </div>

            {{-- 3. INPUT DESKRIPSI SINGKAT --}}
            <div class="mb-4">
                <label class="form-label form-label-custom">Deskripsi Singkat</label>
                <textarea name="short_description" rows="3" class="form-control form-control-premium" placeholder="Tulis ringkasan singkat promosi untuk pratinjau kartu..." required></textarea>
            </div>

            {{-- 4. INPUT ISI BERITA --}}
            <div class="mb-4">
                <label class="form-label form-label-custom">Isi Berita / Konten Lengkap</label>
                <textarea name="content" rows="8" class="form-control form-control-premium" placeholder="Tuliskan seluruh detail informasi promosi di sini..." required></textarea>
            </div>

            {{-- 5. INPUT TANGGAL EVENT --}}
            <div class="mb-5">
                <label class="form-label form-label-custom">Tanggal Event / Batas Waktu</label>
                <input type="date" name="event_date" class="form-control form-control-premium" value="{{ date('Y-m-d') }}" required>
            </div>

            {{-- PANEL PANEL TOMBOL AKSI DI BAWAH --}}
            <div class="d-flex align-items-center justify-content-end gap-3 pt-3 border-top" style="border-color: rgba(255,255,255,0.04) !important;">
                <a href="{{ route('admin.promotions.index') }}" class="btn-console-cancel">
                    Batal
                </a>
                <button type="submit" class="btn-console-save shadow-sm">
                    Simpan Promosi
                </button>
            </div>

        </form>

    </div>
</div>
@endsection