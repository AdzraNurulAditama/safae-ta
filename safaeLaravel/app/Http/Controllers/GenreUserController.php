<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Bookmark; // Model Bookmark
use App\Models\FavoriteBook; // 🔥 1. TAMBAHKAN IMPORT MODEL FAVORITEBOOK DI SINI
use Illuminate\Support\Facades\Auth;

class GenreUserController extends Controller
{
    public function index(Request $request)
    {
        $current_genre = $request->input('genre', '');
        $search = $request->input('search', '');

        $publicStatuses = ['approved', 'published'];

        $all_genres = Book::whereIn('status', $publicStatuses)
                          ->pluck('genre')
                          ->unique()
                          ->filter()
                          ->values();

        $books_query = Book::whereIn('status', $publicStatuses);

        if ($current_genre) {
            $books_query->where('genre', $current_genre);
        }

        if ($search) {
            $books_query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }

        $books_to_show = $books_query->latest()->get();

        // Ambil daftar ID buku yang sudah di-bookmark oleh user yang sedang login
        $bookmarkedBookIds = [];
        if (Auth::check()) {
            $bookmarkedBookIds = Bookmark::where('user_id', Auth::id())
                ->pluck('book_id')
                ->toArray();
        }

        // 🔥 2. TAMBAHKAN KODE INI UNTUK MENGAMBIL DAFTAR ID BUKU FAVORIT USER
        $favorites = [];
        if (Auth::check()) {
            $favorites = FavoriteBook::where('user_id', Auth::id())
                ->pluck('book_id')
                ->toArray();
        }

        // 🔥 3. MASUKKAN 'favorites' KE DALAM COMPACT() DI BAWAH INI
        return view('books.genre', compact(
            'books_to_show',
            'all_genres',
            'current_genre',
            'search',
            'bookmarkedBookIds',
            'favorites'
        ));
    }

    /**
     * Aksi Simpan / Hapus Bookmark (Toggle)
     */
    public function toggleBookmark($bookId)
    {
        $userId = Auth::id();

        $bookmark = Bookmark::where('user_id', $userId)
            ->where('book_id', $bookId)
            ->first();

        if ($bookmark) {
            // Jika sudah ada, hapus bookmark
            $bookmark->delete();
            $message = 'Buku berhasil dihapus dari Bookmark!';
        } else {
            // Jika belum ada, simpan bookmark baru
            Bookmark::create([
                'user_id' => $userId,
                'book_id' => $bookId,
            ]);
            $message = 'Buku berhasil disimpan ke Bookmark!';
        }

        return redirect()->back()->with('success', $message);
    }

    public function preview($id)
    {
        $book = Book::with('reviews')->findOrFail($id);

        // Ambil 4 buku lain dengan genre sejenis sebagai rekomendasi "Anda Mungkin Juga Menyukai"
        $recommendedBooks = Book::where('genre', $book->genre)
            ->where('id', '!=', $book->id)
            ->whereIn('status', ['approved', 'published'])
            ->take(4)
            ->get();

        return view('books.preview', compact('book', 'recommendedBooks'));
    }
}