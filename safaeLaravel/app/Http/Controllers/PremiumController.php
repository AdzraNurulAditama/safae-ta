<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\PremiumRequest;
use Illuminate\Support\Facades\Auth;

class PremiumController extends Controller
{
    public function index()
    {
        $books = Book::where(
            'user_id',
            Auth::id()
        )->get();

        return view(
            'premium.index',
            compact('books')
        );
    }

    public function store(Book $book)
    {
        PremiumRequest::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
        ]);

        return back()->with(
            'success',
            'Pengajuan premium berhasil dikirim'
        );
    }
}