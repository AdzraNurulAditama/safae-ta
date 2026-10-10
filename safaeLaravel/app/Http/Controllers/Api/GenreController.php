<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GenreController extends Controller
{
    public function index(Request $request)
    {
        $current_genre = $request->query('genre', '');
        $search = $request->query('search', '');

        // Ambil genre unik
        $all_genres = Book::where('status', 'approved')
            ->pluck('genre')
            ->unique()
            ->values();

        // Query buku
        $books_query = Book::where('status', 'approved');

        if (!empty($current_genre)) {
            $books_query->where('genre', $current_genre);
        }

        if (!empty($search)) {
            $books_query->where('title', 'like', "%{$search}%");
        }

        // Ambil data buku + mapping gambar
        $books = $books_query->get()->map(function ($book) {
            return [
                'id' => $book->id,
                'title' => $book->title,
                'genre' => $book->genre,
                'author' => $book->author ?? '',
                'description' => $book->description ?? '',
                'image' => $book->cover
                    ? asset('storage/' . $book->cover)
                    : null,
            ];
        });

        // Favorite user (jika login)
        $favorites = [];
        if (Auth::check()) {
            $favorites = Auth::user()
                ->favoriteBooks()
                ->pluck('book_id');
        }

        return response()->json([
            'status' => true,
            'message' => 'Data genre dan buku berhasil diambil',
            'data' => [
                'genres' => $all_genres,
                'current_genre' => $current_genre,
                'search' => $search,
                'books' => $books,
                'favorites' => $favorites
            ]
        ]);
    }
}
