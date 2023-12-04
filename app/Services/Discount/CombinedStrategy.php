<?php
declare(strict_types=1);

namespace App\Services\Discount;

use App\Models\Cart;
use App\Models\Discount;

class CombinedStrategy extends CartTotalStrategy
{
    /**
     * @param ApplyingStrategyInterface[] $strategies
     */
    public function __construct(
        private readonly array $strategies = []
    ) {
    }

    public function canApply(Cart $cart, Discount $discount): bool
    {
        foreach ($this->strategies as $strategy) {
            if (!$strategy->canApply($cart, $discount)) {
                return false;
            }
        }
        return true;
    }
}
