@extends('layouts.app')

@section('content')
<div class="komentar-container">

    <div class="komentar-card">
        <h1>Tambah Komentar</h1>
        <form action="/komentar/simpan" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Komentar:</label>
                <textarea name="komentar" placeholder="Tulis komentar Anda" required></textarea>
            </div>

            <div class="form-group file-group">
                <label class="file-label">
                    <input type="file" name="image" hidden>
                    Pilih Gambar (Opsional)
                </label>
                <span class="file-info">Tidak ada file yang dipilih</span>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Komentar</button>
            <a href="/komentar" class="btn btn-secondary">Batal</a>
        </form>
    </div>

</div>

<script>
document.querySelector('input[name="image"]').addEventListener('change', function(){
    const info = document.querySelector('.file-info');
    info.textContent = this.files[0] ? this.files[0].name : "Tidak ada file yang dipilih";
});
</script>
@endsection
