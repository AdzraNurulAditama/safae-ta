
@extends('layouts.layoutsAdmin')
@section('title', 'Kelola Reward')
@section('content')
<link rel="stylesheet" href="{{ asset('css/admin-reward.css') }}">

<div class="ar-page">
    <div class="ar-heading">
        <div>
            <span class="ar-kicker">
                <i class="fa-solid fa-gem"></i> SAFAE REWARD MANAGEMENT
            </span>
            <h1>Kelola <span>Reward</span></h1>
            <p>Atur saldo poin dan pantau aktivitas reward pengguna Safae.</p>
        </div>
        <div class="ar-heading-icon">
            <i class="fa-solid fa-coins"></i>
        </div>
    </div>

    @foreach(['success', 'error', 'info'] as $kind)
        @if(session($kind))
            <div class="ar-alert {{ $kind }}">
                <i class="fa-solid fa-circle-info"></i>
                {{ session($kind) }}
            </div>
        @endif
    @endforeach

    @if($errors->any())
        <div class="ar-alert error">
            <i class="fa-solid fa-triangle-exclamation"></i>
            {{ $errors->first() }}
        </div>
    @endif

    <div class="ar-stats">
        <div class="ar-stat">
            <span class="ar-stat-icon blue"><i class="fa-solid fa-users"></i></span>
            <div>
                <small>Total Pengguna</small>
                <strong>{{ number_format($totalUsers, 0, ',', '.') }}</strong>
            </div>
        </div>
        <div class="ar-stat">
            <span class="ar-stat-icon gold"><i class="fa-solid fa-coins"></i></span>
            <div>
                <small>Saldo Poin Pengguna</small>
                <strong>{{ number_format($totalPoints, 0, ',', '.') }}</strong>
            </div>
        </div>
        <div class="ar-stat">
            <span class="ar-stat-icon green"><i class="fa-solid fa-receipt"></i></span>
            <div>
                <small>Riwayat Poin</small>
                <strong>{{ number_format($totalTransactions, 0, ',', '.') }}</strong>
            </div>
        </div>
        <div class="ar-stat">
            <span class="ar-stat-icon purple"><i class="fa-solid fa-book-open-reader"></i></span>
            <div>
                <small>Bab Premium Dibuka</small>
                <strong>{{ number_format($totalUnlocks, 0, ',', '.') }}</strong>
            </div>
        </div>
    </div>

    <section class="ar-panel">
        <div class="ar-panel-head">
            <div>
                <h2><i class="fa-solid fa-users-gear"></i> Daftar Pengguna</h2>
                <p>Kelola poin pengguna dengan mudah dan aman.</p>
            </div>
            <span class="ar-count">{{ $users->total() }} pengguna</span>
        </div>

        <form class="ar-filter" action="{{ route('admin.rewards.index') }}" method="GET">
            <label class="ar-search">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="search" name="search" value="{{ request('search') }}"
                    placeholder="Cari username atau email...">
            </label>
            <button class="ar-button primary" type="submit">
                <i class="fa-solid fa-magnifying-glass"></i> Cari
            </button>
            @if(request('search'))
                <a class="ar-button neutral" href="{{ route('admin.rewards.index') }}">Reset</a>
            @endif
        </form>

        <div class="ar-list">
            @forelse($users as $user)
                @php
                    $level = ($user->points ?? 0) >= 1000
                        ? 'Diamond'
                        : (($user->points ?? 0) >= 500 ? 'Silver' : 'Bronze');
                    $avatar = $user->foto_profil ?: ($user->profile_image ?? null);
                    $avatar = $avatar ? preg_replace('#^(public/|storage/)+#', '', $avatar) : null;
                @endphp

                <article class="ar-user">
                    <div class="ar-identity">
                        @if($avatar)
                            <img class="ar-avatar" src="{{ asset('storage/'.$avatar) }}"
                                alt="Foto {{ $user->username }}">
                        @else
                            <div class="ar-avatar ar-avatar-empty">
                                <i class="fa-solid fa-user"></i>
                            </div>
                        @endif
                        <div class="ar-identity-text">
                            <h3>{{ $user->username }}</h3>
                            <p>{{ $user->email }}</p>
                            <span class="ar-level {{ strtolower($level) }}">
                                <i class="fa-solid fa-medal"></i> {{ $level }}
                            </span>
                        </div>
                    </div>

                    <div class="ar-balance">
                        <small>Saldo poin</small>
                        <strong>
                            <i class="fa-solid fa-coins"></i>
                            {{ number_format($user->points ?? 0, 0, ',', '.') }}
                        </strong>
                    </div>

                    <div class="ar-actions">
                        <form action="{{ route('admin.reward.add', $user->id) }}"
                            method="POST" class="ar-action-form">
                            @csrf
                            <div class="ar-input-wrap">
                                <i class="fa-solid fa-plus"></i>
                                <input type="number" name="points" min="1" max="1000000"
                                    placeholder="Jumlah poin" required>
                                <button class="ar-button add" type="submit">Tambah</button>
                            </div>
                        </form>

                        <form action="{{ route('admin.reward.remove', $user->id) }}"
                            method="POST" class="ar-action-form"
                            onsubmit="return confirm('Kurangi poin pengguna ini?')">
                            @csrf
                            <div class="ar-input-wrap">
                                <i class="fa-solid fa-minus"></i>
                                <input type="number" name="points" min="1" max="1000000"
                                    placeholder="Jumlah poin" required>
                                <button class="ar-button remove" type="submit">Kurangi</button>
                            </div>
                        </form>

                        <a class="ar-button history"
                            href="{{ route('admin.reward.history', $user->id) }}">
                            <i class="fa-solid fa-clock-rotate-left"></i> History
                        </a>
                    </div>
                </article>
            @empty
                <div class="ar-empty">
                    <i class="fa-solid fa-user-slash"></i>
                    <h3>Pengguna tidak ditemukan</h3>
                    <p>Coba gunakan username atau email yang berbeda.</p>
                </div>
            @endforelse
        </div>

        @if($users->hasPages())
            <div class="ar-pagination">{{ $users->links() }}</div>
        @endif
    </section>
</div>
@endsection
