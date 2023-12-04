<?php

namespace Database\Factories;

use App\Models\Discount;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Discount>
 */
class DiscountFactory extends Factory
{
    public function definition(): array
    {
        $types = [Discount::TYPE_PRODUCT, Discount::TYPE_CART, Discount::TYPE_COMBINED];
        $discountType = $types[array_rand($types)];
        return [
            Discount::TYPE             => $discountType,
            Discount::DISCOUNT_PERCENT => rand(1, 40),
            Discount::CONDITIONS       => $this->getConditions($discountType)
        ];
    }

    private function getConditions(string $type): array
    {
        return match ($type) {
            Discount::TYPE_PRODUCT => [
                'product_id' => Product::all()->random()->id
            ],
            Discount::TYPE_CART => [
                'cart_total' => rand(2000, 10000)
            ],
            Discount::TYPE_COMBINED => [
                'product_id' => Product::all()->random()->id,
                'cart_total' => rand(2000, 10000)
            ],
            default => [],
        };
    }
}
