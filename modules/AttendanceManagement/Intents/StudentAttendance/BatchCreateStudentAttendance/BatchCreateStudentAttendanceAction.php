<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\BatchCreateStudentAttendance;

use Carbon\Carbon;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AttendanceManagement\Models\AttendanceReason;
use Modules\AttendanceManagement\Models\StudentAttendance;
use Modules\StudentManagement\Models\Student;

class BatchCreateStudentAttendanceAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $batchCreateStudentAttendanceUserDTO = BatchCreateStudentAttendanceUserDTO::validate($payloadArray);

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['created_by'];

        // System Data Validation
        $batchCreateStudentAttendanceSystemDTO = BatchCreateStudentAttendanceSystemDTO::validate($system_data);

        // Final Data Validation
        $batchCreateStudentAttendanceDTO = BatchCreateStudentAttendanceDTO::validate(array_merge($batchCreateStudentAttendanceUserDTO, $batchCreateStudentAttendanceSystemDTO));

        $attendanceRecords = [];
        $reasonRecords = [];
        $processedStudents = [];

        // Process each attendance record
        foreach ($batchCreateStudentAttendanceDTO['attendance_data'] as $attendanceItem) {
            // Validate that student exists and belongs to the specified class
            $student = Student::where('id', $attendanceItem['student_id'])
                ->where('grade_level_class_id', $attendanceItem['grade_level_class_id'])
                ->where('has_dropped_out', false)
                ->where('is_school_leaver', false)
                ->first();

            $student = true;
            if (! $student) {
                throw new \Exception("Student {$attendanceItem['student_id']} not found or doesn't belong to class {$attendanceItem['grade_level_class_id']}");
            }

            // Generate attendance records based on frontend input
            $recordsToCreate = $this->generateAttendanceRecords($attendanceItem, $batchCreateStudentAttendanceDTO['created_by']);

            // Check for duplicates and filter out existing records
            foreach ($recordsToCreate as $record) {
                $existingAttendance = StudentAttendance::where('student_id', $record['student_id'])
                    ->where('date', $record['date'])
                    ->where('attendance_type_id', $record['attendance_type_id'])
                    ->where('time', $record['time'])
                    ->exists();

                if (! $existingAttendance) {
                    $attendanceRecords[] = $record;
                }
            }

            // If reason is provided, prepare reason record for each created record
            if (! empty($attendanceItem['reason'])) {
                foreach ($recordsToCreate as $record) {
                    $reasonRecords[] = [
                        'attendance_item' => array_merge($attendanceItem, $record),
                        'reason' => $attendanceItem['reason'],
                    ];
                }
            }

            $processedStudents[] = $attendanceItem['student_id'];
        }

        if (empty($attendanceRecords)) {
            return [
                'message' => 'No new attendance records to create (all were duplicates)',
                'processed_students' => [],
                'created_count' => 0,
            ];
        }

        // Insert attendance records in batch
        StudentAttendance::insert($attendanceRecords);

        // Process reasons if any
        if (! empty($reasonRecords)) {
            $this->processAttendanceReasons($reasonRecords, $batchCreateStudentAttendanceDTO['created_by']);
        }

        return [
            'message' => 'Batch attendance created successfully',
            'processed_students' => $processedStudents,
            'created_count' => count($attendanceRecords),
            'reasons_count' => count($reasonRecords),
        ];
    }

    /**
     * Generate attendance records based on frontend input
     * Frontend attendance_type_id=1 (Present) -> Create 2 records: In (id=1) + Out (id=2)
     * Frontend attendance_type_id=2 (Absent) -> Create 1 record: Leave (id=3)
     * Frontend attendance_type_id=3 (Present with custom time) -> Create 2 records: In (id=1) + Out (id=2)
     */
    private function generateAttendanceRecords(array $attendanceItem, int $createdBy): array
    {
        $baseRecord = [
            'student_id' => $attendanceItem['student_id'],
            'grade_level_class_id' => $attendanceItem['grade_level_class_id'],
            'date' => $attendanceItem['date'],
            'created_by' => $createdBy,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        $records = [];

        if ($attendanceItem['attendance_type_id'] == 1) {
            // Frontend "Present" -> Create In (1) + Out (2) records
            $inTime = $attendanceItem['in_time'] ?? '07:30';
            $outTime = $attendanceItem['out_time'] ?? '13:00';

            // In record
            $records[] = array_merge($baseRecord, [
                'attendance_type_id' => 1, // In
                'time' => $inTime,
            ]);

            // Out record
            $records[] = array_merge($baseRecord, [
                'attendance_type_id' => 2, // Out
                'time' => $outTime,
            ]);

        } elseif ($attendanceItem['attendance_type_id'] == 2) {
            // Frontend "Absent" -> Create single Leave (3) record
            $inTime = $attendanceItem['in_time'] ?? '08:30';

            // Leave record (for absent)
            $records[] = array_merge($baseRecord, [
                'attendance_type_id' => 4, // Leave
                'time' => $inTime,
            ]);

        } elseif ($attendanceItem['attendance_type_id'] == 3) {
            // Frontend "Present with custom time" -> Create In (1) + Out (2) records
            $inTime = $attendanceItem['in_time'] ?? '07:30';
            $outTime = $attendanceItem['out_time'] ?? '13:00';

            // In record
            $records[] = array_merge($baseRecord, [
                'attendance_type_id' => 1, // In
                'time' => $inTime,
            ]);

            // Out record
            $records[] = array_merge($baseRecord, [
                'attendance_type_id' => 2, // Out
                'time' => $outTime,
            ]);

        } else {
            // For other attendance types (4=Absent, etc.), create single record as-is
            $records[] = array_merge($baseRecord, [
                'attendance_type_id' => $attendanceItem['attendance_type_id'],
                'time' => $attendanceItem['in_time'] ?? $attendanceItem['time'] ?? '07:30',
            ]);
        }

        return $records;
    }

    /**
     * Process attendance reasons after attendance records are created
     */
    private function processAttendanceReasons(array $reasonRecords, int $createdBy): void
    {
        $reasonsToInsert = [];

        foreach ($reasonRecords as $reasonRecord) {
            $attendanceItem = $reasonRecord['attendance_item'];

            // Find the attendance record we just created
            $attendanceRecord = StudentAttendance::where('student_id', $attendanceItem['student_id'])
                ->where('date', $attendanceItem['date'])
                ->where('attendance_type_id', $attendanceItem['attendance_type_id'])
                ->where('grade_level_class_id', $attendanceItem['grade_level_class_id'])
                ->where('time', $attendanceItem['time'])
                ->orderBy('id', 'desc')
                ->first();

            if ($attendanceRecord) {
                $reasonsToInsert[] = [
                    'attendance_id' => $attendanceRecord->id,
                    'reason' => $reasonRecord['reason'],
                    'created_by' => $createdBy,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
        }

        if (! empty($reasonsToInsert)) {
            AttendanceReason::insert($reasonsToInsert);
        }
    }
}
