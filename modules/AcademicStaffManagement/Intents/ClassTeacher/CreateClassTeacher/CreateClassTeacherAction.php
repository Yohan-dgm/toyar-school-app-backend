<?php

namespace Modules\AcademicStaffManagement\Intents\ClassTeacher\CreateClassTeacher;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AcademicStaffManagement\Models\ClassTeacher;

class CreateClassTeacherAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createClassTeacherUserDTO = CreateClassTeacherUserDTO::validate($payloadArray);

        // Prepare data for creation
        $data = [
            'user_id' => $createClassTeacherUserDTO['user_id'],
            'grade_level_class_id' => $createClassTeacherUserDTO['grade_level_class_id'],
            'academic_year' => $createClassTeacherUserDTO['academic_year'],
            'start_date' => $createClassTeacherUserDTO['start_date'],
            'end_date' => $createClassTeacherUserDTO['end_date'] ?? null,
            'is_active' => true,
            'created_by' => $actionData['created_by'],
        ];

        // Create class teacher assignment
        $classTeacher = ClassTeacher::create($data);

        // Load relationships for response
        $classTeacher->load(['user', 'grade_level_class.grade_level']);

        return $classTeacher;
    }
}
