<?php

namespace App\Http\Controllers;

use App\Http\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService) {
        $this->notificationService = $notificationService;
    }

    public function getLatestNotifications(Request $request)
    {
        return $this->notificationService->getLatestNotifications(Auth::id());
    }

    public function getAllNotifications(Request $request)
    {
        return $this->notificationService->getAllNotifications(Auth::id());
    }
}
