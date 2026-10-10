<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FavoriteBook;
use App\Models\User;
use App\Models\Book;

class FavoriteBookSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil user pertama
        $user = User::first();

        // Ambil beberapa buku
        $books = Book::take(3)->get();

        // Kalau user atau buku belum ada, hentikan
        if (!$user || $books->isEmpty()) {
            return;
        }

        foreach ($books as $book) {
            FavoriteBook::firstOrCreate([
                'user_id' => $user->id,
                'book_id' => $book->id,
            ]);
        }
    }
}
