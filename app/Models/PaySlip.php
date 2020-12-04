<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaySlip extends Model
{
    protected $fillable = [
        'user_id',
        'start_date',
        'end_date',
        'working_hours',
        'absence_hours',
        'overtime_hours',
        'late_hours',
        'support_amount',
        'bonus_amount',
        'violation_amount'
    ];
}
