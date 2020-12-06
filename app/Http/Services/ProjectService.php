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
        return Project::join('user_projects', 'projects.id', 'user_projects.project_id')
                    ->join('users', 'user_projects.user_id', 'users.id')
                    ->join('positions', 'user_projects.position_id', 'positions.id')
                    ->where('positions.name', 'Project manager')
                    ->select('projects.id' ,'projects.name', 'projects.status', 'users.full_name')
                    ->when(!empty(array_get($params, 'search')), function ($query) use ($params) {
                        $search = array_get($params, 'search');
                        return $query->where('projects.name', 'like', "%$search%")
                                    ->orWhere('projects.status', 'like', "%$search%")
                                    ->orWhere('users.full_name', 'like', "%$search%");
                        })->orderBy('projects.created_at', 'desc')
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
                        })->orderBy('user_projects.created_at', 'desc')
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
}
