<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("discipline_misconduct_level", function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger("level_number")->unique();
            $table->string("level_name");
            $table->text("nature_of_offence");
            $table->unsignedTinyInteger("indicative_deduction_min");
            $table->unsignedTinyInteger("indicative_deduction_max");
            $table->text("examples")->nullable();
            $table->unsignedTinyInteger("approval_tier");
            $table->boolean("is_active")->default(true);
            $table->unsignedBigInteger("created_by");
            $table->unsignedBigInteger("updated_by")->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("discipline_misconduct_level");
    }
};
