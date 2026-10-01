<?php

/**
 * Create test data for attendance management system testing
 */

require_once __DIR__.'/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    echo "🧪 Creating test data for attendance management system...\n";
    echo '='.str_repeat('=', 60)."\n";

    // Update attendance types to match our system expectations
    echo "📝 Updating attendance types...\n";
    DB::table('attendance_type')->truncate();

    DB::table('attendance_type')->insert([
        ['id' => 1, 'name' => 'Present', 'created_by' => 1, 'created_at' => now()],
        ['id' => 2, 'name' => 'Absent', 'created_by' => 1, 'created_at' => now()],
        ['id' => 3, 'name' => 'Late', 'created_by' => 1, 'created_at' => now()],
    ]);
    echo "✅ Attendance types updated\n";

    // Check if user table exists and create test user if needed
    echo "\n👤 Checking for test users...\n";
    $userCount = DB::table('user')->count();
    if ($userCount == 0) {
        echo "Creating test user...\n";
        DB::table('user')->insert([
            'id' => 1,
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        echo "✅ Test user created\n";
    } else {
        echo "✅ Users already exist ($userCount found)\n";
    }

    // Create test grade level and class (these are likely needed)
    echo "\n🏫 Creating test grade level and class...\n";

    // We need to check if these tables exist first
    $hasGradeLevel = DB::connection()->getSchemaBuilder()->hasTable('grade_level');
    $hasGradeLevelClass = DB::connection()->getSchemaBuilder()->hasTable('grade_level_class');

    if ($hasGradeLevel) {
        echo "grade_level table exists\n";
        // Check if test grade level exists
        $gradeLevelExists = DB::table('grade_level')->where('id', 1)->exists();
        if (! $gradeLevelExists) {
            DB::table('grade_level')->insert([
                'id' => 1,
                'name' => 'Grade 1',
                'created_by' => 1,
                'created_at' => now(),
            ]);
        }
        echo "✅ Grade level ready\n";
    } else {
        echo "⚠️ grade_level table doesn't exist - will create temporary data structure\n";
    }

    if ($hasGradeLevelClass) {
        echo "grade_level_class table exists\n";
        $classExists = DB::table('grade_level_class')->where('id', 5)->exists();
        if (! $classExists) {
            DB::table('grade_level_class')->insert([
                'id' => 5,
                'name' => 'Grade 1A',
                'grade_level_id' => 1,
                'class_capacity' => 30,
                'created_by' => 1,
                'created_at' => now(),
            ]);
        }
        echo "✅ Grade level class ready\n";
    } else {
        echo "⚠️ grade_level_class table doesn't exist - will create temporary data structure\n";
    }

    // Create test students
    echo "\n🎓 Creating test students...\n";
    $hasStudent = DB::connection()->getSchemaBuilder()->hasTable('student');

    if ($hasStudent) {
        echo "student table exists\n";

        // Clear existing test students
        DB::table('student')->whereIn('id', [1001, 1002, 1003, 1004, 1005, 1006, 1007, 1008])->delete();

        // Create test students
        $students = [
            ['id' => 1001, 'full_name' => 'Test Student 1', 'admission_number' => 'STU001'],
            ['id' => 1002, 'full_name' => 'Test Student 2', 'admission_number' => 'STU002'],
            ['id' => 1003, 'full_name' => 'Test Student 3', 'admission_number' => 'STU003'],
            ['id' => 1004, 'full_name' => 'Test Student 4', 'admission_number' => 'STU004'],
            ['id' => 1005, 'full_name' => 'Test Student 5', 'admission_number' => 'STU005'],
            ['id' => 1006, 'full_name' => 'Test Student 6', 'admission_number' => 'STU006'],
            ['id' => 1007, 'full_name' => 'Test Student 7', 'admission_number' => 'STU007'],
            ['id' => 1008, 'full_name' => 'Test Student 8', 'admission_number' => 'STU008'],
        ];

        foreach ($students as $student) {
            DB::table('student')->insert([
                'id' => $student['id'],
                'grade_level_class_id' => 5,
                'grade_level_id' => 1,
                'full_name' => $student['full_name'],
                'admission_number' => $student['admission_number'],
                'has_dropped_out' => false,
                'is_school_leaver' => false,
                'created_by' => 1,
                'created_at' => now(),
            ]);
        }
        echo "✅ Test students created\n";

    } else {
        echo "⚠️ student table doesn't exist - cannot create test students\n";
        echo "You'll need to run the student management SQL files first\n";
    }

    echo "\n".'='.str_repeat('=', 60)."\n";
    echo "🎉 Test data creation completed!\n";

    // Show summary
    echo "\n📊 Summary:\n";
    echo '  - Attendance types: '.DB::table('attendance_type')->count()." records\n";
    echo '  - Users: '.DB::table('user')->count()." records\n";
    if ($hasStudent) {
        echo '  - Students: '.DB::table('student')->count()." records\n";
    }

    echo "\n🚀 System ready for testing!\n";
    echo "Next step: Start Laravel server with 'composer dev'\n";

} catch (Exception $e) {
    echo '❌ Error: '.$e->getMessage()."\n";
    echo 'Stack trace: '.$e->getTraceAsString()."\n";
}
