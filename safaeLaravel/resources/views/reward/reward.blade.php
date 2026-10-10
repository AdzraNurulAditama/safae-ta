@extends('layouts.app')

@section('title', 'Reward & Leaderboard')

@section('content')
<link rel="stylesheet" href="{{ asset('css/favorite.css') }}">
<link rel="stylesheet" href="{{ asset('css/reward.css') }}">

<div class="container-fluid px-0" style="max-width: 1300px;">

    {{-- ================= HEADER UTAMA HALAMAN ================= --}}
    <div class="mb-4">
        <h3 class="favorite-header mb-1 text-white">
            <i class="fa-solid fa-trophy text-warning me-2"></i> Poin & Peringkat Membaca
        </h3>
        <p class="text-white small mb-0" style="opacity: 0.75; font-size: 0.9rem;">Pantau perolehan poin membaca kamu dan lihat posisi kamu di papan peringkat komunitas Safae.</p>
    </div>

    {{-- ================= LAYOUT WRAPPER GRID SYSTEM ================= --}}
    <div class="row g-4">
        
        {{-- KIRI: USER POINT CARD --}}
        @if($currentUser)
            <div class="col-12 col-lg-4">
                <div class="card p-4 h-100 shadow-sm d-flex flex-column justify-content-between" 
                     style="background: #1e293b; border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 14px;">
                    
                    <div>
                        {{-- Sektor Profil Atas --}}
                        <div class="d-flex align-items-center gap-3 mb-3">
                            @if(Auth::user()->foto_profil)
                                <img src="{{ asset('storage/' . Auth::user()->foto_profil) }}"
                                     class="rounded-circle border border-secondary" width="54" height="54" style="object-fit:cover; flex-shrink:0;">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->username }}&background=06B6D4&color=0b0f19"
                                     class="rounded-circle border border-secondary" width="54" height="54" style="object-fit:cover; flex-shrink:0;">
                            @endif
                            
                            <div class="text-truncate">
                                <h4 class="text-white fw-bold m-0 text-truncate" style="font-size: 1.15rem;">{{ $currentUser->username }}</h4>
                                <span class="badge mt-1" style="background: rgba(6, 182, 212, 0.12); color: #22d3ee; border: 1px solid rgba(6, 182, 212, 0.2); font-size: 0.75rem; font-weight: 600;">
                                    <i class="fa-solid fa-id-badge me-1" style="font-size: 0.7rem;"></i> {{ $level }} Member
                                </span>
                            </div>
                        </div>

                        {{-- Garis Pembatas Tipis --}}
                        <div style="height: 1px; background: rgba(255, 255, 255, 0.06); margin: 20px 0;"></div>

                        {{-- Sektor Display Nilai Poin Utama --}}
                        <div class="d-flex align-items-center gap-3 px-3 py-3 rounded-3" style="background: rgba(11, 15, 25, 0.3); border: 1px solid rgba(255,255,255,0.02);">
                            <div class="d-flex align-items-center justify-content-center text-warning" 
                                 style="width: 44px; height: 44px; background: rgba(245, 158, 11, 0.08); border: 1px solid rgba(245, 158, 11, 0.15); border-radius: 10px; font-size: 1.2rem;">
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <div>
                                <div class="font-monospace text-white fw-bold" style="font-size: 1.6rem; line-height: 1.1;">
                                    {{ number_format($currentUser->points) }}
                                </div>
                                <div class="text-white-50 small text-uppercase tracking-wider font-monospace" style="font-size: 0.7rem; opacity: 0.6; letter-spacing: 0.5px;">Total Poin Reward</div>
                            </div>
                        </div>
                    </div>

                    {{-- Kelompok Tombol Kontrol Aksi --}}
                    <div class="d-flex flex-column gap-2 mt-4">
                        <a href="{{ route('premium.books') }}" class="btn btn-sm text-center fw-bold d-flex align-items-center justify-content-center gap-2 py-2.5" 
                           style="background: linear-gradient(135deg, #06b6d4, #0891b2); color: #0b0f19; border: none; border-radius: 8px; font-size: 0.88rem;">
                            <i class="fa-solid fa-gift"></i> Tukarkan Poin
                        </a>
                        <a href="{{ route('reward.detail') }}" class="btn btn-sm text-center fw-bold d-flex align-items-center justify-content-center gap-2 py-2.5" 
                           style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); color: #fff; border-radius: 8px; font-size: 0.88rem;">
                            <i class="fa-solid fa-chart-simple opacity-70"></i> Detail Reward
                        </a>
                    </div>

                </div>
            </div>
        @endif

        {{-- KANAN: LEADERBOARD BOARD --}}
        <div class="col-12 col-lg-8">
            <div class="card p-4 shadow-sm" style="background: #1e293b; border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 14px;">
                
                {{-- Header Sub-Card --}}
                <div class="d-flex align-items-center gap-2 mb-4">
                    <i class="fa-solid fa-medal text-warning fs-5"></i>
                    <h5 class="m-0 text-white fw-bold" style="font-size: 1.1rem;">Peringkat Teratas Komunitas</h5>
                </div>

                {{-- PODIUM TOP THREE (Peringkat 1, 2, 3) --}}
                <div class="row g-3 mb-4 justify-content-center">
                    @foreach($ranking->take(3) as $index => $user)
                        <div class="col-12 col-sm-4">
                            <div class="text-center p-3 rounded-3 position-relative" 
                                 style="background: rgba(11, 15, 25, 0.4); border: 1px solid rgba(255,255,255,0.03); overflow: hidden;">
                                
                                {{-- Medali Rank Badge Indikator --}}
                                <span class="position-absolute top-0 start-0 m-2 font-monospace fw-bold rounded-circle d-flex align-items-center justify-content-center shadow-sm" 
                                      style="width: 24px; height: 24px; font-size: 0.75rem; 
                                             {{ $index == 0 ? 'background:#f59e0b; color:#0f172a;' : ($index == 1 ? 'background:#94a3b8; color:#0f172a;' : 'background:#b45309; color:#fff;') }}">
                                    {{ $index + 1 }}
                                </span>

                                {{-- Avatar Melingkar --}}
                                <div class="d-flex justify-content-center mb-2">
                                    @if($user->foto_profil)
                                        <img src="{{ asset('storage/' . $user->foto_profil) }}"
                                             class="rounded-circle border" width="48" height="48" style="object-fit:cover;">
                                    @else
                                        <div class="rounded-circle border bg-secondary text-white fw-bold d-flex align-items-center justify-content-center text-uppercase font-monospace" 
                                             style="width: 48px; height: 48px; font-size: 0.85rem; background: rgba(255,255,255,0.05) !important; border-color: rgba(255,255,255,0.1) !important;">
                                            {{ substr($user->username, 0, 2) }}
                                        </div>
                                    @endif
                                </div>

                                {{-- Identitas Pengguna podium --}}
                                <div class="fw-bold text-white text-truncate small px-1" title="{{ $user->username }}">{{ $user->username }}</div>
                                <div class="text-warning font-monospace small fw-bold mt-1" style="font-size: 0.8rem;">
                                    <i class="fa-solid fa-star" style="font-size: 0.65rem;"></i> {{ number_format($user->points) }} pts
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- SUB-LIST RINGKASAN DATA PERINGKAT 4++ --}}
                <div class="d-flex flex-column gap-2" style="max-height: 320px; overflow-y: auto; padding-right: 4px;">
                    @foreach($ranking->skip(3) as $index => $user)
                        <div class="d-flex align-items-center justify-content-between p-2.5 rounded-3" 
                             style="background: rgba(11, 15, 25, 0.2); border: 1px solid rgba(255,255,255,0.01);">
                            
                            <div class="d-flex align-items-center gap-3 min-width-0">
                                {{-- Nomor Urut Urutan --}}
                                <span class="font-monospace text-white-50 fw-semibold text-center" style="width: 25px; font-size: 0.85rem;">
                                    #{{ $index + 4 }}
                                </span>
                                
                                {{-- Mini Avatar Ringkas --}}
                                @if($user->foto_profil)
                                    <img src="{{ asset('storage/' . $user->foto_profil) }}"
                                         class="rounded-circle border" width="30" height="30" style="object-fit:cover; flex-shrink:0;">
                                @else
                                    <div class="rounded-circle border text-white-50 fw-bold d-flex align-items-center justify-content-center text-uppercase font-monospace" 
                                         style="width: 30px; height: 30px; font-size: 0.72rem; background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.06);">
                                        {{ substr($user->username, 0, 2) }}
                                    </div>
                                @endif
                                
                                {{-- Nama Akun --}}
                                <span class="text-white small fw-medium text-truncate">{{ $user->username }}</span>
                            </div>

                            {{-- Poin Perolehan --}}
                            <span class="text-white-50 font-monospace small" style="font-size: 0.82rem; opacity: 0.8;">
                                <strong>{{ number_format($user->points) }}</strong> <span style="font-size:0.75rem;">pts</span>
                            </span>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>

    </div>
</div>
@endsection