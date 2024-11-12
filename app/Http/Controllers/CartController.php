<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Product $product, Request $request)
    {
        // Ambil data keranjang dari session
        $cart = session()->get('cart', []);

        // Jika produk sudah ada di keranjang, tambahkan jumlahnya
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            // Jika produk belum ada, tambahkan ke keranjang
            $cart[$product->id] = [
                "product_name" => $product->product_name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function showCart()
    {
        // Ambil data keranjang dari session
        $cart = session()->get('cart', []);
        return view('landing.cart', compact('cart'));
    }

    public function checkout(Request $request)
    {
        // Proses checkout dan bersihkan keranjang
        session()->forget('cart');
        return redirect()->route('home')->with('success', 'Thank you for your purchase!');
    }
}
