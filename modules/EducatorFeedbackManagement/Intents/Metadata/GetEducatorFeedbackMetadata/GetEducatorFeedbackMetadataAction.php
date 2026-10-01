<?php

namespace Modules\EducatorFeedbackManagement\Intents\Metadata\GetEducatorFeedbackMetadata;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\EducatorFeedbackManagement\Models\EduFbCategory;
use Modules\EducatorFeedbackManagement\Models\EduFdEvaluationType;
use Modules\ProgramManagement\Models\GradeLevel;
use Modules\StudentManagement\Models\Student;

class GetEducatorFeedbackMetadataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // Get all metadata needed for feedback forms
        $metadata = [
            'categories' => EduFbCategory::where('is_active', true)
                ->select('id', 'name')
                ->orderBy('name')
                ->get(),

            'evaluation_types' => EduFdEvaluationType::where('is_active', true)
                ->select('id', 'name', 'status_code', 'description')
                ->orderBy('status_code')
                ->get(),

            'grade_levels' => GradeLevel::where('is_active', true)
                ->select('id', 'name')
                ->orderBy('name')
                ->get(),

            'students' => Student::where('has_dropped_out', false)
                ->where('is_school_leaver', false)
                ->with(['grade_level:id,name'])
                ->select('id', 'full_name', 'admission_number', 'grade_level_id')
                ->orderBy('full_name')
                ->get(),

            'categories_with_questions' => EduFbCategory::where('is_active', true)
                ->with(['predefined_questions' => function (Builder $questions_query) {
                    $questions_query->where('is_active', 1)
                        ->select('id', 'question', 'edu_fb_category_id', 'edu_fb_answer_type_id')
                        ->with(['predefined_answers' => function (Builder $answers_query) {
                            $answers_query->where('is_active', 1)
                                ->select('id', 'predefined_answer', 'edu_fb_predefined_question_id', 'predefined_answer_weight', 'marks')
                                ->orderBy('predefined_answer_weight');
                        }])
                        ->orderBy('id');
                }])
                ->select('id', 'name')
                ->orderBy('name')
                ->get(),
        ];

        return $metadata;
    }
}
