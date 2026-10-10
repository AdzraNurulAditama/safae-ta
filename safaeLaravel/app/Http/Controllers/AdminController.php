<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Ambil semua buku dari database, urutkan terbaru
        $books = Book::orderBy('created_at', 'desc')->get();

        // Kirim ke view 'admin.admin'
        return view('admin.admin', compact('books'));
    }
}
