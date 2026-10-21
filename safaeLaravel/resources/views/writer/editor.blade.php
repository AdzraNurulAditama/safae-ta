
@extends('layouts.app')
@section('title', isset($chapter) ? 'Edit Bab - '.$book->title : 'Tulis Bab Baru - '.$book->title)
@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Literata:opsz,wght@7..72,400;7..72,500;7..72,700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

.editor-page {
    --card: #162033;
    --input-bg: #0b1424;
    --line: rgba(148, 163, 184, 0.18);
    --line-strong: rgba(148, 163, 184, 0.32);
    --text: #f1f5f9;
    --text-soft: #a3b1c6;
    --text-mute: #70819b;
    --accent: #38bdf8;
    --accent-dark: #062a40;
    font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
    color: var(--text);
    padding: 10px 0 32px;
}

.editor-container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 14px;
}

.editor-page a:focus-visible,
.editor-page button:focus-visible,
.editor-upload:focus-visible {
    outline: 2px solid var(--accent);
    outline-offset: 3px;
}

.editor-topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 6px;
    margin-bottom: 8px;
}

.editor-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 5px 12px;
    background: var(--card);
    border: 1px solid var(--line);
    border-radius: 999px;
    color: var(--text-soft);
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: 0.2s;
}

.editor-back:hover {
    border-color: var(--accent);
    color: #7dd3fc;
}

.editor-book-pill {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    max-width: 100%;
    padding: 4px 11px;
    border: 1px solid rgba(56, 189, 248, 0.28);
    border-radius: 999px;
    background: rgba(56, 189, 248, 0.1);
    color: #7dd3fc;
    font-size: 12.5px;
    font-weight: 600;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.editor-hero {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    margin-bottom: 10px;
    border: 1px solid rgba(125, 211, 252, 0.18);
    border-radius: 20px;
    background:
        radial-gradient(360px 180px at 95% 0%, rgba(99, 102, 241, 0.25), transparent 70%),
        linear-gradient(120deg, #14214a, #0b3a5c 60%, #0d1730);
}

.editor-hero-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    width: 38px;
    height: 38px;
    border-radius: 11px;
    background: rgba(56, 189, 248, 0.15);
    color: var(--accent);
    font-size: 16px;
}

.editor-hero h1 {
    margin: 0 0 1px;
    color: #fff;
    font-size: clamp(18px, 2.4vw, 22px);
    font-weight: 800;
    letter-spacing: -0.02em;
}

.editor-hero p {
    margin: 0;
    color: #b9c9de;
    font-size: 13px;
    line-height: 1.4;
}

.editor-error {
    margin-bottom: 10px;
    padding: 9px 14px;
    border: 1px solid rgba(239, 68, 68, 0.35);
    border-radius: 14px;
    background: rgba(239, 68, 68, 0.1);
    color: #fca5a5;
    font-size: 13px;
}

.editor-error strong {
    display: block;
    margin-bottom: 2px;
}

.editor-error ul {
    margin: 0;
    padding-left: 18px;
}

.editor-grid {
    display: grid;
    grid-template-columns: minmax(0, 1fr) 290px;
    gap: 10px;
    align-items: start;
}

.editor-box {
    padding: 12px;
    background: var(--card);
    border: 1px solid var(--line);
    border-radius: 16px;
}

.editor-side {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.editor-field + .editor-field {
    margin-top: 10px;
}

.editor-label {
    display: block;
    margin-bottom: 4px;
    color: #e2e8f0;
    font-size: 12.5px;
    font-weight: 600;
}

.editor-label small {
    color: var(--text-mute);
    font-weight: 500;
}

.editor-input {
    display: block;
    width: 100%;
    padding: 8px 12px;
    background: var(--input-bg);
    border: 1px solid var(--line-strong);
    border-radius: 10px;
    color: #fff;
    font-family: inherit;
    font-size: 14px;
    transition: border-color 0.2s, box-shadow 0.2s;
}

.editor-input::placeholder {
    color: var(--text-mute);
    opacity: 1;
}

.editor-input:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.14);
    outline: none;
}

.editor-input.is-title {
    padding: 9px 12px;
    font-size: 16px;
    font-weight: 700;
}

.editor-textarea {
    min-height: 380px;
    padding: 12px 14px;
    font-family: 'Literata', Georgia, serif;
    font-size: 16.5px;
    line-height: 1.8;
    resize: vertical;
}

.editor-counter {
    display: flex;
    justify-content: space-between;
    gap: 8px;
    margin-top: 4px;
    color: var(--text-mute);
    font-size: 12px;
}

.editor-help {
    display: block;
    margin-top: 6px;
    color: #94a3b8;
    font-size: 11px;
    line-height: 1.6;
}

.editor-current-image {
    margin-bottom: 8px;
    padding: 6px;
    background: var(--input-bg);
    border: 1px solid var(--line);
    border-radius: 10px;
}

.editor-current-image p {
    margin: 0 0 4px;
    color: var(--text-soft);
    font-size: 12px;
}

.editor-current-image img,
#imagePreview {
    display: block;
    width: 100%;
    max-height: 140px;
    object-fit: cover;
    border-radius: 8px;
}

.editor-upload {
    padding: 12px 10px;
    background: var(--input-bg);
    border: 2px dashed var(--line-strong);
    border-radius: 14px;
    text-align: center;
    cursor: pointer;
    transition: border-color 0.2s, background 0.2s;
}

.editor-upload:hover {
    border-color: var(--accent);
    background: rgba(56, 189, 248, 0.05);
}

.editor-upload i {
    display: block;
    margin-bottom: 3px;
    color: var(--accent);
    font-size: 22px;
}

.editor-upload strong {
    display: block;
    color: #fff;
    font-size: 12.5px;
}

.editor-upload small {
    color: var(--text-soft);
    font-size: 11.5px;
}

#imagePreviewContainer {
    margin-top: 8px;
    padding: 6px;
    background: var(--input-bg);
    border: 1px solid var(--line);
    border-radius: 10px;
}

#imagePreviewContainer p {
    margin: 0 0 4px;
    color: #7dd3fc;
    font-size: 12px;
}

.editor-actions {
    position: sticky;
    top: 10px;
}

.editor-btn-save {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    width: 100%;
    min-height: 42px;
    border: none;
    border-radius: 12px;
    background: var(--accent);
    color: var(--accent-dark);
    font-family: inherit;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    transition: background 0.2s, transform 0.2s;
}

.editor-btn-save:hover {
    background: #7dd3fc;
}

.editor-btn-save:active {
    transform: scale(0.98);
}

.editor-btn-cancel {
    display: block;
    margin-top: 4px;
    padding: 6px;
    border-radius: 11px;
    color: var(--text-soft);
    font-size: 13px;
    font-weight: 600;
    text-align: center;
    text-decoration: none;
    transition: color 0.2s, background 0.2s;
}

.editor-btn-cancel:hover {
    background: rgba(255, 255, 255, 0.05);
    color: #fff;
}

@media (max-width: 900px) {
    .editor-grid {
        grid-template-columns: 1fr;
    }

    .editor-actions {
        position: static;
    }

    .editor-textarea {
        min-height: 280px;
    }
}

@media (max-width: 575px) {
    .editor-container {
        padding: 0 10px;
    }

    .editor-hero {
        padding: 11px 12px;
    }

    .editor-box {
        padding: 10px;
    }

    .editor-textarea {
        font-size: 16px;
    }
}

@media (prefers-reduced-motion: reduce) {
    .editor-page * {
        transition: none !important;
    }
}
</style>

<div class="editor-page">
    <div class="editor-container">
        {{-- TOPBAR --}}
        <div class="editor-topbar">
            <a href="{{ route('writer.chapters.index', ['book' => $book->id]) }}" class="editor-back">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Bab
            </a>
            <span class="editor-book-pill">
                <i class="fa-solid fa-book-open"></i> {{ $book->title }}
            </span>
        </div>

        {{-- HEADER --}}
        <div class="editor-hero">
            <div class="editor-hero-icon">
                <i class="fa-solid fa-pen-nib"></i>
            </div>
            <div>
                <h1>{{ $chapter ? 'Edit Bab Cerita' : 'Tulis Bab Baru' }}</h1>
                <p>Susun konten bab, atur status publikasi, dan tambahkan ilustrasi gambar.</p>
            </div>
        </div>

        {{-- PESAN ERROR --}}
        @if($errors->any())
            <div class="editor-error">
                <strong>
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    Terdapat kesalahan input:
                </strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM --}}
        <form action="{{ route('writer.chapter.store', ['book' => $book->id, 'chapter' => $chapter->id ?? null]) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="editor-grid">
                {{-- KOLOM KIRI --}}
                <div class="editor-box">
                    <div class="editor-field">
                        <label class="editor-label" for="chapterTitle">Judul Bab</label>
                        <input type="text" id="chapterTitle" name="title" class="editor-input is-title"
                               placeholder="Contoh: Awal Mula Petualangan"
                               value="{{ old('title', $chapter->title ?? '') }}" required>
                    </div>

                    <div class="editor-field">
                        <label class="editor-label" for="chapterContent">Isi Cerita / Konten Bab</label>
                        <textarea id="chapterContent" name="content" class="editor-input editor-textarea"
                                  rows="14" placeholder="Tulis atau tempel isi bab cerita di sini..."
                                  required>{{ old('content', $chapter->content ?? '') }}</textarea>
                        <div class="editor-counter">
                            <span>
                                <i class="fa-regular fa-file-lines"></i>
                                <span id="wordCount">0</span> kata
                            </span>
                            <span><span id="charCount">0</span> karakter</span>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN --}}
                <div class="editor-side">
                    <div class="editor-box">
                        {{-- NOMOR BAB --}}
                        <div class="editor-field">
                            <label class="editor-label" for="chapterNumber">Nomor Bab</label>
                            <input type="number" id="chapterNumber" name="chapter_number"
                                   class="editor-input" min="1"
                                   value="{{ old('chapter_number', $chapter->chapter_number ?? $nextChapterNumber) }}"
                                   required>
                        </div>

                        {{-- STATUS PUBLIKASI --}}
                        <div class="editor-field">
                            <label class="editor-label" for="chapterStatus">Status Publikasi</label>
                            <select id="chapterStatus" name="status" class="editor-input" required>
                                <option value="draft" {{ old('status', $chapter->status ?? 'draft') == 'draft' ? 'selected' : '' }}>
                                    📝 Draf (Belum Ditampilkan ke Publik)
                                </option>
                                <option value="published" {{ old('status', $chapter->status ?? 'draft') == 'published' ? 'selected' : '' }}>
                                    🚀 Published (Tampil untuk Pembaca)
                                </option>
                            </select>
                            <small class="editor-help">
                                Bab draf hanya dapat dilihat penulis. Bab published dapat dibaca sesuai pengaturan akses.
                            </small>
                        </div>

                        {{-- AKSES BAB --}}
                        <div class="editor-field">
                            <label class="editor-label" for="chapterPremium">Akses Bab</label>

                            @if($book->is_premium)
                                <select id="chapterPremium" name="is_premium" class="editor-input" required>
                                    <option value="0" {{ old('is_premium', (int) ($chapter->is_premium ?? 0)) == 0 ? 'selected' : '' }}>
                                        📖 Gratis — Semua Pembaca
                                    </option>
                                    <option value="1" {{ old('is_premium', (int) ($chapter->is_premium ?? 0)) == 1 ? 'selected' : '' }}>
                                        👑 Premium — 50 Poin per Bab
                                    </option>
                                </select>
                                <small class="editor-help">
                                    Bab premium hanya terbuka setelah pembaca menukar 50 poin untuk bab ini atau memiliki akses seluruh buku.
                                </small>
                            @else
                                <input type="hidden" name="is_premium" value="0">
                                <select id="chapterPremium" class="editor-input" disabled>
                                    <option>📖 Gratis — Semua Pembaca</option>
                                </select>
                                <small class="editor-help">
                                    Ajukan buku menjadi premium agar dapat mengatur akses setiap bab.
                                </small>
                            @endif
                        </div>
                    </div>

                    {{-- ILUSTRASI BAB --}}
                    <div class="editor-box">
                        <label class="editor-label">
                            Ilustrasi Bab <small>(Opsional)</small>
                        </label>

                        @if($chapter && $chapter->image)
                            @php
                                $imagePath = preg_replace('#^(public/|storage/)#', '', $chapter->image);
                            @endphp
                            <div class="editor-current-image">
                                <p>Ilustrasi saat ini:</p>
                                <img src="{{ asset('storage/' . $imagePath) }}" alt="Ilustrasi Bab">
                            </div>
                        @endif

                        <div class="editor-upload" role="button" tabindex="0"
                             onclick="document.getElementById('chapterImageInput').click()"
                             onkeydown="if(event.key==='Enter'||event.key===' '){event.preventDefault();this.click();}">
                            <i class="fa-regular fa-image"></i>
                            <strong>Klik untuk unggah atau ganti foto</strong>
                            <small>JPG, PNG, WEBP (maks. 2MB)</small>
                        </div>

                        <input type="file" name="chapter_image" id="chapterImageInput"
                               class="d-none" accept=".jpg,.jpeg,.png,.webp"
                               onchange="previewImage(event)">

                        <div id="imagePreviewContainer" class="d-none text-center">
                            <p>Pratinjau gambar baru:</p>
                            <img id="imagePreview" alt="Pratinjau gambar baru">
                        </div>
                    </div>

                    {{-- TOMBOL SIMPAN --}}
                    <div class="editor-actions">
                        <button type="submit" class="editor-btn-save">
                            <i class="fa-solid fa-floppy-disk"></i>
                            Simpan Bab Cerita
                        </button>
                        <a href="{{ route('writer.chapters.index', ['book' => $book->id]) }}"
                           class="editor-btn-cancel">Batal</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    const container = document.getElementById('imagePreviewContainer');
    const preview = document.getElementById('imagePreview');

    if (!file) {
        preview.removeAttribute('src');
        container.classList.add('d-none');
        return;
    }

    const reader = new FileReader();
    reader.onload = function(e) {
        preview.src = e.target.result;
        container.classList.remove('d-none');
    };
    reader.readAsDataURL(file);
}

(function() {
    const textarea = document.getElementById('chapterContent');
    const words = document.getElementById('wordCount');
    const chars = document.getElementById('charCount');

    function updateCount() {
        const text = textarea.value.trim();
        words.textContent = text ? text.split(/\s+/).length : 0;
        chars.textContent = textarea.value.length;
    }

    textarea.addEventListener('input', updateCount);
    updateCount();
})();
</script>
@endsection
