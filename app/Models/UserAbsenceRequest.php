<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAbsenceRequest extends Model
{
    protected $fillable = ['user_id', 'title', 'absence_type_id', 'reason', 'start_date', 'end_date'];
}
