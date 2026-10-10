<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenreSeeder extends Seeder
{
    public function run()
    {
        $genres = [
            'Romance',
            'Action',
            'Comedy',
            'Sci-fi',
            'History',
            'Fiction',
            'Edukasi',
            'Motivasi',
            'Horor',
        ];

        foreach ($genres as $g) {
            Genre::create([
                'nama_genre' => $g
            ]);
        }
    }
}
