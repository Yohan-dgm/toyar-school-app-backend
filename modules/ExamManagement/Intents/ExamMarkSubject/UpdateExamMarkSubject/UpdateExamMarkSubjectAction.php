<?php

namespace Modules\ExamManagement\Intents\ExamMarkSubject\UpdateExamMarkSubject;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Models\SchedulingExaminationGradeSubject;

class UpdateExamMarkSubjectAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateExamMarkSubjectUserDTO = UpdateExamMarkSubjectUserDTO::validate($payloadArray);
        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['updated_by'] = $actionData['updated_by'];

        // System Data Validation
        $updateExamMarkSubjectSystemDTO = UpdateExamMarkSubjectSystemDTO::validate($system_data);
        // Final Data Validation

        $updateExamMarkSubjectDTO = UpdateExamMarkSubjectDTO::validate(array_merge($updateExamMarkSubjectUserDTO, $updateExamMarkSubjectSystemDTO));
        // Save In Database
        SchedulingExaminationGradeSubject::where('id', $updateExamMarkSubjectUserDTO['id'])->update($updateExamMarkSubjectDTO);

        $examMarkSubject = SchedulingExaminationGradeSubject::where('id', $updateExamMarkSubjectUserDTO['id'])->first();

        return $examMarkSubject;
    }
}
