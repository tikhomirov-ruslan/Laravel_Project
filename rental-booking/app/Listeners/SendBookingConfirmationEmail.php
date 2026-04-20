<?php

namespace App\Listeners;

use App\Events\BookingCreated;
use App\Mail\BookingConfirmed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendBookingConfirmationEmail implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(BookingCreated $event): void
    {
        Mail::to($event->booking->user->email)->send(new BookingConfirmed($event->booking));
    }
}
