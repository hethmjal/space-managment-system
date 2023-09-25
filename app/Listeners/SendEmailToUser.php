<?php

namespace App\Listeners;

use App\Events\BookingStatusChanged;
use App\Notifications\ChangeBookStatusnotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendEmailToUser
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
    public function handle(BookingStatusChanged $event): void
    {
        $booking = $event->booking;
        Notification::route('mail', $booking->email)
        ->notify(new ChangeBookStatusnotification($booking));
    }
}
