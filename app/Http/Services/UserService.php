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

    public function updateProfile($userId, $input)
    {
        \Log::alert($input);
        $user = User::where('id', $userId)->first();

        $user->email = $input['email'];
        $user->phone_number = $input['phone_number'];
        $user->address = $input['address'];

        $user->save();
        return $user;
    }
}
