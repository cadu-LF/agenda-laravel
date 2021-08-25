<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function sendNotification()
    {
        $fields['include_player_ids'] = ['xxxxxxxx-xxxx-xxx-xxxx-yyyyyyyyy'];
        $message = 'Olá!';

        \OneSignal::sendPush($fields, $message);
    }

    public function getNotification()
    {
        return OneSignal::getNotification();
        // $ch = curl_init();
        // curl_setopt(
        //     $ch,
        //     CURLOPT_URL,
        //     "https://onesignal.com/api/v1/notifications/YOUR_NOTIFICATION_ID?app_id=YOUR_APP_ID"
        // );
        // curl_setopt(
        //     $ch,
        //     CURLOPT_HTTPHEADER,
        //     array(
        //         'Content-Type: application/json',
        //         'Authorization: Basic AUTH_KEY'
        //     )
        // );

        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_HEADER, false);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // $response = curl_exec($ch);
        // curl_close($ch);
        //     $return["allresponses"] = $response;
        // $return = json_encode($return);

        // print("\n\nJSON received:\n");
        // print($return);
        // print("\n");
    }
}
