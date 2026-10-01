<?php

namespace Modules\ExamManagement\Intents\ExamPrivateCandidate\UpdateExamPrivateCandidate;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Models\ExamPrivateCandidate;

class UpdateExamPrivateCandidateAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateExamPrivateCandidateUserDTO = UpdateExamPrivateCandidateUserDTO::validate($payloadArray);
        // Data Prep

        // System Data Prep
        $system_data = [];
        if ($updateExamPrivateCandidateUserDTO['gender'] == 'Male') {
            $system_data['full_name_with_title'] = 'Mr. '.$updateExamPrivateCandidateUserDTO['full_name'];
        } elseif ($updateExamPrivateCandidateUserDTO['gender'] == 'Female') {
            $system_data['full_name_with_title'] = 'Ms. '.$updateExamPrivateCandidateUserDTO['full_name'];
        }
        $system_data['updated_by'] = $actionData['user_id'];

        // System Data Validation
        $updateExamPrivateCandidateSystemDTO = UpdateExamPrivateCandidateSystemDTO::validate($system_data);
        // Final Data Validation

        $updateExamPrivateCandidateDTO = UpdateExamPrivateCandidateDTO::validate(array_merge($updateExamPrivateCandidateUserDTO, $updateExamPrivateCandidateSystemDTO));
        // Save In Database
        ExamPrivateCandidate::where('id', $updateExamPrivateCandidateUserDTO['id'])->update($updateExamPrivateCandidateDTO);
        $updatedExamPrivateCandidate = ExamPrivateCandidate::where('id', $updateExamPrivateCandidateUserDTO['id'])->first();

        return $updatedExamPrivateCandidate;
    }
}
