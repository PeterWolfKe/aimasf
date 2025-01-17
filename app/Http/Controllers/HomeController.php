<?php

namespace App\Http\Controllers;

use App\Models\EmailSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        session()->forget('products'); //Temporary
        return Inertia::render('Home')->toResponse(request())->withHeaders([
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }
}
