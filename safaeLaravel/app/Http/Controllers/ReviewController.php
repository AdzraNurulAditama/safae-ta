<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Tampilkan ulasan untuk 1 buku
    public function index($id)
    {
        $book = Book::findOrFail($id);

        $reviews = $book->reviews()->with('user')->latest()->get();
        $avgRating = round($book->reviews()->avg('rating') ?? 0, 1);
        $totalReview = $reviews->count();

        return view('reviews.index', compact('book', 'reviews', 'avgRating', 'totalReview'));
    }

    // Tambah ulasan
    public function store(Request $request, $id)
{
    $book = Book::findOrFail($id);

    $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'komentar' => 'required|max:500',
    ]);

    if ($book->reviews()->where('user_id', Auth::id())->exists()) {
        return back()->with('error', 'Kamu sudah memberi ulasan.');
    }

    $book->reviews()->create([
        'user_id' => Auth::id(),
        'rating' => $request->rating,
        'komentar' => $request->komentar,
    ]);

    return back()->with('success', 'Ulasan berhasil dikirim!');
}
}