<?php

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table(Cart::TABLE, function (Blueprint $table) {
            $table->float(Cart::BASE_TOTAL_PRICE);
        });

        Schema::table(CartItem::TABLE, function (Blueprint $table) {
            $table->float(CartItem::SINGLE_PRICE)->nullable(false);
            $table->float(CartItem::BASE_PRICE)->nullable(false);
        });
    }

    public function down(): void
    {
        Schema::table(Cart::TABLE, function (Blueprint $table) {
            $table->dropColumn(Cart::BASE_TOTAL_PRICE);
        });

        Schema::table(CartItem::TABLE, function (Blueprint $table) {
            $table->dropColumn(CartItem::SINGLE_PRICE, CartItem::BASE_PRICE);
        });
    }
};
