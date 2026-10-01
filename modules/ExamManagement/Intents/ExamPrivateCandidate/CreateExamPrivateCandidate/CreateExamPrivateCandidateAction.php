<?php

namespace Modules\ExamManagement\Intents\ExamPrivateCandidate\CreateExamPrivateCandidate;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Models\ExamPrivateCandidate;

class CreateExamPrivateCandidateAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createExamPrivateCandidateUserDTO = CreateExamPrivateCandidateUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $maxDigit = ExamPrivateCandidate::where(function (Builder $exam_private_candidate_query) {})->max('exam_private_candidate_number_digits');
        $system_data['exam_private_candidate_number_digits'] = (int) $maxDigit + 1;
        $system_data['exam_private_candidate_number_current_year'] = strval(date('m') > 8 ? date('y') : (date('y') - 1));
        $system_data['exam_private_candidate_number_prefix'] = 'EXAM-PC-NY/';
        $system_data['exam_private_candidate_number'] = $system_data['exam_private_candidate_number_prefix'].$system_data['exam_private_candidate_number_current_year'].'/'.$system_data['exam_private_candidate_number_digits'];
        if ($createExamPrivateCandidateUserDTO['gender'] == 'Male') {
            $system_data['full_name_with_title'] = 'Mr. '.$createExamPrivateCandidateUserDTO['full_name'];
        } elseif ($createExamPrivateCandidateUserDTO['gender'] == 'Female') {
            $system_data['full_name_with_title'] = 'Ms. '.$createExamPrivateCandidateUserDTO['full_name'];
        }
        $system_data['created_by'] = $actionData['user_id'];

        // System Data Validation
        $createExamPrivateCandidateSystemDTO = CreateExamPrivateCandidateSystemDTO::validate($system_data);
        // Final Data Validation
        $createExamPrivateCandidateDTO = CreateExamPrivateCandidateDTO::validate(array_merge($createExamPrivateCandidateUserDTO, $createExamPrivateCandidateSystemDTO));

        // Save In Database
        $examPrivateCandidate = ExamPrivateCandidate::create($createExamPrivateCandidateDTO);
        $createdExamPrivateCandidate = ExamPrivateCandidate::where('id', $examPrivateCandidate->id)->first();

        return $createdExamPrivateCandidate;
    }
}
