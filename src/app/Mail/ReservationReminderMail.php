<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('【本日予約リマインダー】')
                    ->view('emails.reservation_reminder')
                    ->with([
                        'user' => $this->user,
                        'restaurant' => $this->restaurant,
                        'reservation' => $this->reservation,
                    ]);
    }
}
