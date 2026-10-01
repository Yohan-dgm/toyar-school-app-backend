<?php

namespace Modules\ExamManagement\Intents\StudentExamMark\RemovableSubjectStudentData;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Models\StudentExamMark;
use Modules\ExamManagement\Models\StudentSubjectMark;

class RemovableSubjectStudentDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $removableSubjectStudentDataUserDTO = RemovableSubjectStudentDataUserDTO::validate($payloadArray);
        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['updated_by'] = $actionData['updated_by'];

        // System Data Validation
        $removableSubjectStudentDataSystemDTO = RemovableSubjectStudentDataSystemDTO::validate($system_data);
        // Final Data Validation
        $removableSubjectStudentDataDTO = RemovableSubjectStudentDataDTO::validate(array_merge($removableSubjectStudentDataUserDTO, $removableSubjectStudentDataSystemDTO));

        // Save In Database
        // StudentExamMark::where('id', $removableSubjectStudentDataUserDTO['id'])->update(['is_active' => 0, 'updated_by' => $removableSubjectStudentDataDTO['updated_by']]);
        StudentExamMark::where('id', $removableSubjectStudentDataUserDTO['id'])->delete();
        StudentSubjectMark::where('student_exam_mark_id', $removableSubjectStudentDataUserDTO['id'])->delete();

        // $studentExamMark = StudentExamMark::where('id', $removableSubjectStudentDataUserDTO['id'])->first();
        $studentExamMark = StudentExamMark::first();

        return $studentExamMark;
    }
}
