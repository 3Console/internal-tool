<?php

namespace App\Http\Services;

use App\User;
use App\Models\Notification;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Bucket;
use App\Models\Word;

class NotificationService
{
    public function sendNotification($userId)
    {
        $curl = curl_init();
        $tokens = Notification::where('user_id', $userId)->pluck('token');
        
        foreach($tokens as $token) {
            $content = "Coconut: Dừa - nhiều nước, rất ngọt";
            $title = "Từ mới hôm nay:";
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "{\n\"to\":\"$token\",\n \"notification\" : {\n  \"sound\" : \"default\",\n  \"body\" :  \"$content\",\n  \"title\" : \"$title\",\n  \"content_available\" : true,\n  \"priority\" : \"high\",\n },\n \"data\" : {\n  \"sound\" : \"default\",\n  \"body\" :  \"test body\",\n  \"title\" : \"test title\",\n  \"content_available\" : true,\n  \"priority\" : \"high\",\n }\n}",
                CURLOPT_HTTPHEADER => array(
                    "authorization: key=".env('FIREBASE_PUSH_KEY'),
                    "cache-control: no-cache",
                    "content-type: application/json",
                    // "postman-token: f5de4dbc-5394-7798-ef04-3f51ba36e46f",
                ),
            ));
    
            $response = curl_exec($curl);
            $err = curl_error($curl);
    
            
            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                echo $response;
            }
        }
        curl_close($curl);
    }

}
