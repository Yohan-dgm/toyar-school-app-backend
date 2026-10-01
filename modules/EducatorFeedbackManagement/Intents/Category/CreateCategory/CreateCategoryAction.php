<?php

namespace Modules\EducatorFeedbackManagement\Intents\Category\CreateCategory;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\EducatorFeedbackManagement\Models\EduFbCategory;
use Modules\EducatorFeedbackManagement\Models\EduFbPredefinedAnswer;
use Modules\EducatorFeedbackManagement\Models\EduFbPredefinedQuestion;
use Modules\LogManagement\Intents\StudentLog\CreateStudentLog\CreateStudentLogAction;

class CreateCategoryAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createCategoryUserDTO = CreateCategoryUserDTO::validate($payloadArray);

        // System Data Prep
        $system_data = [
            'created_by' => $actionData['user_id'],
            'updated_by' => null,
        ];

        // System Data Validation
        $createCategorySystemDTO = CreateCategorySystemDTO::validate($system_data);

        // Final Data Validation
        $createCategoryDTO = CreateCategoryDTO::validate(array_merge($createCategoryUserDTO, $createCategorySystemDTO));

        // Use database transaction for data integrity
        return DB::transaction(function () use ($createCategoryDTO, $actionData) {
            // Check if category with same name already exists
            $existingCategory = EduFbCategory::where('name', $createCategoryDTO['name'])->orderBy('id', 'desc')->first();

            if ($existingCategory) {
                // If category exists, deactivate it (set is_active = 0)
                $existingCategory->update([
                    'is_active' => false,
                    'updated_by' => $createCategoryDTO['created_by'],
                ]);
            }

            // Create new category (always with is_active = 1)
            $category = EduFbCategory::create([
                'name' => $createCategoryDTO['name'],
                'is_active' => true, // Always set to true for new category
                'created_by' => $createCategoryDTO['created_by'],
                'updated_by' => $createCategoryDTO['updated_by'],
            ]);

            $createdQuestionsCount = 0;
            $createdAnswersCount = 0;

            // Create predefined questions if provided
            if (! is_null($createCategoryDTO['predefined_questions']) && count($createCategoryDTO['predefined_questions']) > 0) {
                foreach ($createCategoryDTO['predefined_questions'] as $questionData) {
                    // Create predefined question
                    $question = EduFbPredefinedQuestion::create([
                        'question' => $questionData['question'],
                        'edu_fb_category_id' => $category->id,
                        'edu_fb_answer_type_id' => $questionData['edu_fb_answer_type_id'] ?? null,
                        'is_active' => $questionData['is_active'] ?? 1,
                        'created_by' => $createCategoryDTO['created_by'],
                    ]);
                    $createdQuestionsCount++;

                    // Create predefined answers if provided
                    if (! is_null($questionData['predefined_answers']) && count($questionData['predefined_answers']) > 0) {
                        foreach ($questionData['predefined_answers'] as $answerData) {
                            EduFbPredefinedAnswer::create([
                                'predefined_answer' => $answerData['predefined_answer'],
                                'edu_fb_predefined_question_id' => $question->id,
                                'predefined_answer_weight' => $answerData['predefined_answer_weight'] ?? 1,
                                'marks' => $answerData['marks'] ?? 0,
                                'is_active' => $answerData['is_active'] ?? 1,
                                'created_by' => $createCategoryDTO['created_by'],
                            ]);
                            $createdAnswersCount++;
                        }
                    }
                }
            }

            // Create activity log
            if (array_key_exists('username', $actionData)) {
                $statusDescription = $existingCategory ? 'Successfully Created Category (Deactivated Previous)' : 'Successfully Created New Category';
                $previousId = $existingCategory ? ', PREVIOUS_ID: '.$existingCategory->id : '';
                $logData['description'] = "[STATUS: {$statusDescription}, IP: ".$_SERVER['REMOTE_ADDR'].', USER: '.$actionData['username'].', CATEGORY: '.$category->name.', NEW_ID: '.$category->id."{$previousId}, QUESTIONS: {$createdQuestionsCount}, ANSWERS: {$createdAnswersCount}]";
                $logData['user_name'] = $actionData['username'];
                CreateStudentLogAction::run($logData, ['created_by' => $actionData['user_id']]);
            }

            // Load relationships for response
            $category->load([
                'created_by:id,call_name_with_title',
                'predefined_questions' => function ($query) {
                    $query->select('id', 'question', 'edu_fb_category_id', 'edu_fb_answer_type_id', 'is_active')
                        ->with(['predefined_answers' => function ($answerQuery) {
                            $answerQuery->select('id', 'predefined_answer', 'edu_fb_predefined_question_id', 'predefined_answer_weight', 'marks', 'is_active');
                        }]);
                },
            ]);

            return $category;
        });
    }
}
