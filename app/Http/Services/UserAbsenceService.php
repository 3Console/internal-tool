<?php

namespace App\Http\Services;

use App\User;
use App\Models\UserAbsenceRequest;

class UserAbsenceService
{
    public function getUserAbsenceRequests($params)
    {
        $limit = array_get($params, 'limit', 10);
        return UserAbsenceRequest::join('users', 'user_absence_requests.user_id', 'users.id')->when(!empty(array_get($params, 'search')), function ($query) use ($params) {
            $search = array_get($params, 'search');
            return $query->where('user_absence_requests.title', 'like', "%$search%")
                        ->orWhere('user_absence_requests.status', 'like', "%$search%");
        })->orderBy('user_absence_requests.created_at', 'desc')->paginate($limit);
    }
}
