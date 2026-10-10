<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
    
        $books = [
            [
                'title' => 'Buku Laravel Pemula',
                'author' => 'Ahmad Budi',
                'genre' => 'Pemrograman',
                'year' => 2023,
                'status' => 'approved',
                'image_path' => 'uploads/682cb38eb964.jpg',
                'description' => "Laravel adalah framework PHP yang sangat populer di dunia pengembangan web modern. Buku ini dirancang khusus untuk pemula yang ingin memahami konsep dasar MVC (Model-View-Controller).

Pada bab pertama, pembaca akan diajak melakukan instalasi menggunakan Composer dan XAMPP. Buku ini juga membahas Eloquent ORM, Blade Templating, hingga proyek akhir membuat website toko online."
            ],
            [
                'title' => 'Misteri Hutan Tua',
                'author' => 'Dian Sastro',
                'genre' => 'Novel',
                'year' => 2021,
                'status' => 'approved',
                'image_path' => 'uploads/682cb77dca2fa.jpg',
                'description' => "Angin malam berhembus dingin ketika Rara memasuki Hutan Tua. Penduduk desa melarang siapa pun masuk setelah matahari terbenam.

Novel ini menyajikan misteri supranatural dan ketegangan psikologis yang mencekam hingga halaman terakhir."
            ],
            [
                'title' => 'Resep Masakan Nusantara',
                'author' => 'Chef Juna',
                'genre' => 'Hobi',
                'year' => 2022,
                'status' => 'pending',
                'image_path' => 'uploads/682fc75a21a02.jpg',
                'description' => "Buku ini merangkum 50 resep terbaik dari Sabang sampai Merauke, lengkap dengan teknik memasak modern tanpa menghilangkan cita rasa asli Indonesia."
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }

        
        Book::factory(20)->create();
    }
}
