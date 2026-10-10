<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $fillable = [
        'user_id',
        'points',
        'price',
        'metode'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
