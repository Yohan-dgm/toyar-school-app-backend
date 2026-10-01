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
        Schema::create('academic_timetable', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('grade_level_class_id');
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('educator_id');
            $table->enum('day_of_week', ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']);
            $table->time('start_time');
            $table->time('end_time');
            $table->string('room_number', 50)->nullable();
            $table->string('building', 100)->nullable();
            $table->string('semester', 50);
            $table->string('academic_year', 20);
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('grade_level_class_id')->references('id')->on('grade_level_class')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subject')->onDelete('cascade');
            $table->foreign('educator_id')->references('id')->on('educators')->onDelete('cascade');

            // Indexes for better performance
            $table->index(['grade_level_class_id', 'day_of_week']);
            $table->index(['educator_id', 'day_of_week']);
            $table->index(['subject_id']);
            $table->index(['semester', 'academic_year']);
            $table->index(['is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_timetable');
    }
};
