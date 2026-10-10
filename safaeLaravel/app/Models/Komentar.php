<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Book;

class Komentar extends Model
{
    protected $table = 'komentar';

    protected $fillable = [
        'user_id',
        'book_id',
        'page',
        'username', 
        'komentar',
        'image_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

}
