<?php

namespace App\Models;

use App\Models\ReadingProgress;
use App\Models\PointHistory;
use App\Models\FavoriteBook;
use App\Models\Book; 
use App\Models\PremiumRequest; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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
        'jurusan',
        'semester',
        // Tambahan agar kolom ini bisa diupdate:
        'social_media',
        'bio',
        'foto_profil',
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

    public function readingProgress()
    {
        return $this->hasMany(ReadingProgress::class);
    }

    public function pointHistories()
    {
        return $this->hasMany(PointHistory::class);
    }

    public function favoriteBooks()
    {
        return $this->hasMany(FavoriteBook::class); 
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