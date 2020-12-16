<?php

namespace App\Http\Services;

use App\User;
use App\Models\UserOvertimeRequest;
use App\Models\UserProject;
use App\Models\Project;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class UserOvertimeService
{
    public function getUserOvertimeRequests($params)
    {
        $limit = array_get($params, 'limit', 10);
        return UserOvertimeRequest::join('users', 'user_overtime_requests.user_id', 'users.id')
        ->where('user_overtime_requests.status', $params['status'])
        ->select('users.id', 'user_overtime_requests.id as request_id', 'users.name', 'user_overtime_requests.title', 'user_overtime_requests.created_at')
        ->when(!empty(array_get($params, 'search')), function ($query) use ($params) {
            $search = array_get($params, 'search');
            return $query->where('user_overtime_requests.title', 'like', "%$search%")
                        ->orWhere('user_overtime_requests.status', 'like', "%$search%");
        })->orderBy('user_overtime_requests.created_at', 'desc')->paginate($limit);
    }

    public function approveRequest($input)
    {
        $userOvertime = UserOvertimeRequest::where('id', $input['id'])->first();
        $userOvertime->status = 'approved';
        $userOvertime->save();

        $notification = Notification::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $userOvertime->user_id,
            'title' => 'Your overtime request has been approved',
            'content' => 'Your overtime request has been approved'
        ]);

        return $userOvertime;
    }

    public function rejectRequest($input)
    {
        $userOvertime = UserOvertimeRequest::where('id', $input['id'])->first();
        $userOvertime->status = 'rejected';
        $userOvertime->save();

        $notification = Notification::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $userOvertime->user_id,
            'title' => 'Your overtime request has been rejected',
            'content' => 'Your overtime request has been rejected'
        ]);

        return $userOvertime;
    }

    public function createOvertimeRequest($userId, $params)
    {
        $userOvertime = UserOvertimeRequest::create([
            'user_id' => $userId,
            'title' => $params['title'],
            'project_id' => $params['project'],
            'reason' => $params['content'],
            'start_date' => $params['start_date'],
            'end_date' => $params['end_date']
        ]);

        $notification = Notification::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $userId,
            'title' => 'Your overtime request has been sent',
            'content' => 'Your overtime request has been sent'
        ]);

        return $userOvertime;
    }

    public function getProjects($userId)
    {
        return UserProject::join('projects', 'user_projects.project_id', 'projects.id')
                        ->where('user_projects.user_id', $userId)
                        ->select('projects.id', 'projects.name')
                        ->get();
    }

    public function getUserOvertimeDetail($overtimeId)
    {
        return UserOvertimeRequest::join('users', 'user_overtime_requests.user_id', 'users.id')
                                ->join('projects', 'user_overtime_requests.project_id', 'projects.id')
                                ->where('user_overtime_requests.id', $overtimeId)
                                ->select('users.full_name', 'users.email', 'projects.name as project', 'user_overtime_requests.title',
                                        'user_overtime_requests.reason', 'user_overtime_requests.start_date', 'user_overtime_requests.end_date')
                                ->first();
    }
}
