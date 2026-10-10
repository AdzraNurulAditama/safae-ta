@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{ asset('css/detail-reward.css') }}">

<div class="dr-container">

  <a href="{{ route('reward.index') }}" class="btn-back">
    <i class="ti ti-arrow-left"></i> Kembali ke reward
  </a>

@php
  $levelColor = match($level) {
    'Diamond' => ['card' => '#533483', 'border' => '#3C3489', 'icon_bg' => 'rgba(175,169,236,0.18)', 'icon' => '#AFA9EC', 'label' => '#AFA9EC', 'val' => '#EEEDFE', 'meta' => '#AFA9EC', 'icon_name' => 'ti-diamond'],
    'Silver'  => ['card' => '#185FA5', 'border' => '#0C447C', 'icon_bg' => 'rgba(181,212,244,0.18)', 'icon' => '#85B7EB', 'label' => '#85B7EB', 'val' => '#E6F1FB', 'meta' => '#85B7EB', 'icon_name' => 'ti-star'],
    default   => ['card' => '#854F0B', 'border' => '#633806', 'icon_bg' => 'rgba(250,199,117,0.18)', 'icon' => '#FAC775', 'label' => '#FAC775', 'val' => '#FAEEDA', 'meta' => '#FAC775', 'icon_name' => 'ti-medal'],
  };
@endphp

<div class="dr-container">
  <div class="dr-top">

    <div class="stat-card" style="background: {{ $levelColor['card'] }}; border-color: {{ $levelColor['border'] }};">
      <div class="sc-icon" style="background: {{ $levelColor['icon_bg'] }};">
        <i class="ti {{ $levelColor['icon_name'] }}" style="color: {{ $levelColor['icon'] }};"></i>
      </div>
      <div class="sc-label" style="color: {{ $levelColor['label'] }};">Total poin</div>
      <div class="sc-val" style="color: {{ $levelColor['val'] }};">{{ number_format($user->points) }}</div>
      <div class="sc-meta" style="color: {{ $levelColor['meta'] }};">{{ $user->username }} · {{ $level }} member</div>
    </div>

    <div class="stat-card ditukar">
      <div class="sc-icon green"><i class="ti ti-gift"></i></div>
      <div class="sc-label green">Sudah ditukar</div>
      <div class="sc-val green">{{ $riwayat->count() }}</div>
      <div class="sc-meta green">reward ditukarkan</div>
    </div>

  </div>

  <div class="rw-card">
    <div class="rw-card-header">
      <div class="rw-card-title">
        <i class="ti ti-history"></i>
        Riwayat penukaran poin
      </div>
      <span class="rw-count">{{ $riwayat->count() }} transaksi</span>
    </div>

    @forelse($riwayat as $item)
    <div class="rw-item">
      <div class="rw-dot"><i class="ti ti-ticket"></i></div>
      <div class="rw-info">
        <div class="rw-name">{{ $item->nama_reward }}</div>
        <div class="rw-date">
          <i class="ti ti-clock"></i>
          {{ $item->created_at->format('d M Y, H:i') }}
        </div>
      </div>
      @php
        $badgeClass = match(strtolower($item->status)) {
          'berhasil', 'sukses', 'success' => 'badge-success',
          'diproses', 'pending'           => 'badge-pending',
          default                          => 'badge-gagal',
        };
        $badgeIcon = match(strtolower($item->status)) {
          'berhasil', 'sukses', 'success' => 'ti-check',
          'diproses', 'pending'           => 'ti-loader',
          default                          => 'ti-x',
        };
      @endphp
      <div class="badge-status {{ $badgeClass }}">
        <i class="ti {{ $badgeIcon }}"></i>
        {{ ucfirst($item->status) }}
      </div>
    </div>
    @empty
    <div class="rw-empty">
      <div class="rw-empty-icon"><i class="ti ti-inbox"></i></div>
      <p class="rw-empty-text">Belum ada riwayat penukaran poin.</p>
    </div>
    @endforelse
  </div>
</div>
@endsection