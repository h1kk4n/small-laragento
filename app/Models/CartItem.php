<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $cart_id
 * @property Cart $cart
 * @property int $product_id
 * @property Product $product
 * @property int $qty
 * @property int $final_price
 */
class CartItem extends Model
{
    public const
        TABLE = 'cart_items',
        ID = 'id',
        CART_ID = 'cart_id',
        PRODUCT_ID = 'product_id',
        QTY = 'qty',
        FINAL_PRICE = 'final_price';

    protected $table = self::TABLE;
    protected $primaryKey = self::ID;
    protected $attributes = [
        self::QTY => 1
    ];

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
