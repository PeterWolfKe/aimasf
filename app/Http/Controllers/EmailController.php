<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewsEmail;
use Inertia\Inertia;
use Inertia\Response;

class EmailController extends Controller
{
    public function index(): Response
    {
        $emails = session()->get('newsletter_emails', []);
        return Inertia::render('EmailAdmin', ['emails' => $emails]);
    }

    public function addEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $emails = session()->get('newsletter_emails', []);
        $emails[] = $request->email;
        session()->put('newsletter_emails', $emails);

        return redirect()->back()->with('success', 'Email added to the list.');
    }

    public function sendEmails()
    {
        $emails = session()->get('newsletter_emails', []);

        if (empty($emails)) {
            return redirect()->back()->with('error', 'No emails in the list.');
        }

        foreach ($emails as $email) {
            Mail::to($email)->send(new NewsEmail());
        }

        session()->forget('newsletter_emails');

        return redirect()->back()->with('success', 'News email sent successfully.');
    }
}
