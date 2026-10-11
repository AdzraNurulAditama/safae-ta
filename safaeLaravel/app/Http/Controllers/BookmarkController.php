<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function index()
    {
        $bookmarks = Bookmark::with('book')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('books.bookmark', compact('bookmarks'));
    }

    public function toggle($bookId)
    {
        $userId = Auth::id();

        $bookmark = Bookmark::where('user_id', $userId)
            ->where('book_id', $bookId)
            ->first();

        if ($bookmark) {
            $bookmark->delete();
            return back()->with('success', 'Buku berhasil dihapus dari bookmark.');
        }

        Bookmark::create([
            'user_id' => $userId,
            'book_id' => $bookId,
        ]);

        return back()->with('success', 'Buku berhasil ditambahkan ke bookmark!');
    }

    public function destroy($id)
    {
        $bookmark = Bookmark::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $bookmark->delete();

        return back()->with('success', 'Bookmark berhasil dihapus.');
    }
}