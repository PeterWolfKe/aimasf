<?php

namespace App\Http\Controllers;

use App\Models\EmailSubscription;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        session()->forget('products'); //Temporary
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
