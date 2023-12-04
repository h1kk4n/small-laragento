<?php

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

Route::get('/', function (\Illuminate\Http\Request $request) {
    if ($cartId = $request->cookie(\App\Http\Controllers\CartController::CART_ID_COOKIE)) {
        $cart = \App\Models\Cart::find($cartId);
    }
    return view('index', [
        'products'  => \App\Models\Product::all(),
        'cart'      => $cart ?? null,
        'discounts' => \App\Models\Discount::all()
    ]);
});

Route::controller(\App\Http\Controllers\CartController::class)
    ->prefix('cart')
    ->group(function () {
        Route::post('', 'store');
        Route::put('{id}', 'update');
        Route::delete('{id}', 'destroy');
        Route::post('order', 'placeOrder');
    });
