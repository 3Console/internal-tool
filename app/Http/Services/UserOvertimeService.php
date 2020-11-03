<?php

namespace App\Http\Services;

use App\User;
use App\Models\UserOvertimeRequest;

class UserOvertimeService
{
    public function getUserOvertimeRequests($params)
    {
        $limit = array_get($params, 'limit', 10);
        return UserOvertimeRequest::join('users', 'user_overtime_requests.user_id', 'users.id')->when(!empty(array_get($params, 'search')), function ($query) use ($params) {
            $search = array_get($params, 'search');
            return $query->where('user_overtime_requests.title', 'like', "%$search%")
                        ->orWhere('user_overtime_requests.status', 'like', "%$search%");
        })->orderBy('user_overtime_requests.created_at', 'desc')->paginate($limit);
    }
}
