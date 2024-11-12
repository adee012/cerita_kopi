<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function home()
    {
        $cart = session()->get('cart', []);
        return view('landing.dashboard', compact('cart'));
    }

    public function index()
    {
        $products = Product::with('category')->get();
        return view('landing.product', compact('products'));
    }

    public function checkout(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        return view('landing.checkout', ['product' => $product]);
    }
}
