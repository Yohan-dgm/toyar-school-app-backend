<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Modules\AttendanceManagement\Intents\StudentAttendance\BatchCreateStudentAttendance\BatchCreateStudentAttendanceAction;
use Modules\AttendanceManagement\Models\AttendanceReason;
use Modules\AttendanceManagement\Models\AttendanceType;
use Modules\AttendanceManagement\Models\StudentAttendance;
use Modules\ProgramManagement\Models\GradeLevel;
use Modules\ProgramManagement\Models\GradeLevelClass;
use Modules\StudentManagement\Models\Student;
use Modules\UserManagement\Models\User;

uses(RefreshDatabase::class);

describe('BatchCreateStudentAttendanceAction', function () {
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
            'id' => 5,
            'name' => 'Grade 1A',
            'grade_level_id' => 1,
            'class_capacity' => 30,
            'created_by' => 1,
        ]);

        // Create attendance types
        AttendanceType::create(['id' => 1, 'name' => 'Present', 'created_by' => 1]);
        AttendanceType::create(['id' => 2, 'name' => 'Absent', 'created_by' => 1]);
        AttendanceType::create(['id' => 3, 'name' => 'Late', 'created_by' => 1]);

        // Create test students
        $this->student1 = Student::create([
            'id' => 1001,
            'grade_level_class_id' => 5,
            'grade_level_id' => 1,
            'full_name' => 'Test Student 1',
            'admission_number' => 'STU001',
            'has_dropped_out' => false,
            'is_school_leaver' => false,
            'created_by' => 1,
        ]);

        $this->student2 = Student::create([
            'id' => 1002,
            'grade_level_class_id' => 5,
            'grade_level_id' => 1,
            'full_name' => 'Test Student 2',
            'admission_number' => 'STU002',
            'has_dropped_out' => false,
            'is_school_leaver' => false,
            'created_by' => 1,
        ]);

        $this->student3 = Student::create([
            'id' => 1003,
            'grade_level_class_id' => 5,
            'grade_level_id' => 1,
            'full_name' => 'Test Student 3',
            'admission_number' => 'STU003',
            'has_dropped_out' => false,
            'is_school_leaver' => false,
            'created_by' => 1,
        ]);
    });

    it('creates batch attendance records successfully with default times', function () {
        $payloadArray = [
            'attendance_data' => [
                [
                    'student_id' => 1001,
                    'grade_level_class_id' => 5,
                    'date' => '2025-01-15',
                    'attendance_type_id' => 1,
                ],
                [
                    'student_id' => 1002,
                    'grade_level_class_id' => 5,
                    'date' => '2025-01-15',
                    'attendance_type_id' => 1,
                ],
            ],
        ];

        $actionData = [
            'created_by' => 1,
        ];

        $result = BatchCreateStudentAttendanceAction::run($payloadArray, $actionData);

        expect($result['created_count'])->toBe(2);
        expect($result['processed_students'])->toBe([1001, 1002]);

        // Verify records in database
        $attendance1 = StudentAttendance::where('student_id', 1001)->where('date', '2025-01-15')->first();
        $attendance2 = StudentAttendance::where('student_id', 1002)->where('date', '2025-01-15')->first();

        expect($attendance1)->not->toBeNull();
        expect($attendance2)->not->toBeNull();
        expect($attendance1->in_time)->toBe('07:30');
        expect($attendance1->out_time)->toBe('13:00');
        expect($attendance2->in_time)->toBe('07:30');
        expect($attendance2->out_time)->toBe('13:00');
    });

    it('creates attendance records with custom times when provided', function () {
        $payloadArray = [
            'attendance_data' => [
                [
                    'student_id' => 1001,
                    'grade_level_class_id' => 5,
                    'date' => '2025-01-16',
                    'attendance_type_id' => 3,
                    'in_time' => '08:30',
                    'out_time' => '14:00',
                ],
            ],
        ];

        $actionData = [
            'created_by' => 1,
        ];

        $result = BatchCreateStudentAttendanceAction::run($payloadArray, $actionData);

        expect($result['created_count'])->toBe(1);

        $attendance = StudentAttendance::where('student_id', 1001)->where('date', '2025-01-16')->first();
        expect($attendance->in_time)->toBe('08:30');
        expect($attendance->out_time)->toBe('14:00');
    });

    it('creates attendance reasons when provided', function () {
        $payloadArray = [
            'attendance_data' => [
                [
                    'student_id' => 1003,
                    'grade_level_class_id' => 5,
                    'date' => '2025-01-17',
                    'attendance_type_id' => 2,
                    'reason' => 'family emergency',
                ],
            ],
        ];

        $actionData = [
            'created_by' => 1,
        ];

        $result = BatchCreateStudentAttendanceAction::run($payloadArray, $actionData);

        expect($result['created_count'])->toBe(1);
        expect($result['reasons_count'])->toBe(1);

        $attendance = StudentAttendance::where('student_id', 1003)->where('date', '2025-01-17')->first();
        $reason = AttendanceReason::where('attendance_id', $attendance->id)->first();

        expect($reason)->not->toBeNull();
        expect($reason->reason)->toBe('family emergency');
    });

    it('skips duplicate attendance records', function () {
        // Create initial attendance
        StudentAttendance::create([
            'student_id' => 1001,
            'grade_level_class_id' => 5,
            'date' => '2025-01-18',
            'attendance_type_id' => 1,
            'in_time' => '07:30',
            'out_time' => '13:00',
            'created_by' => 1,
        ]);

        $payloadArray = [
            'attendance_data' => [
                [
                    'student_id' => 1001,
                    'grade_level_class_id' => 5,
                    'date' => '2025-01-18',
                    'attendance_type_id' => 1,
                ],
                [
                    'student_id' => 1002,
                    'grade_level_class_id' => 5,
                    'date' => '2025-01-18',
                    'attendance_type_id' => 1,
                ],
            ],
        ];

        $actionData = [
            'created_by' => 1,
        ];

        $result = BatchCreateStudentAttendanceAction::run($payloadArray, $actionData);

        expect($result['created_count'])->toBe(1); // Only student 1002 created
        expect($result['processed_students'])->toBe([1002]);
    });

    it('handles mixed attendance types and reasons in single batch', function () {
        $payloadArray = [
            'attendance_data' => [
                [
                    'student_id' => 1001,
                    'grade_level_class_id' => 5,
                    'date' => '2025-01-19',
                    'attendance_type_id' => 1,
                ],
                [
                    'student_id' => 1002,
                    'grade_level_class_id' => 5,
                    'date' => '2025-01-19',
                    'attendance_type_id' => 2,
                    'reason' => 'illness',
                ],
                [
                    'student_id' => 1003,
                    'grade_level_class_id' => 5,
                    'date' => '2025-01-19',
                    'attendance_type_id' => 3,
                    'in_time' => '08:45',
                    'reason' => 'traffic',
                ],
            ],
        ];

        $actionData = [
            'created_by' => 1,
        ];

        $result = BatchCreateStudentAttendanceAction::run($payloadArray, $actionData);

        expect($result['created_count'])->toBe(3);
        expect($result['reasons_count'])->toBe(2);

        // Verify different attendance types
        $presentStudent = StudentAttendance::where('student_id', 1001)->where('date', '2025-01-19')->first();
        $absentStudent = StudentAttendance::where('student_id', 1002)->where('date', '2025-01-19')->first();
        $lateStudent = StudentAttendance::where('student_id', 1003)->where('date', '2025-01-19')->first();

        expect($presentStudent->attendance_type_id)->toBe(1);
        expect($absentStudent->attendance_type_id)->toBe(2);
        expect($lateStudent->attendance_type_id)->toBe(3);
        expect($lateStudent->in_time)->toBe('08:45');

        // Verify reasons
        $absentReason = AttendanceReason::where('attendance_id', $absentStudent->id)->first();
        $lateReason = AttendanceReason::where('attendance_id', $lateStudent->id)->first();

        expect($absentReason->reason)->toBe('illness');
        expect($lateReason->reason)->toBe('traffic');
    });

    it('throws exception for non-existent student', function () {
        $payloadArray = [
            'attendance_data' => [
                [
                    'student_id' => 9999, // Non-existent
                    'grade_level_class_id' => 5,
                    'date' => '2025-01-20',
                    'attendance_type_id' => 1,
                ],
            ],
        ];

        $actionData = [
            'created_by' => 1,
        ];

        expect(fn () => BatchCreateStudentAttendanceAction::run($payloadArray, $actionData))
            ->toThrow(Exception::class, 'Student 9999 not found');
    });

    it('throws exception for student in wrong class', function () {
        $payloadArray = [
            'attendance_data' => [
                [
                    'student_id' => 1001,
                    'grade_level_class_id' => 999, // Wrong class
                    'date' => '2025-01-21',
                    'attendance_type_id' => 1,
                ],
            ],
        ];

        $actionData = [
            'created_by' => 1,
        ];

        expect(fn () => BatchCreateStudentAttendanceAction::run($payloadArray, $actionData))
            ->toThrow(Exception::class, "doesn't belong to class 999");
    });
});
