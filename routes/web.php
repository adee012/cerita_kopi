<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [ProductController::class, 'home'])->name('/');

Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/checkout/{productId}', [ProductController::class, 'checkout'])->name('checkout');


Route::post('/processPayment', [PaymentController::class, 'processPayment'])->name('processPayment');
Route::get('/payment/invoice/{orderId}', [PaymentController::class, 'showInvoice'])->name('payment.invoice');
Route::post('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
