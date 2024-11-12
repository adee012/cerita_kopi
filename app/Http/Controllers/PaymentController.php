<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{

    public function __construct()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        Config::$isSanitized = env('MIDTRANS_IS_SANITIZED');
        Config::$is3ds = env('MIDTRANS_IS_3DS');
    }

    public function processPayment(Request $request)
    {
        try {
            $product = Product::findOrFail($request->product_id);

            // Cek stok
            if ($product->stock < 1) {
                return response()->json(['error' => 'Stok produk habis'], 400);
            }

            $orderId = 'ORDER-' . uniqid();

            // Simpan transaksi
            $transaction = Transaction::create([
                'order_id' => $orderId,
                'product_id' => $product->id,
                'user_name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'amount' => $product->price,
                'status' => 'pending'
            ]);

            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => (int) $product->price,
                ],
                'customer_details' => [
                    'first_name' => $request->name,
                    'email' => $request->email,
                    'address' => $request->address,
                ],
                'item_details' => [
                    [
                        'id' => $product->id,
                        'price' => (int) $product->price,
                        'quantity' => 1,
                        'name' => $product->name
                    ]
                ]
            ];

            $snapToken = Snap::getSnapToken($params);

            // Simpan snap token
            $transaction->update(['snap_token' => $snapToken]);

            // Kurangi stok produk
            $product->decrement('stock', 1);

            return response()->json([
                'snap_token' => $snapToken,
                'redirect_url' => route('landing.invoice', $orderId)
            ]);
        } catch (\Exception $e) {
            // Log::error('Payment Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {
            $transaction = Transaction::where('order_id', $request->order_id)->first();

            if ($transaction) {
                $transaction->update(['status' => $request->transaction_status]);
            }
        }
    }
}
