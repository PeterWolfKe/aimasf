<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;
use App\Mail\SurveyMail;
use Illuminate\Support\Facades\Mail;

class SendSurveyEmail extends Command
{
    protected $signature = 'send:survey-email';
    protected $description = 'Send survey email to unique customers with status 2 or 3';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $emails = Order::whereIn('status', [2, 3])
            ->distinct()
            ->pluck('email');

        if ($emails->isEmpty()) {
            $this->info("No customers found to send survey emails.");
            return;
        }

        foreach ($emails as $email) {
            Mail::to($email)->send(new SurveyMail($email));

            $this->info("Survey email sent to: " . $email);
        }

        $this->info("Survey emails have been sent successfully.");
    }
}
