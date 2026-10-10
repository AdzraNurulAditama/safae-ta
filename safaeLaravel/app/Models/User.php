<?php

namespace App\Models;
use App\Models\ReadingProgress;
use App\Models\PointHistory;
use App\Models\FavoriteBook;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\BukuFavorit;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'nama_depan',
        'nama_belakang',
        'username',
        'email',
        'telepon',
        'password',
        'points',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /* =====================
       RELATION
       ===================== */

    // relasi ke reading_progress
    public function readingProgress()
    {
        return $this->hasMany(ReadingProgress::class);
    }

    // relasi ke point_histories
    public function pointHistories()
    {
        return $this->hasMany(PointHistory::class);
    }

    // relasi ke favorite_books
    
    public function favoriteBooks()
    {
        return $this->hasMany(favoriteBook::class);
    }
public function books()
{
    return $this->hasMany(Book::class);
}

public function premiumRequests()
{
    return $this->hasMany(PremiumRequest::class);
}


    // helper nama lengkap
    public function getNamaLengkapAttribute()
    {
        return $this->nama_depan . ' ' . $this->nama_belakang;
    }
}
