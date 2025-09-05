<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SurveyResponseMail extends Mailable
{
    use Queueable, SerializesModels;

    public $responses;

    public function __construct($responses)
    {
        $this->responses = $responses;
    }

    public function build()
    {
        return $this->subject('Your Survey Responses')
                    ->view('email.email_response')
                    ->with('responses', $this->responses);
    }
}
