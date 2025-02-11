<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        session()->forget('products'); //Temporary
        session()->forget('discount');
        $id = "00000001";
        $idValentine = "00000002";

        $product = Product::findOrFail($id);
        $productImages = json_decode($product->product_images) ?: [];

        $productValentine = Product::findOrFail($idValentine);
        $productImagesValentine = json_decode($productValentine->product_images) ?: [];

        return Inertia::render('Home',
            ['product' => $product, 'productImages' => $productImages,
                'productValentine' => $productValentine, 'productImagesValentine' => $productImagesValentine])
            ->toResponse(request())->withHeaders([
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
        ]);
    }
}
