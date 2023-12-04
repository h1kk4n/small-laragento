<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property Collection<CartItem> $items
 * @property int $total_qty
 * @property float $base_total_price
 * @property float $total_price
 */
class Cart extends Model
{
    public const
        TABLE = 'carts',
        ID = 'id',
        TOTAL_QTY = 'total_qty',
        BASE_TOTAL_PRICE = 'base_total_price',
        TOTAL_PRICE = 'total_price';

    protected $table = self::TABLE;
    protected $primaryKey = self::ID;
    protected $attributes = [
        self::TOTAL_QTY => 0,
        self::BASE_TOTAL_PRICE => 0,
        self::TOTAL_PRICE => 0
    ];

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function collectTotals(): void
    {
        $this->refresh();

        $totalQty = 0;
        $totalPrice = 0;
        foreach ($this->items as $item) {
            $totalQty += $item->qty;
            $totalPrice += $item->final_price;
        }

        $this->total_qty = $totalQty;
        $this->total_price = $totalPrice;
        $this->save();
    }
}
