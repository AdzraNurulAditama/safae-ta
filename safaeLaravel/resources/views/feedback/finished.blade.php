@extends('layouts.app')

@section('content')
@php
    $nonfiksi = $book->jenis_buku === 'nonfiksi';
@endphp

<style>
    .fin-wrap { max-width: 1024px; margin: 0 auto; padding: 32px 16px; }
    .fin-head { text-align: center; margin-bottom: 32px; }
    .fin-head h1 { font-size: 1.5rem; font-weight: 700; margin: 0; }
    .fin-head p { color: #6b7280; margin: 6px 0 0; }
    .fin-title { font-size: 1.1rem; font-weight: 600; margin-bottom: 16px; }

    .fin-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; }
    @media (min-width: 768px) { .fin-grid { grid-template-columns: repeat(3, 1fr); } }

    .fin-card { display: block; border: 1px solid #e5e7eb; border-radius: 10px;
                background: #fff; overflow: hidden; text-decoration: none; color: inherit;
                transition: box-shadow .2s; }
    .fin-card:hover { box-shadow: 0 4px 14px rgba(0,0,0,.12); }
    .fin-card img { width: 100%; aspect-ratio: 3 / 4; object-fit: cover; display: block; }
    .fin-card-body { padding: 10px 12px; }
    .fin-card-body .t { font-size: .9rem; font-weight: 500; margin: 0; }
    .fin-card-body .g { font-size: .75rem; color: #6b7280; margin: 4px 0 0; }
    .fin-empty { grid-column: 1 / -1; color: #6b7280; font-size: .9rem; }

    .fin-back { margin-top: 32px; text-align: center; }
    .fin-back a { font-size: .9rem; color: #4b5563; text-decoration: underline; }

    .fb-overlay { position: fixed; inset: 0; z-index: 2000; display: flex;
                  align-items: center; justify-content: center;
                  background: rgba(0,0,0,.5); padding: 16px; }
    .fb-box { background: #fff; border-radius: 14px; padding: 24px; width: 100%;
              max-width: 380px; text-align: center; }
    .fb-box h3 { font-size: 1.15rem; font-weight: 600; margin: 0 0 4px; }
    .fb-box p { font-size: .9rem; color: #4b5563; margin: 0 0 16px; }
    .fb-actions { display: flex; gap: 8px; }
    .fb-btn { flex: 1; border: 0; border-radius: 10px; padding: 10px 8px;
              font-size: .95rem; cursor: pointer; }
    .fb-btn:disabled { opacity: .6; cursor: default; }
    .fb-yes { background: #16a34a; color: #fff; }
    .fb-yes:hover:not(:disabled) { background: #15803d; }
    .fb-no { background: #e5e7eb; color: #111827; }
    .fb-no:hover:not(:disabled) { background: #d1d5db; }
    .fb-skip { margin-top: 12px; background: none; border: 0; color: #6b7280;
               font-size: .75rem; cursor: pointer; }
</style>

<div class="fin-wrap">

    {{-- Ucapan selesai --}}
    <div class="fin-head">
        <h1>Selesai membaca!</h1>
        <p>Kamu baru menyelesaikan "{{ $book->title }}".</p>
    </div>

    {{-- Rekomendasi --}}
    <h2 class="fin-title">Buku lain yang mungkin kamu suka</h2>

    <div class="fin-grid">
        @forelse($recs as $r)
            <a href="{{ route('fullbacaan.show', $r->id) }}" class="fin-card">
                <img src="{{ asset($r->image_path ?: $r->cover_image) }}" alt="{{ $r->title }}">
                <div class="fin-card-body">
                    <p class="t">{{ $r->title }}</p>
                    @if($r->genre)
                        <p class="g">{{ $r->genre }}</p>
                    @endif
                </div>
            </a>
        @empty
            <p class="fin-empty">Belum ada rekomendasi. Baca beberapa buku lagi, ya.</p>
        @endforelse
    </div>

    <div class="fin-back">
        <a href="{{ route('fullbacaan.show', $book->id) }}">Kembali ke detail buku</a>
    </div>
</div>

{{-- Popup feedback (hanya muncul kalau user belum menilai buku ini) --}}
@unless($sudahMenilai)
<div id="feedback-modal" class="fb-overlay">
    <div class="fb-box">
        <h3>Selesai membaca!</h3>
        <p>{{ $nonfiksi ? 'Apakah buku ini membantu kamu?' : 'Apakah buku ini cocok untukmu?' }}</p>

        <div class="fb-actions">
            <button type="button" data-cocok="1" class="fb-btn fb-yes">
                {{ $nonfiksi ? 'Membantu' : 'Cocok untukku' }}
            </button>
            <button type="button" data-cocok="0" class="fb-btn fb-no">
                {{ $nonfiksi ? 'Kurang membantu' : 'Belum cocok' }}
            </button>
        </div>

        <button type="button" id="feedback-skip" class="fb-skip">Nanti saja</button>
    </div>
</div>

<script>
    (function () {
        const modal = document.getElementById('feedback-modal');
        const buttons = modal.querySelectorAll('[data-cocok]');

        buttons.forEach(function (btn) {
            btn.addEventListener('click', async function () {
                buttons.forEach(function (b) { b.disabled = true; });
                try {
                    await fetch("{{ route('books.feedback', $book->id) }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ cocok: btn.dataset.cocok === '1' ? 1 : 0 })
                    });
                } catch (e) {
                    console.error(e);
                }
                modal.remove();
            });
        });

        document.getElementById('feedback-skip').addEventListener('click', function () {
            modal.remove();
        });

        // popup hilang sendiri setelah 15 detik (tidak menyimpan label)
        setTimeout(function () {
            if (document.getElementById('feedback-modal')) {
                modal.remove();
            }
        }, 15000);
    })();
</script>
@endunless
@endsection