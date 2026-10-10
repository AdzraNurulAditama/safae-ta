@extends('layouts.app')

@section('content')

<div class="container" style="max-width:600px; margin-top:40px;">

    <h3>Edit Komentar</h3>

    <form action="{{ route('komentar.update', $komentar->id) }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="book_id" value="{{ $komentar->book_id }}">
        <input type="hidden" name="page" value="{{ $komentar->page }}">

        <div class="form-group mb-3">
            <textarea name="komentar" class="form-control" required>{{ $komentar->komentar }}</textarea>
        </div>

        @if($komentar->image_path)
            <div class="mb-3">
                <p>Gambar saat ini:</p>
                <img src="{{ asset('uploads/' . $komentar->image_path) }}"
                     style="max-width:200px;">
            </div>
        @endif

        <div class="form-group mb-3">
            <label>Ganti Gambar (opsional)</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">
            💾 Simpan Perubahan
        </button>

        <a href="{{ route('komentar.index', [$komentar->book_id, $komentar->page]) }}"
           class="btn btn-secondary">
            Batal
        </a>
    </form>

</div>

@endsection
