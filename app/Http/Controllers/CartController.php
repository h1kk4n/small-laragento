<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartManagement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public const
        CART_ID_COOKIE = 'cart_id',
        COOKIE_LIFETIME = 30 * 24 * 60, // One month in minutes
        PRODUCT_ID = 'product-id';

    public function __construct(
        private readonly CartManagement $cartManagement
    ) {
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([self::PRODUCT_ID => 'required|numeric']);

        $cart = $this->cartManagement->getCart($request->cookie(self::CART_ID_COOKIE));

        $product = Product::findOrFail($request->input(self::PRODUCT_ID));
        $this->cartManagement->addProduct($cart, $product);

        return redirect('/')->withCookie(cookie(self::CART_ID_COOKIE, $cart->id, self::COOKIE_LIFETIME));
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
