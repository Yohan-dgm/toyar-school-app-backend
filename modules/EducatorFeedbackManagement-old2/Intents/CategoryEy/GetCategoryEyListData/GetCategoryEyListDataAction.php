<?php

namespace Modules\EducatorFeedbackManagement\Intents\CategoryEy\GetCategoryEyListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\EducatorFeedbackManagement\Models\EduFbCategoryEy;

class GetCategoryEyListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // Get all active EY categories with related data
        $categoryListData = EduFbCategoryEy::where('is_active', true)
            ->with(['predefined_questions' => function (Builder $questions_query) {
                $questions_query->where('is_active', 1)
                    ->select('id', 'question', 'edu_fb_category_ey_id', 'edu_fb_answer_type_id')
                    ->with(['predefined_answers' => function (Builder $answers_query) {
                        $answers_query->where('is_active', 1)
                            ->select('id', 'predefined_answer', 'edu_fb_predefined_question_ey_id', 'predefined_answer_weight', 'marks');
                    }]);
            }])
            ->with(['created_by' => function (Builder $created_by_query) {
                $created_by_query->select('id', 'call_name_with_title');
            }])
            ->select(
                'id',
                'name',
                'is_active',
                'created_by',
                'created_at',
                'updated_at'
            )
            ->where('is_active', true)
            ->orderBy('name', 'asc')
            ->get();

        return $categoryListData;
    }
}