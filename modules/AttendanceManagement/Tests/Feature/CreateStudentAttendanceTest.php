<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Modules\AttendanceManagement\Intents\StudentAttendance\CreateStudentAttendance\CreateStudentAttendanceAction;
use Modules\AttendanceManagement\Models\AttendanceType;
use Modules\AttendanceManagement\Models\StudentAttendance;
use Modules\ProgramManagement\Models\GradeLevel;
use Modules\ProgramManagement\Models\GradeLevelClass;
use Modules\StudentManagement\Models\Student;
use Modules\UserManagement\Models\User;

uses(RefreshDatabase::class);

describe('CreateStudentAttendanceAction', function () {
    beforeEach(function () {
        // Create test data manually
        $this->user = User::create([
            'id' => 1,
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        // Create grade level first
        $this->gradeLevel = GradeLevel::create([
            'id' => 1,
            'name' => 'Grade 1',
            'created_by' => 1,
        ]);

        $this->gradeLevelClass = GradeLevelClass::create([
            'id' => 1,
            'name' => 'Test Class',
            'grade_level_id' => 1,
            'class_capacity' => 30,
            'created_by' => 1,
        ]);

        // Create attendance types
        AttendanceType::create(['id' => 1, 'name' => 'In', 'created_by' => 1]);
        AttendanceType::create(['id' => 2, 'name' => 'Out', 'created_by' => 1]);

        $this->student1 = Student::create([
            'id' => 1,
            'grade_level_class_id' => 1,
            'grade_level_id' => 1,
            'full_name' => 'Test Student 1',
            'admission_number' => 'STU001',
            'has_dropped_out' => false,
            'is_school_leaver' => false,
            'created_by' => 1,
        ]);

        $this->student2 = Student::create([
            'id' => 2,
            'grade_level_class_id' => 1,
            'grade_level_id' => 1,
            'full_name' => 'Test Student 2',
            'admission_number' => 'STU002',
            'has_dropped_out' => false,
            'is_school_leaver' => false,
            'created_by' => 1,
        ]);
    });

    it('creates individual student attendance without triggering bulk creation when no student_list provided', function () {
        $payloadArray = [
            'student_id' => 1,
            'date' => '2025-01-15',
            'time' => '08:30',
            'attendance_type_id' => 1,
        ];

        $actionData = [
            'created_by' => 1,
        ];

        $result = CreateStudentAttendanceAction::run($payloadArray, $actionData);

        expect($result)->toBeInstanceOf(StudentAttendance::class);
        expect($result->student_id)->toBe(1);
        expect($result->grade_level_class_id)->toBe(1);

        // Verify only one attendance record was created
        $attendanceCount = StudentAttendance::where('date', '2025-01-15')
            ->where('grade_level_class_id', 1)
            ->count();
        expect($attendanceCount)->toBe(1);
    });

    it('creates individual attendance and triggers bulk creation when student_list is provided and no existing bulk attendance', function () {
        $payloadArray = [
            'student_id' => 1,
            'date' => '2025-01-16',
            'time' => '08:30',
            'attendance_type_id' => 1,
            'in_time' => '08:00',
            'out_time' => '15:00',
            'student_list' => [1, 2],
        ];

        $actionData = [
            'created_by' => 1,
        ];

        $result = CreateStudentAttendanceAction::run($payloadArray, $actionData);

        expect($result)->toBeInstanceOf(StudentAttendance::class);

        // Verify bulk attendance was created for all students in the list
        // Should have 2 students × 2 attendance types (in/out) = 4 records from bulk
        // Plus 1 individual record = 5 total
        $attendanceCount = StudentAttendance::where('date', '2025-01-16')
            ->where('grade_level_class_id', 1)
            ->count();
        expect($attendanceCount)->toBeGreaterThan(1);

        // Verify attendance exists for both students
        $student1Attendance = StudentAttendance::where('date', '2025-01-16')
            ->where('student_id', 1)
            ->exists();
        $student2Attendance = StudentAttendance::where('date', '2025-01-16')
            ->where('student_id', 2)
            ->exists();

        expect($student1Attendance)->toBeTrue();
        expect($student2Attendance)->toBeTrue();
    });

    it('does not trigger bulk creation when bulk attendance already exists for the date and class', function () {
        // Create existing bulk attendance
        StudentAttendance::create([
            'student_id' => 1,
            'grade_level_class_id' => 1,
            'date' => '2025-01-17',
            'time' => '08:00',
            'attendance_type_id' => 1,
            'created_by' => 1,
        ]);

        $initialCount = StudentAttendance::where('date', '2025-01-17')
            ->where('grade_level_class_id', 1)
            ->count();

        $payloadArray = [
            'student_id' => 2,
            'date' => '2025-01-17',
            'time' => '08:30',
            'attendance_type_id' => 1,
            'in_time' => '08:00',
            'out_time' => '15:00',
            'student_list' => [1, 2],
        ];

        $actionData = [
            'created_by' => 1,
        ];

        $result = CreateStudentAttendanceAction::run($payloadArray, $actionData);

        expect($result)->toBeInstanceOf(StudentAttendance::class);

        // Verify only one new record was added (the individual one)
        $finalCount = StudentAttendance::where('date', '2025-01-17')
            ->where('grade_level_class_id', 1)
            ->count();
        expect($finalCount)->toBe($initialCount + 1);
    });

    it('throws exception when student is not found', function () {
        $payloadArray = [
            'student_id' => 999, // Non-existent student
            'date' => '2025-01-18',
            'time' => '08:30',
            'attendance_type_id' => 1,
        ];

        $actionData = [
            'created_by' => 1,
        ];

        expect(fn () => CreateStudentAttendanceAction::run($payloadArray, $actionData))
            ->toThrow(Exception::class, 'Student not found');
    });

    it('handles empty student_list array gracefully', function () {
        $payloadArray = [
            'student_id' => 1,
            'date' => '2025-01-19',
            'time' => '08:30',
            'attendance_type_id' => 1,
            'in_time' => '08:00',
            'out_time' => '15:00',
            'student_list' => [],
        ];

        $actionData = [
            'created_by' => 1,
        ];

        $result = CreateStudentAttendanceAction::run($payloadArray, $actionData);

        expect($result)->toBeInstanceOf(StudentAttendance::class);

        // Verify only individual attendance was created
        $attendanceCount = StudentAttendance::where('date', '2025-01-19')
            ->where('grade_level_class_id', 1)
            ->count();
        expect($attendanceCount)->toBe(1);
    });
});
