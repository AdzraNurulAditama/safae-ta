<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChapterUnlock extends Model
{
    protected $table = 'chapter_unlocks';

    protected $fillable = [
        'user_id',
        'chapter_id',
        'points_spent'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function chapter()
    {
        return $this->belongsTo(Chapter::class, 'chapter_id');
    }
}
