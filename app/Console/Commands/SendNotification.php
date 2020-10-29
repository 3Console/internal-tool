<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\NotificationSchedule;
use App\Http\Services\NotificationService;
use Carbon\Carbon;

class SendNotification extends Command
{
    protected $notificationService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // $this->notificationService->sendNotification(2);
        // echo Carbon::now();
        $daysNumber = [
            "Monday" => 0,
            "Saturday" => 1,
            "Tuesday" => 2,
            "Wednesday" => 3,
            "Thursday" => 4,
            "Saturday" => 5,
            "Sunday" => 6,
        ];
        $currentDayNumber = $daysNumber[Carbon::now()->format('l')];
        $currentHour = Carbon::now()->format('h');
        $currentMinute = Carbon::now()->format('i');
        echo $currentDayNumber."\n";
        echo $currentMinute."\n";
        echo $currentHour."\n";
        
        if($currentMinute == 0) {
            $notifications = NotificationSchedule::where(['day_number' => $currentDayNumber, 'hour' => $currentHour])->get();
            foreach($notifications as $notification) {
                echo $notification['user_id'];
                $this->notificationService->sendNotification($notification['user_id']);
            }
        }
    }
}
