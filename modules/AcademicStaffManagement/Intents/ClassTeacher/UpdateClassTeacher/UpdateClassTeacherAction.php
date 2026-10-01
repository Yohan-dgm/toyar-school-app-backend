<?php

namespace Modules\AcademicStaffManagement\Intents\ClassTeacher\UpdateClassTeacher;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AcademicStaffManagement\Models\ClassTeacher;

class UpdateClassTeacherAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateClassTeacherUserDTO = UpdateClassTeacherUserDTO::validate($payloadArray);

        // Find the class teacher assignment
        $classTeacher = ClassTeacher::findOrFail($updateClassTeacherUserDTO['id']);

        // Prepare data for update (only update provided fields)
        $data = ['updated_by' => $actionData['updated_by']];

        if (isset($updateClassTeacherUserDTO['user_id'])) {
            $data['user_id'] = $updateClassTeacherUserDTO['user_id'];
        }
        if (isset($updateClassTeacherUserDTO['grade_level_class_id'])) {
            $data['grade_level_class_id'] = $updateClassTeacherUserDTO['grade_level_class_id'];
        }
        if (isset($updateClassTeacherUserDTO['academic_year'])) {
            $data['academic_year'] = $updateClassTeacherUserDTO['academic_year'];
        }
        if (isset($updateClassTeacherUserDTO['start_date'])) {
            $data['start_date'] = $updateClassTeacherUserDTO['start_date'];
        }
        if (isset($updateClassTeacherUserDTO['end_date'])) {
            $data['end_date'] = $updateClassTeacherUserDTO['end_date'];
        }
        if (isset($updateClassTeacherUserDTO['is_active'])) {
            $data['is_active'] = $updateClassTeacherUserDTO['is_active'];
        }

        // Update class teacher assignment
        $classTeacher->update($data);

        // Load relationships for response
        $classTeacher->load(['user', 'grade_level_class.grade_level']);

        return $classTeacher;
    }
}
