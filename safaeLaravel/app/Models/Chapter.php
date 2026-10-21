<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    protected $table = 'chapters';

    protected $fillable = [
        'book_id',
        'chapter_number',
        'title',
        'content',
        'image',
        'status',
    ];

    public function book()
{
    return $this->belongsTo(Book::class, 'book_id', 'id');
}
}