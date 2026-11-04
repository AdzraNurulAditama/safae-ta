@extends('layouts.layoutsAdmin')

@section('title', 'Detail Buku - ' . $book->title)

@push('styles')
<style>
    .detail-wrapper {
        color: #30264a;
        padding: 8px 0 25px;
    }

    /* Breadcrumb */
    .detail-breadcrumb {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 28px;
    }

    .detail-breadcrumb .breadcrumb {
        margin: 0;
        font-size: 13px;
    }

    .detail-breadcrumb .breadcrumb a {
        color: #75658f;
        text-decoration: none;
        font-weight: 600;
    }

    .detail-breadcrumb .breadcrumb a:hover {
        color: #7651c9;
    }

    .detail-breadcrumb .breadcrumb-item.active {
        color: #49336e;
        font-weight: 700;
    }

    .btn-back {
        background: #fff;
        border: 1px solid #ded5ed;
        color: #5b4384;
        padding: 9px 17px;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        transition: .2s;
    }

    .btn-back:hover {
        background: #f3edfc;
        color: #593c91;
        border-color: #c9b7e8;
    }

    /* Header Buku */
    .book-header-profile {
        display: flex;
        gap: 30px;
        align-items: flex-start;
        background: #fff;
        border: 1px solid #e8e0f1;
        border-radius: 18px;
        padding: 28px;
        margin-bottom: 25px;
        box-shadow: 0 5px 18px rgba(70, 45, 110, .06);
    }

    .book-profile-cover {
        flex-shrink: 0;
    }

    .book-profile-cover img,
    .book-profile-cover .no-cover {
        width: 175px;
        height: 250px;
        object-fit: cover;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(45, 30, 75, .15);
    }

    .book-profile-cover .no-cover {
        background: #f2edf9;
        border: 1px dashed #cbbce0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #957fb8;
    }

    .book-profile-info {
        flex: 1;
        min-width: 0;
    }

    .tag-container {
        display: flex;
        gap: 9px;
        flex-wrap: wrap;
        margin-bottom: 14px;
    }

    .tag-item {
        display: inline-flex;
        align-items: center;
        padding: 6px 13px;
        border-radius: 7px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .3px;
        text-transform: uppercase;
    }

    .tag-genre {
        background: #f0e9fc;
        color: #6945a5;
        border: 1px solid #dfd0f5;
    }

    .tag-approved {
        background: #e7f8ee;
        color: #187c46;
        border: 1px solid #c5ebd3;
    }

    .tag-pending {
        background: #fff5df;
        color: #a76a0b;
        border: 1px solid #f5dfaa;
    }

    .book-title {
        color: #302044;
        font-size: 29px;
        font-weight: 800;
        line-height: 1.35;
        margin: 0 0 22px;
        overflow-wrap: anywhere;
    }

    .info-inline-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 28px;
        padding: 18px 0;
        border-top: 1px solid #eee8f5;
        border-bottom: 1px solid #eee8f5;
    }

    .info-inline-item small {
        display: block;
        color: #817292;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .5px;
        margin-bottom: 7px;
    }

    .info-inline-item span {
        color: #38294f;
        font-size: 14px;
        font-weight: 700;
    }

    .action-bar {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 22px;
    }

    .btn-edit-custom {
        background: #7651bd;
        color: #fff !important;
        border: 1px solid #7651bd;
        font-size: 13px;
        font-weight: 700;
        padding: 9px 19px;
        border-radius: 8px;
        transition: .2s;
    }

    .btn-edit-custom:hover {
        background: #5e3c9e;
        border-color: #5e3c9e;
        transform: translateY(-2px);
    }

    .btn-delete-custom {
        background: #fff;
        color: #d34252 !important;
        border: 1px solid #f0c8ce;
        font-size: 13px;
        font-weight: 700;
        padding: 9px 17px;
        border-radius: 8px;
        transition: .2s;
    }

    .btn-delete-custom:hover {
        background: #fff0f1;
        border-color: #e7a5ad;
    }

    /* Statistik */
    .inline-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 15px;
        margin-bottom: 28px;
    }

    .stat-card {
        display: flex;
        align-items: center;
        gap: 15px;
        background: #fff;
        border: 1px solid #e8e0f1;
        border-radius: 13px;
        padding: 19px 22px;
        box-shadow: 0 4px 13px rgba(70, 45, 110, .04);
    }

    .stat-icon {
        width: 43px;
        height: 43px;
        border-radius: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
        flex-shrink: 0;
    }

    .stat-icon.purple {
        background: #f0eafd;
        color: #7651bd;
    }

    .stat-icon.blue {
        background: #e9f2ff;
        color: #3979c9;
    }

    .stat-icon.green {
        background: #e8f8ef;
        color: #27965a;
    }

    .stat-val {
        display: block;
        color: #35234f;
        font-size: 22px;
        font-weight: 800;
        line-height: 1.2;
    }

    .stat-lbl {
        display: block;
        color: #82738f;
        font-size: 12px;
        font-weight: 600;
        margin-top: 4px;
    }

    /* Section */
    .content-card {
        background: #fff;
        border: 1px solid #e8e0f1;
        border-radius: 15px;
        padding: 24px 26px;
        margin-bottom: 23px;
        box-shadow: 0 4px 14px rgba(70, 45, 110, .04);
    }

    .content-section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #493267;
        font-size: 16px;
        font-weight: 800;
        margin-bottom: 17px;
    }

    .content-section-title i {
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f0eafd;
        color: #7651bd;
        border-radius: 9px;
        font-size: 14px;
    }

    .description-text {
        color: #514461;
        font-size: 14px;
        line-height: 1.9;
        text-align: justify;
        margin: 0;
        white-space: pre-line;
    }

    /* Isi Buku */
    .text-body-area {
        background: #fff;
        border: 1px solid #e8e0f1;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 4px 14px rgba(70, 45, 110, .04);
    }

    .book-content {
        color: #443850;
        font-size: 14px;
        line-height: 2;
        text-align: justify;
        overflow-wrap: anywhere;
    }

    .book-content p {
        margin-bottom: 17px;
    }

    .empty-content {
        text-align: center;
        padding: 25px 10px;
        color: #82738f;
        font-size: 13px;
    }

    .empty-content i {
        display: block;
        font-size: 25px;
        color: #a28bc5;
        margin-bottom: 10px;
    }

    /* Pagination */
    .pagination {
        gap: 5px;
    }

    .pagination .page-link {
        border: 1px solid #e2d8ef;
        background: #fff;
        color: #654b91;
        border-radius: 7px;
        font-size: 13px;
        font-weight: 600;
        margin: 0 2px;
    }

    .pagination .page-link:hover {
        background: #f2edfb;
        color: #593b91;
    }

    .pagination .page-item.active .page-link {
        background: #7651bd;
        border-color: #7651bd;
        color: #fff;
    }

    .pagination .page-item.disabled .page-link {
        color: #b6aabd;
        background: #faf9fc;
    }

    .page-information {
        color: #82738f;
        font-size: 12px;
        margin-top: 10px;
    }

    /* Footer */
    .detail-footer {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        border-top: 1px solid #e8e0f1;
        padding-top: 17px;
        margin-top: 30px;
        color: #817292;
        font-size: 11px;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .book-header-profile {
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 22px;
        }

        .book-title {
            font-size: 23px;
        }

        .tag-container,
        .action-bar {
            justify-content: center;
        }

        .info-inline-grid {
            justify-content: center;
            gap: 20px;
        }

        .inline-stats {
            grid-template-columns: 1fr;
        }

        .stat-card {
            padding: 15px 18px;
        }

        .content-card,
        .text-body-area {
            padding: 19px;
        }

        .detail-breadcrumb {
            align-items: flex-start;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-0 detail-wrapper">

    {{-- BREADCRUMB --}}
    <div class="detail-breadcrumb">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('/admin') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.genre.index') }}">Daftar Buku</a>
                </li>
                <li class="breadcrumb-item active text-truncate" style="max-width: 200px;" aria-current="page">
                    {{ $book->title }}
                </li>
            </ol>
        </nav>

        <a href="{{ route('admin.genre.index') }}" class="btn-back">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    {{-- PROFIL BUKU --}}
    <div class="book-header-profile">
        <div class="book-profile-cover">
            @if ($book->image_path)
                <img src="{{ asset($book->image_path) }}"
                     alt="{{ $book->title }}"
                     onerror="this.src='{{ asset('images/default-book.png') }}'">
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
                    <span class="tag-item tag-approved">
                        <i class="fas fa-check-circle me-1"></i>Disetujui
                    </span>
                @elseif($book->status === 'pending')
                    <span class="tag-item tag-pending">
                        <i class="fas fa-clock me-1"></i>Pending
                    </span>
                @else
                    <span class="tag-item" style="background:#f2edf8;color:#6d5b82;">
                        {{ $book->status }}
                    </span>
                @endif
            </div>

            <h1 class="book-title">{{ $book->title }}</h1>

            <div class="info-inline-grid">
                <div class="info-inline-item">
                    <small>Penulis</small>
                    <span>{{ $book->author }}</span>
                </div>

                <div class="info-inline-item">
                    <small>Tahun Terbit</small>
                    <span>{{ $book->year }}</span>
                </div>

                <div class="info-inline-item">
                    <small>Terakhir Diperbarui</small>
                    <span>{{ $book->updated_at->format('d M Y H:i') }}</span>
                </div>
            </div>

            <div class="action-bar">
                <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-edit-custom">
                    <i class="fas fa-edit me-2"></i>Edit Buku
                </a>

                <form method="POST"
                      action="{{ route('admin.books.delete') }}"
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?')"
                      class="d-inline">
                    @csrf
                    <input type="hidden" name="id" value="{{ $book->id }}">

                    <button type="submit" class="btn btn-delete-custom">
                        <i class="fas fa-trash me-2"></i>Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- STATISTIK --}}
    <div class="inline-stats">
        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fas fa-star"></i>
            </div>
            <div>
                <span class="stat-val">{{ $book->reviews->count() }}</span>
                <span class="stat-lbl">Total Review</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-comments"></i>
            </div>
            <div>
                <span class="stat-val">{{ $book->komentar->count() }}</span>
                <span class="stat-lbl">Total Komentar</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-book-reader"></i>
            </div>
            <div>
                <span class="stat-val">{{ $book->readingHistories->count() }}</span>
                <span class="stat-lbl">Total Pembaca</span>
            </div>
        </div>
    </div>

    {{-- SINOPSIS --}}
    @if($book->description)
        <div class="content-card">
            <div class="content-section-title">
                <i class="fas fa-align-left"></i>
                Sinopsis Buku
            </div>

            <p class="description-text">{{ $book->description }}</p>
        </div>
    @endif

    {{-- ISI BUKU --}}
    <div class="content-card">
        <div class="content-section-title">
            <i class="fas fa-book-open"></i>
            Isi Buku Lengkap
        </div>

        <div class="text-body-area">
            <div class="book-content">
                @if($book->content)
                    {!! $finalContent !!}
                @else
                    <div class="empty-content">
                        <i class="fas fa-book"></i>
                        Konten atau isi buku belum tersedia.
                    </div>
                @endif
            </div>
        </div>

        {{-- PAGINATION --}}
        @if($paginatedData->hasPages())
            <div class="d-flex flex-column align-items-center mt-4">
                {{ $paginatedData->links() }}

                <div class="page-information">
                    Halaman {{ $paginatedData->currentPage() }}
                    dari {{ $paginatedData->lastPage() }}
                    | Total {{ $paginatedData->total() }} baris
                </div>
            </div>
        @endif
    </div>

    {{-- FOOTER --}}
    <div class="detail-footer">
        <div>ID BUKU: #{{ $book->id }}</div>
        <div>DIBUAT: {{ $book->created_at->format('d M Y H:i:s') }}</div>
        <div>STATUS: {{ strtoupper($book->status) }}</div>
    </div>

</div>
@endsection