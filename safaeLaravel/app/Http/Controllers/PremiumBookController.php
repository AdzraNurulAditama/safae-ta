<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\PenukaranPoint;
use Illuminate\Support\Facades\Auth;

class PremiumBookController extends Controller
{
    public function index()
    {
        // ambil semua buku premium
        $books = Book::where('is_premium', 1)->get();

        return view('premium.bukuPrem', compact('books'));
    }

    public function tukar(Book $book)
    {
        $user = Auth::user();

        // cek sudah pernah tukar
        $sudahDitukar = PenukaranPoint::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->exists();

        if ($sudahDitukar) {
            return redirect()->route('book.show', $book->id);
        }

        // cek poin cukup
        if ($user->points < $book->premium_point) {
            return back()->with(
                'error',
                'Poin tidak cukup. Silakan tambah poin terlebih dahulu.'
            );
        }

        // potong poin user
        $user->decrement('points', $book->premium_point);

        // simpan riwayat penukaran
        PenukaranPoint::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'point_used' => $book->premium_point
        ]);

        return back()->with(
            'success',
            'Buku premium berhasil dibuka.'
        );
    }
}