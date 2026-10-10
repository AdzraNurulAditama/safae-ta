<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReadingProgress extends Model
{
    protected $table = 'reading_progress';

    protected $fillable = [
        'user_id',
        'book_id',
        'duration'
    ];

    // relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // relasi ke book
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
