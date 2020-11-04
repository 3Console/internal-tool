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

    public function approveRequest(Request $request)
    {
        DB::beginTransaction();
        try {
            $approveRequest = $this->userAbsenceService->approveRequest($request->all());
            DB::commit();
            return $approveRequest;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            throw $e;
        }
    }

    public function rejectRequest(Request $request)
    {
        DB::beginTransaction();
        try {
            $rejectRequest = $this->userAbsenceService->rejectRequest($request->all());
            DB::commit();
            return $rejectRequest;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            throw $e;
        }
    }
}
