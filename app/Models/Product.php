<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $sku
 * @property float $price
 */
class Product extends Model
{
    use HasFactory;

    public const
        ID = 'id',
        NAME = 'name',
        SKU = 'sku',
        PRICE = 'price';

    protected static function newFactory(): ProductFactory
    {
        return ProductFactory::new();
    }
}
