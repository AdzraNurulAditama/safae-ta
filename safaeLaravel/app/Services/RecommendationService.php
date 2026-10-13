<?php

namespace App\Services;

use App\Models\Book;
use App\Models\BookRecommendation;
use App\Models\ReadingHistory;
use App\Models\User;

class RecommendationService
{
    public function forUser(User $user, int $limit = 8): array
    {
        $recs = BookRecommendation::with('book')
            ->where('user_id', $user->id)
            ->whereHas('book', fn ($q) => $q->where('status', 'approved'))
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

        $sudahDibaca = ReadingHistory::where('user_id', $user->id)->pluck('book_id');
        $populer = Book::where('status', 'approved')
            ->whereNotIn('id', $sudahDibaca)
            ->orderByDesc('reader_count')
            ->limit($limit)
            ->get();

        return ['books' => $populer, 'sumber' => 'populer'];
    }
}