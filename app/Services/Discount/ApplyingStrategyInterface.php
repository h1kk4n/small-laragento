<?php
declare(strict_types=1);

namespace App\Services\Discount;

use App\Models\Cart;
use App\Models\Discount;

interface ApplyingStrategyInterface
{
    public function canApply(Cart $cart, Discount $discount): bool;

    public function apply(Cart $cart, Discount $discount): void;
}
