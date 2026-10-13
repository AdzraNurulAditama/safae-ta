@extends('layouts.app')

@section('title', 'Riwayat Baca per Genre - Safae')

@section('content')

<style>
    .history-header {
        color: #f1f5f9;
        font-weight: 800;
    }

    /* Filter Bar */
    .filter-pills {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .filter-pills .btn-filter {
        background: #1e293b;
        color: #94a3b8;
        border: 1px solid #334155;
        border-radius: 12px;
        padding: 8px 18px;
        font-weight: 600;
        font-size: 0.88rem;
        transition: 0.3s;
        text-decoration: none;
    }

    .filter-pills .btn-filter:hover,
    .filter-pills .btn-filter.active {
        background: #38bdf8;
        color: #0f172a;
        border-color: #38bdf8;
        font-weight: 700;
    }

    /* Genre Section Title */
    .genre-section-title {
        color: #38bdf8;
        font-size: 1.25rem;
        font-weight: 700;
        padding-bottom: 8px;
        border-bottom: 2px solid #334155;
        margin-top: 25px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Card Item */
    .history-card {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 20px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
        transition: 0.3s ease;
    }

    .history-card:hover {
        transform: translateY(-5px);
        border-color: #38bdf8;
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.4);
    }

    .cover-wrapper {
        height: 200px;
        background: #0f172a;
        position: relative;
        overflow: hidden;
    }

    .cover-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Badge Status */
    .status-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 0.72rem;
        font-weight: 700;
    }
    .badge-selesai { background: #22c55e; color: #052e16; }
    .badge-sedang { background: #38bdf8; color: #0f172a; }
    .badge-belum { background: #64748b; color: #f8fafc; }

    .card-body {
        padding: 16px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .book-title {
        color: #f8fafc;
        font-weight: 700;
        font-size: 1rem;
        margin-bottom: 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .meta-text {
        color: #94a3b8;
        font-size: 0.8rem;
        margin-bottom: 4px;
    }

    .progress-wrapper {
        margin: 10px 0;
    }

    .progress {
        height: 7px;
        background: #0f172a;
        border-radius: 10px;
    }

    /* Action Buttons */
    .card-actions {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-top: auto;
        padding-top: 10px;
        border-top: 1px solid #334155;
    }

    .btn-act {
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.8rem;
        padding: 7px;
        text-align: center;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: 0.2s;
        border: none;
    }

    .btn-primary-act { background: #38bdf8; color: #0f172a; }
    .btn-primary-act:hover { background: #7dd3fc; }

    .btn-secondary-act { background: rgba(139, 92, 246, 0.15); color: #c084fc; border: 1px solid rgba(139, 92, 246, 0.3); }
    .btn-secondary-act:hover { background: #8b5cf6; color: white; }

    .btn-success-act { background: rgba(34, 197, 94, 0.15); color: #4ade80; border: 1px solid rgba(34, 197, 94, 0.3); }
    .btn-success-act:hover { background: #22c55e; color: #052e16; }

    .btn-danger-act { background: transparent; color: #f87171; border: 1px solid #f87171; }
    .btn-danger-act:hover { background: #ef4444; color: white; }
</style>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <h3 class="history-header mb-0">
            <i class="fa-solid fa-layer-group text-info me-2"></i> Riwayat Baca Berdasarkan Genre
        </h3>
    </div>

    @if(session('success'))
        <div class="alert alert-success bg-opacity-10 border-success text-success mb-4 rounded-3">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
        </div>
    @endif

    <!-- FILTER BAR GENRE -->
    <div class="filter-pills">
        <span class="text-secondary align-self-center me-2 fw-bold">Genre:</span>
        <a href="{{ route('reading.history', ['genre' => 'Semua', 'status' => $statusFilter]) }}" 
           class="btn-filter {{ $selectedGenre == 'Semua' ? 'active' : '' }}">Semua Genre</a>
        @foreach($availableGenres as $genreName)
            <a href="{{ route('reading.history', ['genre' => $genreName, 'status' => $statusFilter]) }}" 
               class="btn-filter {{ $selectedGenre == $genreName ? 'active' : '' }}">{{ $genreName }}</a>
        @endforeach
    </div>

    <!-- TAMPILAN KOSONG -->
    @if($groupedHistories->isEmpty())
        <div class="text-center py-5 background-dark rounded-4 border border-secondary border-dashed" style="background: #1e293b;">
            <i class="fa-solid fa-book-open fa-3x text-muted mb-3"></i>
            <h5 class="text-white fw-bold">Tidak ada riwayat baca</h5>
            <p class="text-secondary small">Belum ada buku dibaca pada genre ini.</p>
            <a href="{{ route('genre.index') }}" class="btn btn-primary-act d-inline-flex px-4 py-2 mt-2">Cari Buku</a>
        </div>
    @else
        <!-- LOOPING SETIAP GENRE -->
        @foreach($groupedHistories as $genre => $items)
            <div class="genre-section">
                <div class="genre-section-title">
                    <i class="fa-solid fa-bookmark text-warning"></i> Genre: {{ $genre }}
                    <span class="badge bg-secondary bg-opacity-25 text-light fs-6 fw-normal ms-auto">{{ $items->count() }} Buku</span>
                </div>

                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-4 mb-4">
                    @foreach($items as $history)
                        @php
                            $buku = $history->book;
                            $status = $history->status ?? 'Sedang Dibaca';
                            $percent = $history->progress_percentage ?? 0;
                            $hasResume = in_array($history->book_id, $resumesBookIds);
                        @endphp
                        <div class="col">
                            <div class="history-card">
                                
                               <div class="cover-wrapper">
    @php
        $rawPath = $buku->image_path ?? $buku->cover ?? $buku->gambar ?? $buku->image ?? null;
        $imageUrl = 'https://via.placeholder.com/300x400?text=No+Cover';

        if (!empty($rawPath)) {
            $fileName = basename($rawPath);

            // 1. Jika URL penuh (http:// atau https://)
            if (\Illuminate\Support\Str::startsWith($rawPath, ['http://', 'https://'])) {
                $imageUrl = $rawPath;
            } 
            // 2. Jika path tersimpan lengkap di public/ (seperti "uploads/cover/laskar-pelangi.jpg")
            elseif (file_exists(public_path($rawPath))) {
                $imageUrl = asset($rawPath);
            } 
            // 3. Jika nama filenya ada di folder public/uploads/cover/
            elseif (file_exists(public_path('uploads/cover/' . $fileName))) {
                $imageUrl = asset('uploads/cover/' . $fileName);
            }
            // 4. Jika nama filenya ada di public/uploads/
            elseif (file_exists(public_path('uploads/' . $fileName))) {
                $imageUrl = asset('uploads/' . $fileName);
            }
            // 5. Fallback ke storage/
            else {
                $cleanPath = str_replace(['public/', 'storage/'], '', ltrim($rawPath, '/'));
                $imageUrl = asset('storage/' . $cleanPath);
            }
        }
    @endphp

    <img src="{{ $imageUrl }}" 
         alt="{{ $buku->title ?? 'Cover Buku' }}"
         onerror="this.onerror=null; this.src='https://via.placeholder.com/300x400?text=No+Cover';">

    <span class="status-badge {{ $status == 'Selesai Dibaca' ? 'badge-selesai' : ($status == 'Sedang Dibaca' ? 'badge-sedang' : 'badge-belum') }}">
        {{ $status }}
    </span>
</div>

                                <div class="card-body">
                                    <h5 class="book-title" title="{{ $buku->title ?? '-' }}">{{ $buku->title ?? 'Judul Tidak Ada' }}</h5>
                                    <div class="meta-text"><i class="fa-solid fa-user me-1 text-info"></i> {{ $buku->author ?? '-' }}</div>
                                    <div class="meta-text"><i class="fa-regular fa-clock me-1 text-warning"></i> {{ $history->last_read_at ? $history->last_read_at->diffForHumans() : '-' }}</div>

                                    <div class="progress-wrapper">
                                        <div class="d-flex justify-content-between small text-white mb-1">
                                            <span>Hal {{ $history->progress }}</span>
                                            <span>{{ $percent }}%</span>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar bg-info" style="width: {{ $percent }}%"></div>
                                        </div>
                                    </div>

                                    <div class="card-actions">
                                        @if($buku)
                                            <a href="{{ route('book.show', ['id' => $buku->id, 'page' => $history->progress ?: 1]) }}" class="btn-act btn-primary-act">
                                                <i class="fa-solid fa-play"></i> Lanjutkan
                                            </a>
                                        @endif

                                        @if($hasResume)
                                            <a href="{{ route('resume.my') }}" class="btn-act btn-secondary-act">
                                                <i class="fa-solid fa-file-lines"></i> Lihat Resume
                                            </a>
                                        @else
                                            <a href="{{ route('resume.create', $history->book_id) }}" class="btn-act btn-secondary-act">
                                                <i class="fa-solid fa-pen"></i> Tulis Resume
                                            </a>
                                        @endif

                                        @if($status !== 'Selesai Dibaca')
                                            <form action="{{ route('reading.history.markFinished', $history->id) }}" method="POST" class="w-100">
                                                @csrf
                                                <button type="submit" class="btn-act btn-success-act w-100">
                                                    <i class="fa-solid fa-circle-check"></i> Selesai
                                                </button>
                                            </form>
                                        @endif

                                        <form action="{{ route('reading.history.delete', $history->id) }}" method="POST" class="w-100" onsubmit="return confirm('Hapus buku ini dari riwayat?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-act btn-danger-act w-100">
                                                <i class="fa-solid fa-trash-can"></i> Hapus
                                            </button>
                                        </form>
                                    </div>

                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    @endif

</div>

@endsection