<?php

namespace App\Http\Services;

use App\User;
use App\Models\Notification;

class NotificationService
{
    public function getLatestNotifications($userId)
    {
        return Notification::where('receiver_id', $userId)
                            ->select('*')
                            ->orderBy('created_at', 'desc')
                            ->limit(3)
                            ->get();
    }

    public function getAllNotifications($userId)
    {
        return Notification::where('receiver_id', $userId)
                            ->select('*')
                            ->orderBy('created_at', 'desc')
                            ->get();
    }
}
