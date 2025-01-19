<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;
    public $invoicePdf;
    public $filename;

    public function __construct($details, $invoicePdf)
    {
        $this->details = $details;
        $this->invoicePdf = $invoicePdf;
        $this->filename = 'invoice_' . $this->details['unique_order_id'] . '.pdf';
    }

    public function build()
    {
        return $this->subject('Potvrdenie objednávky')
            ->view('emails.order_success')
            ->attachData($this->invoicePdf, $this->filename, [
            'mime' => 'application/pdf',
        ]);
    }
}
