<?php
declare(strict_types=1);

namespace App\Services\Discount;

use App\Models\Cart;
use App\Models\Discount;

class CartTotalStrategy extends ProductStrategy
{
    public function canApply(Cart $cart, Discount $discount): bool
    {
        return $cart->base_total_price > $discount->conditions['cart_total'];
    }

    public function apply(Cart $cart, Discount $discount): void
    {
        foreach ($cart->items as $item) {
            $this->applyToItem($item, $discount);
        }
    }
}
