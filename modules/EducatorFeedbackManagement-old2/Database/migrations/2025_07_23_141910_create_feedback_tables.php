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
        Schema::create('feedback_categories', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->unsignedBigInteger('school_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->json('subcategories')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->index('school_id');
            $table->index('sort_order');
        });

        Schema::create('feedback_questions', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('category_id', 50);
            $table->text('question');
            $table->enum('answer_type', ['scale', 'predefined', 'custom']);
            $table->boolean('is_required')->default(true);
            $table->integer('sort_order')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->index('category_id');
            $table->index('sort_order');

            $table->foreign('category_id')->references('id')->on('feedback_categories')->onDelete('cascade');
        });

        Schema::create('feedback_question_options', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('question_id', 50);
            $table->text('text');
            $table->integer('marks')->default(0);
            $table->integer('sort_order')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->index('question_id');
            $table->index('sort_order');

            $table->foreign('question_id')->references('id')->on('feedback_questions')->onDelete('cascade');
        });

        Schema::create('educator_feedbacks', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->unsignedBigInteger('school_id');
            $table->string('student_id', 50);
            $table->string('educator_id', 50);
            $table->string('main_category', 50);
            $table->json('subcategories')->nullable();
            $table->text('description');
            $table->decimal('rating', 3, 2)->default(0.00);
            $table->json('questionnaire_answers')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'revision_requested'])->default('pending');
            $table->string('created_by', 50);
            $table->string('approved_by', 50)->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->text('revision_instructions')->nullable();
            $table->timestamps();

            $table->index('student_id');
            $table->index('educator_id');
            $table->index('main_category');
            $table->index('status');
            $table->index('created_at');
            $table->index('rating');

            // Assuming you have 'schools', 'students', and 'users' tables.
            // If not, these foreign keys will fail.
            // $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            // $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            // $table->foreign('educator_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('main_category')->references('id')->on('feedback_categories')->onDelete('restrict');
        });

        Schema::create('feedback_analytics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->string('student_id', 50)->nullable();
            $table->string('educator_id', 50)->nullable();
            $table->string('grade_id', 50)->nullable();
            $table->string('category_id', 50)->nullable();
            $table->char('month', 7)->nullable(); // Format: YYYY-MM
            $table->integer('total_feedbacks')->default(0);
            $table->decimal('average_rating', 3, 2)->default(0.00);
            $table->integer('pending_count')->default(0);
            $table->integer('approved_count')->default(0);
            $table->integer('rejected_count')->default(0);
            $table->timestamps();

            $table->unique(['school_id', 'student_id', 'educator_id', 'grade_id', 'category_id', 'month'], 'unique_analytics');
            $table->index('month');

            // $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback_analytics');
        Schema::dropIfExists('educator_feedbacks');
        Schema::dropIfExists('feedback_question_options');
        Schema::dropIfExists('feedback_questions');
        Schema::dropIfExists('feedback_categories');
    }
};
