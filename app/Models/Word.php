<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    protected $fillable = ['word', 'hint', 'meaning', 'image', 'category_id', 'is_important'];
}
