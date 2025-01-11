<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 25);
        $offset = $request->query('page', 0);

        $orders = Order::skip($offset*$perPage)->take($perPage)->get();

        return inertia('AdminPanel', [
            'orders' => $orders,
            'offset' => $offset,
            'per_page' => $perPage,
        ]);
    }
}

