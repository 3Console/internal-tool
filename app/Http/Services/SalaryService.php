<?php

namespace App\Http\Services;

use App\User;
use App\Models\UserAbsenceRequest;
use App\Models\UserOvertimeRequest;
use App\Models\PaySlip;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

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

        $notification = Notification::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $params['user_id'],
            'title' => 'You have received this month pay slip',
            'content' => 'You have received this month pay slip'
        ]);

        return $paySlip;
    }

    public function getPaySlips($userId)
    {
        return PaySlip::where('user_id', $userId)
                    ->select('*')
                    ->orderBy('created_at', 'desc')
                    ->get();
    }

    public function getPaySlipDetail($slipId)
    {
        return PaySlip::join('users', 'pay_slips.user_id', 'users.id')
                    ->where('pay_slips.id', $slipId)
                    ->select('users.full_name', 'users.email', 'users.address', 'pay_slips.*')
                    ->first();
    }
}
