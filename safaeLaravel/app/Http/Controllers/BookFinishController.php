<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookFinishController extends Controller
{
    private const JUMLAH_REKOMENDASI = 6;

    /**
     * Halaman rekomendasi setelah user menilai / selesai membaca.
     * Rekomendasi dibaca dari tabel book_recommendations (hasil batch model),
     * bukan dihitung saat halaman dibuka.
     */
    public function show(Book $book)
    {
        $user = auth()->user();

        // Buku yang sudah dibaca user + buku ini tidak ikut direkomendasikan
        $excludeIds = DB::table('reading_histories')
            ->where('user_id', $user->id)
            ->pluck('book_id')
            ->push($book->id)
            ->unique()
            ->values();

        $sudahMenilai = BookFeedback::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->exists();

        // 1) Rekomendasi personal dari hasil batch model
        $recs = $this->fromBatch($user->id, $excludeIds);

        // 2) Kalau belum ada (user baru / batch belum jalan): buku populer
        $judul = 'Buku lain yang mungkin kamu suka';
        if ($recs->isEmpty()) {
            $recs = $this->popular($excludeIds);
            $judul = 'Buku populer di Safae';
        }

        return view('feedback.finished', compact('book', 'recs', 'sudahMenilai', 'judul'));
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
     * Ambil N buku dengan skor tertinggi untuk user ini dari book_recommendations.
     */
    private function fromBatch(int $userId, $excludeIds)
    {
        $ids = DB::table('book_recommendations')
            ->where('user_id', $userId)
            ->whereNotIn('book_id', $excludeIds)
            ->orderByDesc('skor')
            ->limit(self::JUMLAH_REKOMENDASI)
            ->pluck('book_id');

        if ($ids->isEmpty()) {
            return collect();
        }

        return Book::whereIn('id', $ids)
            // ->where('status', 'approved') // sesuaikan dengan nilai status di tabel books
            ->get()
            ->sortBy(fn ($b) => $ids->search($b->id)) // pertahankan urutan skor
            ->values();
    }

    /**
     * Fallback untuk user tanpa rekomendasi: buku paling banyak dibaca.
     */
    private function popular($excludeIds)
    {
        return Book::select('books.*')
            ->selectSub(
                DB::table('reading_histories')
                    ->selectRaw('COUNT(*)')
                    ->whereColumn('reading_histories.book_id', 'books.id'),
                'jumlah_pembaca'
            )
            ->whereNotIn('books.id', $excludeIds)
            // ->where('status', 'approved')
            ->orderByDesc('jumlah_pembaca')
            ->limit(self::JUMLAH_REKOMENDASI)
            ->get();
    }
}