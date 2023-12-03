<?php

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(CartItem::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(CartItem::CART_ID);
            $table->unsignedBigInteger(CartItem::PRODUCT_ID);
            $table->unsignedSmallInteger(CartItem::QTY)->default(1)->nullable(false);
            $table->float(CartItem::FINAL_PRICE)->nullable(false);
            $table->timestamps();

            $table->foreign(CartItem::CART_ID)->references(Cart::ID)->on(Cart::TABLE);
            $table->foreign(CartItem::PRODUCT_ID)->references(Product::ID)->on(Product::TABLE);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(CartItem::TABLE);
    }
};
