<?php

use App\Models\Discount;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(Discount::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(Discount::TYPE, 32)->nullable(false);
            $table->unsignedSmallInteger(Discount::DISCOUNT_PERCENT)->nullable(false);
            $table->json(Discount::CONDITIONS); // For current types could be used two separate commands
                                                        // but this way is easier to extend
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(Discount::TABLE);
    }
};
