<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointHistory extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'points',
        'type',
        'description'
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
