<?php

namespace Modules\EducatorFeedbackManagement\Intents\EducatorFeedback\UpdateEducatorFeedback;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\EducatorFeedbackManagement\Models\EduFb;
use Modules\EducatorFeedbackManagement\Models\EduFbComment;
use Modules\EducatorFeedbackManagement\Models\EduFbQuestionAnswer;
use Modules\EducatorFeedbackManagement\Models\EduFbSubcategory;
use Modules\LogManagement\Intents\StudentLog\CreateStudentLog\CreateStudentLogAction;

class UpdateEducatorFeedbackAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateEducatorFeedbackUserDTO = UpdateEducatorFeedbackUserDTO::validate($payloadArray);

        // Find the feedback
        $feedback = EduFb::findOrFail($updateEducatorFeedbackUserDTO['id']);

        // Store original values for logging
        $originalData = [
            'student_id' => $feedback->student_id,
            'grade_level_id' => $feedback->grade_level_id,
            'edu_fb_category_id' => $feedback->edu_fb_category_id,
            'rating' => $feedback->rating,
            'decline_reason' => $feedback->decline_reason,
        ];

        // Use database transaction for data integrity
        return DB::transaction(function () use ($updateEducatorFeedbackUserDTO, $actionData, $feedback, $originalData) {

            // Update main feedback record
            $feedback->update([
                'student_id' => $updateEducatorFeedbackUserDTO['student_id'],
                'grade_level_id' => $updateEducatorFeedbackUserDTO['grade_level_id'],
                'grade_level_class_id' => $updateEducatorFeedbackUserDTO['grade_level_class_id'],
                'edu_fb_category_id' => $updateEducatorFeedbackUserDTO['edu_fb_category_id'],
                'rating' => $updateEducatorFeedbackUserDTO['rating'],
                'decline_reason' => $updateEducatorFeedbackUserDTO['decline_reason'],
                'created_by_designation' => $updateEducatorFeedbackUserDTO['created_by_designation'],
                'updated_by' => $actionData['user_id'],
            ]);

            // Update backup record with new data
            $feedback->backup()->updateOrCreate(
                ['edu_fb_id' => $feedback->id],
                [
                    'student_id' => $updateEducatorFeedbackUserDTO['student_id'],
                    'grade_level_id' => $updateEducatorFeedbackUserDTO['grade_level_id'],
                    'grade_level_class_id' => $updateEducatorFeedbackUserDTO['grade_level_class_id'],
                    'edu_fb_category_id' => $updateEducatorFeedbackUserDTO['edu_fb_category_id'],
                    'rating' => $updateEducatorFeedbackUserDTO['rating'],
                    'decline_reason' => $updateEducatorFeedbackUserDTO['decline_reason'],
                    'created_by_designation' => $updateEducatorFeedbackUserDTO['created_by_designation'],
                    'created_by' => $feedback->created_by,
                    'updated_at' => now(),
                ]
            );

            // Update question answers if provided
            if (! is_null($updateEducatorFeedbackUserDTO['question_answers'])) {
                // Delete existing question answers
                $feedback->question_answers()->delete();

                // Create new question answers
                foreach ($updateEducatorFeedbackUserDTO['question_answers'] as $question_answer) {
                    EduFbQuestionAnswer::create([
                        'edu_fb_id' => $feedback->id,
                        'edu_fb_predefined_question_id' => $question_answer['edu_fb_predefined_question_id'],
                        'edu_fb_predefined_answer_id' => $question_answer['edu_fb_predefined_answer_id'],
                        'selected_predefined_answer_id' => $question_answer['selected_predefined_answer_id'] ?? null,
                        'answer_mark' => $question_answer['answer_mark'] ?? null,
                        'created_by' => $actionData['user_id'],
                    ]);
                }
            }

            // Update subcategories if provided
            if (! is_null($updateEducatorFeedbackUserDTO['subcategories'])) {
                // Delete existing subcategories
                $feedback->subcategories()->delete();

                // Create new subcategories
                foreach ($updateEducatorFeedbackUserDTO['subcategories'] as $subcategory) {
                    EduFbSubcategory::create([
                        'edu_fb_id' => $feedback->id,
                        'edu_fb_category_id' => $updateEducatorFeedbackUserDTO['edu_fb_category_id'],
                        'subcategory_name' => $subcategory['subcategory_name'],
                        'created_by' => $actionData['user_id'],
                    ]);
                }
            }

            // Update comments if provided
            if (! is_null($updateEducatorFeedbackUserDTO['comments'])) {
                // Delete existing comments
                $feedback->comments()->delete();

                // Create new comment if not empty
                if ($updateEducatorFeedbackUserDTO['comments'] != '') {
                    EduFbComment::create([
                        'edu_fb_id' => $feedback->id,
                        'comment_text' => $updateEducatorFeedbackUserDTO['comments'],
                        'created_by' => $actionData['user_id'],
                    ]);
                }
            }

            // Create activity log with changes
            if (array_key_exists('username', $actionData)) {
                $changes = [];

                if ($originalData['student_id'] !== $updateEducatorFeedbackUserDTO['student_id']) {
                    $changes[] = "Student ID: {$originalData['student_id']} → {$updateEducatorFeedbackUserDTO['student_id']}";
                }
                if ($originalData['grade_level_id'] !== $updateEducatorFeedbackUserDTO['grade_level_id']) {
                    $changes[] = "Grade Level ID: {$originalData['grade_level_id']} → {$updateEducatorFeedbackUserDTO['grade_level_id']}";
                }
                if ($originalData['edu_fb_category_id'] !== $updateEducatorFeedbackUserDTO['edu_fb_category_id']) {
                    $changes[] = "Category ID: {$originalData['edu_fb_category_id']} → {$updateEducatorFeedbackUserDTO['edu_fb_category_id']}";
                }
                if ($originalData['rating'] != $updateEducatorFeedbackUserDTO['rating']) {
                    $changes[] = "Rating: {$originalData['rating']} → {$updateEducatorFeedbackUserDTO['rating']}";
                }

                $logData['description'] = '[STATUS: Successfully Updated Educator Feedback, IP: '.$_SERVER['REMOTE_ADDR'].', USER: '.$actionData['username'].', FEEDBACK ID: '.$feedback->id.', CHANGES: '.implode(', ', $changes).']';
                $logData['user_name'] = $actionData['username'];
                CreateStudentLogAction::run($logData, ['created_by' => $actionData['user_id']]);
            }

            // Load relationships for response
            $feedback->load([
                'student:id,full_name,admission_number',
                'grade_level:id,name',
                'category:id,name',
                'evaluations.evaluation_type:id,name,status_code',
                'question_answers.predefined_question:id,question',
                'question_answers.predefined_answer:id,predefined_answer',
                'subcategories:id,subcategory_name',
                'comments:id,comment_text',
                'created_by:id,call_name_with_title',
                'updated_by:id,call_name_with_title',
            ]);

            return $feedback;
        });
    }
}
