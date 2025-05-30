<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminNoticeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subjectLine;
    public $messageBody;

    public function __construct($subjectLine, $messageBody)
    {
        $this->subjectLine = $subjectLine;
        $this->messageBody = $messageBody;
    }

    public function build()
    {
        return $this->subject($this->subjectLine)
                    ->view('emails.admin_notice')
                    ->with([
                        'body' => $this->messageBody,
                    ]);
    }
}
