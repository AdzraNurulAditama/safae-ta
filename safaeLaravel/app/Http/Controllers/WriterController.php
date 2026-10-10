<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Chapter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class WriterController extends Controller
{
    // 1. Menampilkan Daftar Buku Milik Penulis (Kelola Buku)
    public function index()
    {
        $books = Book::where('user_id', Auth::id())
                     ->withCount('chapters')
                     ->latest()
                     ->get();

        return view('writer.index', compact('books'));
    }

    // 2. Menampilkan Daftar Bab / Chapter Berdasarkan Buku
    public function chapters($bookId)
    {
        $book = Book::where('user_id', Auth::id())->findOrFail($bookId);
        $chapters = $book->chapters()->orderBy('chapter_number', 'asc')->get();

        return view('writer.chapters-index', compact('book', 'chapters'));
    }

    // 3. Form Tulis / Edit Chapter
    public function editor($bookId, $chapterId = null)
    {
        $book = Book::where('user_id', Auth::id())->findOrFail($bookId);
        $chapter = null;

        if ($chapterId) {
            $chapter = Chapter::where('book_id', $book->id)->findOrFail($chapterId);
        }

        // Hitung otomatis nomor chapter berikutnya jika baru
        $nextChapterNumber = $book->chapters()->max('chapter_number') + 1;

        return view('writer.editor', compact('book', 'chapter', 'nextChapterNumber'));
    }

    // 4. Menyimpan atau Memperbarui Chapter (Draft / Publish + Foto Chapter)
    public function saveChapter(Request $request, $bookId, $chapterId = null)
    {
        $request->validate([
            'chapter_number' => 'required|integer',
            'title'          => 'required|string|max:255',
            'content'        => 'required',
            'chapter_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'         => 'required|in:draft,published',
        ]);

        $book = Book::where('user_id', Auth::id())->findOrFail($bookId);

        // Data yang akan disimpan
        $data = [
            'book_id'        => $book->id,
            'chapter_number' => $request->input('chapter_number'),
            'title'          => $request->input('title'),
            'content'        => $request->input('content'),
            'status'         => $request->input('status'),
        ];

        // Handle Upload Foto Ilustrasi Chapter
        if ($request->hasFile('chapter_image')) {
            if ($chapterId) {
                $oldChapter = Chapter::find($chapterId);
                if ($oldChapter && $oldChapter->image) {
                    Storage::disk('public')->delete($oldChapter->image);
                }
            }
            $data['image'] = $request->file('chapter_image')->store('chapter-images', 'public');
        }

        if ($chapterId) {
            // Update Chapter
            $chapter = Chapter::where('book_id', $book->id)->findOrFail($chapterId);
            $chapter->update($data);
            $message = 'Bab berhasil diperbarui!';
        } else {
            // Buat Chapter Baru
            Chapter::create($data);
            $message = 'Bab baru berhasil ditambahkan!';
        }

        return redirect()->to('/penulis/buku/'.$book->id.'/chapters')->with('success', $message);
    }

    // =========================================================================
    // KELOLA BUKU UTAMA (TAMBAH & EDIT NOVEL BARU)
    // =========================================================================

    // 5. Form Membuat Buku/Novel Baru
    public function createBook()
    {
        return view('writer.create');
    }

    // 6. Menyimpan Buku/Novel Baru
    public function storeBook(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'genre'       => 'required|string',
            'year'        => 'nullable|numeric',
            'description' => 'required|string',
            'cover'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'      => 'required|in:draft,published',
        ]);

        $coverPath = null;
        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('covers', 'public');
        }

        // Jika status yang dipilih published, ubah menjadi pending agar divalidasi admin
        $statusInput = $request->input('status');
        if ($statusInput === 'published') {
            $statusInput = 'pending';
        }

        $book = Book::create([
            'user_id'     => Auth::id(),
            'title'       => $request->input('title'),
            'author'      => $request->input('author', Auth::user()->username ?? 'Penulis'),
            'genre'       => $request->input('genre'),
            'year'        => $request->input('year', date('Y')),
            'description' => $request->input('description'),
            'image_path'  => $coverPath,
            'status'      => $statusInput,
        ]);

        return redirect()->to('/penulis/buku/'.$book->id.'/chapters')
                         ->with('success', 'Buku baru berhasil dibuat dan diajukan untuk validasi!');
    }

    // 7. Form Edit Detail Buku/Novel
    public function editBook($bookId)
    {
        $book = Book::where('user_id', Auth::id())->findOrFail($bookId);
        return view('writer.edit', compact('book'));
    }

    // 8. Memperbarui Detail Buku/Novel
    public function updateBook(Request $request, $bookId)
    {
        $book = Book::where('user_id', Auth::id())->findOrFail($bookId);

        $request->validate([
            'title'       => 'required|string|max:255',
            'genre'       => 'required|string',
            'year'        => 'nullable|numeric',
            'description' => 'required|string',
            'cover'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'      => 'required|in:draft,published',
        ]);

        // Jika penulis memilih published, ubah menjadi pending untuk validasi admin
        $statusInput = $request->input('status');
        if ($statusInput === 'published') {
            $statusInput = 'pending';
        }

        $data = [
            'title'       => $request->input('title'),
            'author'      => $request->input('author', $book->author),
            'genre'       => $request->input('genre'),
            'year'        => $request->input('year'),
            'description' => $request->input('description'),
            'status'      => $statusInput,
        ];

        if ($request->hasFile('cover')) {
            if ($book->image_path) {
                Storage::disk('public')->delete($book->image_path);
            }
            $data['image_path'] = $request->file('cover')->store('covers', 'public');
        }

        $book->update($data);

        return redirect()->to('/penulis/buku')
                         ->with('success', 'Informasi buku berhasil diperbarui dan diajukan untuk validasi!');
    }

    // 9. Menghapus Buku/Novel beserta file cover dan chapternya
    public function destroyBook($bookId)
    {
        $book = Book::where('user_id', Auth::id())->findOrFail($bookId);

        // Hapus file cover jika ada
        if ($book->image_path && Storage::disk('public')->exists($book->image_path)) {
            Storage::disk('public')->delete($book->image_path);
        }

        // Hapus seluruh bab terkait lalu hapus bukunya
        $book->chapters()->delete();
        $book->delete();

        return redirect()->to('/penulis/buku')->with('success', 'Buku beserta seluruh bab berhasil dihapus!');
    }

    // 10. Halaman Baca / Pratinjau Buku Khusus Penulis
    public function readBook($bookId)
    {
        $book = Book::where('user_id', Auth::id())->with('chapters')->findOrFail($bookId);
        $chapters = $book->chapters()->orderBy('chapter_number', 'asc')->get();

        return view('writer.read', compact('book', 'chapters'));
    }
}