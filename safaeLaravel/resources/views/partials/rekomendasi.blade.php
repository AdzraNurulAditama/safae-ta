{{--
    Partial rekomendasi untuk dashboard user.
    Dipakai:  @include('partials.rekomendasi', ['rekomendasi' => $rekomendasi])
    Wadah luar memakai kelas yang sudah ada di user/dashboard.blade.php
    (glass-card-premium, card-header-premium, section-title-premium).
    Isi kartu memakai kelas sendiri berawalan "rk-" supaya tidak bentrok.
--}}
@if (!empty($rekomendasi) && $rekomendasi['books']->isNotEmpty())
<style>
    /* Grid Layout */
    .rk-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 28px 20px;
    }

    /* Card Wrapper */
    .rk-card {
        display: flex;
        flex-direction: column;
        text-decoration: none;
        color: inherit;
        position: relative;
    }
    
    /* Cover Image Container */
    .rk-cover {
        position: relative;
        aspect-ratio: 2 / 3; /* Rasio buku standar yang lebih proporsional */
        border-radius: 12px;
        overflow: hidden;
        background: #1e293b;
        border: 1px solid rgba(255, 255, 255, 0.05);
        box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.4);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .rk-card:hover .rk-cover {
        transform: translateY(-8px);
        box-shadow: 0 20px 25px -5px rgba(56, 189, 248, 0.15), 0 8px 10px -6px rgba(56, 189, 248, 0.1);
        border-color: rgba(56, 189, 248, 0.4);
    }

    /* Image Styling */
    .rk-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .rk-card:hover .rk-cover img { 
        transform: scale(1.08); 
    }

    /* Fallback Cover */
    .rk-fallback {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3.5rem;
        font-weight: 800;
        color: rgba(255, 255, 255, 0.9);
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        position: relative;
    }
    .rk-fallback::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(56, 189, 248, 0.2), rgba(139, 92, 246, 0.2));
    }

    /* Hover Overlay & Action Button */
    .rk-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(15, 23, 42, 0.95) 0%, transparent 60%);
        opacity: 0;
        transition: opacity 0.3s ease;
        display: flex;
        align-items: flex-end;
        padding: 15px;
    }
    .rk-card:hover .rk-overlay {
        opacity: 1;
    }
    .rk-read-btn {
        width: 100%;
        background: #38bdf8;
        color: #0f172a;
        text-align: center;
        padding: 8px 0;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 700;
        transform: translateY(15px);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 12px rgba(56, 189, 248, 0.3);
    }
    .rk-card:hover .rk-read-btn {
        transform: translateY(0);
    }

    /* Premium Badge (Glassmorphism) */
    .rk-premium {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border: 1px solid rgba(251, 191, 36, 0.3);
        color: #fbbf24;
        border-radius: 20px;
        padding: 4px 10px;
        font-size: 0.7rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 4px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        z-index: 2;
    }

    /* Text Typography */
    .rk-info {
        padding-top: 12px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .rk-title {
        font-size: 0.95rem;
        font-weight: 700;
        line-height: 1.4;
        color: #f8fafc;
        margin-bottom: 4px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        transition: color 0.2s ease;
    }
    .rk-card:hover .rk-title {
        color: #38bdf8;
    }
    .rk-author {
        font-size: 0.8rem;
        color: #94a3b8;
        font-weight: 500;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 8px;
    }

    /* Genre Chip */
    .rk-chip-wrapper {
        margin-top: auto;
    }
    .rk-chip {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 6px;
        font-size: 0.7rem;
        font-weight: 600;
        background: rgba(51, 65, 85, 0.5);
        color: #cbd5e1;
        border: 1px solid rgba(71, 85, 105, 0.4);
        transition: all 0.2s ease;
    }
    .rk-card:hover .rk-chip {
        background: rgba(56, 189, 248, 0.15);
        color: #38bdf8;
        border-color: rgba(56, 189, 248, 0.3);
    }

    /* Header Subtitle */
    .rk-sub {
        font-size: 0.85rem;
        color: #94a3b8;
        margin: 6px 0 0;
        font-weight: 400;
    }
</style>

<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="card glass-card-premium">
            <div class="card-header-premium p-4 border-bottom border-secondary" style="border-color: rgba(255,255,255,0.05) !important;">
                <h5 class="section-title-premium mb-0 d-flex align-items-center gap-2">
                    @if ($rekomendasi['sumber'] === 'model')
                        <span class="p-2 rounded-circle bg-info bg-opacity-10">
                            <i class="fas fa-wand-magic-sparkles text-info"></i>
                        </span> 
                        Rekomendasi untukmu
                    @else
                        <span class="p-2 rounded-circle bg-danger bg-opacity-10">
                            <i class="fas fa-fire text-danger"></i>
                        </span> 
                        Buku populer untukmu
                    @endif
                </h5>
                <p class="rk-sub ms-1">
                    @if ($rekomendasi['sumber'] === 'model')
                        Disesuaikan khusus berdasarkan riwayat dan minat bacamu.
                    @else
                        Deretan buku dengan pembaca terbanyak di Safae saat ini.
                    @endif
                </p>
            </div>

            <div class="card-body p-4">
                <div class="rk-grid">
                    @foreach ($rekomendasi['books'] as $book)
                        @php
                            $cover = $book->image_path ?: $book->cover_image;
                        @endphp
                        <a href="{{ route('fullbacaan.show', $book->id) }}" class="rk-card">
                            <div class="rk-cover">
                                @if ($cover)
                                    <img src="{{ asset($cover) }}" alt="{{ $book->title }}" loading="lazy">
                                @else
                                    <div class="rk-fallback">{{ Str::upper(Str::substr($book->title, 0, 1)) }}</div>
                                @endif

                                @if ($book->is_premium)
                                    <span class="rk-premium">
                                        <i class="fas fa-crown"></i> Premium
                                    </span>
                                @endif
                                
                                {{-- Hover Overlay Button Baru --}}
                                <div class="rk-overlay">
                                    <div class="rk-read-btn">Mulai Baca</div>
                                </div>
                            </div>

                            <div class="rk-info">
                                <div class="rk-title">{{ $book->title }}</div>
                                <div class="rk-author"><i class="fas fa-pen-nib ms-1 me-1" style="font-size: 0.7rem"></i> {{ $book->author }}</div>
                                @if ($book->genre)
                                    <div class="rk-chip-wrapper">
                                        <span class="rk-chip">{{ $book->genre }}</span>
                                    </div>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif  