<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserOvertimeRequest extends Model
{
    protected $fillable = ['user_id', 'title', 'project_id', 'reason', 'start_date', 'end_date'];
}
