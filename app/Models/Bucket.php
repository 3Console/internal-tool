<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bucket extends Model
{
    protected $fillable = ['user_id'];

    public function categories() {
        return $this->hasMany('App\Models\Category');
    }
}
