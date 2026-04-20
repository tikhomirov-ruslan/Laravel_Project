<?php

namespace App\Listeners;

use App\Events\BookingCreated;
use App\Mail\BookingConfirmed;
use Illuminate\Support\Facades\Mail;

class SendBookingConfirmationEmail
{
    public function handle(BookingCreated $event): void
    {
        Mail::to($event->booking->user->email)->send(new BookingConfirmed($event->booking));
    }
}
