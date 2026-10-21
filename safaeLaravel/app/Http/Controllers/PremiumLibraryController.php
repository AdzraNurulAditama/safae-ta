<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class PremiumLibraryController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::where('is_premium', 1)
            ->whereIn('status', ['approved', 'published']);

        // Ambil daftar genre buku premium
        $genres = (clone $query)
            ->whereNotNull('genre')
            ->where('genre', '!=', '')
            ->distinct()
            ->orderBy('genre')
            ->pluck('genre');

        // Pencarian berdasarkan judul atau penulis
        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan genre
        if ($request->filled('genre')) {
            $query->where('genre', $request->input('genre'));
        }

        // Ambil buku premium beserta jumlah bab
        $books = Book::query()
            ->where('is_premium', 1)
            ->where('status', 'approved')
            ->withCount([
                'chapters' => function ($query) {
                    $query->where('status', 'published');
                }
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        return view('premium.bukuPrem', compact('books', 'genres'));
    }
}