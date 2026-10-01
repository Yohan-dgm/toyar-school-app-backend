<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("canteen_order_item", function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("canteen_order_id")->index();
            $table->unsignedBigInteger("meal_plan_id");
            $table->string("meal_plan_title");
            $table->decimal("unit_price", 8, 2);
            $table->unsignedInteger("quantity");
            $table->decimal("subtotal", 8, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("canteen_order_item");
    }
};
