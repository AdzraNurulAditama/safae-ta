@extends('layouts.app')

@section('title', 'Ulasan Buku')

@push('styles')
<style>
    :root {
        --primary-color: #4a90e2;
        --star-color: #ffc107;
        --bg-soft: #f7f9fd;
    }

    body { background: var(--bg-soft); }

    .rating-star { 
        font-size: 1.4rem; 
        color: var(--star-color); 
    }

    #starPicker span {
        cursor: pointer;
        font-size: 2rem;
        color: #ddd;
        transition: color 0.2s ease-in-out;
    }

    .card {
        border-radius: 14px;
        border: none;
        box-shadow: 0 4px 22px rgba(0,0,0,0.08);
    }
</style>
@endpush

@section('content')

<div class="container py-4 text-center">
    <h2 class="fw-bold" style="color: var(--primary-color);">
        {{ $book->title }}
    </h2>
    <p class="text-muted">Bagikan pendapatmu setelah membaca buku ini! ✨</p>

    @if($totalReview > 0)
        <p class="fw-bold">
            ⭐ Rata-rata Rating: {{ $avgRating }} / 5 
            ({{ $totalReview }} ulasan)
        </p>
    @endif
</div>

{{-- Form Ulasan --}}
@auth
    @if(!$reviews->contains('user_id', Auth::id()))
    <div class="card p-4 mx-auto" style="max-width: 480px;">
        <form action="{{ route('ulasan.store', $book->id) }}" method="POST">
            @csrf

            <label class="fw-semibold">Rating</label>
            <div id="starPicker" class="mb-3">
                @for($i = 1; $i <= 5; $i++)
                    <span data-value="{{ $i }}">★</span>
                @endfor
            </div>

            <input type="hidden" name="rating" id="ratingValue" value="0">

            {{-- name="isi" sesuai controller & database --}}
            <textarea name="komentar" class="form-control mb-3"
          placeholder="Tulis ulasanmu..." required></textarea>


            <button class="btn btn-primary w-100">
                Kirim Ulasan ⭐
            </button>
        </form>
    </div>
    @endif
@else
    <p class="text-center text-muted">
        Silakan <a href="/login">login</a> untuk menulis ulasan 📝
    </p>
@endauth

{{-- Daftar Ulasan --}}
<div class="mt-4">
    <h5 class="fw-bold mb-3 text-primary">Ulasan Pembaca</h5>

    @forelse($reviews as $review)
    <div class="card p-3 mb-2">

        {{-- FIX: tampilkan username atau nama lengkap --}}
        <strong>
            {{ 
                $review->user->nama_depan 
                    ? $review->user->nama_depan . ' ' . $review->user->nama_belakang
                    : $review->user->username
            }}
        </strong>

        <div class="rating-star">
            {{ str_repeat('★', $review->rating) }}
        </div>

        {{-- isi sesuai kolom DB --}}
        <p class="mb-1">{{ $review->komentar }}</p>


        <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
    </div>
    @empty
    <p class="text-muted">Belum ada ulasan 😁</p>
    @endforelse
</div>

@endsection


@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const stars = document.querySelectorAll('#starPicker span');
    const inputRating = document.getElementById('ratingValue');
    const activeColor = '#ffc107';
    const normalColor = '#ddd';

    stars.forEach(star => {
        star.addEventListener('click', () => {
            let rating = star.getAttribute('data-value');
            inputRating.value = rating;

            stars.forEach(s => {
                s.style.color = s.getAttribute('data-value') <= rating ? activeColor : normalColor;
            });
        });
    });
});
</script>
@endpush