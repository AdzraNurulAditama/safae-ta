<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\PremiumRequest;
use App\Models\Notification;

class AdminPremiumController extends Controller
{
    public function index()
    {
        $requests = PremiumRequest::with([
            'user',
            'book'
        ])->latest()->get();

        return view(
            'admin.premium.index',
            compact('requests')
        );
    }
public function books()
{
    $requests = PremiumRequest::with([
        'user',
        'book'
    ])->latest()->get();

    $books = Book::latest()->get();

    return view(
        'admin.premium.books',
        compact('requests', 'books')
    );
}

public function setPremium(Request $request, Book $book)
{
    $request->validate([
        'premium_point' => 'required|integer|min:1'
    ]);

    $book->update([
        'is_premium' => true,
        'premium_point' => $request->premium_point
    ]);

    return back()->with(
        'success',
        'Buku berhasil dijadikan Premium.'
    );
}

    public function approve(Request $request, $id)
    {
        $request->validate([
            'premium_point' => 'required|integer|min:1'
        ]);

        $premium = PremiumRequest::findOrFail($id);

        $premium->update([
            'status' => 'approved'
        ]);

        $premium->book->update([
            'is_premium' => true,
            'premium_point' => $request->premium_point
        ]);

        Notification::create([
            'user_id' => $premium->user_id,
            'title' => 'Pengajuan Premium Disetujui',
            'message' => '🎉 Buku "' .
                $premium->book->title .
                '" berhasil menjadi Buku Premium.'
        ]);

        return back()->with(
            'success',
            'Pengajuan berhasil disetujui.'
        );
    }

 
    public function reject($id)
    {
        $premium = PremiumRequest::findOrFail($id);

        $premium->update([
            'status' => 'rejected'
        ]);

        Notification::create([
            'user_id' => $premium->user_id,
            'title' => 'Pengajuan Premium Ditolak',
            'message' => 'Pengajuan premium untuk buku "' .
                $premium->book->title .
                '" ditolak admin.'
        ]);

        return back()->with(
            'success',
            'Pengajuan berhasil ditolak.'
        );
    }

    public function destroy($id)
{
    $book = Book::findOrFail($id);

    $book->delete();

    return back()->with(
        'success',
        'Buku berhasil dihapus.'
    );
}
}