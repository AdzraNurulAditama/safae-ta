@extends('layouts.layoutsAdmin')

@section('title', 'Detail Buku - ' . $book->title)

@push('styles')
    <style>
        /* ================= PREMIUM OBSIDIAN CLEAN STYLES ================= */
        
        .detail-wrapper {
            background: transparent;
            color: var(--text);
            padding: 10px 0;
        }

        /* Profil Header Buku */
        .book-header-profile {
            display: flex;
            gap: 35px;
            align-items: flex-start;
            margin-bottom: 40px;
            padding-bottom: 35px;
            border-bottom: 1px solid var(--border);
        }

        /* Frame Cover Buku Modern */
        .book-profile-cover img {
            width: 170px;
            height: 245px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
            transition: transform 0.3s ease;
        }
        .book-profile-cover img:hover {
            transform: scale(1.02);
        }

        .book-profile-cover .no-cover {
            width: 170px;
            height: 245px;
            background: var(--sidebar-bg);
            border: 1px dashed var(--border);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--muted);
        }

        .book-profile-info {
            flex: 1;
        }

        /* Badges Minimalis */
        .tag-container {
            display: flex;
            gap: 8px;
            margin-bottom: 18px;
        }
        .tag-item {
            font-size: 0.7rem;
            font-weight: 700;
            padding: 5px 14px;
            border-radius: 6px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .tag-genre {
            background: rgba(6, 182, 212, 0.08);
            color: var(--primary);
            border: 1px solid rgba(6, 182, 212, 0.18);
        }
        .tag-approved {
            background: rgba(16, 185, 129, 0.08);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.18);
        }
        .tag-pending {
            background: rgba(245, 158, 11, 0.08);
            color: #f59e0b;
            border: 1px solid rgba(245, 158, 11, 0.18);
        }

        /* Grid Informasi Searah */
        .info-inline-grid {
            display: flex;
            gap: 45px;
            margin-top: 24px;
        }
        .info-inline-item small {
            display: block;
            color: var(--muted);
            font-size: 0.72rem;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }
        .info-inline-item span {
            font-size: 1rem;
            color: #fff;
            font-weight: 600;
        }

        /* Baris Tombol Aksi */
        .action-bar {
            display: flex;
            gap: 12px;
            margin-top: 30px;
        }
        .btn-edit-custom {
            background: var(--primary);
            color: #0b0f19;
            font-weight: 700;
            transition: all 0.2s ease;
        }
        .btn-edit-custom:hover {
            background: #22d3ee;
            color: #0b0f19;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(6, 182, 212, 0.2);
        }

        /* Statistik Minimalis Terintegrasi */
        .inline-stats {
            display: flex;
            gap: 35px;
            margin-bottom: 35px;
            background: rgba(17, 24, 39, 0.4);
            padding: 16px 28px;
            border-radius: 10px;
            border: 1px solid var(--border);
            width: fit-content;
        }
        .stat-node {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .stat-node .stat-val {
            color: var(--primary);
            font-weight: 700;
            font-size: 1.25rem;
        }
        .stat-node .stat-lbl {
            color: var(--muted);
            font-size: 0.8rem;
            font-weight: 500;
        }

        /* Section Penulisan Utama */
        .content-section-title {
            font-size: 0.8rem;
            color: var(--muted);
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.8px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .text-body-area {
            color: #cbd5e1;
            line-height: 1.9;
            font-size: 1rem;
            text-align: justify;
            background: rgba(17, 24, 39, 0.3);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 30px;
        }

        /* Overrides Navigasi Halaman */
        .pagination .page-link {
            background: var(--sidebar-bg);
            border-color: var(--border);
            color: var(--muted);
        }
        .pagination .page-item.active .page-link {
            background: rgba(6, 182, 212, 0.15);
            border-color: var(--primary);
            color: var(--primary);
        }

        /* Responsivitas Media */
        @media (max-width: 768px) {
            .book-header-profile {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
            .info-inline-grid {
                justify-content: center;
                gap: 25px;
                flex-wrap: wrap;
            }
            .action-bar {
                justify-content: center;
            }
            .inline-stats {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
@endpush

@section('content')
<div class="container-fluid px-0 detail-wrapper">
    
    {{-- ================= HEADER UTAMA (BREADCRUMB & KEMBALI) ================= --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="font-size: 0.8rem;">
                    <li class="breadcrumb-item"><a href="{{ url('/admin') }}" style="color: var(--muted); text-decoration: none;">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/genre') }}" style="color: var(--muted); text-decoration: none;">Daftar Buku</a></li>
                    <li class="breadcrumb-item active text-truncate" style="max-width: 200px; color: var(--primary);" aria-current="page">{{ $book->title }}</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.genre.index') }}" class="btn btn-sm btn-outline-secondary text-white border-secondary px-3 rounded-2 fw-semibold">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    {{-- ================= SEGMEN PROFIL BUKU ================= --}}
    <div class="book-header-profile">
        <div class="book-profile-cover">
            @if ($book->image_path)
                <img src="{{ asset($book->image_path) }}" alt="{{ $book->title }}" onerror="this.src='{{ asset('images/default-book.png') }}'">
            @else
                <div class="no-cover">
                    <i class="fas fa-image fa-2x"></i>
                </div>
            @endif
        </div>

        <div class="book-profile-info">
            <div class="tag-container">
                <span class="tag-item tag-genre">{{ $book->genre }}</span>
                @if($book->status === 'approved')
                    <span class="tag-item tag-approved">Disetujui</span>
                @elseif($book->status === 'pending')
                    <span class="tag-item tag-pending">Pending</span>
                @else
                    <span class="tag-item bg-dark text-muted border border-secondary">{{ $book->status }}</span>
                @endif
            </div>

            <h1 class="fw-bold text-white mb-2" style="font-size: 2.2rem; letter-spacing: -0.5px;">{{ $book->title }}</h1>
            
            <div class="info-inline-grid">
                <div class="info-inline-item">
                    <small>Penulis</small>
                    <span>{{ $book->author }}</span>
                </div>
                <div class="info-inline-item">
                    <small>Tahun Terbit</small>
                    <span class="text-info font-monospace">{{ $book->year }}</span>
                </div>
                <div class="info-inline-item">
                    <small>Terakhir Diperbarui</small>
                    <span class="text-secondary">{{ $book->updated_at->format('d M Y H:i') }}</span>
                </div>
            </div>

            <div class="action-bar">
                <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-edit-custom btn-sm px-4 rounded-2">
                    <i class="fas fa-edit me-2"></i> Edit Buku
                </a>
                <form method="POST" action="{{ route('admin.books.delete') }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?')" class="d-inline">
                    @csrf
                    <input type="hidden" name="id" value="{{ $book->id }}">
                    <button type="submit" class="btn btn-sm btn-outline-danger px-3 rounded-2" style="color: #fca5a5; border-color: rgba(239, 68, 68, 0.35);">
                        <i class="fas fa-trash me-2"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- ================= SEGMEN INDIKATOR STATISTIK ================= --}}
    <div class="inline-stats shadow-sm">
        <div class="stat-node">
            <span class="stat-val">{{ $book->reviews->count() }}</span>
            <span class="stat-lbl">Review</span>
        </div>
        <div class="stat-node border-start ps-3" style="border-color: var(--border) !important;">
            <span class="stat-val">{{ $book->komentar->count() }}</span>
            <span class="stat-lbl">Komentar</span>
        </div>
        <div class="stat-node border-start ps-3" style="border-color: var(--border) !important;">
            <span class="stat-val">{{ $book->readingHistories->count() }}</span>
            <span class="stat-lbl">Pembaca</span>
        </div>
    </div>

    {{-- ================= SEGMEN SINOPSIS ================= --}}
    @if($book->description)
        <div class="mb-40" style="margin-bottom: 35px;">
            <div class="content-section-title">
                <i class="fas fa-align-left text-primary"></i> Sinopsis Buku
            </div>
            <div style="font-size: 0.98rem; max-width: 850px; line-height: 1.7; color: #94a3b8;">
                {{ $book->description }}
            </div>
        </div>
    @endif

    {{-- ================= SEGMEN ISI BUKU LENGKAP ================= --}}
    <div class="mt-4">
        <div class="content-section-title">
            <i class="fa-solid fa-book-open text-primary"></i> Isi Buku Lengkap
        </div>

        <div class="text-body-area shadow-sm">
            <div class="book-content">
                @if($book->content)
                    {!! $finalContent !!}
                @else
                    <div class="text-center text-muted py-2 small">
                        <i class="fas fa-info-circle me-2"></i> Konten atau isi buku belum tersedia.
                    </div>
                @endif
            </div>
        </div>

        {{-- Navigasi Halaman (Pagination) --}}
        @if($paginatedData->hasPages())
            <div class="d-flex flex-column align-items-center mt-4">
                <div class="pagination-sm">
                    {{ $paginatedData->links() }}
                </div>
                <div class="text-muted small mt-2" style="font-size: 0.75rem; font-family: monospace;">
                    PAGE: {{ $paginatedData->currentPage() }} / {{ $paginatedData->lastPage() }} [Total: {{ $paginatedData->total() }} baris]
                </div>
            </div>
        @endif
    </div>

    {{-- ================= METRICS FOOTER ================= --}}
    <div class="mt-5 pt-3 border-top d-flex justify-content-between text-muted" style="border-color: var(--border) !important; font-size: 0.75rem; font-family: monospace;">
        <div>DATA_ID: #{{ $book->id }}</div>
        <div>TIMESTAMP: {{ $book->created_at->format('Y-m-d H:i:s') }}</div>
        <div>NODE_STATUS: ACTIVE</div>
    </div>

</div>
@endsection