<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("canteen_order", function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("student_id")->index();
            $table->unsignedBigInteger("ordered_by");
            $table->date("order_date")->index();
            $table->enum("status", ["Pending", "Cancelled"])->default("Pending")->index();
            $table->decimal("total_amount", 8, 2);
            $table->unsignedBigInteger("created_by");
            $table->unsignedBigInteger("updated_by")->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("canteen_order");
    }
};
