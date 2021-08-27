<?php

namespace App\Http\Controllers;

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
    }
}
