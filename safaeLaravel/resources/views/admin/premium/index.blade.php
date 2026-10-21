
@extends('layouts.layoutsAdmin')
@section('title', 'Pengajuan Buku Premium')
@section('content')
<link rel="stylesheet" href="{{ asset('css/admin-premium.css') }}">

<div class="ap-page">
    <div class="ap-header">
        <div>
            <span class="ap-eyebrow">
                <i class="fa-solid fa-clipboard-check"></i> SAFAE ADMIN
            </span>
            <h1>Pengajuan <span>Buku Premium</span></h1>
            <p>Periksa dan kelola pengajuan premium dari penulis Safae.</p>
        </div>
        <a href="{{ route('admin.premium.books') }}" class="ap-header-link">
            <i class="fa-solid fa-crown"></i> Kelola Buku Premium
        </a>
    </div>

    @foreach(['success', 'error', 'info'] as $type)
        @if(session($type))
            <div class="ap-alert {{ $type }}">
                <i class="fa-solid fa-circle-info"></i> {{ session($type) }}
            </div>
        @endif
    @endforeach

    <div class="ap-stats ap-stats-four">
        <div class="ap-stat">
            <div class="ap-stat-icon blue"><i class="fa-solid fa-file-lines"></i></div>
            <div><strong>{{ $totalRequests }}</strong><span>Total Pengajuan</span></div>
        </div>
        <div class="ap-stat">
            <div class="ap-stat-icon yellow"><i class="fa-solid fa-clock"></i></div>
            <div><strong>{{ $totalPending }}</strong><span>Menunggu</span></div>
        </div>
        <div class="ap-stat">
            <div class="ap-stat-icon green"><i class="fa-solid fa-circle-check"></i></div>
            <div><strong>{{ $totalApproved }}</strong><span>Disetujui</span></div>
        </div>
        <div class="ap-stat">
            <div class="ap-stat-icon red"><i class="fa-solid fa-circle-xmark"></i></div>
            <div><strong>{{ $totalRejected }}</strong><span>Ditolak</span></div>
        </div>
    </div>

    <div class="ap-panel">
        <div class="ap-panel-header">
            <div>
                <h2><i class="fa-solid fa-inbox"></i> Daftar Pengajuan</h2>
                <p>Tinjau buku sebelum menyetujui status premium.</p>
            </div>
            <span class="ap-count">{{ $requests->total() }} Pengajuan</span>
        </div>

        <form method="GET" action="{{ route('admin.premium.index') }}" class="ap-filter">
            <div class="ap-search">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari judul buku atau penulis...">
            </div>
            <select name="status" class="ap-select">
                <option value="">Semua Status</option>
                <option value="pending" @selected(request('status') === 'pending')>Menunggu</option>
                <option value="approved" @selected(request('status') === 'approved')>Disetujui</option>
                <option value="rejected" @selected(request('status') === 'rejected')>Ditolak</option>
            </select>
            <button type="submit" class="ap-btn primary">
                <i class="fa-solid fa-filter"></i> Terapkan
            </button>
            @if(request('search') || request('status'))
                <a href="{{ route('admin.premium.index') }}" class="ap-btn secondary">Reset</a>
            @endif
        </form>

        <div class="ap-table-wrap">
            <table class="ap-table">
                <thead>
                    <tr>
                        <th>Buku</th>
                        <th>Penulis</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $item)
                        @php
                            $book = $item->book;
                            $cover = $book?->image_path
                                ? preg_replace('#^(public/|storage/)+#', '', $book->image_path)
                                : null;
                        @endphp
                        <tr>
                            <td>
                                <div class="ap-table-book">
                                    @if($cover)
                                        <img src="{{ asset('storage/'.$cover) }}"
                                            alt="{{ $book?->title }}">
                                    @else
                                        <div class="ap-table-cover-empty">
                                            <i class="fa-solid fa-book"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <strong>{{ $book?->title ?? 'Buku tidak tersedia' }}</strong>
                                        <small>{{ $book?->genre ?? '-' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                {{ $book?->author ?: ($item->user?->username ?? '-') }}
                            </td>
                            <td>{{ $item->created_at?->format('d M Y') ?? '-' }}</td>
                            <td>
                                <span class="ap-status {{ $item->status }}">
                                    {{ match($item->status) {
                                        'pending' => 'Menunggu',
                                        'approved' => 'Disetujui',
                                        'rejected' => 'Ditolak',
                                        default => ucfirst($item->status)
                                    } }}
                                </span>
                            </td>
                            <td>
                                <div class="ap-table-actions">
                                    @if($item->status === 'pending' && $book)
                                        <form action="{{ route('admin.premium.approve', $item->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Setujui pengajuan premium buku ini?')">
                                            @csrf
                                            <button class="ap-btn success" type="submit">
                                                <i class="fa-solid fa-check"></i> Setujui
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.premium.reject', $item->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Tolak pengajuan premium buku ini?')">
                                            @csrf
                                            <button class="ap-btn danger" type="submit">
                                                <i class="fa-solid fa-xmark"></i> Tolak
                                            </button>
                                        </form>
                                    @else
                                        <span class="ap-muted">Sudah diproses</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="ap-table-empty">
                                Belum ada pengajuan premium yang sesuai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($requests->hasPages())
            <div class="ap-pagination">{{ $requests->links() }}</div>
        @endif
    </div>
</div>
@endsection
