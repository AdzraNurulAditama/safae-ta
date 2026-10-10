<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReadingHistory extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'progress',
        'last_read_at',
        'bukti_progress',
    ];
       protected $casts = [
        'last_read_at' => 'datetime',
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

