<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookFeedback extends Model
{
    protected $table = 'book_feedbacks';
    protected $fillable = ['user_id', 'book_id', 'cocok'];
}