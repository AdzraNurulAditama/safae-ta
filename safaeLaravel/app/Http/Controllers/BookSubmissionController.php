<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class BookSubmissionController extends Controller
{
    private $opsi_genre = [
        'Romance', 'Fantasi', 'Misteri', 'Thriller', 'Sci-Fi', 
        'Horor', 'Petualangan', 'Komedi', 'Drama', 'Sejarah'
    ];

    /**
     * Untuk route resource (GET /tulis-buku)
     */
    public function index()
    {
        return view('user.tulis-buku', [
            'opsi_genre' => $this->opsi_genre
        ]);
    }

    /**
     * Untuk route resource (GET /tulis-buku/create)
     */
    public function create()
    {
        return view('user.tulis-buku', [
            'opsi_genre' => $this->opsi_genre
        ]);
    }

    /**
     * Simpan buku (POST)
     */
    public function store(Request $request)
    {
        $data_valid = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'genre' => 'required|string',
            'year' => 'required|integer',
            'description' => 'required|string',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $jalur_gambar = $request->file('image')->store('covers', 'public');
            $data_valid['image_path'] = '/storage/' . $jalur_gambar;
        }

        $data_valid['status'] = 'pending';

        $data_valid['user_id'] = Auth::id();

        Book::create($data_valid);

        return redirect('/tulis-buku')->with('success', 'Buku berhasil dikirim! Mohon tunggu validasi dari Admin.');
    }

    /**
     * ================= ADMIN =================
     */

    public function indexAdmin()
    {
        $semua_buku = Book::where('status', 'pending')
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('admin.validasi.index', [
            'pending_books' => $semua_buku
        ]);
    }

    public function approve($id)
    {
        $buku = Book::findOrFail($id);
        $buku->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Buku berhasil disetujui dan tayang!');
    }

    public function reject($id)
    {
        $buku = Book::findOrFail($id);
        $buku->update(['status' => 'rejected']);

        return redirect()->back()->with('error', 'Buku telah ditolak.');
    }
}