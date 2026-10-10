<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    protected $fillable = [
        'topic_id',
        'user_id',
        'parent_id',
        'isi'
    ];

    // 🔁 balasan
    public function replies()
    {
        return $this->hasMany(Comments::class, 'parent_id')
            ->with('replies', 'user');
    }

    // 👤 user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
