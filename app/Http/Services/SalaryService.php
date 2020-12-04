<?php

namespace App\Http\Services;

use App\User;
use App\Models\UserAbsenceRequest;
use App\Models\UserOvertimeRequest;
use App\Models\PaySlip;

class SalaryService
{
    public function getEmployee()
    {
        return User::where('role', '!=', '2')
                    ->select('id', 'full_name')
                    ->get();
    }

    public function getUserAbsenceApprovedRequest($input)
    {
        $limit = array_get($input, 'limit', 10);
        return UserAbsenceRequest::where('user_id', $input['id'])
                                ->where('status', 'approved')
                                ->select('title', 'start_date', 'end_date')
                                ->paginate($limit);
    }

    public function getUserOvertimeApprovedRequest($input)
    {
        $limit = array_get($input, 'limit', 10);
        return UserOvertimeRequest::where('user_id', $input['id'])
                                ->where('status', 'approved')
                                ->select('title', 'start_date', 'end_date')
                                ->paginate($limit);
    }

    public function submitPaySlip($params)
    {
        $paySlip = PaySlip::create([
            'user_id' => $params['user_id'],
            'start_date' => $params['start_date'],
            'end_date' => $params['end_date'],
            'working_hours' => $params['working_hours'],
            'absence_hours' => $params['absence_hours'],
            'overtime_hours' => $params['overtime_hours'],
            'late_hours' => $params['late_hours'],
            'support_amount' => $params['support_amount'],
            'bonus_amount' => $params['bonus_amount'],
            'violation_amount' => $params['violation_amount']
        ]);

        return $paySlip;
    }
}
