<?php

namespace Modules\ExamManagement\Intents\ExamSubjectComponent\GetExamSubjectComponentListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Models\ExamSubjectComponent;

class GetExamSubjectComponentListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getExamSubjectComponentListDataUserDTO = GetExamSubjectComponentListDataUserDTO::validate($payloadArray);

        // Action
        $getExamSubjectComponentListData = ExamSubjectComponent::where(function (Builder $exam_subject_component_query_group1) use ($getExamSubjectComponentListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getExamSubjectComponentListDataUserDTO) && $getExamSubjectComponentListDataUserDTO['group_filter'] != '') {
                if ($getExamSubjectComponentListDataUserDTO['group_filter'] == 'All') {
                }
            }
        })->where(function (Builder $exam_subject_component_query_group2) use ($getExamSubjectComponentListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getExamSubjectComponentListDataUserDTO) && ! is_null($getExamSubjectComponentListDataUserDTO['search_filter_list']) && count($getExamSubjectComponentListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getExamSubjectComponentListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $exam_subject_component_query_group3) use ($getExamSubjectComponentListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getExamSubjectComponentListDataUserDTO) && $getExamSubjectComponentListDataUserDTO['search_phrase'] != '') {
                $exam_subject_component_query_group3->orWhereHas('exam_subject', function (Builder $exam_subject_query) use ($getExamSubjectComponentListDataUserDTO) {
                    return $exam_subject_query
                        ->where('name', 'ILIKE', '%'.$getExamSubjectComponentListDataUserDTO['search_phrase'].'%');
                });
                $exam_subject_component_query_group3->orWhereHas('exam_subject_component_type', function (Builder $exam_subject_component_type_query) use ($getExamSubjectComponentListDataUserDTO) {
                    return $exam_subject_component_type_query
                        ->where('name', 'ILIKE', '%'.$getExamSubjectComponentListDataUserDTO['search_phrase'].'%');
                });
            }
        })
            ->with(['exam_subject' => function (Builder $exam_subject_query) {
                //
                $exam_subject_query->select('id', 'name');
            }])
            ->with(['exam_subject_component_type' => function (Builder $exam_subject_component_type_query) {
                //
                $exam_subject_component_type_query->select('id', 'name');
            }])

            ->select(
                'id',
                'exam_subject_component_type_id',
                'exam_subject_id',
            )
            ->orderBy('id', 'desc')
            ->paginate(
                $perPage = $getExamSubjectComponentListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getExamSubjectComponentListDataUserDTO['page']
            );

        return $getExamSubjectComponentListData;
    }
}
