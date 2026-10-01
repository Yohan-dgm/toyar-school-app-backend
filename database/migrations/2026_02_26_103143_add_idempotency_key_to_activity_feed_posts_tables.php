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
        if (Schema::hasTable('school_posts')) {
            Schema::table('school_posts', function (Blueprint $table) {
                $table->string('idempotency_key')->nullable()->index();
            });
        }

        if (Schema::hasTable('class_posts')) {
            Schema::table('class_posts', function (Blueprint $table) {
                $table->string('idempotency_key')->nullable()->index();
            });
        }

        if (Schema::hasTable('student_posts')) {
            Schema::table('student_posts', function (Blueprint $table) {
                $table->string('idempotency_key')->nullable()->index();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('school_posts')) {
            Schema::table('school_posts', function (Blueprint $table) {
                $table->dropColumn('idempotency_key');
            });
        }

        if (Schema::hasTable('class_posts')) {
            Schema::table('class_posts', function (Blueprint $table) {
                $table->dropColumn('idempotency_key');
            });
        }

        if (Schema::hasTable('student_posts')) {
            Schema::table('student_posts', function (Blueprint $table) {
                $table->dropColumn('idempotency_key');
            });
        }
    }
};
