<?php

namespace Modules\ExamManagement\Intents\SchedulingExaminationGrade\GetSchedulingExaminationGradeListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Models\SchedulingExaminationGrade;

class GetSchedulingExaminationGradeListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getSchedulingExaminationGradeListDataUserDTO = GetSchedulingExaminationGradeListDataUserDTO::validate($payloadArray);

        // Action
        $getSchedulingExaminationGradeListData = SchedulingExaminationGrade::where(function (Builder $scheduling_examination_grade_query_group1) use ($getSchedulingExaminationGradeListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getSchedulingExaminationGradeListDataUserDTO) && $getSchedulingExaminationGradeListDataUserDTO['group_filter'] != '') {
                if ($getSchedulingExaminationGradeListDataUserDTO['group_filter'] == 'All') {
                }
            }
        })->where(function (Builder $scheduling_examination_grade_query_group2) use ($getSchedulingExaminationGradeListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getSchedulingExaminationGradeListDataUserDTO) && ! is_null($getSchedulingExaminationGradeListDataUserDTO['search_filter_list']) && count($getSchedulingExaminationGradeListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getSchedulingExaminationGradeListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'is_generate_student_exam_report') {
                        $scheduling_examination_grade_query_group2->where($key, $value);
                    }
                    if ($key == 'scheduling_examination_id' && $value != null) {
                        $scheduling_examination_grade_query_group2->where($key, $value);
                    }
                }
            }
        })->where(function (Builder $scheduling_examination_grade_query_group3) use ($getSchedulingExaminationGradeListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getSchedulingExaminationGradeListDataUserDTO) && $getSchedulingExaminationGradeListDataUserDTO['search_phrase'] != '') {
                $scheduling_examination_grade_query_group3->whereHas('program', function (Builder $program_query) use ($getSchedulingExaminationGradeListDataUserDTO) {
                    $program_query->where('name', 'like', '%'.$getSchedulingExaminationGradeListDataUserDTO['search_phrase'].'%');
                });
            }
        })->with(['program' => function (Builder $program_query) {
            //
            $program_query->select('id', 'name');
        }])
            ->select(
                'id',
                'program_id',
                'scheduling_examination_id',
                'is_generate_student_exam_report',
            )
            ->orderBy('id', 'desc')
            ->paginate(
                $perPage = $getSchedulingExaminationGradeListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getSchedulingExaminationGradeListDataUserDTO['page']
            );

        return $getSchedulingExaminationGradeListData;
    }
}
