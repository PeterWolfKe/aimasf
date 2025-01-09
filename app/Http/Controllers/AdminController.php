<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index(Request $request){
        $orders = Order::all();
        return inertia('Orders', ['orders' => $orders]);
    }
}
