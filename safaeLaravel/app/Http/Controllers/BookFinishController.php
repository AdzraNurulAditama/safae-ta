<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BookFinishController extends Controller
{
    private const JUMLAH_REKOMENDASI = 6;

    /**
     * Halaman rekomendasi setelah user menilai / selesai membaca.
     * Rekomendasi dibaca dari tabel book_recommendations (dihitung ulang oleh service ML
     * lewat API tiap halaman ini dibuka), lalu diprioritaskan berdasarkan genre & jenis buku
     * yang BARU selesai dibaca.
     */
    public function show(Book $book)
    {
        $user = auth()->user();

        // Minta service ML menghitung ulang rekomendasi user ini sebelum dibaca di bawah
        $this->refreshRekomendasi($user->id);

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

        // 1) Rekomendasi personal dari hasil model, diprioritaskan sesuai buku yang baru selesai
        $recs = $this->fromBatch($user->id, $excludeIds, $book);
        $judul = 'Buku lain yang mungkin kamu suka';

        // 2) Kalau belum ada (user baru / service ML belum menghasilkan apa pun): cari buku SERUPA (genre sama)
        if ($recs->isEmpty()) {
            $recs = Book::where('status', 'approved')
                ->where('genre', $book->genre) // Pastikan nama kolom di database sesuai ('genre' atau 'kategori_topik')
                ->whereNotIn('id', $excludeIds)
                ->limit(self::JUMLAH_REKOMENDASI)
                ->get();
            $judul = 'Buku dengan genre serupa';
        }

        // 3) Kalau buku di genre yang sama juga habis/kosong: buku POPULER
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
     * Minta service ML (FastAPI) menghitung ulang rekomendasi user ini.
     * Kalau service mati atau lambat, abaikan: halaman tetap pakai isi book_recommendations yang lama.
     */
    private function refreshRekomendasi(int $userId): void
    {
        try {
            Http::timeout(5)->post('http://127.0.0.1:8001/recommend', ['user_id' => $userId]);
        } catch (\Throwable $e) {
            Log::warning('Refresh rekomendasi gagal: ' . $e->getMessage());
        }
    }

    /**
     * Ambil N buku dari book_recommendations untuk user ini.
     * Urutan prioritas:
     *   1. genre sama dengan buku yang baru selesai
     *   2. jenis buku (fiksi/nonfiksi) sama
     *   3. urutan dari Python (kolom urutan; 1 = paling cocok), lalu skor model tertinggi
     * Hanya buku berstatus 'approved' yang ikut.
     */
    private function fromBatch(int $userId, $excludeIds, Book $book)
    {
        $ids = DB::table('book_recommendations as r')
            ->join('books as b', 'b.id', '=', 'r.book_id')
            ->where('r.user_id', $userId)
            ->where('b.status', 'approved')
            ->whereNotIn('r.book_id', $excludeIds)
            ->orderByRaw('(b.genre = ?) DESC', [$book->genre])
            ->orderByRaw('(b.jenis_buku = ?) DESC', [$book->jenis_buku])
            ->orderBy('r.urutan')       // urutan dari Python (skor + pemecah seri), 1 = paling cocok
            ->orderByDesc('r.skor')     // cadangan untuk baris lama yang urutan-nya masih kosong
            ->limit(self::JUMLAH_REKOMENDASI)
            ->pluck('r.book_id');

        if ($ids->isEmpty()) {
            return collect();
        }

        return Book::whereIn('id', $ids)
            ->get()
            ->sortBy(fn ($b) => $ids->search($b->id)) // pertahankan urutan hasil query
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
            ->where('books.status', 'approved')
            ->orderByDesc('jumlah_pembaca')
            ->limit(self::JUMLAH_REKOMENDASI)
            ->get();
    }
}