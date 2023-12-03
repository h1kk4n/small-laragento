<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property Collection<CartItem> $items
 * @property int $total_qty
 * @property int $total_price
 */
class Cart extends Model
{
    public const
        TABLE = 'carts',
        ID = 'id',
        ITEMS = 'items',
        TOTAL_QTY = 'total_qty',
        TOTAL_PRICE = 'total_price';

    protected $table = self::TABLE;
    protected $primaryKey = self::ID;
    protected $attributes = [
        self::TOTAL_QTY => 0,
        self::TOTAL_PRICE => 0
    ];

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class, CartItem::CART_ID, self::ITEMS);
    }
}
