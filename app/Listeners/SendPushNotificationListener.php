<?php

namespace App\Listeners;

use App\Models\Question;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class SendPushNotificationListener
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        DB::table('user_notifications')->insert(['user_id' => $event->userId, 'title' => $event->title, 'message' => $event->message, 'question_id' => $event->questionId, 'author_id' => $event->authorId]);

        $token = User::find($event->userId)->device_token;
        $fcmKey = DB::table('settings')->find(1)->fcm_key;
        $data = [
            "to" => $token,
            "data" => [
                "message" => $event->message,
                "user_id" => $event->userId,
                "question_id" => $event->questionId,
                "author_id" => $event->authorId,
            ],
            "notification" => [
                "title" => $event->title,
                "body" => $event->message,
            ]
        ];
        $dataString = json_encode($data);
        $headers = [
            'Authorization: key=' . $fcmKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);
        $success = json_decode($response, true)['success'];
    }
}
