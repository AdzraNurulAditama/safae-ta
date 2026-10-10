{{--
    Partial rekomendasi untuk dashboard user.
    Dipakai:  @include('partials.rekomendasi', ['rekomendasi' => $rekomendasi])
    Memakai kelas CSS yang sudah ada di user/dashboard.blade.php
    (glass-card-premium, card-header-premium, section-title-premium, promo-inner-card, promo-img-wrapper).
--}}
@if (!empty($rekomendasi) && $rekomendasi['books']->isNotEmpty())
<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="card glass-card-premium">
            <div class="card-header-premium">
                <h5 class="section-title-premium mb-0">
                    @if ($rekomendasi['sumber'] === 'model')
                        <i class="fas fa-wand-magic-sparkles text-info"></i> Rekomendasi untukmu
                    @else
                        <i class="fas fa-fire text-danger"></i> Buku populer untukmu
                    @endif
                </h5>
            </div>

            <div class="card-body p-4">
                <div class="row g-4">
                    @foreach ($rekomendasi['books'] as $book)
                        <div class="col-xl-3 col-md-6">
                            <a href="{{ route('book.show', $book->id) }}" class="text-decoration-none">
                                <div class="promo-inner-card">
                                    <div class="promo-img-wrapper">
                                        <img src="{{ $book->image_path ? asset($book->image_path) : 'https://via.placeholder.com/300x400?text=No+Cover' }}"
                                             alt="{{ $book->title }}">
                                    </div>
                                    <div class="p-3">
                                        <!-- Judul -->
                                        <h6 class="text-white fw-bold mb-1 small">{{ Str::limit($book->title, 40) }}</h6>
                                        
                                        <!-- Penulis dan Tahun -->
                                        <small class="text-secondary d-block mb-2" style="color: #94a3b8 !important;">
                                            {{ $book->author }} &bull; {{ $book->year }}
                                        </small>
                                        
                                        <!-- Deskripsi Singkat -->
                                        <p class="text-white-50 small mb-2" style="font-size: 0.8rem;">
                                            {{ Str::limit($book->description, 60) }}
                                        </p>

                                        <!-- Kumpulan Badge (Genre, Jenis Buku, Halaman, Premium) -->
                                        <div class="mt-2 d-flex flex-wrap gap-1">
                                            <span class="badge bg-info bg-opacity-25 text-info">{{ $book->genre }}</span>
                                            <span class="badge bg-secondary bg-opacity-25 text-light">{{ $book->jenis_buku }}</span>
                                            <span class="badge bg-secondary bg-opacity-25 text-light">{{ $book->jumlah_halaman }} hal</span>
                                            
                                            @if ($book->is_premium)
                                                <span class="badge bg-warning bg-opacity-25 text-warning">
                                                    <i class="fas fa-crown me-1"></i>Premium
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                @if ($rekomendasi['sumber'] === 'model')
                    <small class="text-secondary d-block mt-3" style="color: #94a3b8 !important;">
                        Dipilih berdasarkan kebiasaan membaca dan minatmu.
                    </small>
                @endif
            </div>
        </div>
    </div>
</div>
@endif  