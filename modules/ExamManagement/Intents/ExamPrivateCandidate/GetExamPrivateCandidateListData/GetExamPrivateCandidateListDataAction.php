<?php

namespace Modules\ExamManagement\Intents\ExamPrivateCandidate\GetExamPrivateCandidateListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Models\ExamPrivateCandidate;

class GetExamPrivateCandidateListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getExamPrivateCandidateListDataUserDTO = GetExamPrivateCandidateListDataUserDTO::validate($payloadArray);

        // Action
        $getExamPrivateCandidateListData = ExamPrivateCandidate::where(function (Builder $exam_private_candidate_query_category1) use ($getExamPrivateCandidateListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getExamPrivateCandidateListDataUserDTO) && $getExamPrivateCandidateListDataUserDTO['group_filter'] != '') {
                if ($getExamPrivateCandidateListDataUserDTO['group_filter'] == 'All') {
                }
            }
        })->where(function (Builder $exam_private_candidate_query_category2) use ($getExamPrivateCandidateListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getExamPrivateCandidateListDataUserDTO) && ! is_null($getExamPrivateCandidateListDataUserDTO['search_filter_list']) && count($getExamPrivateCandidateListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getExamPrivateCandidateListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $exam_private_candidate_query_category3) use ($getExamPrivateCandidateListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getExamPrivateCandidateListDataUserDTO) && $getExamPrivateCandidateListDataUserDTO['search_phrase'] != '') {
                $exam_private_candidate_query_category3->where('full_name', 'ILIKE', '%'.$getExamPrivateCandidateListDataUserDTO['search_phrase'].'%');
                $exam_private_candidate_query_category3->orWhere('exam_private_candidate_number', 'ILIKE', '%'.$getExamPrivateCandidateListDataUserDTO['search_phrase'].'%');
                $exam_private_candidate_query_category3->orWhere('phone', 'ILIKE', '%'.$getExamPrivateCandidateListDataUserDTO['search_phrase'].'%');
                $exam_private_candidate_query_category3->orWhere('email', 'ILIKE', '%'.$getExamPrivateCandidateListDataUserDTO['search_phrase'].'%');
                $exam_private_candidate_query_category3->orWhere('address', 'ILIKE', '%'.$getExamPrivateCandidateListDataUserDTO['search_phrase'].'%');
            }
        })
            ->with(['student_admission_source' => function (Builder $student_admission_source_query) {
                //
                $student_admission_source_query->select('id', 'name');
            }])
            ->select(
                'id',
                'gender',
                'full_name',
                'full_name_with_title',
                'phone',
                'email',
                'address',
                'student_admission_source_id',
                'student_admission_source_other',
                'exam_private_candidate_number',
            )
            ->orderBy('exam_private_candidate_number_digits', 'desc')
            ->paginate(
                $perPage = $getExamPrivateCandidateListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getExamPrivateCandidateListDataUserDTO['page']
            );

        return $getExamPrivateCandidateListData;
    }
}
