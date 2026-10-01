<?php

namespace Modules\ExamManagement\Intents\SchedulingExamination\GetSchedulingExaminationListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Models\SchedulingExamination;

class GetSchedulingExaminationListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getSchedulingExaminationListDataUserDTO = GetSchedulingExaminationListDataUserDTO::validate($payloadArray);

        // Action
        $getSchedulingExaminationListData = SchedulingExamination::where(function (Builder $scheduling_examination_query_group1) use ($getSchedulingExaminationListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getSchedulingExaminationListDataUserDTO) && $getSchedulingExaminationListDataUserDTO['group_filter'] != '') {
                if ($getSchedulingExaminationListDataUserDTO['group_filter'] == 'All') {
                } else {
                    $scheduling_examination_query_group1->whereHas('scheduling_examination_status_type', function (Builder $scheduling_examination_status_type_query) use ($getSchedulingExaminationListDataUserDTO) {
                        return $scheduling_examination_status_type_query->where('name', $getSchedulingExaminationListDataUserDTO['group_filter']);
                    });
                }
            }
        })->where(function (Builder $scheduling_examination_query_group2) use ($getSchedulingExaminationListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getSchedulingExaminationListDataUserDTO) && ! is_null($getSchedulingExaminationListDataUserDTO['search_filter_list']) && count($getSchedulingExaminationListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getSchedulingExaminationListDataUserDTO['search_filter_list'] as $key => $value) {
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
        })->where(function (Builder $scheduling_examination_query_group3) use ($getSchedulingExaminationListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getSchedulingExaminationListDataUserDTO) && $getSchedulingExaminationListDataUserDTO['search_phrase'] != '') {
                $scheduling_examination_query_group3->where('exam_title', 'ILIKE', '%'.$getSchedulingExaminationListDataUserDTO['search_phrase'].'%');
                $scheduling_examination_query_group3->orWhere('exam_type', 'ILIKE', '%'.$getSchedulingExaminationListDataUserDTO['search_phrase'].'%');
            }
        })
            ->with(['scheduling_examinations_grade_list' => function (Builder $scheduling_examinations_grade_list_query) {
                //
                $scheduling_examinations_grade_list_query->with(['program' => function (Builder $program_query) {
                    //
                    $program_query->select('id', 'name', 'program_code');
                }])->with(['scheduling_examinations_grade_subject_list' => function (Builder $scheduling_examinations_grade_subject_list_query) {
                    //
                    $scheduling_examinations_grade_subject_list_query->with(['subject' => function (Builder $subject_query) {
                        //
                        $subject_query->select('id', 'name', 'subject_code');
                    }])->with(['scheduling_examinations_subject_paper_list' => function (Builder $scheduling_examinations_subject_paper_list_query) {
                        //
                        $scheduling_examinations_subject_paper_list_query->select(
                            'id',
                            'scheduling_examination_grade_subject_id',
                            'paper_type',
                            'name',
                            'overall_mark',
                            'duration_hours',
                            'duration_minutes',
                        );
                    }]);
                    $scheduling_examinations_grade_subject_list_query->select('id', 'scheduling_examination_grade_id', 'subject_id');
                }]);
                $scheduling_examinations_grade_list_query->select('id', 'program_id', 'scheduling_examination_id');
            }])->with(['term' => function (Builder $term_query) {
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
                $perPage = $getSchedulingExaminationListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getSchedulingExaminationListDataUserDTO['page']
            );

        return $getSchedulingExaminationListData;
    }
}
