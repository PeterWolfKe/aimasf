<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 25);
        $page = (int) $request->query('page', 0);
        $offset = $page * $perPage;

        $orders = Order::skip($offset)->take($perPage)->get();

        $orders = $orders->map(function ($order) {
            $orderProducts = json_decode($order->products, true);

            $productsWithDetails = collect($orderProducts)->map(function ($item) {
                $product = Product::find($item['product_id']);
                return [
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'name' => $product->name ?? 'Unknown Product',
                    'size' => $product->size ?? null,
                    'price' => $product->price ?? null,
                ];
            });

            $order->products = $productsWithDetails;

            return $order;
        });

        return inertia('AdminPanel', [
            'orders' => $orders,
            'page' => $page,
            'per_page' => $perPage,
        ]);
    }
}
