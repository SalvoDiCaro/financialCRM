<?php

namespace App\Listeners;

use App\Notifications\EmailNotification;

class SendPasswordResetEmail
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
       $user=$event->user;
	$user->notify(new EmailNotification());
    }
}
