
@extends('layouts.layoutsAdmin')
@section('title', 'Detail History Reward')
@section('content')
<link rel="stylesheet" href="{{ asset('css/admin-reward.css') }}">

<div class="ar-page">
    <a class="ar-back" href="{{ route('admin.rewards.index') }}">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Kelola Reward
    </a>

    <div class="ar-heading">
        <div>
            <span class="ar-kicker">
                <i class="fa-solid fa-clock-rotate-left"></i> SAFAE REWARD HISTORY
            </span>
            <h1>Detail <span>Reward</span></h1>
            <p>Riwayat transaksi poin pengguna <strong>{{ $user->username }}</strong>.</p>
        </div>
    </div>

    <div class="ar-stats three">
        <div class="ar-stat">
            <span class="ar-stat-icon gold"><i class="fa-solid fa-wallet"></i></span>
            <div>
                <small>Saldo Saat Ini · {{ $level }}</small>
                <strong>{{ number_format($user->points ?? 0, 0, ',', '.') }}</strong>
            </div>
        </div>
        <div class="ar-stat">
            <span class="ar-stat-icon green"><i class="fa-solid fa-arrow-trend-up"></i></span>
            <div>
                <small>Total Poin Masuk Tercatat</small>
                <strong>+{{ number_format($totalIn, 0, ',', '.') }}</strong>
            </div>
        </div>
        <div class="ar-stat">
            <span class="ar-stat-icon red"><i class="fa-solid fa-arrow-trend-down"></i></span>
            <div>
                <small>Total Poin Keluar Tercatat</small>
                <strong>-{{ number_format($totalOut, 0, ',', '.') }}</strong>
            </div>
        </div>
    </div>

    <section class="ar-panel">
        <div class="ar-panel-head">
            <div>
                <h2><i class="fa-solid fa-receipt"></i> Riwayat Transaksi</h2>
                <p>Catatan poin masuk, poin keluar, dan akses bab premium.</p>
            </div>
            <span class="ar-count">{{ $transactions->count() }} transaksi</span>
        </div>

        <div class="ar-transactions">
            @forelse($transactions as $item)
                @php
                    $direction = $item['points'] > 0
                        ? 'income'
                        : ($item['points'] < 0 ? 'expense' : 'neutral');
                    $icon = match($item['type']) {
                        'resume' => 'fa-book-open',
                        'admin_add' => 'fa-circle-plus',
                        'admin_remove' => 'fa-circle-minus',
                        'unlock' => 'fa-crown',
                        default => 'fa-receipt'
                    };
                @endphp
                <div class="ar-transaction">
                    <span class="ar-transaction-icon {{ $direction }}">
                        <i class="fa-solid {{ $icon }}"></i>
                    </span>
                    <div class="ar-transaction-info">
                        <h3>{{ $item['title'] }}</h3>
                        <p>{{ $item['description'] }}</p>
                        <small>{{ $item['date']?->format('d M Y, H:i') ?? '-' }}</small>
                    </div>
                    <strong class="ar-transaction-points {{ $direction }}">
                        {{ $item['points'] > 0 ? '+' : '' }}{{ number_format($item['points'], 0, ',', '.') }} poin
                    </strong>
                </div>
            @empty
                <div class="ar-empty">
                    <i class="fa-solid fa-inbox"></i>
                    <h3>Belum ada transaksi</h3>
                    <p>Belum ada riwayat poin untuk pengguna ini.</p>
                </div>
            @endforelse
        </div>
    </section>
</div>
@endsection
