<?php

namespace Modules\ExamManagement\Intents\ExamMarkSubject\GetExamMarkSubjectListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Models\SchedulingExaminationGradeSubject;

class GetExamMarkSubjectListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getExamMarkSubjectListDataUserDTO = GetExamMarkSubjectListDataUserDTO::validate($payloadArray);

        // Action
        $getExamMarkSubjectListData = SchedulingExaminationGradeSubject::where(function (Builder $exam_mark_subject_query_group1) use ($getExamMarkSubjectListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getExamMarkSubjectListDataUserDTO) && $getExamMarkSubjectListDataUserDTO['group_filter'] != '') {
                if ($getExamMarkSubjectListDataUserDTO['group_filter'] == 'All') {
                } elseif ($getExamMarkSubjectListDataUserDTO['group_filter'] == 'Pending Confirmed') {
                    $exam_mark_subject_query_group1->where('is_all_marks_confirmed', false);
                } elseif ($getExamMarkSubjectListDataUserDTO['group_filter'] == 'Confirmed') {
                    $exam_mark_subject_query_group1->where('is_all_marks_confirmed', true);
                }
            }
        })->where(function (Builder $exam_mark_subject_query_group2) {
            // search_filter_list
        })->where(function (Builder $exam_mark_subject_query_group3) use ($getExamMarkSubjectListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getExamMarkSubjectListDataUserDTO) && $getExamMarkSubjectListDataUserDTO['search_phrase'] != '') {
                $exam_mark_subject_query_group3->whereHas('subject', function (Builder $subject_query) use ($getExamMarkSubjectListDataUserDTO) {
                    return $subject_query
                        ->where('name', 'ILIKE', '%'.$getExamMarkSubjectListDataUserDTO['search_phrase'].'%')
                        ->orWhere('subject_code', 'ILIKE', '%'.$getExamMarkSubjectListDataUserDTO['search_phrase'].'%');
                });
            }
        })->where(function (Builder $exam_mark_subject_query_group4) use ($actionData, $getExamMarkSubjectListDataUserDTO) {
            // scheduling_examination_status_type_id
            $exam_mark_subject_query_group4->whereHas('scheduling_examination_grade', function (Builder $scheduling_examination_grade_query) {
                $scheduling_examination_grade_query->whereHas('scheduling_examination', function (Builder $scheduling_examination_query) {
                    $scheduling_examination_query->where('scheduling_examination_status_type_id', 2);
                });
            });

            if ($getExamMarkSubjectListDataUserDTO['user_type'] != 'Management') {
                $exam_mark_subject_query_group4->whereHas('subject', function (Builder $subject_query) use ($actionData) {
                    $subject_query->whereHas('educator_list', function (Builder $educator_query) use ($actionData) {
                        $educator_query->whereHas('employee', function (Builder $employee_query) use ($actionData) {
                            $employee_query->where('user_id', $actionData['user_id']);
                        });
                    });
                });
            }
        })
            // ->where(function (Builder $exam_mark_subject_query_group5) use ($getExamMarkSubjectListDataUserDTO) {
            //     $exam_mark_subject_query_group5->whereHas('subject_list', function (Builder $subject_query) use ($getExamMarkSubjectListDataUserDTO) {
            //         //
            //         $subject_query->whereHas('subjectsubject_list', function (Builder $subject_query) use ($getExamMarkSubjectListDataUserDTO) {
            //             //
            //             $subject_query->where('subject_id', $getExamMarkSubjectListDataUserDTO['subject_id']);
            //         });
            //     });
            // })
            ->with(['subject' => function (Builder $subject_query) {
                //
                $subject_query->select('id', 'name', 'subject_code');
            }])
            ->with(['scheduling_examination_grade' => function (Builder $scheduling_examination_grade_query) {
                //
                $scheduling_examination_grade_query->with(['program' => function (Builder $program_query) {
                    //
                    $program_query->select('id', 'name');
                }]);
                $scheduling_examination_grade_query->with(['scheduling_examination' => function (Builder $scheduling_examination_query) {
                    //
                    $scheduling_examination_query->select('id', 'exam_type', 'exam_title');
                }]);
                $scheduling_examination_grade_query->select('id', 'program_id', 'scheduling_examination_id');
            }])
            ->with(['student_exam_mark_list' => function (Builder $student_exam_mark_list_query) {
                //
                $student_exam_mark_list_query->select('id', 'grading', 'scheduling_examination_grade_subject_id', 'subject_total_mark', 'is_mark_added');
            }])
            ->select(
                'id',
                'scheduling_examination_grade_id',
                'subject_id',
                'is_all_marks_confirmed',
            )
            ->orderBy('id', 'desc')
            ->paginate(
                $perPage = $getExamMarkSubjectListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getExamMarkSubjectListDataUserDTO['page']
            );

        return $getExamMarkSubjectListData;
    }
}
