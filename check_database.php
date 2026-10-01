<?php

/**
 * Simple database check script
 */

require_once __DIR__.'/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    echo "🔍 Checking database connection and tables...\n";

    // Check database connection
    $connection = DB::connection()->getPDO();
    echo "✅ Database connection: SUCCESSFUL\n";

    // Check for student_attendance table
    $hasStudentAttendance = DB::connection()->getSchemaBuilder()->hasTable('student_attendance');
    echo '📋 student_attendance table exists: '.($hasStudentAttendance ? 'YES' : 'NO')."\n";

    // Check for attendance_reasons table
    $hasAttendanceReasons = DB::connection()->getSchemaBuilder()->hasTable('attendance_reasons');
    echo '💭 attendance_reasons table exists: '.($hasAttendanceReasons ? 'YES' : 'NO')."\n";

    // List available tables
    echo "\n📊 Available tables:\n";
    $tables = DB::select("SELECT tablename FROM pg_tables WHERE schemaname = 'public' ORDER BY tablename");
    foreach ($tables as $table) {
        echo '  - '.$table->tablename."\n";
    }

    // Check current database name
    $databaseName = DB::connection()->getDatabaseName();
    echo "\n🎯 Current database: ".$databaseName."\n";

} catch (Exception $e) {
    echo '❌ Database error: '.$e->getMessage()."\n";
}
