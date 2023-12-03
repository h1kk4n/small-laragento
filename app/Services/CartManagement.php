<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

class CartManagement
{
    public function getCart(int $cartId = null): Cart
    {
        if ($cartId) {
            return Cart::findOrFail($cartId);
        } else {
            $cart = new Cart;
            $cart->save();
            return $cart;
        }
    }

    public function addProduct(Cart $cart, Product $product): void
    {
        /** @var CartItem|null $existingItem */
        $cartItem = $cart->items->keyBy(CartItem::PRODUCT_ID)->get($product->id);
        if (!$cartItem) {
            $cartItem = new CartItem;
            $cartItem->product_id = $product->id;
            $cartItem->final_price = $product->price;
        } else {
            $cartItem->qty++;
        }
        $cart->items()->save($cartItem);
        $cart->collectTotals();
    }
}
