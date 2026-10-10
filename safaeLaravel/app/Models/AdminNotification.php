<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminNotification extends Model
{
    use HasFactory;

    protected $table = 'notifications'; // tetap pakai tabel notifications

    protected $fillable = [
        'user_id', 'title', 'message', 'url', 'is_read'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
