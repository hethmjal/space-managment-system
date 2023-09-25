<?php

namespace App\Listeners;

use App\Events\NewBookingCreated;
use App\Models\User;
use App\Notifications\NewBookNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendEmailToAdmin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewBookingCreated $event): void
    {
        $booking = $event->booking;
        $users = User::where('type','admin')->get();
        Notification::send($users,new NewBookNotification);
    }
}
