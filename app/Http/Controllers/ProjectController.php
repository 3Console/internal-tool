<?php

namespace App\Http\Controllers;
use App\Http\Services\ProjectService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function getProjects(Request $request)
    {
        return $this->projectService->getProjects($request->all());
    }

    public function getProject(Request $request)
    {
        return $this->projectService->getProject($request->id);
    }

    public function createProject(Request $request)
    {
        DB::beginTransaction();
        try {
            $project = $this->projectService->createProject($request->all());
            DB::commit();
            return $project;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            throw $e;
        }
    }

    public function updateProject(Request $request)
    {
        DB::beginTransaction();
        try {
            $project = $this->projectService->updateProject($request->id, $request->all());
            DB::commit();
            return $project;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            throw $e;
        }
    }

    public function deleteProject(Request $request)
    {
        DB::beginTransaction();
        try {
            $project = $this->projectService->deleteProject($request->id);
            DB::commit();
            return $project;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            throw $e;
        }
    }

    public function getProjectMembers(Request $request)
    {
        return $this->projectService->getProjectMembers($request->id, $request->all());
    }

    public function getPositions()
    {
        return $this->projectService->getPositions();
    }

    public function getMember(Request $request)
    {
        return $this->projectService->getMember($request->id);
    }

    public function addMember(Request $request)
    {
        DB::beginTransaction();
        try {
            $project = $this->projectService->addMember($request->all());
            DB::commit();
            return $project;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            throw $e;
        }
    }

    public function updateMember(Request $request)
    {
        DB::beginTransaction();
        try {
            $project = $this->projectService->updateMember($request->id, $request->all());
            DB::commit();
            return $project;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            throw $e;
        }
    }

    public function deleteMember(Request $request)
    {
        DB::beginTransaction();
        try {
            $project = $this->projectService->deleteMember($request->id);
            DB::commit();
            return $project;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            throw $e;
        }
    }
}
