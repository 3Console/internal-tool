<?php

namespace App\Http\Controllers;
use App\Http\Services\SalaryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class SalaryController extends Controller
{
    protected $salaryService;

    public function __construct(SalaryService $salaryService)
    {
        $this->salaryService = $salaryService;
    }

    public function getEmployee()
    {
        return $this->salaryService->getEmployee();
    }

    public function getUserAbsenceApprovedRequest(Request $request)
    {
        return $this->salaryService->getUserAbsenceApprovedRequest($request->all());
    }

    public function getUserOvertimeApprovedRequest(Request $request)
    {
        return $this->salaryService->getUserOvertimeApprovedRequest($request->all());
    }

    public function submitPaySlip(Request $request)
    {
        DB::beginTransaction();
        try {
            $paySlip = $this->salaryService->submitPaySlip($request->all());
            DB::commit();
            return $paySlip;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            throw $e;
        }
    }

    public function getPaySlips()
    {
        return $this->salaryService->getPaySlips(Auth::id());
    }

    public function getPaySlipDetail(Request $request)
    {
        return $this->salaryService->getPaySlipDetail($request->id);
    }
}
