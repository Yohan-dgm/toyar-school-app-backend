<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("discipline_record", function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("student_id")->index();
            $table->string("academic_year")->index();
            $table->unsignedBigInteger("misconduct_level_id");
            $table->string("offence");
            $table->text("description")->nullable();
            $table->date("incident_date");
            $table->unsignedTinyInteger("marks_deducted");
            $table->text("override_reason")->nullable();
            $table->text("disciplinary_action_taken")->nullable();
            $table->unsignedBigInteger("reported_by");
            $table->unsignedBigInteger("reviewed_by")->nullable();
            $table->enum("status", ["Pending", "Approved", "Rejected"])->default("Pending")->index();
            $table->date("reviewed_date")->nullable();
            $table->boolean("parent_informed")->default(false);
            $table->text("student_response")->nullable();
            $table->string("grade_class_at_time")->nullable();
            $table->boolean("is_active")->default(true);
            $table->unsignedBigInteger("created_by");
            $table->unsignedBigInteger("updated_by")->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("discipline_record");
    }
};
