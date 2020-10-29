<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['title', 'cover', 'is_visible', 'bucket_id', 'slug'];
    protected $appends = array('total_word');

    public function getTotalWordAttribute()
    {
        return $this->words()->count();  
    }

    public function words() {
        return $this->hasMany('App\Models\Word');
    }
}
