<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Services\CartManagement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public const
        CART_ID_COOKIE = 'cart_id',
        COOKIE_LIFETIME = 30 * 24 * 60, // One month in minutes
        PRODUCT_ID = 'product-id',
        QTY_INCREMENT = 'qty-increment';

    public function __construct(
        private readonly CartManagement $cartManagement
    ) {
    }

    public function placeOrder(Request $request): RedirectResponse
    {
        $cart = $this->getCart($request);
        $this->cartManagement->placeOrder($cart);

        return redirect('/')->withoutCookie(self::CART_ID_COOKIE);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([self::PRODUCT_ID => 'required|numeric']);

        $cart = $this->getCart($request);
        $product = Product::findOrFail($request->input(self::PRODUCT_ID));
        $this->cartManagement->addProduct($cart, $product);

        return redirect('/')->withCookie(cookie(self::CART_ID_COOKIE, $cart->id, self::COOKIE_LIFETIME));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            self::QTY_INCREMENT => 'required|boolean'
        ]);

        $cart = $this->getCart($request);
        $increment = (bool) $request->input(self::QTY_INCREMENT);
        $this->cartManagement->updateQty($cart, $id, $increment);

        return $this->getResponse($cart);
    }

    public function destroy(Request $request, int $id): RedirectResponse
    {
        $cart = $this->getCart($request);
        $this->cartManagement->removeItem($cart, $id);

        return $this->getResponse($cart);
    }

    private function getCart(Request $request): Cart
    {
        $cartId = $request->cookie(self::CART_ID_COOKIE);
        return $this->cartManagement->getCart($cartId);
    }

    private function getResponse(Cart $cart): RedirectResponse
    {
        $cookie = cookie(self::CART_ID_COOKIE, $cart->id, self::COOKIE_LIFETIME);
        return redirect('/')->withCookie($cookie);
    }
}
