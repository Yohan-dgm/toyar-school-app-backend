<?php

namespace Modules\ExamManagement\Intents\ExamSubject\GetExamSubjectListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Models\ExamSubject;

class GetExamSubjectListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getExamSubjectListDataUserDTO = GetExamSubjectListDataUserDTO::validate($payloadArray);

        // Action
        $getExamSubjectListData = ExamSubject::where(function (Builder $exam_subject_query_group1) use ($getExamSubjectListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getExamSubjectListDataUserDTO) && $getExamSubjectListDataUserDTO['group_filter'] != '') {
                if ($getExamSubjectListDataUserDTO['group_filter'] == 'All') {
                } else {
                    $exam_subject_query_group1->whereHas('exam_subject_category', function (Builder $exam_subject_category_query) use ($getExamSubjectListDataUserDTO) {
                        return $exam_subject_category_query->where('name', $getExamSubjectListDataUserDTO['group_filter']);
                    });
                }
            }
        })->where(function (Builder $exam_subject_query_group2) use ($getExamSubjectListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getExamSubjectListDataUserDTO) && ! is_null($getExamSubjectListDataUserDTO['search_filter_list']) && count($getExamSubjectListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getExamSubjectListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'exam_subject_category_id' && $value != null) {
                        $exam_subject_query_group2->whereHas('exam_subject_category', function (Builder $exam_subject_category_query) use ($value) {
                            return $exam_subject_category_query->where('id', $value);
                        });
                    }
                }
            }
        })->where(function (Builder $exam_subject_query_group3) use ($getExamSubjectListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getExamSubjectListDataUserDTO) && $getExamSubjectListDataUserDTO['search_phrase'] != '') {
                $exam_subject_query_group3->where('name', 'ILIKE', '%'.$getExamSubjectListDataUserDTO['search_phrase'].'%');
                $exam_subject_query_group3->orWhere('exam_subject_code', 'ILIKE', '%'.$getExamSubjectListDataUserDTO['search_phrase'].'%');
                $exam_subject_query_group3->orWhere('exam_subject_components', 'ILIKE', '%'.$getExamSubjectListDataUserDTO['search_phrase'].'%');
                $exam_subject_query_group3->orWhere('exam_subject_option_code', 'ILIKE', '%'.$getExamSubjectListDataUserDTO['search_phrase'].'%');
            }
        })
            ->with(['exam_subject_category' => function (Builder $exam_subject_category_query) {
                //
                $exam_subject_category_query->select('id', 'name');
            }])
            ->with(['exam_subject_group_list' => function (Builder $exam_subject_group_list_query) {
                //
                $exam_subject_group_list_query->select('exam_subject_group_id as id', 'name');
            }])
            ->select(
                'id',
                'exam_subject_category_id',
                'name',
                'exam_subject_code',
                'exam_subject_components',
                'has_practical_component',
                'exam_subject_option_code',
                'exam_subject_fee',
                'has_practical_component',
            )
            ->orderBy('name', 'asc')
            ->paginate(
                $perPage = $getExamSubjectListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getExamSubjectListDataUserDTO['page']
            );

        return $getExamSubjectListData;
    }
}
