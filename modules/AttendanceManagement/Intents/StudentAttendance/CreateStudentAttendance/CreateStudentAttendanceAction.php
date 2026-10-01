<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\CreateStudentAttendance;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AttendanceManagement\Intents\StudentAttendance\BulkCreateStudentAttendance\BulkCreateStudentAttendanceAction;
use Modules\AttendanceManagement\Models\StudentAttendance;
use Modules\StudentManagement\Models\Student;

class CreateStudentAttendanceAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createStudentAttendanceUserDTO = CreateStudentAttendanceUserDTO::validate($payloadArray);

        // Get student info to determine grade_level_class_id
        $student = Student::with('grade_level_class')->find($createStudentAttendanceUserDTO['student_id']);
        if (! $student) {
            throw new \Exception('Student not found');
        }

        // Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['created_by'];
        $system_data['grade_level_class_id'] = $student->grade_level_class_id;

        // System Data Validation
        $createStudentAttendanceSystemDTO = CreateStudentAttendanceSystemDTO::validate($system_data);

        // Final Data Validation
        $createStudentAttendanceDTO = CreateStudentAttendanceDTO::validate(array_merge($createStudentAttendanceUserDTO, $createStudentAttendanceSystemDTO));

        // Check if bulk attendance already exists for this date and class
        $attendanceDate = $createStudentAttendanceDTO['date'] ?? date('Y-m-d');
        $existingBulkAttendance = StudentAttendance::where('grade_level_class_id', $student->grade_level_class_id)
            ->where('date', $attendanceDate)
            ->exists();

        // If no bulk attendance exists for this date and class, create it
        if (! $existingBulkAttendance && isset($payloadArray['student_list']) && is_array($payloadArray['student_list'])) {
            // Get grade level class name
            $gradeLevelClassName = $student->grade_level_class->name ?? 'Class '.$student->grade_level_class_id;

            // Prepare bulk attendance data
            $bulkPayload = [
                'grade_level_class_name' => $gradeLevelClassName,
                'date' => $attendanceDate,
                'in_time' => $payloadArray['in_time'] ?? '08:00',
                'out_time' => $payloadArray['out_time'] ?? '15:00',
                'student_list' => $payloadArray['student_list'],
            ];

            $bulkActionData = [
                'grade_level_class_id' => $student->grade_level_class_id,
                'created_by' => $actionData['created_by'],
            ];

            // Call BulkCreateStudentAttendanceAction
            BulkCreateStudentAttendanceAction::run($bulkPayload, $bulkActionData);
        }

        // Save individual attendance record
        $user = StudentAttendance::create($createStudentAttendanceDTO);

        return $user;
    }
}
