<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Modules\AttendanceManagement\Intents\StudentAttendance\DeleteStudentAttendance\DeleteStudentAttendanceAction;
use Modules\AttendanceManagement\Intents\StudentAttendance\UpdateStudentAttendance\UpdateStudentAttendanceAction;
use Modules\AttendanceManagement\Models\AttendanceReason;
use Modules\AttendanceManagement\Models\AttendanceType;
use Modules\AttendanceManagement\Models\StudentAttendance;
use Modules\ProgramManagement\Models\GradeLevel;
use Modules\ProgramManagement\Models\GradeLevelClass;
use Modules\StudentManagement\Models\Student;
use Modules\UserManagement\Models\User;

uses(RefreshDatabase::class);

describe('AttendanceReason CRUD Operations', function () {
    beforeEach(function () {
        // Create test data
        $this->user = User::create([
            'id' => 1,
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

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

        AttendanceType::create(['id' => 1, 'name' => 'Present', 'created_by' => 1]);
        AttendanceType::create(['id' => 2, 'name' => 'Absent', 'created_by' => 1]);
        AttendanceType::create(['id' => 3, 'name' => 'Late', 'created_by' => 1]);

        $this->student = Student::create([
            'id' => 1001,
            'grade_level_class_id' => 5,
            'grade_level_id' => 1,
            'full_name' => 'Test Student',
            'admission_number' => 'STU001',
            'has_dropped_out' => false,
            'is_school_leaver' => false,
            'created_by' => 1,
        ]);

        // Create initial attendance record
        $this->attendance = StudentAttendance::create([
            'id' => 1,
            'student_id' => 1001,
            'grade_level_class_id' => 5,
            'date' => '2025-01-15',
            'attendance_type_id' => 2,
            'in_time' => '07:30',
            'out_time' => '13:00',
            'created_by' => 1,
        ]);
    });

    describe('UpdateStudentAttendance with Reasons', function () {
        it('updates attendance record with new reason', function () {
            $payloadArray = [
                'attendance_id' => 1,
                'attendance_type_id' => 3,
                'reason' => 'traffic jam',
            ];

            $actionData = [
                'created_by' => 1,
            ];

            $result = UpdateStudentAttendanceAction::run($payloadArray, $actionData);

            expect($result['message'])->toBe('Attendance updated successfully');

            $updatedAttendance = StudentAttendance::find(1);
            expect($updatedAttendance->attendance_type_id)->toBe(3);

            $reason = AttendanceReason::where('attendance_id', 1)->first();
            expect($reason)->not->toBeNull();
            expect($reason->reason)->toBe('traffic jam');
        });

        it('updates existing reason when attendance already has one', function () {
            // Create initial reason
            AttendanceReason::create([
                'attendance_id' => 1,
                'reason' => 'initial reason',
                'created_by' => 1,
            ]);

            $payloadArray = [
                'attendance_id' => 1,
                'reason' => 'updated reason',
            ];

            $actionData = [
                'created_by' => 1,
            ];

            $result = UpdateStudentAttendanceAction::run($payloadArray, $actionData);

            $reason = AttendanceReason::where('attendance_id', 1)->first();
            expect($reason->reason)->toBe('updated reason');

            // Should be only one reason record
            $reasonCount = AttendanceReason::where('attendance_id', 1)->count();
            expect($reasonCount)->toBe(1);
        });

        it('deletes reason when set to null', function () {
            // Create initial reason
            AttendanceReason::create([
                'attendance_id' => 1,
                'reason' => 'to be deleted',
                'created_by' => 1,
            ]);

            $payloadArray = [
                'attendance_id' => 1,
                'reason' => null,
            ];

            $actionData = [
                'created_by' => 1,
            ];

            $result = UpdateStudentAttendanceAction::run($payloadArray, $actionData);

            $reasonExists = AttendanceReason::where('attendance_id', 1)->exists();
            expect($reasonExists)->toBeFalse();
        });

        it('updates attendance times and adds reason', function () {
            $payloadArray = [
                'attendance_id' => 1,
                'in_time' => '08:15',
                'out_time' => '14:30',
                'reason' => 'late arrival due to appointment',
            ];

            $actionData = [
                'created_by' => 1,
            ];

            $result = UpdateStudentAttendanceAction::run($payloadArray, $actionData);

            $updatedAttendance = StudentAttendance::find(1);
            expect($updatedAttendance->in_time)->toBe('08:15');
            expect($updatedAttendance->out_time)->toBe('14:30');

            $reason = AttendanceReason::where('attendance_id', 1)->first();
            expect($reason->reason)->toBe('late arrival due to appointment');
        });

        it('throws exception for non-existent attendance record', function () {
            $payloadArray = [
                'attendance_id' => 999,
                'reason' => 'test reason',
            ];

            $actionData = [
                'created_by' => 1,
            ];

            expect(fn () => UpdateStudentAttendanceAction::run($payloadArray, $actionData))
                ->toThrow(Exception::class, 'Attendance record not found');
        });
    });

    describe('DeleteStudentAttendance with Cascade', function () {
        it('deletes attendance and associated reason', function () {
            // Create reason
            AttendanceReason::create([
                'attendance_id' => 1,
                'reason' => 'test reason',
                'created_by' => 1,
            ]);

            $payloadArray = [
                'attendance_id' => 1,
            ];

            $actionData = [
                'created_by' => 1,
            ];

            $result = DeleteStudentAttendanceAction::run($payloadArray, $actionData);

            expect($result['message'])->toBe('Attendance record deleted successfully');

            // Verify attendance is deleted
            $attendanceExists = StudentAttendance::find(1);
            expect($attendanceExists)->toBeNull();

            // Verify reason is deleted (cascade)
            $reasonExists = AttendanceReason::where('attendance_id', 1)->exists();
            expect($reasonExists)->toBeFalse();
        });

        it('deletes attendance without reason successfully', function () {
            $payloadArray = [
                'attendance_id' => 1,
            ];

            $actionData = [
                'created_by' => 1,
            ];

            $result = DeleteStudentAttendanceAction::run($payloadArray, $actionData);

            expect($result['message'])->toBe('Attendance record deleted successfully');

            $attendanceExists = StudentAttendance::find(1);
            expect($attendanceExists)->toBeNull();
        });

        it('throws exception for non-existent attendance record', function () {
            $payloadArray = [
                'attendance_id' => 999,
            ];

            $actionData = [
                'created_by' => 1,
            ];

            expect(fn () => DeleteStudentAttendanceAction::run($payloadArray, $actionData))
                ->toThrow(Exception::class, 'Attendance record not found');
        });
    });

    describe('AttendanceReason Model Relations', function () {
        it('loads attendance reason relationship correctly', function () {
            AttendanceReason::create([
                'attendance_id' => 1,
                'reason' => 'relationship test',
                'created_by' => 1,
            ]);

            $attendance = StudentAttendance::with('attendance_reason')->find(1);

            expect($attendance->attendance_reason)->not->toBeNull();
            expect($attendance->attendance_reason->reason)->toBe('relationship test');
        });

        it('handles attendance without reason gracefully', function () {
            $attendance = StudentAttendance::with('attendance_reason')->find(1);

            expect($attendance->attendance_reason)->toBeNull();
        });
    });
});
