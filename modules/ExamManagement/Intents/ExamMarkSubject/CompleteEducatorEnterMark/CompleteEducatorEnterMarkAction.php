<?php

namespace Modules\ExamManagement\Intents\ExamMarkSubject\CompleteEducatorEnterMark;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Models\SchedulingExaminationGradeSubject;

class CompleteEducatorEnterMarkAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $completeEducatorEnterMarkUserDTO = CompleteEducatorEnterMarkUserDTO::validate($payloadArray);
        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['updated_by'] = $actionData['updated_by'];
        $system_data['is_all_marks_confirmed'] = true;
        $system_data['confirmed_by'] = $actionData['updated_by'];

        // System Data Validation
        $completeEducatorEnterMarkSystemDTO = CompleteEducatorEnterMarkSystemDTO::validate($system_data);
        // Final Data Validation

        $completeEducatorEnterMarkDTO = CompleteEducatorEnterMarkDTO::validate(array_merge($completeEducatorEnterMarkUserDTO, $completeEducatorEnterMarkSystemDTO));
        // Save In Database
        SchedulingExaminationGradeSubject::where('id', $completeEducatorEnterMarkUserDTO['id'])->update($completeEducatorEnterMarkDTO);

        $examMarkSubject = SchedulingExaminationGradeSubject::where('id', $completeEducatorEnterMarkUserDTO['id'])->first();

        return $examMarkSubject;
    }
}
