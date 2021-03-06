<?php

namespace App\Http\Controllers;
use App\Http\Services\UserOvertimeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

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

    public function approveRequest(Request $request)
    {
        DB::beginTransaction();
        try {
            $approveRequest = $this->userOvertimeService->approveRequest($request->all());
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
            $rejectRequest = $this->userOvertimeService->rejectRequest($request->all());
            DB::commit();
            return $rejectRequest;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            throw $e;
        }
    }

    public function createOvertimeRequest(Request $request)
    {
        DB::beginTransaction();
        try {
            $overtimeRequest = $this->userOvertimeService->createOvertimeRequest(Auth::id() ,$request->all());
            DB::commit();
            return $overtimeRequest;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            throw $e;
        }
    }

    public function getProjects()
    {
        return $this->userOvertimeService->getProjects(Auth::id());
    }

    public function getUserOvertimeDetail(Request $request)
    {
        try {
            $overtimeDetail = $this->userOvertimeService->getUserOvertimeDetail($request->id);
            DB::commit();
            return $overtimeDetail;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            throw $e;
        }
    }
}
