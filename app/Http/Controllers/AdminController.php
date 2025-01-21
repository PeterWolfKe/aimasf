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
            $this->get_products($order);

            return $order;
        });

        return Inertia::render('AdminPanel', [
            'orders' => $orders,
            'page' => $page,
            'per_page' => $perPage,
        ]);
    }
    public function order($id){
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $this->get_products($order);

        return Inertia::render('OrderPage', [
            'order' => $order
        ]);
    }

    /**
     * @param $order
     * @return void
     */
    protected function get_products($order): void
    {
        $orderProducts = json_decode($order->products, true);
        $productsWithDetails = collect($orderProducts)->map(function ($item) {
            $product = Product::find($item['id']);
            return [
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'name' => $product->name ?? 'Unknown Product',
                'size' => $product->size ?? null,
                'price' => $product->price ?? null,
            ];
        });

        $order->products = $productsWithDetails;
        $order->shipping_option_id = $order->shippingOption->title ?? 'Unknown Delivery Method';
    }
}
