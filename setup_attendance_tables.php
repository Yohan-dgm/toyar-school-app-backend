<?php

/**
 * Script to create attendance management database tables
 */

require_once __DIR__.'/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$sqlFiles = [
    'attendance_type.sql',
    'student_attendance.sql',
    'attendance_reasons.sql',
];

$basePath = __DIR__.'/modules/AttendanceManagement/Database/Sql/';

try {
    echo "🚀 Setting up Attendance Management database tables...\n";
    echo '='.str_repeat('=', 60)."\n";

    foreach ($sqlFiles as $fileName) {
        $filePath = $basePath.$fileName;

        if (! file_exists($filePath)) {
            echo "❌ File not found: $fileName\n";

            continue;
        }

        echo "📋 Executing: $fileName\n";

        $sql = file_get_contents($filePath);

        // Execute the SQL
        DB::unprepared($sql);

        echo "✅ Successfully executed: $fileName\n";
    }

    echo "\n".'='.str_repeat('=', 60)."\n";
    echo "🎉 Database setup completed!\n";

    // Verify tables were created
    echo "\n🔍 Verifying tables...\n";
    $tables = ['attendance_type', 'student_attendance', 'attendance_reasons'];

    foreach ($tables as $table) {
        $exists = DB::connection()->getSchemaBuilder()->hasTable($table);
        echo "  $table: ".($exists ? '✅ EXISTS' : '❌ NOT FOUND')."\n";
    }

    // Check attendance types
    echo "\n📝 Checking attendance types...\n";
    $types = DB::table('attendance_type')->select('id', 'name')->get();
    foreach ($types as $type) {
        echo "  ID {$type->id}: {$type->name}\n";
    }

} catch (Exception $e) {
    echo '❌ Error: '.$e->getMessage()."\n";
    echo 'Stack trace: '.$e->getTraceAsString()."\n";
}
