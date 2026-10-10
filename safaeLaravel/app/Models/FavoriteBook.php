<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteBook extends Model
{
    use HasFactory;

    protected $table = 'favorite_books'; 

    protected $fillable = [
        'user_id',
        'book_id'
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
