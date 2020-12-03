<?php

namespace App\Http\Services;

use App\User;
use App\Models\UserAbsenceRequest;
use App\Models\UserOvertimeRequest;

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
}
