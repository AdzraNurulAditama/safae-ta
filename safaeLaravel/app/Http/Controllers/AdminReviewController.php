<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class AdminReviewController extends Controller
{
    // =====================================================
    // TAMPILKAN SEMUA ULASAN BUKU (ADMIN)
    // =====================================================
    public function index()
    {
        $reviews = Review::with(['user', 'book'])->latest()->get();

        return view('admin.reviews.index', [
            'reviews' => $reviews
        ]);
    }

    // =====================================================
    // TAMPILKAN DETAIL ULASAN SATUAN (ADMIN)
    // =====================================================
    public function show($id)
    {
        $review = Review::with(['user', 'book'])->findOrFail($id);

        return view('admin.reviews.show', [
            'review' => $review
        ]);
    }

    // =====================================================
    // HAPUS DATA ULASAN (ADMIN)
    // =====================================================
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        // DI-FIX: Menggunakan route name dan menambahkan flash message success
        return redirect()->route('admin.reviews.index')
                         ->with('success', 'Ulasan buku berhasil dihapus dari sistem!');
    }
}