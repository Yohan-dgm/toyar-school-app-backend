<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('edu_fb_subcategory', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('edu_fb_id');
            $table->unsignedBigInteger('edu_fb_category_id');
            $table->string('subcategory_name', 255);
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            // Add foreign key constraints if needed
            // $table->foreign('edu_fb_id')->references('id')->on('edu_fb')->onDelete('cascade');
            // $table->foreign('edu_fb_category_id')->references('id')->on('edu_fb_category');
            // $table->foreign('created_by')->references('id')->on('users');
            // $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('edu_fb_subcategory');
    }
};
