<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class GenreUserController extends Controller
{
    public function index(Request $request)
    {
        // Ambil query parameter
        $current_genre = $request->input('genre', '');
        $search = $request->input('search', '');

        // Status buku publik yang ditampilkan (approved atau published)
        $publicStatuses = ['approved', 'published'];

        // Ambil semua genre unik dari buku yang sudah disetujui / dipublikasikan
        $all_genres = Book::whereIn('status', $publicStatuses)
                          ->pluck('genre')
                          ->unique()
                          ->filter()
                          ->values();

        // Query buku berdasarkan status, genre, dan pencarian
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

        // Ambil ID buku favorit user jika dalam kondisi terautentikasi (login)
        $favorites = [];
        if (Auth::check()) {
            $favorites = Auth::user()->favoriteBooks()->pluck('book_id')->toArray();
        }

        return view('books.genre', compact(
            'books_to_show',
            'all_genres',
            'current_genre',
            'search',
            'favorites'
        ));
    }
}