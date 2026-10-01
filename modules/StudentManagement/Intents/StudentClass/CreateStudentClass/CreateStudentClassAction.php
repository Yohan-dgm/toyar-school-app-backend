<?php

namespace Modules\StudentManagement\Intents\StudentClass\CreateStudentClass;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ProgramManagement\Models\GradeLevelClass;
use Modules\StudentManagement\Models\Student;
use Modules\StudentManagement\Models\StudentClass;

class CreateStudentClassAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createStudentClassUserDTO = CreateStudentClassUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];

        // System Data Prep
        $system_data['created_by'] = $actionData['created_by'];
        $system_data['is_current_class'] = true;

        // System Data Validation
        $createStudentClassSystemDTO = CreateStudentClassSystemDTO::validate($system_data);

        // Final Data Validation
        $createStudentClassDTO = CreateStudentClassDTO::validate(array_merge($createStudentClassUserDTO, $createStudentClassSystemDTO));

        StudentClass::where('student_id', $createStudentClassDTO['student_id'])->update(['is_current_class' => false]);
        // Save In Database
        $createStudentClass = StudentClass::create($createStudentClassDTO);

        //update student
        Student::where('id', $createStudentClassDTO['student_id'])->update(
            [
                'grade_level_class_id' => $createStudentClassDTO['grade_level_class_id'],
                'grade_level_id' => GradeLevelClass::where('id', $createStudentClassDTO['grade_level_class_id'])->first()->grade_level_id,
            ]
        );

        return $createStudentClass;
    }
}
