<?php
declare(strict_types=1);

namespace App\Services\Discount;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Discount;

class ProductStrategy implements ApplyingStrategyInterface
{
    public function canApply(Cart $cart, Discount $discount): bool
    {
        return $cart->items->keyBy(CartItem::PRODUCT_ID)->get($discount->conditions['product_id']) !== null;
    }

    public function apply(Cart $cart, Discount $discount): void
    {
        $item = $cart->items->keyBy(CartItem::PRODUCT_ID)->get($discount->conditions['product_id']);
        $this->applyToItem($item, $discount);
    }

    protected function applyToItem(CartItem $cartItem, Discount $discount): void
    {
        if ($cartItem->final_price <= 0) {
            return;
        }

        $discountAmount = $cartItem->base_price * $discount->discount_percent / 100;
        $cartItem->final_price = max($cartItem->final_price - $discountAmount, 0);
    }
}
