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

        // Ambil semua genre unik dari buku yang disetujui
        $all_genres = Book::where('status', 'approved')->pluck('genre')->unique();

        // Query buku berdasarkan status, genre, dan search
        $books_query = Book::where('status', 'approved');

        if ($current_genre) {
            $books_query->where('genre', $current_genre);
        }

        if ($search) {
            $books_query->where('title', 'like', "%{$search}%");
        }

        $books_to_show = $books_query->get();

        // Ambil favorite books user jika login
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
