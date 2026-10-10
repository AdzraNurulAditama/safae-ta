<?php

namespace Database\Seeders;

use App\Models\ReadingHistory;
use App\Models\User;
use App\Models\Book;
use Illuminate\Database\Seeder;

class ReadingHistorySeeder extends Seeder
{
    public function run()
    {
        $user = User::first();        // user pertama
        $books = Book::take(5)->get(); // ambil max 5 buku (kalau ada)

        foreach ($books as $book) {
            ReadingHistory::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'book_id' => $book->id,
                ],
                [
                    'progress' => rand(10, 100),
                    'last_read_at' => now()->subDays(rand(1, 30)),
                ]
            );
        }
    }
}
