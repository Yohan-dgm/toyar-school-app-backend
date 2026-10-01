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
        Schema::create('sport_attendance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('student_id');
            $table->date('date');
            $table->time('time');
            $table->unsignedBigInteger('attendance_type_id');
            $table->text('notes')->nullable();
            $table->string('sport_activity');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->unsignedBigInteger('coach_id')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('attendance_type_id')->references('id')->on('attendance_types')->onDelete('cascade');
            $table->foreign('coach_id')->references('id')->on('users')->onDelete('set null');

            // Indexes for better performance
            $table->index(['student_id', 'date']);
            $table->index(['sport_activity']);
            $table->index(['coach_id']);
            $table->index(['date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sport_attendance');
    }
};
