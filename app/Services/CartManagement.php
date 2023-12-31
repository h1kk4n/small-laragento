<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

class CartManagement
{
    public function __construct(
        private readonly DiscountApplier $discountApplier
    ) {
    }

    public function getCart(int $cartId = null): Cart
    {
        if ($cartId && $cart = Cart::find($cartId)) {
            return $cart;
        } else {
            $cart = new Cart;
            $cart->save();
            return $cart;
        }
    }

    public function addProduct(Cart $cart, Product $product): void
    {
        /** @var CartItem $item */
        $item = $cart->items->keyBy(CartItem::PRODUCT_ID)->get($product->id);
        if (!$item) {
            $item = new CartItem;
            $item->product_id = $product->id;
            $item->single_price = $product->price;
        } else {
            $item->qty++;
        }
        $item->updatePrices();
        $cart->items()->save($item);
        $this->collectTotals($cart);
    }

    public function updateQty(Cart $cart, int $itemId, bool $increment): void
    {
        /** @var CartItem $item */
        $item = $cart->items->find($itemId);
        if (!$item) {
            throw new \InvalidArgumentException("Cart item with id = {$itemId} not found");
        }

        $increment ? $item->qty++ : $item->qty--;

        if ($item->qty > 0) {
            $item->updatePrices();
            $item->save();
        } else {
            $item->delete();
        }
        $this->collectTotals($cart);
    }

    public function removeItem(Cart $cart, int $itemId): void
    {
        /** @var CartItem $item */
        $item = $cart->items->find($itemId);
        if (!$item) {
            throw new \InvalidArgumentException("Cart item with id = {$itemId} not found");
        }
        $item->delete();
        $this->collectTotals($cart);
    }

    public function placeOrder(Cart $cart): void
    {
        $cart->delete(); // Properly it should create order from cart, but the point is cart logic
    }

    public function collectTotals(Cart $cart): void
    {
        $cart->refresh();
        $this->calculateBaseTotals($cart);
        $this->discountApplier->applyRules($cart);
        $this->calculateTotalPrice($cart);

        $cart->items->map(
            fn (CartItem $cartItem) => $cartItem->save()
        );
        $cart->save();
    }

    private function calculateBaseTotals(Cart $cart): void
    {
        $totalQty = 0;
        $totalBasePrice = 0;

        foreach ($cart->items as $item) {
            $totalQty += $item->qty;
            $totalBasePrice += $item->base_price;
        }

        $cart->total_qty = $totalQty;
        $cart->base_total_price = $totalBasePrice;
    }

    private function calculateTotalPrice(Cart $cart): void
    {
        $cart->total_price = round((float) $cart->items->reduce(
            fn (float $sum, CartItem $item) => $sum + $item->final_price,
            0
        ), 2);
    }
}
