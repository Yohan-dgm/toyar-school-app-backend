<?php

namespace Modules\EducatorFeedbackManagement\Intents\StudentCategoryFeedback\GetStudentCategoryFeedbackList;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\EducatorFeedbackManagement\Models\EduFb;
use Modules\LogManagement\Intents\StudentLog\CreateStudentLog\CreateStudentLogAction;

class GetStudentCategoryFeedbackListAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $validatedData = GetStudentCategoryFeedbackListUserDTO::validate($payloadArray);

        // Build base query with required filters
        $feedbackQuery = EduFb::with([
            'student' => function (Builder $student_query) {
                $student_query->select('id', 'full_name', 'student_calling_name', 'admission_number', 'grade_level_id')
                    ->with(['student_attachment_list' => function (Builder $student_attachment_list_query) {
                        $student_attachment_list_query->select('id', 'student_id', 'file_name', 'original_file_name', 'mime_type', 'is_active')
                            ->where('is_active', true);
                    }]);
            },
            'grade_level' => function (Builder $grade_level_query) {
                $grade_level_query->select('id', 'name');
            },
            'grade_level_class' => function (Builder $grade_level_class_query) {
                $grade_level_class_query->select('id', 'name');
            },
            'category' => function (Builder $category_query) {
                $category_query->select('id', 'name');
            },
            'evaluations' => function (Builder $evaluations_query) {
                $evaluations_query->select('id', 'edu_fb_id', 'edu_fd_evaluation_type_id', 'reviewer_feedback', 'created_at', 'is_parent_visible', 'is_active', 'created_by')
                    ->where('is_parent_visible', true)
                    ->with(['evaluation_type' => function (Builder $eval_type_query) {
                        $eval_type_query->select('id', 'name', 'status_code');
                    }])
                    ->with(['created_by' => function (Builder $evaluation_user_query) {
                        $evaluation_user_query->select('id', 'call_name_with_title');
                    }])
                    ->latest();
            },
            'created_by' => function (Builder $created_by_query) {
                $created_by_query->select('id', 'call_name_with_title');
            },
            'comments' => function (Builder $comments_query) {
                $comments_query->select('id', 'edu_fb_id', 'comment', 'is_active', 'created_by', 'created_at', 'updated_at')
                    ->with(['created_by' => function (Builder $comment_user_query) {
                        $comment_user_query->select('id', 'call_name_with_title');
                    }])
                    ->where('is_active', true)
                    ->orderBy('created_at', 'desc');
            },
            'subcategories' => function (Builder $subcategories_query) {
                $subcategories_query->select('id', 'edu_fb_id', 'edu_fb_category_id', 'subcategory_name', 'is_active', 'created_by', 'created_at', 'updated_at')
                    ->with(['created_by' => function (Builder $subcategory_user_query) {
                        $subcategory_user_query->select('id', 'call_name_with_title');
                    }])
                    ->orderBy('created_at', 'asc');
            },
        ])
            ->where('student_id', $validatedData['student_id'])
            ->where('status', 2);

        // Apply evaluation status filter (only evaluations that are parent visible)
        if (isset($validatedData['evaluation_status'])) {
            $feedbackQuery->whereHas('evaluations', function (Builder $evaluation_query) use ($validatedData) {
                return $evaluation_query->where('is_parent_visible', true)
                    ->whereHas('evaluation_type', function (Builder $eval_type_query) use ($validatedData) {
                        return $eval_type_query->where('status_code', $validatedData['evaluation_status']);
                    });
            });
        }

        // Apply date filters
        if (isset($validatedData['date_from'])) {
            $feedbackQuery->whereDate('created_at', '>=', $validatedData['date_from']);
        }

        if (isset($validatedData['date_to'])) {
            $feedbackQuery->whereDate('created_at', '<=', $validatedData['date_to']);
        }

        // Apply search phrase filter
        if (isset($validatedData['search_phrase']) && ! empty($validatedData['search_phrase'])) {
            $feedbackQuery->where(function (Builder $search_query) use ($validatedData) {
                $search_query->where('decline_reason', 'ILIKE', '%'.$validatedData['search_phrase'].'%')
                    ->orWhereHas('comments', function (Builder $comment_search) use ($validatedData) {
                        $comment_search->where('comment', 'ILIKE', '%'.$validatedData['search_phrase'].'%');
                    })
                    ->orWhereHas('evaluations', function (Builder $eval_search) use ($validatedData) {
                        $eval_search->where('is_parent_visible', true)
                            ->where('reviewer_feedback', 'ILIKE', '%'.$validatedData['search_phrase'].'%');
                    });
            });

            // Create activity log for search
            if (isset($actionData['username']) && isset($actionData['user_id'])) {
                $logData['description'] = '[Status: Search Student Feedback, IP: '.$_SERVER['REMOTE_ADDR'].', User: '.$actionData['username'].', Student ID: '.$validatedData['student_id'].', Search Phrase: '.$validatedData['search_phrase'].']';
                $logData['user_name'] = $actionData['username'];
                CreateStudentLogAction::run($logData, ['created_by' => $actionData['user_id']]);
            }
        }

        // Apply additional filters if provided
        if (isset($validatedData['filters']) && is_array($validatedData['filters']) && ! empty($validatedData['filters'])) {
            foreach ($validatedData['filters'] as $key => $value) {
                if (! empty($value)) {
                    $feedbackQuery->where($key, $value);
                }
            }
        }

        // Select specific columns for main query
        $feedbackQuery->select(
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
        );

        // Order by latest first
        $feedbackQuery->orderBy('created_at', 'desc');
        // $feedbackQuery->where("status", 2);

        // Validate page size limits
        $pageSize = min(max($validatedData['page_size'], 1), 100); // Limit between 1 and 100

        // Execute paginated query
        $feedbackListData = $feedbackQuery->paginate(
            $perPage = $pageSize,
            $columns = ['*'],
            $pageName = 'page',
            $page = $validatedData['page']
        );

        return $feedbackListData;
    }
}
