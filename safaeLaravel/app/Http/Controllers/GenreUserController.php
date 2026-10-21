<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\FavoriteBook;
use App\Models\Bookmark;
use Illuminate\Support\Facades\Auth;

class GenreUserController extends Controller
{
    public function index(Request $request)
    {
        $current_genre = $request->input('genre', '');
        $search = $request->input('search', '');

        // Status buku yang boleh dilihat pembaca
        $publicStatuses = ['approved', 'published'];

        // Hanya mengambil buku gratis
        // Buku premium tidak tampil di halaman Genre
        $freeBooks = Book::whereIn('status', $publicStatuses)
            ->where(function ($query) {
                $query->where('is_premium', 0)
                      ->orWhereNull('is_premium');
            });

        // Ambil daftar genre dari buku gratis
        $all_genres = (clone $freeBooks)
            ->whereNotNull('genre')
            ->where('genre', '!=', '')
            ->distinct()
            ->orderBy('genre')
            ->pluck('genre');

        // Ambil buku beserta jumlah likes
       $books_query = (clone $freeBooks)
        ->withCount([
            'favorites as likes_count',
            'chapters as chapters_count' => function ($query) {
                $query->where('status', 'published');
            }
        ]);

        // Filter genre
        if (!empty($current_genre)) {
            $books_query->where('genre', $current_genre);
        }

        // Search berdasarkan judul atau penulis
        if (!empty($search)) {
            $books_query->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                      ->orWhere('author', 'like', "%{$search}%");
            });
        }

        // Pagination 10 buku per halaman
        $books_to_show = $books_query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // Buku favorit pengguna
        $favorites = [];
        $bookmarkedBookIds = [];

        if (Auth::check()) {
            $favorites = FavoriteBook::where('user_id', Auth::id())
                ->pluck('book_id')
                ->toArray();

            // Ambil bookmark hanya jika model dan tabel tersedia
            if (
                class_exists(Bookmark::class) &&
                \Illuminate\Support\Facades\Schema::hasTable('bookmarks')
            ) {
                $bookmarkedBookIds = Bookmark::where('user_id', Auth::id())
                    ->pluck('book_id')
                    ->toArray();
            }
        }

        return view('books.genre', compact(
            'books_to_show',
            'all_genres',
            'current_genre',
            'search',
            'favorites',
            'bookmarkedBookIds'
        ));
    }

    public function preview($id)
    {
        $book = Book::with([
            'reviews.user'
        ])
        ->withCount([
            'favorites as likes_count',
            'chapters'
        ])
        ->findOrFail($id);

        $recommendedBooks = Book::where('id', '!=', $book->id)
            ->whereIn('status', ['approved', 'published'])
            ->where(function ($query) {
                $query->where('is_premium', 0)
                      ->orWhereNull('is_premium');
            })
            ->where('genre', $book->genre)
            ->latest()
            ->take(4)
            ->get();

        return view('books.preview', compact(
            'book',
            'recommendedBooks'
        ));
    }
}
