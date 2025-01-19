<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailSubscriptionConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function build()
    {
        return $this->view('emails.email_subscription_confirmation')
            ->with(['token' => $this->token])
            ->subject('Potvrdenie odberu noviniek');
    }
}
