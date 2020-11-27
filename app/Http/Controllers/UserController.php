<?php

namespace App\Http\Controllers;
use App\Http\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getProfile()
    {
        return $this->userService->getProfile(Auth::id());
    }

    public function updateProfile(Request $request)
    {
        DB::beginTransaction();
        try {
            $userRequest = $this->userService->updateProfile(Auth::id(), $request->all());
            DB::commit();
            return $userRequest;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            throw $e;
        }
    }
}
