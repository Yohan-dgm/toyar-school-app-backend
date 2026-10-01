<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("canteen_meal_plan", function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->text("description")->nullable();
            $table->decimal("price", 8, 2);
            $table->unsignedInteger("quantity_available")->default(0);
            $table->string("image_path")->nullable();
            $table->boolean("is_active")->default(true);
            $table->unsignedBigInteger("created_by");
            $table->unsignedBigInteger("updated_by")->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("canteen_meal_plan");
    }
};
