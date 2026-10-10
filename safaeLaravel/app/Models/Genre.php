<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $fillable = ['nama_genre', 'slug'];

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }
}
