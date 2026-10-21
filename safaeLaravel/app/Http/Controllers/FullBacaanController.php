<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\ChapterUnlock;
use App\Models\PremiumBookUser;
use App\Models\PenukaranPoint;
use App\Models\ReadingHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FullBacaanController extends Controller
{
    public function show($id, $page = 1)
    {
        $book = Book::findOrFail($id);

        // AMBIL BAB BUKU
        $chapters = $book->chapters()
        ->where('status', 'published')
        ->orderBy('chapter_number')
        ->get();

        $totalHalaman = $chapters->count();

        if ($totalHalaman > 0) {
            $page = max(1, min((int) $page, $totalHalaman));
            $currentChapter = $chapters->get($page - 1);
        } else {
            $page = 1;
            $currentChapter = null;
            $totalHalaman = 1;
        }

        // PEMERIKSAAN AKSES PREMIUM
        $isChapterLocked = false;

        if ($book->is_premium && $currentChapter && $currentChapter->is_premium) {
            $userId = Auth::id();

            if (!$userId) {
                return redirect()->route('login')
                    ->with('error', 'Silakan login untuk membuka bab premium.');
            }

            // Akses seluruh buku melalui PremiumBookUser
            $hasBookAccess = PremiumBookUser::where('user_id', $userId)
                ->where('book_id', $book->id)
                ->exists();

            // Akses seluruh buku dari penukaran sistem lama
            $hasOldAccess = PenukaranPoint::where('user_id', $userId)
                ->where('book_id', $book->id)
                ->exists();

            // Akses satu bab menggunakan poin
            $hasChapterAccess = ChapterUnlock::where('user_id', $userId)
                ->where('chapter_id', $currentChapter->id)
                ->exists();

            // Kunci bab jika pengguna belum memiliki akses
            $isChapterLocked = !($hasBookAccess || $hasOldAccess || $hasChapterAccess);
        }

        // RIWAYAT MEMBACA DAN JUMLAH PEMBACA
        if (Auth::check() && !$isChapterLocked) {
            $existingReader = ReadingHistory::where('user_id', Auth::id())
                ->where('book_id', $book->id)
                ->exists();

            if (!$existingReader) {
                $book->increment('reader_count');
                $book->refresh();

                // NOTIFIKASI 100.000 PEMBACA
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

            $totalPagesHistory = $totalHalaman;

            $status = ($page >= $totalPagesHistory)
                ? 'Selesai Dibaca'
                : 'Sedang Dibaca';

            $percentage = round(
                ($page / max($totalPagesHistory, 1)) * 100,
                2
            );

            ReadingHistory::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'book_id' => $book->id
                ],
                [
                    'last_page' => $page,
                    'total_pages' => $totalPagesHistory,
                    'progress' => $page,
                    'progress_percentage' => $percentage,
                    'status' => $status,
                    'last_read_at' => now()
                ]
            );
        }

        // TAMPILKAN ISI BUKU
        if ($isChapterLocked) {
            // Konten bab terkunci tidak dikirim ke halaman
            $halamanKonten = null;
        } elseif ($currentChapter) {
            $halamanKonten = $currentChapter->content;
        } else {
            if (!empty($book->isi_buku)) {
                $halamanKonten = $book->isi_buku;
            } elseif (!empty($book->content)) {
                $halamanKonten = $book->content;
            } else {
                $halamanKonten = 'Belum ada konten pada buku ini.';
            }
        }

        return view('books.fullbacaan', [
            'buku' => $book,
            'halaman' => $halamanKonten,
            'chapter' => $currentChapter,
            'page' => $page,
            'totalHalaman' => $totalHalaman,
            'isChapterLocked' => $isChapterLocked
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
