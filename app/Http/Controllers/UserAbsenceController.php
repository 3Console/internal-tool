<?php

namespace App\Http\Controllers;
use App\Http\Services\UserAbsenceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserAbsenceController extends Controller
{
    protected $userAbsenceService;

    public function __construct(UserAbsenceService $userAbsenceService)
    {
        $this->userAbsenceService = $userAbsenceService;
    }

    public function getUserAbsenceRequests(Request $request)
    {
        return $this->userAbsenceService->getUserAbsenceRequests($request->all());
    }
}
