<?php

namespace App\Http\Services;

use App\User;

class UserService
{
    public function getProfile($userId)
    {
        return User::where('id', $userId)
                ->select('id', 'name', 'full_name', 'email', 'phone_number', 'address', 'info')
                ->first();
    }
}
