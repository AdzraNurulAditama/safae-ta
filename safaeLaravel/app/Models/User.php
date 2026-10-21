<?php

namespace App\Models;

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

    public function readingProgress()
    {
        return $this->hasMany(ReadingProgress::class);
    }

    public function pointHistories()
    {
        return $this->hasMany(PointHistory::class);
    }

    public function chapterUnlocks()
    {
        return $this->hasMany(ChapterUnlock::class);
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

    public function getNamaLengkapAttribute()
    {
        return trim($this->nama_depan.' '.$this->nama_belakang);
    }
}
