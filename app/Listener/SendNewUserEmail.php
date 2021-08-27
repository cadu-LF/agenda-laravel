<?php

namespace App\Listener;

use App\Mail\Welcome;
use App\Event\NewUser;
use Illuminate\Support\Facades\Mail;

class SendNewUserEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewUser  $event
     * @return void
     */
    public function handle(NewUser $event)
    {
        Mail::to($event->user['email'])->send(new Welcome());
    }
}
