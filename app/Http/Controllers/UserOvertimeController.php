<?php

namespace App\Http\Controllers;
use App\Http\Services\UserOvertimeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserOvertimeController extends Controller
{
    protected $userOvertimeService;

    public function __construct(UserOvertimeService $userOvertimeService)
    {
        $this->userOvertimeService = $userOvertimeService;
    }

    public function getUserOvertimeRequests(Request $request)
    {
        return $this->userOvertimeService->getUserOvertimeRequests($request->all());
    }
}
