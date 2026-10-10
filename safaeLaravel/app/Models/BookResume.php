<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookResume extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'title',
        'content',
        'has_spoiler',
        'is_public'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}