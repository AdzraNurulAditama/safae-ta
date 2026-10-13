@extends('layouts.app')

@section('title', 'Statistik Membaca Saya - Safae')

@section('content')

<style>
    .stats-page-wrapper {
        padding: 10px 0 50px 0;
        color: #f1f5f9;
    }

    .dark-panel {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 20px;
        padding: 22px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        height: 100%;
    }

    .header-title {
        font-size: 1.8rem;
        font-weight: 800;
        color: #f8fafc;
    }

    /* Top Metric Cards */
    .metric-card {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 18px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        transition: transform 0.2s ease, border-color 0.2s ease;
    }

    .metric-card:hover {
        transform: translateY(-3px);
        border-color: #38bdf8;
    }

    .metric-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
    }

    .icon-blue { background: rgba(56, 189, 248, 0.15); color: #38bdf8; }
    .icon-green { background: rgba(34, 197, 94, 0.15); color: #4ade80; }
    .icon-cyan { background: rgba(6, 182, 212, 0.15); color: #22d3ee; }
    .icon-purple { background: rgba(168, 85, 247, 0.15); color: #c084fc; }

    /* Calendar Styling */
    .cal-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 8px;
        text-align: center;
        margin-top: 15px;
    }
    .cal-day-header {
        font-size: 0.75rem;
        color: #64748b;
        font-weight: 700;
    }
    .cal-date {
        padding: 8px 4px;
        font-size: 0.85rem;
        border-radius: 10px;
        color: #94a3b8;
        position: relative;
    }
    .cal-date.active-read::after {
        content: '';
        position: absolute;
        bottom: 3px;
        left: 50%;
        transform: translateX(-50%);
        width: 4px;
        height: 4px;
        background: #38bdf8;
        border-radius: 50%;
    }
    .cal-date.active-resume::after {
        content: '';
        position: absolute;
        bottom: 3px;
        left: 50%;
        transform: translateX(-50%);
        width: 4px;
        height: 4px;
        background: #a855f7;
        border-radius: 50%;
    }
    .cal-date.today {
        border: 1px solid #38bdf8;
        color: #38bdf8;
        font-weight: 800;
    }

    /* Target Widget Styling */
    .target-circle-wrapper {
        position: relative;
        width: 120px;
        height: 120px;
        margin: 0 auto 15px auto;
    }
    .target-circle-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-weight: 800;
        font-size: 1.25rem;
        color: #ffffff;
    }

    .quote-box {
        background: #0f172a;
        border: 1px solid #334155;
        border-radius: 14px;
        padding: 12px 16px;
        text-align: center;
        font-style: italic;
        font-size: 0.85rem;
        color: #94a3b8;
    }

    /* Modal Styling */
    .modal-dark .modal-content {
        background: #1e293b;
        border: 1px solid #334155;
        color: white;
        border-radius: 20px;
    }
    .modal-dark .form-control, .modal-dark .form-select {
        background: #0f172a;
        border: 1px solid #334155;
        color: white;
        border-radius: 12px;
    }

    .btn-catat {
        background: #38bdf8;
        color: #0f172a;
        font-weight: 700;
        padding: 10px 20px;
        border-radius: 14px;
        border: none;
        transition: 0.3s;
    }
    .btn-catat:hover { background: #7dd3fc; }
</style>

<div class="stats-page-wrapper">
    <div class="container-fluid">

        <!-- HEADER & AKSI -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div>
                <h2 class="header-title mb-1"><i class="fa-solid fa-chart-line text-info me-2"></i> Statistik Membaca Saya</h2>
                <p class="text-secondary small mb-0">Pantau kebiasaan, progres, dan pemahaman bacaanmu.</p>
            </div>
            
            <div class="d-flex gap-2">
                <button class="btn btn-outline-info rounded-3" data-bs-toggle="modal" data-bs-target="#modalTarget">
                    <i class="fa-solid fa-flag me-1"></i> Atur Target
                </button>
                <button class="btn-catat" data-bs-toggle="modal" data-bs-target="#modalCatatAktivitas">
                    <i class="fa-solid fa-plus me-1"></i> Catat Aktivitas
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success bg-opacity-10 border-success text-success mb-4 rounded-3">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            </div>
        @endif

        <!-- 1. KARTU METRIK UTAMA -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-lg-3">
                <div class="metric-card">
                    <div class="metric-icon icon-blue"><i class="fa-solid fa-book-open"></i></div>
                    <div>
                        <small class="text-secondary d-block">Buku Dibaca</small>
                        <h3 class="fw-bold mb-0 text-white">{{ $totalDibaca }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="metric-card">
                    <div class="metric-icon icon-green"><i class="fa-solid fa-circle-check"></i></div>
                    <div>
                        <small class="text-secondary d-block">Selesai Dibaca</small>
                        <h3 class="fw-bold mb-0 text-white">{{ $totalSelesai }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="metric-card">
                    <div class="metric-icon icon-cyan"><i class="fa-regular fa-clock"></i></div>
                    <div>
                        <small class="text-secondary d-block">Waktu Membaca</small>
                        <h3 class="fw-bold mb-0 text-white">{{ $waktuMembacaFormatted }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="metric-card">
                    <div class="metric-icon icon-purple"><i class="fa-solid fa-file-lines"></i></div>
                    <div>
                        <small class="text-secondary d-block">Resume Dibuat</small>
                        <h3 class="fw-bold mb-0 text-white">{{ $totalResume }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. KALENDER & KONSISTENSI MEMBACA -->
        <div class="row g-4 mb-4">
            <!-- KALENDER MEMBACA -->
            <div class="col-lg-6">
                <div class="dark-panel">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="fw-bold text-white mb-0"><i class="fa-solid fa-calendar-days text-info me-2"></i> Kalender Membaca</h5>
                        <!-- DISPLAY BULAN & TAHUN -->
                        <span class="badge bg-secondary bg-opacity-25 text-info px-3 py-2 rounded-3 fw-bold fs-6">
                            {{ $namaBulanTahun }}
                        </span>
                    </div>

                    <div class="cal-grid">
                        <div class="cal-day-header">Sen</div><div class="cal-day-header">Sel</div><div class="cal-day-header">Rab</div>
                        <div class="cal-day-header">Kam</div><div class="cal-day-header">Jum</div><div class="cal-day-header">Sab</div><div class="cal-day-header">Min</div>
                        
                        @for($i = 1; $i <= \Carbon\Carbon::now()->daysInMonth; $i++)
                            @php
                                $dateCheck = \Carbon\Carbon::now()->format('Y-m-').sprintf('%02d', $i);
                                $isRead = in_array($dateCheck, $datesRead);
                                $isResume = in_array($dateCheck, $datesResume);
                                $isToday = ($i == \Carbon\Carbon::now()->day);
                            @endphp
                            <div class="cal-date {{ $isToday ? 'today' : '' }} {{ $isRead ? 'active-read' : '' }} {{ $isResume ? 'active-resume' : '' }}">
                                {{ $i }}
                            </div>
                        @endfor
                    </div>
                    <div class="d-flex gap-3 mt-4 small text-secondary justify-content-center">
                        <span><i class="fa-solid fa-circle text-info me-1"></i> Membaca</span>
                        <span><i class="fa-solid fa-circle text-purple me-1"></i> Resume Dibuat</span>
                    </div>
                </div>
            </div>

            <!-- GRAFIK KONSISTENSI MEMBACA -->
            <div class="col-lg-6">
                <div class="dark-panel">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold text-white mb-0"><i class="fa-solid fa-bullseye text-warning me-2"></i> Konsistensi Membaca</h5>
                        <span class="badge bg-warning bg-opacity-25 text-warning"><i class="fa-solid fa-fire me-1"></i> {{ $activeDaysThisWeek }} Hari Beruntun</span>
                    </div>
                    <canvas id="consistencyChart" style="max-height: 200px;"></canvas>
                    <div class="mt-3">
                        <small class="text-secondary d-block mb-1">Target {{ $activeDaysThisWeek }}/5 hari/minggu</small>
                        <div class="progress" style="height: 8px; background: #0f172a;">
                            <div class="progress-bar bg-info" style="width: {{ min(($activeDaysThisWeek/5)*100, 100) }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. PERKEMBANGAN LITERASI, AKTIVITAS TERBARU & TARGET BULAN INI -->
        <div class="row g-4">
            <!-- INDIKATOR PERKEMBANGAN LITERASI -->
            <div class="col-lg-5">
                <div class="dark-panel">
                    <h5 class="fw-bold text-white mb-3"><i class="fa-solid fa-brain text-purple me-2"></i> Perkembangan Literasi</h5>
                    <div class="row g-3">
                        <div class="col-4">
                            <div class="p-3 rounded-4 bg-dark bg-opacity-50 border border-secondary border-opacity-25 text-center">
                                <small class="text-secondary d-block">Pemahaman</small>
                                <h4 class="fw-bold text-info my-1">{{ $pemahamanSkor }}/100</h4>
                                <small class="text-success" style="font-size: 0.7rem;">↑ +8 poin</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-3 rounded-4 bg-dark bg-opacity-50 border border-secondary border-opacity-25 text-center">
                                <small class="text-secondary d-block">Konsistensi</small>
                                <h4 class="fw-bold text-warning my-1">{{ $konsistensiSkor }}</h4>
                                <small class="text-success" style="font-size: 0.7rem;">↑ +1 hari</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-3 rounded-4 bg-dark bg-opacity-50 border border-secondary border-opacity-25 text-center">
                                <small class="text-secondary d-block">Kualitas Resume</small>
                                <h4 class="fw-bold text-purple my-1">{{ $kualitasResumeSkor }}/5</h4>
                                <small class="text-success" style="font-size: 0.7rem;">↑ +0.6</small>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 small text-secondary">
                        <i class="fa-solid fa-info-circle me-1"></i> Berdasarkan penilaian refleksi resume dan statistik sesi membaca mingguan.
                    </div>
                </div>
            </div>

            <!-- AKTIVITAS TERBARU -->
            <div class="col-lg-4">
                <div class="dark-panel">
                    <h5 class="fw-bold text-white mb-3"><i class="fa-solid fa-clock-rotate-left text-info me-2"></i> Aktivitas Terbaru</h5>
                    @forelse($recentActivities as $act)
                        <div class="d-flex align-items-center gap-3 mb-3 pb-2 border-bottom border-secondary border-opacity-25">
                            <img src="{{ $act->book && $act->book->image_path ? asset($act->book->image_path) : 'https://via.placeholder.com/150' }}" width="40" height="55" class="rounded-2" style="object-fit:cover;">
                            <div class="w-100">
                                <div class="fw-bold text-white small">{{ $act->book->title ?? '-' }}</div>
                                <small class="text-secondary d-block" style="font-size: 0.75rem;">
                                    Hal {{ $act->progress }} &bull; {{ $act->status }}
                                </small>
                            </div>
                        </div>
                    @empty
                        <p class="text-secondary small">Belum ada aktivitas terbaru.</p>
                    @endforelse
                </div>
            </div>

            <!-- WIDGET TARGET BULAN INI (SESUAI DESAIN MOCKUP) -->
            <div class="col-lg-3">
                <div class="dark-panel text-center">
                    <h5 class="fw-bold text-white mb-3 text-start">
                        <i class="fa-solid fa-flag text-info me-2"></i> Target Bulan Ini
                    </h5>

                    <!-- CIRCLE PROGRESS -->
                    <div class="target-circle-wrapper">
                        <svg width="120" height="120">
                            <circle cx="60" cy="60" r="50" stroke="#0f172a" stroke-width="10" fill="none"/>
                            <circle cx="60" cy="60" r="50" stroke="#38bdf8" stroke-width="10" fill="none"
                                    stroke-dasharray="314" stroke-dashoffset="{{ 314 - (314 * $persenTarget / 100) }}"
                                    stroke-linecap="round" transform="rotate(-90 60 60)"/>
                        </svg>
                        <div class="target-circle-text">
                            {{ $progressTarget }}<span class="fs-6 text-secondary">/{{ $targetBuku }}</span>
                        </div>
                    </div>

                    <p class="text-white small fw-bold mb-2">{{ $progressTarget }} dari {{ $targetBuku }} buku selesai</p>

                    <div class="progress mb-3" style="height: 8px; background: #0f172a;">
                        <div class="progress-bar bg-info" style="width: {{ $persenTarget }}%"></div>
                    </div>

                    <div class="d-flex justify-content-between small text-secondary mb-3">
                        <span><i class="fa-regular fa-calendar me-1"></i> Sisa hari</span>
                        <span class="text-white fw-bold">{{ $sisaHari }} hari</span>
                    </div>

                    <div class="quote-box">
                        "Sedikit demi sedikit, lama-lama jadi bukit."
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<!-- MODAL ATUR TARGET BULANAN -->
<div class="modal fade modal-dark" id="modalTarget" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-secondary border-opacity-25">
                <h5 class="modal-title fw-bold text-white"><i class="fa-solid fa-flag text-info me-2"></i> Atur Target Membaca Bulanan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('reading.statistics.target') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small text-secondary">Target Jumlah Buku Selesai Bulan Ini</label>
                        <input type="number" name="target_buku" class="form-control" value="{{ $targetBuku }}" min="1" max="100" required>
                    </div>
                </div>
                <div class="modal-footer border-secondary border-opacity-25">
                    <button type="submit" class="btn-catat w-100">Simpan Target</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL POP-UP CATAT AKTIVITAS MEMBACA -->
<div class="modal fade modal-dark" id="modalCatatAktivitas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-secondary border-opacity-25">
                <h5 class="modal-title fw-bold text-white"><i class="fa-solid fa-plus-circle text-info me-2"></i> Catat Sesi Membaca</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('reading.statistics.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small text-secondary">Pilih Buku</label>
                        <select name="book_id" class="form-select" required>
                            <option value="">-- Pilih Buku yang Dibaca --</option>
                            @foreach($userBooks as $b)
                                <option value="{{ $b->id }}">{{ $b->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-secondary">Durasi Membaca (Menit)</label>
                        <input type="number" name="duration_minutes" class="form-control" placeholder="Contoh: 30" required min="1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-secondary">Halaman Terakhir Dibaca</label>
                        <input type="number" name="pages_read" class="form-control" placeholder="Contoh: 45">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-secondary">Tanggal Membaca</label>
                        <input type="date" name="read_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
                <div class="modal-footer border-secondary border-opacity-25">
                    <button type="submit" class="btn-catat w-100">Simpan Aktivitas</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- SCRIPT CHART.JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById('consistencyChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($last7DaysLabels) !!},
                datasets: [{
                    label: 'Sesi Membaca',
                    data: {!! json_encode($last7DaysData) !!},
                    backgroundColor: '#38bdf8',
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    x: { ticks: { color: '#94a3b8' }, grid: { display: false } },
                    y: { ticks: { color: '#94a3b8' }, grid: { color: '#334155' } }
                }
            }
        });
    });
</script>

@endsection