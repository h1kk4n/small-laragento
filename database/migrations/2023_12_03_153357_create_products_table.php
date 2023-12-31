<?php

use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(Product::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(Product::NAME, 255);
            $table->string(Product::SKU, 255);
            $table->float(Product::PRICE);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(Product::TABLE);
    }
};
