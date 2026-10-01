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
        Schema::create('sport_timetable', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('sport_id');
            $table->unsignedBigInteger('grade_level_class_id')->nullable();
            $table->unsignedBigInteger('coach_id');
            $table->enum('day_of_week', ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']);
            $table->time('start_time');
            $table->time('end_time');
            $table->string('venue', 100)->nullable();
            $table->string('facility', 100)->nullable();
            $table->enum('season', ['spring', 'summer', 'autumn', 'winter', 'all_year']);
            $table->string('academic_year', 20);
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('team_id')->nullable();
            $table->integer('max_participants')->nullable();
            $table->string('age_group', 50)->nullable();
            $table->enum('skill_level', ['beginner', 'intermediate', 'advanced', 'expert'])->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('sport_id')->references('id')->on('sport')->onDelete('cascade');
            $table->foreign('grade_level_class_id')->references('id')->on('grade_level_class')->onDelete('set null');
            $table->foreign('coach_id')->references('id')->on('employee')->onDelete('cascade');

            // Indexes for better performance
            $table->index(['sport_id', 'day_of_week']);
            $table->index(['coach_id', 'day_of_week']);
            $table->index(['grade_level_class_id']);
            $table->index(['season', 'academic_year']);
            $table->index(['is_active']);
            $table->index(['skill_level']);
            $table->index(['team_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sport_timetable');
    }
};
