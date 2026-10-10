<div class="modal fade" id="viewModal{{ $book['id'] }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $book['title'] }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if (!empty($book['image_path']))
                    <img src="{{ $book['image_path'] }}" class="img-fluid mb-3" style="max-height: 300px;">
                @endif
                <p><strong>Author:</strong> {{ $book['author'] }}</p>
                <p><strong>Genre:</strong> {{ $book['genre'] }}</p>
                <p><strong>Year:</strong> {{ $book['year'] }}</p>
                <div class="content-preview mb-3">
                    {{-- nl2br(e(...)) adalah cara aman untuk menampilkan teks dengan baris baru --}}
                    <p><strong>Content:</strong> {!! !empty($book['content']) ? nl2br(e(substr($book['content'], 0, 500))) . '...' : 'No content available' !!}</p>
                </div>
                
                @if (!empty($book['content']) && strlen($book['content']) > 500)
                    <a href="{{ url('/books/read/' . $book['id']) }}" class="btn btn-primary">
                        <i class="fas fa-book-open me-1"></i> Baca Selengkapnya
                    </a>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>