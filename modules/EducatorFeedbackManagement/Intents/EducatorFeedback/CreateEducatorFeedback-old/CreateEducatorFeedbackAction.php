<?php

namespace Modules\EducatorFeedbackManagement\Intents\EducatorFeedback\CreateEducatorFeedback;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\EducatorFeedbackManagement\Models\EduFb;
use Modules\EducatorFeedbackManagement\Models\EduFbBackup;
use Modules\EducatorFeedbackManagement\Models\EduFbComment;
use Modules\EducatorFeedbackManagement\Models\EduFbQuestionAnswer;
use Modules\EducatorFeedbackManagement\Models\EduFbSubcategory;
use Modules\EducatorFeedbackManagement\Models\EduFdEvaluation;
use Modules\LogManagement\Intents\StudentLog\CreateStudentLog\CreateStudentLogAction;

class CreateEducatorFeedbackAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createEducatorFeedbackUserDTO = CreateEducatorFeedbackUserDTO::validate($payloadArray);

        // System Data Prep
        $system_data = [
            'status' => 1, // Active status
            'created_by' => $actionData['user_id'],
            'updated_by' => null,
        ];

        // System Data Validation
        $createEducatorFeedbackSystemDTO = CreateEducatorFeedbackSystemDTO::validate($system_data);

        // Final Data Validation
        $createEducatorFeedbackDTO = CreateEducatorFeedbackDTO::validate(array_merge($createEducatorFeedbackUserDTO, $createEducatorFeedbackSystemDTO));

        // Use database transaction for data integrity
        return DB::transaction(function () use ($createEducatorFeedbackDTO, $actionData) {
            // Create main feedback record
            $feedback = EduFb::create([
                'student_id' => $createEducatorFeedbackDTO['student_id'],
                'grade_level_id' => $createEducatorFeedbackDTO['grade_level_id'],
                'grade_level_class_id' => $createEducatorFeedbackDTO['grade_level_class_id'],
                'edu_fb_category_id' => $createEducatorFeedbackDTO['edu_fb_category_id'],
                'rating' => $createEducatorFeedbackDTO['rating'],
                'decline_reason' => null,
                'status' => $createEducatorFeedbackDTO['status'],
                'created_by_designation' => ' ',
                'created_by' => $createEducatorFeedbackDTO['created_by'],
                'updated_by' => $createEducatorFeedbackDTO['updated_by'],
            ]);

            // Create backup record following the pattern
            EduFbBackup::create([
                'edu_fb_id' => $feedback->id,
                'student_id' => $createEducatorFeedbackDTO['student_id'],
                'grade_level_id' => $createEducatorFeedbackDTO['grade_level_id'],
                'grade_level_class_id' => $createEducatorFeedbackDTO['grade_level_class_id'],
                'edu_fb_category_id' => $createEducatorFeedbackDTO['edu_fb_category_id'],
                'rating' => $createEducatorFeedbackDTO['rating'],
                'decline_reason' => null,
                'status' => $createEducatorFeedbackDTO['status'],
                'created_by_designation' => ' ',
                'created_by' => $createEducatorFeedbackDTO['created_by'],
            ]);

            // Create question answers if provided
            if (! is_null($createEducatorFeedbackDTO['question_answers']) && count($createEducatorFeedbackDTO['question_answers']) > 0) {
                foreach ($createEducatorFeedbackDTO['question_answers'] as $question_answer) {
                    EduFbQuestionAnswer::create([
                        'edu_fb_id' => $feedback->id,
                        'edu_fb_predefined_question_id' => $question_answer['edu_fb_predefined_question_id'],
                        'edu_fb_predefined_answer_id' => $question_answer['edu_fb_predefined_answer_id'],
                        'selected_predefined_answer_id' => $question_answer['selected_predefined_answer_id'] ?? null,
                        'answer_mark' => $question_answer['answer_mark'] ?? null,
                        'created_by' => $createEducatorFeedbackDTO['created_by'],
                    ]);
                }
            }

            // Create subcategories if provided
            if (! is_null($createEducatorFeedbackDTO['subcategories']) && count($createEducatorFeedbackDTO['subcategories']) > 0) {
                foreach ($createEducatorFeedbackDTO['subcategories'] as $subcategory) {
                    EduFbSubcategory::create([
                        'edu_fb_id' => $feedback->id,
                        'edu_fb_category_id' => $createEducatorFeedbackDTO['edu_fb_category_id'],
                        'subcategory_name' => $subcategory['subcategory_name'],
                        'created_by' => $createEducatorFeedbackDTO['created_by'],
                    ]);
                }
            }

            // Create comments if provided
            if (! is_null($createEducatorFeedbackDTO['comments']) && $createEducatorFeedbackDTO['comments'] != '') {
                EduFbComment::create([
                    'edu_fb_id' => $feedback->id,
                    'comment' => $createEducatorFeedbackDTO['comments'],
                    'created_by' => $createEducatorFeedbackDTO['created_by'],
                    'is_active' => 1,

                ]);
            }

            // Initialize evaluation with "Under Observation" status (status code 1)
            EduFdEvaluation::create([
                'student_id' => $createEducatorFeedbackDTO['student_id'],
                'edu_fb_id' => $feedback->id,
                'edu_fd_evaluation_type_id' => 1, // Under Observation
                'reviewer_feedback' => 'Feedback under initial observation',
                'decline_reason' => null,
                'is_parent_visible' => false,
                'is_active' => true,
                'created_by' => $createEducatorFeedbackDTO['created_by'],
            ]);

            // Create activity log
            if (array_key_exists('username', $actionData)) {
                $logData['description'] = '[STATUS: Successfully Created Educator Feedback, IP: '.$_SERVER['REMOTE_ADDR'].', USER: '.$actionData['username'].', FEEDBACK ID: '.$feedback->id.']';
                $logData['user_name'] = $actionData['username'];
                CreateStudentLogAction::run($logData, ['created_by' => $actionData['user_id']]);
            }

            // Load relationships for response
            $feedback->load([
                'student:id,full_name,admission_number',
                'grade_level:id,name',
                'category:id,name',
                'evaluations.evaluation_type:id,name,status_code',
            ]);

            return $feedback;
        });
    }
}
