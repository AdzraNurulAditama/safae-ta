<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserGenre extends Model
{
    protected $table = 'user_genres';

    protected $fillable = [
        'user_id',
        'genre',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
