<?php

namespace App\Http\Controllers;

use App\Models\FavoriteBook;
use App\Models\Book;
use Illuminate\Http\Request;

class AdminBukuFavoritController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $favorites = FavoriteBook::with(['user', 'book'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('user', function ($user) use ($search) {
                        $user->where('username', 'like', "%{$search}%");
                    })->orWhereHas('book', function ($book) use ($search) {
                        $book->where('title', 'like', "%{$search}%");
                    });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $totalFavorites = FavoriteBook::count();
        $totalBooks = FavoriteBook::distinct('book_id')->count('book_id');
        $totalUsers = FavoriteBook::distinct('user_id')->count('user_id');

        
        $popularBooks = Book::whereHas('favorites')
            ->withCount('favorites')
            ->orderByDesc('favorites_count')
            ->take(3)
            ->get();


        return view('admin.bukufav.index', compact(
            'favorites',
            'totalFavorites',
            'totalBooks',
            'totalUsers',
            'popularBooks'
        ));
    }

    public function show($id)
    {
        $favorite = FavoriteBook::with(['user', 'book'])
            ->findOrFail($id);

        $book = $favorite->book;

        $chapterCount = $book ? $book->chapters()->count() : 0;
        $favoriteCount = $book
            ? FavoriteBook::where('book_id', $book->id)->count()
            : 0;

        $favoriteUsers = $book
            ? FavoriteBook::with('user')
                ->where('book_id', $book->id)
                ->latest()
                ->get()
            : collect();

        return view('admin.bukufav.show', compact(
            'favorite',
            'book',
            'chapterCount',
            'favoriteCount',
            'favoriteUsers'
        ));
    }

    public function destroy($id)
    {
        $favorite = FavoriteBook::findOrFail($id);
        $favorite->delete();

        return redirect()
            ->route('admin.favorit.index')
            ->with('success', 'Buku berhasil dihapus dari daftar favorit pengguna.');
    }
}
