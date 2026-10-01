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
        Schema::table('student_attendance', function (Blueprint $table) {
            if (Schema::hasColumn('student_attendance', 'in_time')) {
                $table->dropColumn('in_time');
            }
            if (Schema::hasColumn('student_attendance', 'out_time')) {
                $table->dropColumn('out_time');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_attendance', function (Blueprint $table) {
            if (! Schema::hasColumn('student_attendance', 'in_time')) {
                $table->string('in_time', 10)->default('07:30')->after('time');
            }
            if (! Schema::hasColumn('student_attendance', 'out_time')) {
                $table->string('out_time', 10)->default('13:00')->after('in_time');
            }
        });
    }
};
