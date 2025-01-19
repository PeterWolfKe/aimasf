<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        session()->forget('products'); //Temporary
        session()->forget('discount');
        $id = "00000001";

        $product = Product::findOrFail($id);
        $productImages = json_decode($product->product_images) ?: [];

        return Inertia::render('Home',
            ['product' => $product, 'productImages' => $productImages,])
            ->toResponse(request())->withHeaders([
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
        ]);
    }
}
