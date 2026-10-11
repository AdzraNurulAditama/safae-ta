<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Chapter;
use App\Models\ReadingHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FullBacaanController extends Controller
{
    public function show($id, $page = 1)
    {
        $book = Book::with('chapters')->findOrFail($id);

        if ($book->is_premium) {
            $akses = \App\Models\PremiumBookUser::where('user_id', Auth::id())
                ->where('book_id', $book->id)
                ->exists();

            if (!$akses) {
                return redirect()
                    ->route('premium.books')
                    ->with('error', 'Silakan tukarkan poin terlebih dahulu.');
            }
        }

        if (Auth::check()) {
            $existingReader = ReadingHistory::where('user_id', Auth::id())
                ->where('book_id', $book->id)
                ->exists();

            if (!$existingReader) {
                $book->increment('reader_count');
                $book->refresh();

                if ($book->reader_count >= 100000 && !$book->premium_notified) {
                    \App\Models\Notification::create([
                        'user_id' => $book->user_id,
                        'title' => 'Buku Siap Premium',
                        'message' => '🎉 Buku "' . $book->title . '" telah mencapai 100.000 pembaca dan dapat diajukan menjadi Premium.',
                    ]);

                    $book->update([
                        'premium_notified' => true
                    ]);
                }
            }

            ReadingHistory::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'book_id' => $book->id,
                ],
                [
                    'progress' => $page,
                    'last_read_at' => now(),
                ]
            );
        }

        // =========================================================
        // PROSES ISI BUKU (CEK DARI CHAPTER ATAU LANGSUNG DARI BUKU)
        // =========================================================
        $chapters = $book->chapters()->orderBy('chapter_number', 'asc')->get();
        $totalHalaman = $chapters->count();

        // JIKA BUKU MEMILIKI CHAPTER/BAB
        if ($totalHalaman > 0) {
            if ($page < 1) $page = 1;
            if ($page > $totalHalaman) $page = $totalHalaman;

            $currentChapter = $chapters->values()->get($page - 1);
            $halamanKonten = $currentChapter ? $currentChapter->content : 'Konten tidak ditemukan.';
        } 
        // JIKA BUKU TIDAK ADA CHAPTER (TEKS DISIMPAN LANGSUNG DI TABEL BUKU SEPERTI DI ADMIN)
        else {
            /* 
             * PENTING: Cek phpMyAdmin/Database kamu! 
             * Apa nama kolom untuk "ISI BUKU LENGKAP" di tabel books? 
             * Ganti "isi_buku" di bawah ini dengan nama kolom aslinya.
             * (Biasanya bernama 'content', 'isi_buku', 'manuskrip', atau 'description')
             */
            
            // Saya asumsikan nama kolomnya antara isi_buku atau content
            if (!empty($book->isi_buku)) {
                $halamanKonten = $book->isi_buku;
            } elseif (!empty($book->content)) {
                $halamanKonten = $book->content;
            } else {
                $halamanKonten = 'Belum ada konten pada buku ini.';
            }

            $currentChapter = null;
            $totalHalaman = 1; // Karena hanya 1 teks panjang, dihitung 1 halaman
            $page = 1;
        }

        return view('books.fullbacaan', [
            'buku' => $book,
            'halaman' => $halamanKonten,
            'chapter' => $currentChapter,
            'page' => $page,
            'totalHalaman' => $totalHalaman
        ]);
    }

    public function ulasan($id)
    {
        $book = Book::with('reviews.user')->findOrFail($id);

        $reviews = $book->reviews;
        $totalReview = $reviews->count();

        if ($totalReview > 0) {
            $avgRating = round($reviews->avg('rating'), 1);
        } else {
            $avgRating = 0;
        }

        return view('review.index', [
            'book' => $book,
            'reviews' => $reviews,
            'totalReview' => $totalReview,
            'avgRating' => $avgRating
        ]);
    }

    public function storeReview(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string'
        ]);

        $book = Book::findOrFail($id);

        $book->reviews()->create([
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'komentar' => $request->komentar
        ]);

        return redirect()->route('ulasan.index', $id)
            ->with('success', 'Ulasan berhasil ditambahkan!');
    }
}