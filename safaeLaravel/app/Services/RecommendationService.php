<?php

namespace App\Services;

use App\Models\Book;
use App\Models\BookRecommendation;
use App\Models\ReadingHistory;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RecommendationService
{
    public function forUser(User $user, int $limit = 8): array
    {
        // Mengambil riwayat baca pengguna yang sedang login
        $sudahDibaca = ReadingHistory::where('user_id', $user->id)
            ->pluck('book_id');

        $memilikiRiwayat = $sudahDibaca->isNotEmpty();

        // KONDISI 1: Pengguna sudah memiliki riwayat baca
        // Menggunakan hasil prediksi model
        if ($memilikiRiwayat) {
            $recs = BookRecommendation::with('book')
                ->where('user_id', $user->id)
                ->whereHas('book', function ($query) {
                    $query->where('status', 'approved');
                })
                ->whereNotIn('book_id', $sudahDibaca)
                ->orderByDesc('skor')
                ->limit($limit)
                ->get();

            if ($recs->isNotEmpty()) {
                return [
                    'books' => $recs->map(function ($r) {
                        $r->book->skor_rekomendasi = (float) $r->skor;
                        return $r->book;
                    }),
                    'sumber' => 'model',
                ];
            }
        }

        // KONDISI 2: Belum punya riwayat baca,
        // tetapi profil akademik sudah lengkap
        if (!$memilikiRiwayat && !empty($user->jurusan)) {

            // Mengambil ID pengguna lain dengan jurusan sama
            $penggunaSejurusan = User::where('jurusan', $user->jurusan)
                ->where('id', '!=', $user->id)
                ->pluck('id');

            if ($penggunaSejurusan->isNotEmpty()) {

                // Menghitung jumlah pembaca dari jurusan yang sama
                $bukuSejurusan = ReadingHistory::select(
                        'book_id',
                        DB::raw('COUNT(DISTINCT user_id) as total_pembaca')
                    )
                    ->whereIn('user_id', $penggunaSejurusan)
                    ->groupBy('book_id')
                    ->orderByDesc('total_pembaca')
                    ->get();

                $urutanBuku = $bukuSejurusan
                    ->pluck('book_id')
                    ->toArray();

                if (!empty($urutanBuku)) {
                    $buku = Book::where('status', 'approved')
                        ->whereIn('id', $urutanBuku)
                        ->whereNotIn('id', $sudahDibaca)
                        ->get()
                        ->sortBy(function ($book) use ($urutanBuku) {
                            return array_search($book->id, $urutanBuku);
                        })
                        ->take($limit)
                        ->values();

                    if ($buku->isNotEmpty()) {
                        return [
                            'books' => $buku,
                            'sumber' => 'jurusan',
                        ];
                    }
                }
            }
        }

        // KONDISI 3: Fallback jika belum ada data
        // pengguna sejurusan yang membaca buku
        $populer = Book::where('status', 'approved')
            ->whereNotIn('id', $sudahDibaca)
            ->withCount('readingHistories')
            ->orderByDesc('reading_histories_count')
            ->limit($limit)
            ->get();

        return [
            'books' => $populer,
            'sumber' => 'populer',
        ];
    }
}
