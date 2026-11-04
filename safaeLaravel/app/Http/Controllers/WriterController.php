<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Chapter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class WriterController extends Controller
{
    // 1. Menampilkan daftar buku milik penulis
public function index()
{
    $books = Book::where('user_id', Auth::id())
        ->withCount([
            'chapters',
            'favorites as favorites_count',
            'komentar as comments_count'
        ])
        ->with('premiumRequests')
        ->latest()
        ->get();

    return view('writer.index', compact('books'));
}

    // 2. Menampilkan daftar bab berdasarkan buku
    public function chapters($bookId)
    {
        $book = Book::where('user_id', Auth::id())
            ->findOrFail($bookId);

        $chapters = $book->chapters()
            ->orderBy('chapter_number', 'asc')
            ->get();

        return view('writer.chapters-index', compact('book', 'chapters'));
    }

    // 3. Form tambah atau edit bab
    public function editor($bookId, $chapterId = null)
    {
        $book = Book::where('user_id', Auth::id())
            ->findOrFail($bookId);

        $chapter = null;

        if ($chapterId) {
            $chapter = Chapter::where('book_id', $book->id)
                ->findOrFail($chapterId);
        }

        // Nomor bab berikutnya
        $nextChapterNumber = ($book->chapters()
            ->max('chapter_number') ?? 0) + 1;

        return view('writer.editor', compact(
            'book',
            'chapter',
            'nextChapterNumber'
        ));
    }

    // 4. Menyimpan atau memperbarui bab
    // Mendukung Draft, Published, Gratis, Premium, dan Ilustrasi
    public function saveChapter(Request $request, $bookId, $chapterId = null)
    {
        $request->validate([
            'chapter_number' => 'required|integer|min:1',
            'title'          => 'required|string|max:255',
            'content'        => 'required|string',
            'chapter_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'         => 'required|in:draft,published',
            'is_premium'     => 'required|in:0,1',
        ]);

        // Pastikan buku milik penulis yang login
        $book = Book::where('user_id', Auth::id())
            ->findOrFail($bookId);

        // Ambil bab lama atau buat bab baru
        if ($chapterId) {
            $chapter = Chapter::where('book_id', $book->id)
                ->findOrFail($chapterId);
        } else {
            $chapter = new Chapter();
        }

        // Simpan informasi bab
        $chapter->book_id = $book->id;
        $chapter->chapter_number = $request->input('chapter_number');
        $chapter->title = $request->input('title');
        $chapter->content = $request->input('content');
        $chapter->status = $request->input('status');

        // Simpan akses bab: 0 = Gratis, 1 = Premium
        $chapter->is_premium = $request->boolean('is_premium');

        // Upload ilustrasi bab jika ada
        $oldImage = $chapter->image;
        $newImage = null;

        if ($request->hasFile('chapter_image')) {
            $newImage = $request->file('chapter_image')
                ->store('chapter-images', 'public');

            $chapter->image = $newImage;
        }

        try {
            $chapter->save();
        } catch (\Throwable $e) {
            // Hapus file baru jika penyimpanan database gagal
            if ($newImage) {
                Storage::disk('public')->delete($newImage);
            }

            throw $e;
        }

        // Hapus ilustrasi lama setelah data berhasil disimpan
        if ($newImage && $oldImage && $oldImage !== $newImage) {
            Storage::disk('public')->delete($oldImage);
        }

        $message = $chapterId
            ? 'Bab berhasil diperbarui!'
            : 'Bab baru berhasil ditambahkan!';

        return redirect()
            ->route('writer.chapters.index', ['book' => $book->id])
            ->with('success', $message);
    }

// 5. Menghapus bab milik penulis
public function destroyChapter($bookId, $chapterId)
{
    // Pastikan buku merupakan milik penulis yang sedang login
    $book = Book::where('user_id', Auth::id())
        ->findOrFail($bookId);

    // Pastikan bab merupakan bagian dari buku tersebut
    $chapter = Chapter::where('book_id', $book->id)
        ->findOrFail($chapterId);

    // Hapus ilustrasi bab dari storage jika tersedia
    if (
        $chapter->image &&
        Storage::disk('public')->exists($chapter->image)
    ) {
        Storage::disk('public')->delete($chapter->image);
    }

    // Hapus data bab
    $chapter->delete();

    return redirect()
        ->route('writer.chapters.index', ['book' => $book->id])
        ->with('success', 'Bab berhasil dihapus!');
}

    // =========================================================
    // KELOLA BUKU UTAMA
    // =========================================================

    // 5. Form membuat buku baru
    public function createBook()
    {
        return view('writer.create');
    }

    // 6. Menyimpan buku baru
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
            $coverPath = $request->file('cover')
                ->store('covers', 'public');
        }

        // Buku yang dipublikasikan harus menunggu persetujuan admin
        $statusInput = $request->input('status');

        if ($statusInput === 'published') {
            $statusInput = 'pending';
        }

        $book = Book::create([
            'user_id'     => Auth::id(),
            'title'       => $request->input('title'),
            'author'      => $request->input(
                'author',
                Auth::user()->username ?? 'Penulis'
            ),
            'genre'       => $request->input('genre'),
            'year'        => $request->input('year', date('Y')),
            'description' => $request->input('description'),
            'image_path'  => $coverPath,
            'status'      => $statusInput,
        ]);

        return redirect()
            ->route('writer.chapters.index', ['book' => $book->id])
            ->with(
                'success',
                'Buku baru berhasil dibuat dan diajukan untuk validasi!'
            );
    }

    // 7. Form edit detail buku
    public function editBook($bookId)
    {
        $book = Book::where('user_id', Auth::id())
            ->findOrFail($bookId);

        return view('writer.edit', compact('book'));
    }

    // 8. Memperbarui detail buku
    public function updateBook(Request $request, $bookId)
    {
        $book = Book::where('user_id', Auth::id())
            ->findOrFail($bookId);

        $request->validate([
            'title'       => 'required|string|max:255',
            'genre'       => 'required|string',
            'year'        => 'nullable|numeric',
            'description' => 'required|string',
            'cover'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'      => 'required|in:draft,published',
        ]);

        // Jika dipublikasikan, harus divalidasi admin
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

        // Upload cover baru jika ada
        if ($request->hasFile('cover')) {
            $oldCover = $book->image_path;

            $newCover = $request->file('cover')
                ->store('covers', 'public');

            $data['image_path'] = $newCover;
        }

        try {
            $book->update($data);
        } catch (\Throwable $e) {
            if (isset($newCover)) {
                Storage::disk('public')->delete($newCover);
            }

            throw $e;
        }

        // Hapus cover lama setelah update berhasil
        if (isset($newCover) && !empty($oldCover)) {
            Storage::disk('public')->delete($oldCover);
        }

        return redirect()
            ->route('writer.books.index')
            ->with(
                'success',
                'Informasi buku berhasil diperbarui dan diajukan untuk validasi!'
            );
    }

    // 9. Menghapus buku beserta cover dan seluruh bab
    public function destroyBook($bookId)
    {
        $book = Book::where('user_id', Auth::id())
            ->findOrFail($bookId);

        // Hapus cover dari storage
        if (
            $book->image_path &&
            Storage::disk('public')->exists($book->image_path)
        ) {
            Storage::disk('public')->delete($book->image_path);
        }

        // Hapus seluruh bab terkait
        $book->chapters()->delete();

        // Hapus buku
        $book->delete();

        return redirect()
            ->route('writer.books.index')
            ->with(
                'success',
                'Buku beserta seluruh bab berhasil dihapus!'
            );
    }

    // 10. Halaman baca/pratinjau khusus penulis
    public function readBook($bookId)
    {
        $book = Book::where('user_id', Auth::id())
            ->with('chapters')
            ->findOrFail($bookId);

        // Penulis tetap dapat melihat draft miliknya sendiri
        $chapters = $book->chapters()
            ->orderBy('chapter_number', 'asc')
            ->get();

        return view('writer.read', compact('book', 'chapters'));
    }
}
