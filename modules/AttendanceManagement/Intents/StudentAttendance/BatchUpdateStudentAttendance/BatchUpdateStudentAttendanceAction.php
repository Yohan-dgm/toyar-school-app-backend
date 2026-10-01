<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\BatchUpdateStudentAttendance;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AttendanceManagement\Models\AttendanceReason;
use Modules\AttendanceManagement\Models\StudentAttendance;
use Modules\StudentManagement\Models\Student;

class BatchUpdateStudentAttendanceAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $batchUpdateStudentAttendanceUserDTO = BatchUpdateStudentAttendanceUserDTO::validate($payloadArray);

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['created_by'];

        // System Data Validation
        $batchUpdateStudentAttendanceSystemDTO = BatchUpdateStudentAttendanceSystemDTO::validate($system_data);

        // Final Data Validation
        $batchUpdateStudentAttendanceDTO = BatchUpdateStudentAttendanceDTO::validate(array_merge($batchUpdateStudentAttendanceUserDTO, $batchUpdateStudentAttendanceSystemDTO));

        // Validate that all students belong to the specified class and are active
        $studentIds = collect($batchUpdateStudentAttendanceDTO->attendance_data)->pluck('student_id')->unique()->toArray();

        $validStudents = Student::whereIn('id', $studentIds)
            ->where('grade_level_class_id', $batchUpdateStudentAttendanceDTO->grade_level_class_id)
            ->where('has_dropped_out', false)
            ->where('is_school_leaver', false)
            ->pluck('id')
            ->toArray();

        $invalidStudents = array_diff($studentIds, $validStudents);
        if (! empty($invalidStudents)) {
            throw new \Exception('Students '.implode(', ', $invalidStudents)." do not belong to class {$batchUpdateStudentAttendanceDTO->grade_level_class_id} or are inactive");
        }

        // Check for duplicate student IDs in the request
        $duplicateStudents = collect($batchUpdateStudentAttendanceDTO->attendance_data)
            ->pluck('student_id')
            ->duplicates()
            ->values()
            ->toArray();

        if (! empty($duplicateStudents)) {
            throw new \Exception('Duplicate student IDs found in request: '.implode(', ', $duplicateStudents));
        }

        return DB::transaction(function () use ($batchUpdateStudentAttendanceDTO) {
            // PHASE 1: DELETE - Remove all existing attendance records for this date and class
            $existingRecords = StudentAttendance::where('date', $batchUpdateStudentAttendanceDTO->date)
                ->where('grade_level_class_id', $batchUpdateStudentAttendanceDTO->grade_level_class_id)
                ->get();

            $deletedCount = 0;
            $deletedRecordIds = [];

            foreach ($existingRecords as $record) {
                // Delete associated reasons first
                AttendanceReason::where('attendance_id', $record->id)->delete();

                // Delete the attendance record
                if ($record->delete()) {
                    $deletedCount++;
                    $deletedRecordIds[] = $record->id;
                }
            }

            // PHASE 2: CREATE - Generate and create new attendance records
            $attendanceRecords = [];
            $reasonRecords = [];
            $processedStudents = [];

            foreach ($batchUpdateStudentAttendanceDTO->attendance_data as $attendanceItem) {
                // Generate attendance records based on frontend input (using same logic as BatchCreate)
                $generatedRecords = $this->generateAttendanceRecords(
                    $attendanceItem,
                    $batchUpdateStudentAttendanceDTO->created_by,
                    $batchUpdateStudentAttendanceDTO->date,
                    $batchUpdateStudentAttendanceDTO->grade_level_class_id
                );

                foreach ($generatedRecords as $record) {
                    $attendanceRecords[] = $record;
                }

                // If reason is provided, prepare reason record for each generated record
                if (! empty($attendanceItem['reason'])) {
                    foreach ($generatedRecords as $record) {
                        $reasonRecords[] = [
                            'attendance_item' => array_merge($attendanceItem, $record),
                            'reason' => $attendanceItem['reason'],
                        ];
                    }
                }

                $processedStudents[] = $attendanceItem['student_id'];
            }

            // Insert new attendance records in batch
            $createdCount = 0;
            if (! empty($attendanceRecords)) {
                StudentAttendance::insert($attendanceRecords);
                $createdCount = count($attendanceRecords);
            }

            // Process reasons if any
            $reasonsCount = 0;
            if (! empty($reasonRecords)) {
                $reasonsCount = $this->processAttendanceReasons($reasonRecords, $batchUpdateStudentAttendanceDTO->created_by);
            }

            return [
                'message' => "Attendance updated successfully for class {$batchUpdateStudentAttendanceDTO->grade_level_class_id} on {$batchUpdateStudentAttendanceDTO->date}",
                'date' => $batchUpdateStudentAttendanceDTO->date,
                'grade_level_class_id' => $batchUpdateStudentAttendanceDTO->grade_level_class_id,
                'deleted_count' => $deletedCount,
                'created_count' => $createdCount,
                'processed_students' => array_unique($processedStudents),
                'reasons_count' => $reasonsCount,
                'operation_summary' => [
                    'deleted_records' => $deletedCount,
                    'created_records' => $createdCount,
                    'net_change' => $createdCount - $deletedCount,
                ],
            ];
        });
    }

    /**
     * Generate attendance records based on frontend input (copied from BatchCreate)
     */
    private function generateAttendanceRecords(array $attendanceItem, int $createdBy, string $date, int $gradeLevelClassId): array
    {
        $baseRecord = [
            'student_id' => $attendanceItem['student_id'],
            'grade_level_class_id' => $gradeLevelClassId,
            'date' => $date,
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
                'attendance_type_id' => 3, // Leave
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
    private function processAttendanceReasons(array $reasonRecords, int $createdBy): int
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

        return count($reasonsToInsert);
    }
}
