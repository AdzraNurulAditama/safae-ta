<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class BookFinishController extends Controller
{
    /**
     * Halaman setelah user selesai membaca buku:
     * popup "Cocok untukku" + daftar rekomendasi.
     */
    public function show(Book $book)
    {
        $user = auth()->user();

        // Buku yang sudah pernah dibaca user (tidak ikut direkomendasikan)
        $readIds = DB::table('reading_histories')
            ->where('user_id', $user->id)
            ->pluck('book_id');

        // Sudah pernah menilai buku ini? Kalau sudah, popup tidak muncul lagi.
        $sudahMenilai = BookFeedback::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->exists();

        // Tahap 2 (model Python) dulu, kalau gagal jatuh ke tahap 1 (aturan)
        $recs = $this->fromModel($user->id, $book->id, $readIds)
            ?? $this->fromRules($user->id, $book, $readIds);

        return view('feedback.finished', compact('book', 'recs', 'sudahMenilai'));
    }

    /**
     * Simpan label: cocok = 1 (cocok/membantu) atau 0 (belum cocok/kurang membantu).
     * Menutup popup tanpa memilih TIDAK menyimpan apa pun.
     */
    public function feedback(Request $request, Book $book)
    {
        $data = $request->validate([
            'cocok' => 'required|boolean',
        ]);

        BookFeedback::updateOrCreate(
            ['user_id' => auth()->id(), 'book_id' => $book->id],
            ['cocok' => $data['cocok']]
        );

        return response()->json(['ok' => true]);
    }

    /**
     * Tahap 2: ambil rekomendasi dari model Python (Decision Tree / SVM).
     * Return null kalau endpoint belum ada, error, atau timeout.
     */
    private function fromModel($userId, $bookId, $readIds)
    {
        try {
            $res = Http::timeout(3)->post('http://127.0.0.1:5000/recommend', [
                'user_id' => $userId,
                'book_id' => $bookId,
                'limit'   => 6,
            ]);

            if (!$res->ok() || empty($res['book_ids'])) {
                return null;
            }

            return Book::whereIn('id', $res['book_ids'])
                ->whereNotIn('id', $readIds)
                ->get();
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * Tahap 1: berbasis aturan. Genre yang paling sering dibaca user
     * (selesai dihitung 2x, sedang dibaca 1x), jenis buku disamakan.
     */
    private function fromRules($userId, Book $book, $readIds)
    {
        $topGenres = DB::table('reading_histories as rh')
            ->join('books as b', 'b.id', '=', 'rh.book_id')
            ->where('rh.user_id', $userId)
            ->selectRaw('b.genre, SUM(CASE WHEN rh.progress = 100 THEN 2 ELSE 1 END) AS skor')
            ->groupBy('b.genre')
            ->orderByDesc('skor')
            ->limit(3)
            ->pluck('genre');

        return Book::whereIn('genre', $topGenres)
            ->where('jenis_buku', $book->jenis_buku)
            ->whereNotIn('id', $readIds)
            // ->where('status', 'approved') // sesuaikan dengan nilai status di tabel books
            ->inRandomOrder()
            ->limit(6)
            ->get();
    }
}