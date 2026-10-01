<?php

namespace Modules\EducatorFeedbackManagement\Intents\EducatorFeedback\GetMyFeedbackList;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\EducatorFeedbackManagement\Models\EduFb;

class GetMyFeedbackListAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getMyFeedbackListUserDTO = GetMyFeedbackListUserDTO::validate($payloadArray);

        // Build query - only feedbacks created by the logged-in user
        $myFeedbackListData = EduFb::where('created_by', $actionData['user_id'])
            ->when($getMyFeedbackListUserDTO['grade_level_id'], function (Builder $query, $gradeId) {
                $query->where('grade_level_id', $gradeId);
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
            ->with(['parent_comments' => function (Builder $parent_comments_query) {
                $parent_comments_query->select('id', 'edu_fb_id', 'comment', 'is_active', 'created_by', 'created_at', 'updated_at', 'edited_at')
                    ->with(['createdBy' => function (Builder $parent_comment_user_query) {
                        $parent_comment_user_query->select('id', 'call_name_with_title');
                    }])
                    ->where('is_active', true)
                    ->orderBy('created_at', 'desc');
            }])
            ->with(['subcategories' => function (Builder $subcategories_query) {
                $subcategories_query->select('id', 'edu_fb_id', 'edu_fb_category_id', 'subcategory_name', 'is_active', 'created_by', 'created_at', 'updated_at')
                    ->with(['created_by' => function (Builder $subcategory_user_query) {
                        $subcategory_user_query->select('id', 'call_name_with_title');
                    }])
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
                $perPage = $getMyFeedbackListUserDTO['page_size'] ?? 10,
                $columns = ['*'],
                $pageName = 'page',
                $page = $getMyFeedbackListUserDTO['page'] ?? 1
            );

        return $myFeedbackListData;
    }
}
