<?php

namespace App\Services;

use App\Models\Book;
use App\Models\BookRecommendation;
use App\Models\User;

class RecommendationService
{
    /**
     * Rekomendasi untuk satu pengguna.
     * - Pengguna yang punya hasil prediksi: urut skor tertinggi.
     * - Pengguna baru / belum ada hasil: cadangan = buku populer (reader_count),
     *   diprioritaskan yang genre-nya sama dengan buku yang pernah dibacanya jika ada.
     *
     * @return array{books: \Illuminate\Support\Collection, sumber: string}
     */
    public function forUser(User $user, int $limit = 8): array
    {
        $recs = BookRecommendation::with('book')
            ->where('user_id', $user->id)
            ->whereHas('book', fn ($q) => $q->where('status', 'published'))
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

        $sudahDibaca = $user->readingHistories()->pluck('book_id'); // sesuaikan nama relasi
        $populer = Book::where('status', 'published')
            ->whereNotIn('id', $sudahDibaca)
            ->orderByDesc('reader_count')
            ->limit($limit)
            ->get();

        return ['books' => $populer, 'sumber' => 'populer'];
    }
}