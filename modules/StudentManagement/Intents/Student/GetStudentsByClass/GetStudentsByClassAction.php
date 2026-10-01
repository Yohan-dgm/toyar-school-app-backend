<?php

namespace Modules\StudentManagement\Intents\Student\GetStudentsByClass;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\StudentManagement\Models\Student;

class GetStudentsByClassAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // Student Data Validation
        $getStudentsByClassUserDTO = GetStudentsByClassUserDTO::validate($payloadArray);

        // Action - Get all student data with comprehensive relationships
        $studentsData = Student::where('grade_level_class_id', $getStudentsByClassUserDTO['grade_level_class_id'])
            ->where('has_dropped_out', false)
            ->where('is_school_leaver', false)
            ->with([
                // Basic class and academic relationships
                'grade_level_class',
                'grade_level', 
                'school_house',
                'nationality',
                'religion',
                'student_admission_source',
                
                // Guardian relationships
                'father',
                'mother', 
                'guardian',
                
                // Academic and achievement data
                'student_achievement_list',
                'student_role_list',
                'student_sport_list',
                
                // Attendance data (latest records)
                'student_attendance_list' => function($query) {
                    $query->latest()->limit(10);
                },
                
                // Financial data
                'latest_term_fee_receipt_voucher',
                'current_user_payment_students',
                
                // Supply and attachment data
                'student_supply_list' => function($query) {
                    $query->latest()->limit(5);
                },
                'student_attachment_list',
            ])
            ->orderBy('admission_number')
            ->get();

        // Create Response
        $getStudentsByClassResDTO = GetStudentsByClassResDTO::from([
            'data' => $studentsData->toArray(),
            'total' => $studentsData->count(),
        ]);

        return $getStudentsByClassResDTO;
    }
}
