<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Chapter;
use App\Models\ChapterUnlock;
use App\Models\PremiumBookUser;
use App\Models\PenukaranPoint;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PremiumAccessController extends Controller
{
    // MEMBUKA SATU BAB DENGAN 50 POIN
    public function unlockChapter(Chapter $chapter): RedirectResponse
    {
        $book = $chapter->book;

        if (!$book || !in_array($book->status, ['approved', 'published'], true) || $chapter->status !== 'published') {
            abort(404);
        }

        if (!$book->is_premium || !$chapter->is_premium) {
            return back()->with('info', 'Bab ini dapat dibaca secara gratis.');
        }

        $userId = Auth::id();
        $price = 50;

        if (!$userId) {
            return redirect()->route('login');
        }

        $result = DB::transaction(function () use ($chapter, $book, $userId, $price) {
            $user = User::whereKey($userId)->lockForUpdate()->firstOrFail();

            // Periksa apakah bab sudah dibuka
            $hasChapter = ChapterUnlock::where('user_id', $userId)
                ->where('chapter_id', $chapter->id)
                ->exists();

            // Periksa apakah pengguna sudah punya akses seluruh buku
            $hasBookAccess = PremiumBookUser::where('user_id', $userId)
                ->where('book_id', $book->id)
                ->exists();

            // Periksa akses dari sistem lama
            $hasOldAccess = PenukaranPoint::where('user_id', $userId)
                ->where('book_id', $book->id)
                ->exists();

            if ($hasChapter || $hasBookAccess || $hasOldAccess) {
                return 'already';
            }

            // Periksa saldo poin pengguna
            if ($user->points < $price) {
                return 'insufficient';
            }

            // Kurangi 50 poin
            $user->decrement('points', $price);

            // Simpan akses bab
            ChapterUnlock::create([
                'user_id' => $userId,
                'chapter_id' => $chapter->id,
                'points_spent' => $price
            ]);

            return 'success';
        });

        if ($result === 'insufficient') {
            return back()->with('error', 'Poin tidak cukup untuk membuka bab ini.');
        }

        // Kembali ke bab yang baru dibuka
        $page = $book->chapters()
            ->where('chapter_number', '<', $chapter->chapter_number)
            ->count() + 1;

        return redirect()
            ->route('book.show', [
                'id' => $book->id,
                'page' => $page
            ])
            ->with(
                'success',
                $result === 'already'
                    ? 'Kamu sudah memiliki akses ke bab ini.'
                    : 'Bab berhasil dibuka menggunakan 50 poin!'
            );
    }

    // SIMULASI PEMBAYARAN Rp15.000 UNTUK SELURUH BUKU
    public function simulateBookPayment(Book $book): RedirectResponse
    {
        if (!in_array($book->status, ['approved', 'published'], true) || !$book->is_premium) {
            abort(404);
        }

        $userId = Auth::id();

        if (!$userId) {
            return redirect()->route('login');
        }

        DB::transaction(function () use ($book, $userId) {
            User::whereKey($userId)->lockForUpdate()->firstOrFail();

            // Periksa apakah pengguna sudah memiliki akses buku
            $hasAccess = PremiumBookUser::where('user_id', $userId)
                ->where('book_id', $book->id)
                ->exists();

            $hasOldAccess = PenukaranPoint::where('user_id', $userId)
                ->where('book_id', $book->id)
                ->exists();

            // Simpan akses jika belum dimiliki
            if (!$hasAccess && !$hasOldAccess) {
                PremiumBookUser::create([
                    'user_id' => $userId,
                    'book_id' => $book->id
                ]);
            }
        });

        return back()->with(
            'success',
            'Simulasi pembayaran Rp15.000 berhasil! Semua bab premium buku ini sudah terbuka. Tidak ada uang sungguhan yang ditagihkan.'
        );
    }
}
