<?php
declare(strict_types=1);

namespace App\Services\Discount;

use App\Models\Discount;

class ApplyingStrategyFactory
{
    private array $typeMap = [
        Discount::TYPE_PRODUCT  => ProductStrategy::class,
        Discount::TYPE_CART     => CartTotalStrategy::class,
        Discount::TYPE_COMBINED => CombinedStrategy::class
    ];
    private array $cache = [];

    public function get(Discount $discount): ?ApplyingStrategyInterface
    {
        if (!isset($this->cache[$discount->type])) {
            if (!isset($this->typeMap[$discount->type])) {
                return null;
            }
            $this->cache[$discount->type] = app($this->typeMap[$discount->type]);
        }
        return $this->cache[$discount->type];
    }
}
