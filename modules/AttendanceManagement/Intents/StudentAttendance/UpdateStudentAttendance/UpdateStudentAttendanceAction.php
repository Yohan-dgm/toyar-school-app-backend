<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\UpdateStudentAttendance;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AttendanceManagement\Models\AttendanceReason;
use Modules\AttendanceManagement\Models\StudentAttendance;

class UpdateStudentAttendanceAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateStudentAttendanceUserDTO = UpdateStudentAttendanceUserDTO::validate($payloadArray);

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['created_by'] ?? 1;
        $system_data['updated_by'] = $actionData['updated_by'] ?? $actionData['created_by'] ?? 1;

        // System Data Validation
        $updateStudentAttendanceSystemDTO = UpdateStudentAttendanceSystemDTO::validate($system_data);

        // Final Data Validation
        $updateStudentAttendanceDTO = UpdateStudentAttendanceDTO::validate(array_merge($updateStudentAttendanceUserDTO, $updateStudentAttendanceSystemDTO));

        return DB::transaction(function () use ($updateStudentAttendanceDTO) {
            // Step 1: Get existing attendance records for the date and student
            $existingAttendances = StudentAttendance::where('student_id', $updateStudentAttendanceDTO['student_id'])
                ->where('date', $updateStudentAttendanceDTO['date'])
                ->get();

            // Step 2: Delete existing attendance reasons for these records
            if ($existingAttendances->isNotEmpty()) {
                $attendanceIds = $existingAttendances->pluck('id')->toArray();
                AttendanceReason::whereIn('attendance_id', $attendanceIds)->delete();
            }

            // Step 3: Delete existing attendance records
            StudentAttendance::where('student_id', $updateStudentAttendanceDTO['student_id'])
                ->where('date', $updateStudentAttendanceDTO['date'])
                ->delete();

            // Step 4: Create new attendance records based on status
            $newAttendanceRecords = [];
            $baseData = [
                'student_id' => $updateStudentAttendanceDTO['student_id'],
                'grade_level_class_id' => $updateStudentAttendanceDTO['grade_level_class_id'],
                'date' => $updateStudentAttendanceDTO['date'],
                'notes' => $updateStudentAttendanceDTO['notes'],
                'created_by' => $updateStudentAttendanceDTO['created_by'],
                'updated_by' => $updateStudentAttendanceDTO['updated_by'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            switch ($updateStudentAttendanceDTO['attendance_status']) {
                case 'present':
                    // Create in record (attendance_type_id = 1)
                    if ($updateStudentAttendanceDTO['in_time']) {
                        $inRecord = StudentAttendance::create(array_merge($baseData, [
                            'time' => $updateStudentAttendanceDTO['in_time'],
                            'attendance_type_id' => 1, // In
                        ]));
                        $newAttendanceRecords[] = $inRecord;
                    }

                    // Create out record (attendance_type_id = 2)
                    if ($updateStudentAttendanceDTO['out_time']) {
                        $outRecord = StudentAttendance::create(array_merge($baseData, [
                            'time' => $updateStudentAttendanceDTO['out_time'],
                            'attendance_type_id' => 2, // Out
                        ]));
                        $newAttendanceRecords[] = $outRecord;
                    }
                    break;

                case 'late':
                    // Create late in record (attendance_type_id = 1 with late time)
                    if ($updateStudentAttendanceDTO['in_time']) {
                        $inRecord = StudentAttendance::create(array_merge($baseData, [
                            'time' => $updateStudentAttendanceDTO['in_time'],
                            'attendance_type_id' => 1, // In (but late)
                        ]));
                        $newAttendanceRecords[] = $inRecord;
                    }

                    // Create out record (attendance_type_id = 2)
                    if ($updateStudentAttendanceDTO['out_time']) {
                        $outRecord = StudentAttendance::create(array_merge($baseData, [
                            'time' => $updateStudentAttendanceDTO['out_time'],
                            'attendance_type_id' => 2, // Out
                        ]));
                        $newAttendanceRecords[] = $outRecord;
                    }
                    break;

                case 'absent':
                    // Create absent record (attendance_type_id = 4, no time)
                    $absentRecord = StudentAttendance::create(array_merge($baseData, [
                        'time' => null,
                        'attendance_type_id' => 4, // Absent
                    ]));
                    $newAttendanceRecords[] = $absentRecord;
                    break;
            }

            // Step 5: Create attendance reason if provided
            if ($updateStudentAttendanceDTO['reason'] && !empty($newAttendanceRecords)) {
                // Create reason for the first attendance record (or primary record for absent)
                $primaryRecord = $newAttendanceRecords[0];
                AttendanceReason::create([
                    'attendance_id' => $primaryRecord->id,
                    'reason' => $updateStudentAttendanceDTO['reason'],
                    'created_by' => $updateStudentAttendanceDTO['created_by'],
                    'updated_by' => $updateStudentAttendanceDTO['updated_by'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }

            // Load relationships for response
            foreach ($newAttendanceRecords as $record) {
                $record->load(['attendance_type', 'student', 'grade_level_class', 'attendance_reason']);
            }

            return [
                'attendance_records' => $newAttendanceRecords,
                'total_records' => count($newAttendanceRecords),
                'status' => $updateStudentAttendanceDTO['attendance_status'],
                'message' => 'Attendance updated successfully',
            ];
        });
    }
}
