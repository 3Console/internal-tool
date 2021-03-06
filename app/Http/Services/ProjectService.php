<?php

namespace App\Http\Services;

use App\User;
use App\Models\Project;
use App\Models\UserProject;
use App\Models\Position;

class ProjectService
{
    public function getProjects($params)
    {
        $limit = array_get($params, 'limit', 10);
        return Project::select('*')
                    ->when(!empty(array_get($params, 'search')), function ($query) use ($params) {
                        $search = array_get($params, 'search');
                        return $query->where('name', 'like', "%$search%")
                                    ->orWhere('status', 'like', "%$search%");
                        })->orderBy('created_at', 'desc')
                    ->paginate($limit);
    }

    public function getProject($projectId)
    {
        return Project::where('id', $projectId)
                    ->select('id', 'name', 'status')
                    ->first();
    }

    public function createProject($input)
    {
        $project = Project::create([
            'name' => $input['project_name']
        ]);

        return $project;
    }

    public function updateProject($projectId, $input)
    {
        $project = Project::where('id', $projectId)->first();
        $project->name = $input['project_name'];
        $project->status = $input['status'];
        $project->save();
        return $project;
    }

    public function deleteProject($projectId)
    {
        $project = Project::where('id', $projectId)->first();
        $project->delete();
        return 'Delete successfully';
    }

    public function getProjectMembers($projectId, $params)
    {
        $limit = array_get($params, 'limit', 10);
        return UserProject::join('users', 'user_projects.user_id', 'users.id')
                    ->join('positions', 'user_projects.position_id', 'positions.id')
                    ->where('user_projects.project_id', $projectId)
                    ->select('user_projects.id', 'users.full_name' ,'users.email', 'positions.name as position')
                    ->when(!empty(array_get($params, 'search')), function ($query) use ($params) {
                        $search = array_get($params, 'search');
                        return $query->where('users.full_name', 'like', "%$search%")
                                    ->orWhere('users.email', 'like', "%$search%")
                                    ->orWhere('positions.name', 'like', "%$search%");
                        })->orderBy('user_projects.position_id', 'asc')
                    ->paginate($limit);
    }

    public function getPositions() {
        return Position::select('id', 'name')->get();
    }

    public function getMember($memberId) {
        return UserProject::where('id', $memberId)
                        ->select('user_id', 'position_id')
                        ->first();
    }

    public function addMember($input)
    {
        $member = UserProject::create([
            'user_id' => $input['user_id'],
            'project_id' => $input['project_id'],
            'position_id' => $input['position']
        ]);

        return $member;
    }

    public function updateMember($memberId, $input)
    {
        $member = UserProject::where('id', $memberId)->first();
        $member->user_id = $input['user_id'];
        $member->position_id = $input['position'];
        $member->save();
        return $member;
    }

    public function deleteMember($memberId)
    {
        $member = UserProject::where('id', $memberId)->first();
        $member->delete();
        return 'Delete successfully';
    }

    public function getUserProjects($userId)
    {
        return UserProject::join('projects', 'user_projects.project_id', 'projects.id')
                        ->where('user_projects.user_id', $userId)
                        ->select('user_projects.id', 'user_projects.project_id', 'projects.name')
                        ->get();
    }

    public function getProjectManager($projectId)
    {
        return UserProject::join('users', 'user_projects.user_id', 'users.id')
                        ->where('user_projects.project_id', $projectId)
                        ->where('user_projects.position_id', 1)
                        ->select('users.full_name', 'users.email')
                        ->first();
    }

    public function getOtherMembers($projectId)
    {
        return UserProject::join('users', 'user_projects.user_id', 'users.id')
                        ->where('user_projects.project_id', $projectId)
                        ->where('user_projects.position_id', '!=', 1)
                        ->select('users.full_name', 'users.email')
                        ->get();
    }
}
