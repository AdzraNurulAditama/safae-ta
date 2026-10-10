<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\FavoriteBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class BukuFavoritController extends Controller
{
    public function index()
    {
        $books = Book::where('status', 'approved')->get();

        $favorites = FavoriteBook::with('book')->where('user_id', Auth::id())->latest()->get();

        return view('books.bukuFavorit', [
            'books'     => $books,
            'favorites' => $favorites
        ]);
    }
    public function tambah(Request $request)
    {
        $request->validate([
        'book_id' => 'required|exists:books,id'
        ]);

            $fav = FavoriteBook::firstOrCreate([
        'user_id' => Auth::id(),
        'book_id' => $request->book_id
    ]);


    if ($fav->wasRecentlyCreated) {
        \App\Models\Notification::create([
            'user_id' => Auth::id(),
            'message' => 'Buku "' . $fav->book->judul . '" ditambahkan ke favorit',
            'url' => route('favorite.index')
        ]);
    }


return redirect('/genre');

    }
    public function hapus(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id'
        ]);

        FavoriteBook::where('user_id', Auth::id())->where('book_id', $request->book_id)->delete();

        return redirect('/buku-favorit');
    }
}
