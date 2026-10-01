<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("section_access", function (Blueprint $table) {
            $table->id();
            $table->string("section_key")->index();
            $table->unsignedBigInteger("user_id")->index();
            $table->unsignedBigInteger("granted_by");
            $table->timestamps();

            $table->unique(["section_key", "user_id"]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("section_access");
    }
};
