<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    /**
     * Tampilkan halaman daftar bookmark milik user.
     */
    public function index()
    {
        $userId = Auth::id();

        // Ambil semua bookmark user beserta relasi buku
        $bookmarks = Bookmark::with('book')
            ->where('user_id', $userId)
            ->get();

        // Kelompokkan data bookmark berdasarkan genre bukunya
        $groupedBookmarks = $bookmarks->groupBy(function ($item) {
            return $item->book->genre ?? 'Umum';
        });

        return view('books.bookmark', compact('bookmarks', 'groupedBookmarks'));
    }

    /**
     * Fitur Toggle Bookmark (Tambah/Hapus langsung dari kartu buku).
     */
    public function toggle($bookId)
    {
        $userId = Auth::id();

        $bookmark = Bookmark::where('user_id', $userId)
            ->where('book_id', $bookId)
            ->first();

        if ($bookmark) {
            $bookmark->delete();
            return redirect()->back()->with('success', 'Buku dihapus dari bookmark.');
        } else {
            Bookmark::create([
                'user_id' => $userId,
                'book_id' => $bookId,
            ]);
            return redirect()->back()->with('success', 'Buku berhasil disimpan ke bookmark!');
        }
    }

    /**
     * Hapus bookmark berdasarkan ID Bookmark (Method destroy untuk Route DELETE /bookmarks/{id}).
     */
    public function destroy($id)
    {
        $bookmark = Bookmark::where('user_id', Auth::id())->findOrFail($id);
        $bookmark->delete();

        return redirect()->back()->with('success', 'Buku berhasil dihapus dari Bookmark!');
    }

    /**
     * Alias remove jika route kamu memanggil method remove.
     */
    public function remove($id)
    {
        return $this->destroy($id);
    }
}