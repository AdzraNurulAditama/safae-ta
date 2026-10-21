
@extends('layouts.app')
@section('title', 'Detail Reward')
@section('content')
<link rel="stylesheet" href="{{ asset('css/detail-reward.css') }}">

@php
    $levelColor = match($level) {
        'Diamond' => [
            'card' => '#533483',
            'border' => '#3C3489',
            'icon_bg' => 'rgba(175,169,236,0.18)',
            'icon' => '#AFA9EC',
            'label' => '#AFA9EC',
            'val' => '#EEEDFE',
            'meta' => '#AFA9EC'
        ],
        'Silver' => [
            'card' => '#185FA5',
            'border' => '#0C447C',
            'icon_bg' => 'rgba(181,212,244,0.18)',
            'icon' => '#85B7EB',
            'label' => '#85B7EB',
            'val' => '#E6F1FB',
            'meta' => '#85B7EB'
        ],
        default => [
            'card' => '#854F0B',
            'border' => '#633806',
            'icon_bg' => 'rgba(250,199,117,0.18)',
            'icon' => '#FAC775',
            'label' => '#FAC775',
            'val' => '#FAEEDA',
            'meta' => '#FAC775'
        ],
    };

    $transactionIcons = [
        'masuk' => 'fa-file-circle-check',
        'keluar' => 'fa-crown',
        'reward' => 'fa-gift'
    ];
@endphp

<div class="dr-container">
    {{-- TOMBOL KEMBALI --}}
    <a href="{{ route('reward.index') }}" class="btn-back">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Reward
    </a>

    {{-- HEADER --}}
    <div class="dr-heading">
        <div>
            <span class="dr-eyebrow">
                <i class="fa-solid fa-coins"></i> SAFAE REWARD
            </span>
            <h1>Detail <span>Reward</span></h1>
            <p>Lihat saldo poin, reward resume, dan seluruh riwayat transaksi kamu.</p>
        </div>
    </div>

    {{-- RINGKASAN POIN --}}
    <div class="dr-top">
        {{-- SALDO POIN --}}
        <div class="stat-card" style="background:{{ $levelColor['card'] }};border-color:{{ $levelColor['border'] }};">
            <div class="sc-icon" style="background:{{ $levelColor['icon_bg'] }};">
                <i class="fa-solid fa-coins" style="color:{{ $levelColor['icon'] }};"></i>
            </div>
            <div class="sc-label" style="color:{{ $levelColor['label'] }};">
                Saldo Poin Saat Ini
            </div>
            <div class="sc-val" style="color:{{ $levelColor['val'] }};">
                {{ number_format($user->points, 0, ',', '.') }}
            </div>
            <div class="sc-meta" style="color:{{ $levelColor['meta'] }};">
                {{ $user->username }} · {{ $level }} Member
            </div>
        </div>

        {{-- POIN MASUK --}}
        <div class="stat-card stat-income">
            <div class="sc-icon">
                <i class="fa-solid fa-circle-plus"></i>
            </div>
            <div class="sc-label">Poin Masuk Tercatat</div>
            <div class="sc-val">
                +{{ number_format($totalMasuk, 0, ',', '.') }}
            </div>
            <div class="sc-meta">Reward dari resume buku</div>
        </div>

        {{-- POIN KELUAR --}}
        <div class="stat-card stat-expense">
            <div class="sc-icon">
                <i class="fa-solid fa-crown"></i>
            </div>
            <div class="sc-label">Poin Keluar Tercatat</div>
            <div class="sc-val">
                -{{ number_format($totalKeluar, 0, ',', '.') }}
            </div>
            <div class="sc-meta">Pembukaan bab premium</div>
        </div>

        {{-- TOTAL TRANSAKSI --}}
        <div class="stat-card stat-transactions">
            <div class="sc-icon">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
            <div class="sc-label">Total Transaksi</div>
            <div class="sc-val">
                {{ number_format($totalTransaksi, 0, ',', '.') }}
            </div>
            <div class="sc-meta">Aktivitas yang tercatat</div>
        </div>
    </div>

    {{-- HISTORY TRANSAKSI --}}
    <div class="rw-card">
        <div class="rw-card-header">
            <div class="rw-card-heading">
                <div class="rw-card-title">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    History Transaksi Poin
                </div>
                <p>Riwayat reward resume, penggunaan poin, dan penukaran reward.</p>
            </div>
            <span class="rw-count">
                {{ $totalTransaksi }} transaksi
            </span>
        </div>

        {{-- KETERANGAN TRANSAKSI --}}
        <div class="rw-legend">
            <span>
                <i class="fa-solid fa-circle legend-income"></i>
                Poin Masuk
            </span>
            <span>
                <i class="fa-solid fa-circle legend-expense"></i>
                Poin Keluar
            </span>
            <span>
                <i class="fa-solid fa-circle legend-reward"></i>
                Penukaran Reward
            </span>
        </div>

        {{-- DAFTAR TRANSAKSI --}}
        <div class="rw-list">
            @forelse($transaksi as $item)
                @php
                    $jenis = $item['jenis'];
                    $icon = $transactionIcons[$jenis] ?? 'fa-receipt';
                    $status = strtolower($item['status'] ?? 'berhasil');

                    $badgeClass = match($status) {
                        'berhasil', 'sukses', 'success' => 'badge-success',
                        'diproses', 'pending' => 'badge-pending',
                        default => 'badge-gagal'
                    };

                    $badgeIcon = match($status) {
                        'berhasil', 'sukses', 'success' => 'fa-check',
                        'diproses', 'pending' => 'fa-clock',
                        default => 'fa-xmark'
                    };
                @endphp

                <div class="rw-item">
                    {{-- ICON TRANSAKSI --}}
                    <div class="rw-dot {{ $jenis }}">
                        <i class="fa-solid {{ $icon }}"></i>
                    </div>

                    {{-- INFORMASI TRANSAKSI --}}
                    <div class="rw-info">
                        <div class="rw-name">
                            {{ $item['judul'] }}
                        </div>
                        <div class="rw-description">
                            {{ $item['deskripsi'] }}
                        </div>
                        <div class="rw-date">
                            <i class="fa-regular fa-clock"></i>
                            {{ $item['tanggal'] ? $item['tanggal']->format('d M Y, H:i') : '-' }}
                        </div>
                    </div>

                    {{-- JUMLAH POIN DAN STATUS --}}
                    <div class="rw-transaction-right">
                        @if($jenis === 'masuk')
                            <div class="rw-points points-income">
                                <i class="fa-solid fa-plus"></i>
                                {{ number_format($item['poin'], 0, ',', '.') }} Poin
                            </div>
                        @elseif($jenis === 'keluar')
                            <div class="rw-points points-expense">
                                <i class="fa-solid fa-minus"></i>
                                {{ number_format($item['poin'], 0, ',', '.') }} Poin
                            </div>
                        @else
                            <div class="rw-points points-reward">
                                <i class="fa-solid fa-gift"></i>
                                Penukaran Reward
                            </div>
                        @endif

                        <span class="badge-status {{ $badgeClass }}">
                            <i class="fa-solid {{ $badgeIcon }}"></i>
                            {{ $item['status'] }}
                        </span>
                    </div>
                </div>
            @empty
                {{-- BELUM ADA TRANSAKSI --}}
                <div class="rw-empty">
                    <div class="rw-empty-icon">
                        <i class="fa-solid fa-box-open"></i>
                    </div>
                    <p class="rw-empty-text">Belum ada history transaksi poin.</p>
                    <small>
                        Transaksi akan muncul setelah kamu mendapatkan
                        atau menggunakan poin.
                    </small>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
