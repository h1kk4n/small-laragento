<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Discount;
use App\Services\Discount\ApplyingStrategyFactory;

class DiscountApplier
{
    public function __construct(
        private readonly ApplyingStrategyFactory $applyingStrategyFactory
    ) {
    }

    public function applyRules(Cart $cart): void
    {
        foreach ($cart->items as $item) {
            $item->final_price = $item->base_price;
        }

        /** @var Discount $discount */
        foreach (Discount::all() as $discount) {
            $applyingStrategy = $this->applyingStrategyFactory->get($discount);
            if (!$applyingStrategy->canApply($cart, $discount)) {
                continue;
            }
            $applyingStrategy->apply($cart, $discount);
        }
    }
}
