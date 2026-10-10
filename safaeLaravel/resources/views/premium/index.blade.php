@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{ asset('css/ajukan-premium.css') }}">

<div class="ap-container">

  <div class="ap-header">
    <h3 class="ap-title">Ajukan buku premium</h3>
    <p class="ap-sub">Buku dengan 100.000+ pembaca dapat diajukan sebagai konten premium.</p>
  </div>

  @if(session('success'))
  <div class="ap-alert-success">
    <i class="ti ti-circle-check"></i>
    {{ session('success') }}
  </div>
  @endif

  <div class="ap-req-label">
    <i class="ti ti-info-circle"></i>
    Syarat: minimal 100.000 pembaca per buku
  </div>

  @if($books->count() == 0)
  <div class="ap-empty">
    <div class="ap-empty-icon"><i class="ti ti-book-2"></i></div>
    <div class="ap-empty-title">Belum ada buku</div>
    <p class="ap-empty-desc">Kamu harus menulis buku terlebih dahulu sebelum mengajukan premium.</p>
    <a href="{{ route('tulis-buku.create') }}" class="btn-primary-flat">
      <i class="ti ti-plus"></i> Tulis buku sekarang
    </a>
  </div>

  @else
  <div class="ap-book-list">
    @foreach($books as $book)
    @php
      $eligible = $book->reader_count >= 100000;
      $pct = min(100, round($book->reader_count / 100000 * 100));
      $sisa = max(0, 100000 - $book->reader_count);
    @endphp
    <div class="ap-book-card">
      <div class="ap-book-cover {{ $eligible ? 'eligible' : '' }}">
        <i class="ti ti-book"></i>
      </div>
      <div class="ap-book-info">
        <div class="ap-book-title">{{ $book->title }}</div>
        <div class="ap-book-meta">
          <i class="ti ti-users"></i>
          <span>{{ number_format($book->reader_count) }} pembaca</span>
        </div>
        <div class="ap-progress-wrap">
          <div class="ap-progress-bg">
            <div class="ap-progress-fill {{ $eligible ? 'fill-green' : 'fill-amber' }}"
              style="width: {{ $pct }}%"></div>
          </div>
          @if($eligible)
            <span class="ap-progress-pct">100% · syarat terpenuhi</span>
          @else
            <span class="ap-progress-pct">{{ $pct }}% · butuh {{ number_format($sisa) }} lagi</span>
          @endif
        </div>
        @if($eligible)
        <div class="ap-badge-eligible">
          <i class="ti ti-check"></i> Memenuhi syarat
        </div>
        @endif
      </div>
      <div class="ap-book-action">
        @if($eligible)
        <form action="{{ route('premium.store', $book->id) }}" method="POST">
          @csrf
          <button type="submit" class="btn-ajukan">
            <i class="ti ti-crown"></i> Ajukan
          </button>
        </form>
        @else
        <button class="btn-locked" disabled>
          <i class="ti ti-lock"></i> Belum memenuhi
        </button>
        @endif
      </div>
    </div>
    @endforeach
  </div>
  @endif

</div>
@endsection