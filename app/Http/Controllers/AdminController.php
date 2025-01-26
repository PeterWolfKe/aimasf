<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Mail\OrderDelivered;
use Illuminate\Support\Facades\Mail;
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
            $order->set_delivery_data();

            $order->totalPrice = $order->getFullPrice();
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
        $order->set_delivery_data();

        $order->totalPrice = $order->getFullPrice();

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
                'id' => $item['id'],
                'quantity' => $item['quantity'],
                'name' => $product->name ?? 'Unknown Product',
                'size' => $product->size ?? null,
                'price' => $product->price ?? null,
            ];
        });

        $order->products = $productsWithDetails;
    }

    /**
     * Handles sending the order delivered email.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function order_delivered($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }
        $shippingOption = $order->shippingOption;

        if ($order->status != 1) {
            return response()->json(['error' => 'Order not eligible for delivery'], 400);
        }
        $order->update(['status' => 2]);
        if ($shippingOption->type != 1){
            return response()->json(['message' => 'Status aktualizovaný'], 200);
        }

        $products = array_map(function ($item) {
            $product = Product::find($item['id']);
            return [
                'name' => $product->name,
                'quantity' => $item['quantity'],
                'size' => $product->size,
                'price' => $product->price
            ];
        }, json_decode($order->products, true));

        $details = [
            'first_name' => $order->first_name,
            'last_name' => $order->last_name,
            'delivery_method' => $order->shippingOption->title,
            'delivery_address' => $order->shippingOption->address,
            'unique_order_id' => $order->unique_order_id,
            'products' => $products,
        ];

        try {
            Mail::to($order->email)->send(new OrderDelivered($details));
            return response()->json(['message' => 'Email sent successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to send email', 'details' => $e->getMessage()], 500);
        }
    }
}
