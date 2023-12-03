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
        $item = $cart->items->keyBy(CartItem::PRODUCT_ID)->get($product->id);
        if (!$item) {
            $item = new CartItem;
            $item->product_id = $product->id;
            $item->final_price = $product->price;
        } else {
            $item->qty++;
        }
        $cart->items()->save($item);
        $cart->collectTotals();
    }

    public function updateQty(Cart $cart, int $itemId, bool $increment): void
    {
        /** @var CartItem $item */
        $item = $cart->items->find($itemId);
        if (!$item) {
            throw new \InvalidArgumentException("Cart item with id = {$itemId} not found");
        }

        $increment ? $item->qty++ : $item->qty--;
        $item->save();
        $cart->collectTotals();
    }

    public function removeItem(Cart $cart, int $itemId): void
    {
        /** @var CartItem $item */
        $item = $cart->items->find($itemId);
        if (!$item) {
            throw new \InvalidArgumentException("Cart item with id = {$itemId} not found");
        }
        $item->delete();
        $cart->collectTotals();

    }
}
