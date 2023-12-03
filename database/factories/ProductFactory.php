<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            Product::NAME  => fake()->text(32),
            Product::SKU   => fake()->numberBetween(100000000),
            Product::PRICE => fake()->randomFloat(2, 100, 5000)
        ];
    }
}
