<?php

namespace App\Http\Services;

use App\User;
use App\Models\UserOvertimeRequest;

class UserOvertimeService
{
    public function getUserOvertimeRequests($params)
    {
        $limit = array_get($params, 'limit', 10);
        return UserOvertimeRequest::join('users', 'user_overtime_requests.user_id', 'users.id')
        ->where('user_overtime_requests.status', $params['status'])
        ->select('users.id', 'user_overtime_requests.id as request_id', 'users.name', 'user_overtime_requests.title', 'user_overtime_requests.duration', 'user_overtime_requests.created_at')
        ->when(!empty(array_get($params, 'search')), function ($query) use ($params) {
            $search = array_get($params, 'search');
            return $query->where('user_overtime_requests.title', 'like', "%$search%")
                        ->orWhere('user_overtime_requests.status', 'like', "%$search%");
        })->orderBy('user_overtime_requests.created_at', 'desc')->paginate($limit);
    }

    public function approveRequest($input)
    {
        $userOvertime = UserOvertimeRequest::where('id', $input['id'])->first();
        $userOvertime->status = 'approved';
        $userOvertime->save();
        return $userOvertime;
    }

    public function rejectRequest($input)
    {
        $userOvertime = UserOvertimeRequest::where('id', $input['id'])->first();
        $userOvertime->status = 'rejected';
        $userOvertime->save();
        return $userOvertime;
    }
}
