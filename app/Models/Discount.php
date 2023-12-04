<?php

namespace App\Models;

use Database\Factories\DiscountFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $type,
 * @property int $discount_percent
 * @property array $conditions
 */
class Discount extends Model
{
    use HasFactory;

    public const
        TABLE = 'discounts',
        ID = 'id',
        TYPE = 'type',
        DISCOUNT_PERCENT = 'discount_percent',
        CONDITIONS = 'conditions';

    public const
        TYPE_PRODUCT = 'product',
        TYPE_CART = 'cart',
        TYPE_COMBINED = 'combined';

    protected $table = self::TABLE;
    protected $primaryKey = self::ID;
    protected $casts = [
        self::CONDITIONS => 'json'
    ];

    public function getName(): string
    {
        /** @var Product|null $product */
        $product = isset($this->conditions['product_id']) ? Product::find($this->conditions['product_id']) : null;
        // @todo Create runtime caching for products to avoid redundant queries
        $cartTotal = $this->conditions['cart_total'] ?? null;
        $percent = $this->discount_percent;
        return match ($this->type) {
            Discount::TYPE_PRODUCT  => "Discount {$percent}% for SKU: {$product->sku}",
            Discount::TYPE_CART     => "Discount {$percent}% when buying for {$cartTotal}",
            Discount::TYPE_COMBINED => "Discount {$percent}% when buying SKU: {$product->sku}"
                                       . " with other products for {$cartTotal}",
            default => '',
        };
    }

    protected static function newFactory(): DiscountFactory
    {
        return DiscountFactory::new();
    }
}
