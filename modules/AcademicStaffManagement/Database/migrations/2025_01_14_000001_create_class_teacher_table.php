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
        Schema::create('class_teacher', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('grade_level_class_id');
            $table->string('academic_year');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
            $table->foreign('grade_level_class_id')->references('id')->on('grade_level_class')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('user')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('user')->onDelete('set null');

            // Indexes for better query performance
            $table->index('user_id');
            $table->index('grade_level_class_id');
            $table->index('academic_year');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_teacher');
    }
};
