<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = [
    'genre_id', 'user_id', 'judul', 'isi', 'gambar', 'file'
];

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comments::class);
    }
}
