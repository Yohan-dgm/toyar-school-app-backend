<?php

namespace Modules\EducatorFeedbackManagement\Intents\EducatorFeedback\GetEducatorFeedbackListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\EducatorFeedbackManagement\Models\EduFb;
use Modules\LogManagement\Intents\StudentLog\CreateStudentLog\CreateStudentLogAction;

class GetEducatorFeedbackListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getEducatorFeedbackListDataUserDTO = GetEducatorFeedbackListDataUserDTO::validate($payloadArray);

        // Build query with filters
        $feedbackListData = EduFb::where(function (Builder $feedback_query_group1) use ($getEducatorFeedbackListDataUserDTO) {
            // Student filter
            if (array_key_exists('student_id', $getEducatorFeedbackListDataUserDTO) && $getEducatorFeedbackListDataUserDTO['student_id'] != null) {
                $feedback_query_group1->where('student_id', $getEducatorFeedbackListDataUserDTO['student_id']);
            }

            // Grade level filter - Only apply if grade_level_id is provided and not null
            // Initially shows all grades (no filter applied)
            if (array_key_exists('grade_level_id', $getEducatorFeedbackListDataUserDTO) && $getEducatorFeedbackListDataUserDTO['grade_level_id'] != null) {
                $feedback_query_group1->where('grade_level_id', $getEducatorFeedbackListDataUserDTO['grade_level_id']);
            }

            // Category filter
            if (array_key_exists('edu_fb_category_id', $getEducatorFeedbackListDataUserDTO) && $getEducatorFeedbackListDataUserDTO['edu_fb_category_id'] != null) {
                $feedback_query_group1->where('edu_fb_category_id', $getEducatorFeedbackListDataUserDTO['edu_fb_category_id']);
            }

            // Evaluation status filter - Always apply (defaults to status 1 "Under Observation")
            // This ensures we only show feedback with the specified evaluation status
            if (array_key_exists('evaluation_status', $getEducatorFeedbackListDataUserDTO) && $getEducatorFeedbackListDataUserDTO['evaluation_status'] != null) {
                $feedback_query_group1->whereHas('evaluations', function (Builder $evaluation_query) use ($getEducatorFeedbackListDataUserDTO) {
                    return $evaluation_query->where('edu_fd_evaluation_type_id', $getEducatorFeedbackListDataUserDTO['evaluation_status'])
                        ->where('is_active', true);
                });
            }
        })->where(function (Builder $feedback_query_group2) use ($getEducatorFeedbackListDataUserDTO) {
            // Date range filter
            if (array_key_exists('date_from', $getEducatorFeedbackListDataUserDTO) && $getEducatorFeedbackListDataUserDTO['date_from'] != null) {
                $feedback_query_group2->whereDate('created_at', '>=', $getEducatorFeedbackListDataUserDTO['date_from']);
            }
            if (array_key_exists('date_to', $getEducatorFeedbackListDataUserDTO) && $getEducatorFeedbackListDataUserDTO['date_to'] != null) {
                $feedback_query_group2->whereDate('created_at', '<=', $getEducatorFeedbackListDataUserDTO['date_to']);
            }
        })->where(function (Builder $feedback_query_group3) use ($getEducatorFeedbackListDataUserDTO) {
            // Additional search filters
            if (array_key_exists('search_filter_list', $getEducatorFeedbackListDataUserDTO) && ! is_null($getEducatorFeedbackListDataUserDTO['search_filter_list']) && count($getEducatorFeedbackListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getEducatorFeedbackListDataUserDTO['search_filter_list'] as $key => $value) {
                    $feedback_query_group3->where($key, $value);
                }
            }
        })->where(function (Builder $feedback_query_group4) use ($getEducatorFeedbackListDataUserDTO, $actionData) {
            // Search phrase
            if (array_key_exists('search_phrase', $getEducatorFeedbackListDataUserDTO) && $getEducatorFeedbackListDataUserDTO['search_phrase'] != '') {
                $feedback_query_group4->whereHas('student', function (Builder $student_query) use ($getEducatorFeedbackListDataUserDTO) {
                    $student_query->where('full_name', 'ILIKE', '%'.$getEducatorFeedbackListDataUserDTO['search_phrase'].'%')
                        ->orWhere('student_calling_name', 'ILIKE', '%'.$getEducatorFeedbackListDataUserDTO['search_phrase'].'%')
                        ->orWhere('admission_number', 'ILIKE', '%'.$getEducatorFeedbackListDataUserDTO['search_phrase'].'%');
                });

                // Create activity log for search
                if (array_key_exists('username', $actionData) && array_key_exists('user_id', $actionData)) {
                    $logData['description'] = '[Status: Search Educator Feedback, IP: '.$_SERVER['REMOTE_ADDR'].', User: '.$actionData['username'].', Search Phrase: '.$getEducatorFeedbackListDataUserDTO['search_phrase'].']';
                    $logData['user_name'] = $actionData['username'];
                    CreateStudentLogAction::run($logData, ['created_by' => $actionData['user_id']]);
                }
            }
        })
            ->with(['student' => function (Builder $student_query) {
                $student_query->select('id', 'full_name', 'student_calling_name', 'admission_number', 'grade_level_id')
                    ->with(['student_attachment_list' => function (Builder $student_attachment_list_query) {
                        $student_attachment_list_query->select('id', 'student_id', 'file_name', 'original_file_name', 'mime_type', 'is_active')
                            ->where('is_active', true);
                    }]);
            }])
            ->with(['grade_level' => function (Builder $grade_level_query) {
                $grade_level_query->select('id', 'name');
            }])
            ->with(['grade_level_class' => function (Builder $grade_level_class_query) {
                $grade_level_class_query->select('id', 'name');
            }])
            ->with(['category' => function (Builder $category_query) {
                $category_query->select('id', 'name');
            }])
            ->with(['evaluations' => function (Builder $evaluations_query) {
                $evaluations_query->select('id', 'edu_fb_id', 'edu_fd_evaluation_type_id', 'reviewer_feedback', 'created_at', 'is_parent_visible', 'is_active', 'created_by')
                    ->with(['evaluation_type' => function (Builder $eval_type_query) {
                        $eval_type_query->select('id', 'name', 'status_code');
                    }])
                    ->with(['created_by' => function (Builder $evaluation_user_query) {
                        $evaluation_user_query->select('id', 'call_name_with_title');
                    }])
                    ->latest();
            }])
            ->with(['created_by' => function (Builder $created_by_query) {
                $created_by_query->select('id', 'call_name_with_title');
            }])
            ->with(['comments' => function (Builder $comments_query) {
                $comments_query->select('id', 'edu_fb_id', 'comment', 'is_active', 'created_by', 'created_at', 'updated_at')
                    ->with(['created_by' => function (Builder $comment_user_query) {
                        $comment_user_query->select('id', 'call_name_with_title');
                    }])->where('is_active', true)
                    ->orderBy('created_at', 'desc');
            }])
            ->with(['subcategories' => function (Builder $subcategories_query) {
                $subcategories_query->select('id', 'edu_fb_id', 'edu_fb_category_id', 'subcategory_name', 'is_active', 'created_by', 'created_at', 'updated_at')
                    ->with(['created_by' => function (Builder $subcategory_user_query) {
                        $subcategory_user_query->select('id', 'call_name_with_title');
                    }])
                    // ->with(['category' => function (Builder $subcategory_category_query) {
                    //     $subcategory_category_query->select("id", "name");
                    // }])
                    ->orderBy('created_at', 'asc');
            }])
            ->select(
                'id',
                'student_id',
                'grade_level_id',
                'grade_level_class_id',
                'edu_fb_category_id',
                'rating',
                'decline_reason',
                'status',
                'created_by_designation',
                'created_by',
                'created_at',
                'updated_at'
            )
            ->orderBy('created_at', 'desc')
            ->paginate(
                $perPage = $getEducatorFeedbackListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getEducatorFeedbackListDataUserDTO['page']
            );

        return $feedbackListData;
    }
}
