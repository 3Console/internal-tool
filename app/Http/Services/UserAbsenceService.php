<?php

namespace App\Http\Services;

use App\User;
use App\Models\UserAbsenceRequest;
use App\Models\AbsenceType;

class UserAbsenceService
{
    public function getUserAbsenceRequests($params)
    {
        $limit = array_get($params, 'limit', 10);
        return UserAbsenceRequest::join('users', 'user_absence_requests.user_id', 'users.id')
            ->where('user_absence_requests.status', $params['status'])
            ->select('users.id', 'user_absence_requests.id as request_id', 'users.name', 'user_absence_requests.title', 'user_absence_requests.created_at')
            ->when(!empty(array_get($params, 'search')), function ($query) use ($params) {
                $search = array_get($params, 'search');
                return $query->where('user_absence_requests.title', 'like', "%$search%")
                            ->orWhere('user_absence_requests.status', 'like', "%$search%");
                })->orderBy('user_absence_requests.created_at', 'desc')
            ->paginate($limit);
    }

    public function approveRequest($input)
    {
        $userAbsence = UserAbsenceRequest::where('id', $input['id'])->first();
        $userAbsence->status = 'approved';
        $userAbsence->save();
        return $userAbsence;
    }

    public function rejectRequest($input)
    {
        $userAbsence = UserAbsenceRequest::where('id', $input['id'])->first();
        $userAbsence->status = 'rejected';
        $userAbsence->save();
        return $userAbsence;
    }

    public function createAbsenceRequest($userId, $params)
    {
        $userAbsence = UserAbsenceRequest::create([
            'user_id' => $userId,
            'title' => $params['title'],
            'absence_type_id' => $params['absence_type'],
            'reason' => $params['content'],
            'start_date' => $params['start_date'],
            'end_date' => $params['end_date']
        ]);

        return $userAbsence;
    }

    public function getAbsenceTypes()
    {
        return AbsenceType::select('id', 'name')->get();
    }

    public function getUserAbsenceDetail($absenceId)
    {
        return UserAbsenceRequest::join('users', 'user_absence_requests.user_id', 'users.id')
                                ->join('absence_types', 'user_absence_requests.absence_type_id', 'absence_types.id')
                                ->where('user_absence_requests.id', $absenceId)
                                ->select('users.email', 'users.full_name', 'user_absence_requests.title', 'user_absence_requests.reason', 
                                        'user_absence_requests.start_date','user_absence_requests.end_date', 'absence_types.name as absence_type')
                                ->first();
    }
}
