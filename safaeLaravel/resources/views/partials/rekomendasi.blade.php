{{-- Pemakaian di halaman mana pun:  @include('partials.rekomendasi', ['rekomendasi' => $rekomendasi]) --}}
@if ($rekomendasi['books']->isNotEmpty())
<section class="rekomendasi">
    <h3>{{ $rekomendasi['sumber'] === 'model' ? 'Rekomendasi untukmu' : 'Buku populer' }}</h3>
    <div class="rekomendasi-list">
        @foreach ($rekomendasi['books'] as $book)
            <a href="{{ route('books.show', $book->id) }}" class="rekomendasi-item"> {{-- sesuaikan nama route --}}
                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}"> {{-- sesuaikan path cover --}}
                <strong>{{ $book->title }}</strong>
                <small>{{ $book->author }} · {{ $book->genre }}</small>
                @if ($book->is_premium) <span class="badge">Premium</span> @endif
            </a>
        @endforeach
    </div>
</section>
@endif