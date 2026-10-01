<?php

namespace Modules\ExamManagement\Intents\SchedulingExamination\GetSchedulingExaminationSimpleListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Models\SchedulingExamination;

class GetSchedulingExaminationSimpleListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getSchedulingExaminationSimpleListDataUserDTO = GetSchedulingExaminationSimpleListDataUserDTO::validate($payloadArray);

        // Action
        $getSchedulingExaminationSimpleListData = SchedulingExamination::where(function (Builder $scheduling_examination_query_group1) use ($getSchedulingExaminationSimpleListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getSchedulingExaminationSimpleListDataUserDTO) && $getSchedulingExaminationSimpleListDataUserDTO['group_filter'] != '') {
                if ($getSchedulingExaminationSimpleListDataUserDTO['group_filter'] == 'All') {
                } else {
                    $scheduling_examination_query_group1->whereHas('scheduling_examination_status_type', function (Builder $scheduling_examination_status_type_query) use ($getSchedulingExaminationSimpleListDataUserDTO) {
                        return $scheduling_examination_status_type_query->where('name', $getSchedulingExaminationSimpleListDataUserDTO['group_filter']);
                    });
                }
            }
        })->where(function (Builder $scheduling_examination_query_group2) use ($getSchedulingExaminationSimpleListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getSchedulingExaminationSimpleListDataUserDTO) && ! is_null($getSchedulingExaminationSimpleListDataUserDTO['search_filter_list']) && count($getSchedulingExaminationSimpleListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getSchedulingExaminationSimpleListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'from_date' && $value != null) {
                        $scheduling_examination_query_group2->where('date', '>=', $value);
                    }
                    if ($key == 'to_date' && $value != null) {
                        $scheduling_examination_query_group2->where('date', '<=', $value);
                    }
                    if ($key == 'is_generate_student_exam_report') {
                        $scheduling_examination_query_group2->orWhere($key, $value);
                    }
                }
            }
        })->where(function (Builder $scheduling_examination_query_group3) use ($getSchedulingExaminationSimpleListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getSchedulingExaminationSimpleListDataUserDTO) && $getSchedulingExaminationSimpleListDataUserDTO['search_phrase'] != '') {
                $scheduling_examination_query_group3->where('exam_title', 'ILIKE', '%'.$getSchedulingExaminationSimpleListDataUserDTO['search_phrase'].'%');
                $scheduling_examination_query_group3->orWhere('exam_type', 'ILIKE', '%'.$getSchedulingExaminationSimpleListDataUserDTO['search_phrase'].'%');
            }
        })
            ->with(['term' => function (Builder $term_query) {
                //
                $term_query->select('id', 'name', 'start_date', 'end_date', 'school_year');
            }])
            ->select(
                'id',
                'exam_type',
                'exam_title',
                'exam_start_time',
                'exam_start_date',
                'exam_end_time',
                'exam_end_date',
                'term_id',
                'scheduling_examination_status_type_id',
                'description',
            )
            ->orderBy('id', 'desc')
            ->paginate(
                $perPage = $getSchedulingExaminationSimpleListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getSchedulingExaminationSimpleListDataUserDTO['page']
            );

        return $getSchedulingExaminationSimpleListData;
    }
}
