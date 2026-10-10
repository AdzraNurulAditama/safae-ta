<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $table = 'promotions';

    protected $fillable = [
        'title',
        'image',
        'short_description',
        'content',
        'event_date'
    ];
}