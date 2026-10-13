@extends('layouts.app')

@section('content')
@php
    $nonfiksi = $book->jenis_buku === 'nonfiksi';
    $coverBuku = $book->image_path ?: $book->cover_image;
@endphp

<style>
    .fin-wrap { max-width: 1000px; margin: 0 auto; padding: 40px 16px 70px; }

    /* ---------- Header selesai ---------- */
    .fin-hero {
        text-align: center;
        background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
        border: 1px solid #334155;
        border-radius: 22px;
        padding: 34px 24px 30px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, .35);
        margin-bottom: 40px;
    }
    .fin-check {
        width: 68px; height: 68px; margin: 0 auto 16px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.7rem; color: #fff;
        background: linear-gradient(135deg, #38bdf8, #8b5cf6);
        box-shadow: 0 0 28px rgba(56, 189, 248, .4);
    }
    .fin-hero h1 { margin: 0; font-size: 1.6rem; font-weight: 800; color: #f8fafc; }
    .fin-hero p { margin: 8px 0 0; color: #94a3b8; font-size: .95rem; }
    .fin-hero p b { color: #38bdf8; font-weight: 700; }

    .fin-book {
        display: inline-flex; align-items: center; gap: 12px;
        margin-top: 18px; padding: 8px 16px 8px 8px;
        background: rgba(15, 23, 42, .8);
        border: 1px solid #334155; border-radius: 14px;
    }
    .fin-book img, .fin-book .fin-mini {
        width: 40px; height: 54px; border-radius: 8px; object-fit: cover; flex-shrink: 0;
    }
    .fin-mini {
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; color: #fff;
        background: linear-gradient(135deg, #0ea5e9, #8b5cf6);
    }
    .fin-book span { text-align: left; color: #e2e8f0; font-size: .9rem; font-weight: 600; }

    /* ---------- Rekomendasi ---------- */
    .fin-section-title { font-size: 1.15rem; font-weight: 700; color: #f1f5f9; margin: 0 0 4px; }
    .fin-section-sub { font-size: .85rem; color: #94a3b8; margin: 0 0 22px; }

    .fin-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 24px 18px;
    }
    .fin-card { display: block; text-decoration: none; color: inherit; transition: transform .2s ease; }
    .fin-card:hover { transform: translateY(-5px); color: inherit; }

    .fin-cover {
        position: relative; aspect-ratio: 3 / 4; border-radius: 14px; overflow: hidden;
        background: #1e293b; border: 1px solid #334155;
        box-shadow: 0 8px 20px rgba(0, 0, 0, .35);
        transition: box-shadow .2s ease, border-color .2s ease;
    }
    .fin-card:hover .fin-cover { border-color: #38bdf8; box-shadow: 0 12px 28px rgba(56, 189, 248, .25); }
    .fin-cover img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .35s ease; }
    .fin-card:hover .fin-cover img { transform: scale(1.06); }
    .fin-fallback {
        width: 100%; height: 100%;
        display: flex; align-items: center; justify-content: center;
        font-size: 2.6rem; font-weight: 800; color: rgba(255, 255, 255, .85);
        background: linear-gradient(135deg, #0ea5e9, #8b5cf6);
    }
    .fin-premium {
        position: absolute; top: 8px; right: 8px;
        background: rgba(15, 23, 42, .88); color: #fbbf24;
        border-radius: 999px; padding: 3px 9px; font-size: .68rem; font-weight: 700;
    }
    .fin-t {
        margin: 10px 0 2px; font-size: .9rem; font-weight: 700; line-height: 1.3; color: #f1f5f9;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }
    .fin-a { font-size: .78rem; color: #94a3b8; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .fin-chip {
        display: inline-block; margin-top: 6px; padding: 2px 9px; border-radius: 999px;
        font-size: .7rem; font-weight: 600; background: rgba(56, 189, 248, .15); color: #38bdf8;
    }
    .fin-empty { grid-column: 1 / -1; color: #94a3b8; font-size: .9rem; }

    /* ---------- Tombol bawah ---------- */
    .fin-actions { margin-top: 44px; display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
    .fin-btn {
        padding: 11px 24px; border-radius: 12px; font-weight: 700; font-size: .92rem;
        text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
        transition: all .2s ease;
    }
    .fin-btn-main { background: #38bdf8; color: #0f172a; box-shadow: 0 4px 14px rgba(56, 189, 248, .25); }
    .fin-btn-main:hover { background: #7dd3fc; color: #0f172a; transform: translateY(-2px); }
    .fin-btn-ghost { background: #1e293b; color: #cbd5e1; border: 1px solid #334155; }
    .fin-btn-ghost:hover { background: #334155; color: #fff; transform: translateY(-2px); }

    /* ---------- Popup feedback ---------- */
    .fb-overlay {
        position: fixed; inset: 0; z-index: 2000; display: flex;
        align-items: center; justify-content: center;
        background: rgba(2, 6, 23, .8); backdrop-filter: blur(8px); padding: 16px;
    }
    .fb-box {
        background: #0f172a; border: 1px solid #334155; border-radius: 24px;
        padding: 28px 24px; width: 100%; max-width: 390px; text-align: center;
        box-shadow: 0 25px 60px rgba(0, 0, 0, .7);
    }
    .fb-box h3 { font-size: 1.2rem; font-weight: 700; color: #f8fafc; margin: 0 0 6px; }
    .fb-box p { font-size: .92rem; color: #94a3b8; margin: 0 0 18px; }
    .fb-actions { display: flex; gap: 8px; }
    .fb-btn { flex: 1; border: 0; border-radius: 12px; padding: 12px 8px; font-weight: 700; font-size: .95rem; cursor: pointer; transition: all .2s ease; }
    .fb-btn:disabled { opacity: .6; cursor: default; }
    .fb-yes { background: #22c55e; color: #052e16; }
    .fb-yes:hover:not(:disabled) { background: #4ade80; }
    .fb-no { background: #334155; color: #e2e8f0; }
    .fb-no:hover:not(:disabled) { background: #475569; }
    .fb-skip { margin-top: 14px; background: none; border: 0; color: #94a3b8; font-size: .82rem; cursor: pointer; }
</style>

<div class="fin-wrap">

    {{-- Header selesai --}}
    <div class="fin-hero">
        <div class="fin-check"><i class="fa-solid fa-check"></i></div>
        <h1>Selesai membaca!</h1>
        <p>Kamu baru menamatkan <b>{{ $book->title }}</b>.</p>

        <div class="fin-book">
            @if ($coverBuku)
                <img src="{{ asset($coverBuku) }}" alt="{{ $book->title }}">
            @else
                <div class="fin-mini">{{ Str::upper(Str::substr($book->title, 0, 1)) }}</div>
            @endif
            <span>{{ Str::limit($book->title, 40) }}</span>
        </div>
    </div>

    {{-- Rekomendasi --}}
    <h2 class="fin-section-title">{{ $judul ?? 'Buku lain yang mungkin kamu suka' }}</h2>
    <p class="fin-section-sub">Pilihan berikutnya untuk kamu baca.</p>

    <div class="fin-grid">
        @forelse ($recs as $r)
            @php $cover = $r->image_path ?: $r->cover_image; @endphp
            <a href="{{ route('fullbacaan.show', $r->id) }}" class="fin-card">
                <div class="fin-cover">
                    @if ($cover)
                        <img src="{{ asset($cover) }}" alt="{{ $r->title }}" loading="lazy">
                    @else
                        <div class="fin-fallback">{{ Str::upper(Str::substr($r->title, 0, 1)) }}</div>
                    @endif

                    @if ($r->is_premium)
                        <span class="fin-premium"><i class="fa-solid fa-crown"></i> Premium</span>
                    @endif
                </div>

                <div class="fin-t">{{ $r->title }}</div>
                <div class="fin-a">{{ $r->author }}</div>
                @if ($r->genre)
                    <span class="fin-chip">{{ $r->genre }}</span>
                @endif
            </a>
        @empty
            <p class="fin-empty">Belum ada rekomendasi. Baca beberapa buku lagi, ya.</p>
        @endforelse
    </div>

    {{-- Tombol bawah --}}
    <div class="fin-actions">
        <a href="{{ route('genre.index') }}" class="fin-btn fin-btn-main">
            <i class="fa-solid fa-book-open"></i> Jelajahi buku lain
        </a>
        <a href="{{ route('fullbacaan.show', $book->id) }}" class="fin-btn fin-btn-ghost">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke buku
        </a>
    </div>
</div>

{{-- Popup feedback (hanya muncul kalau user belum menilai buku ini) --}}
@unless ($sudahMenilai)
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