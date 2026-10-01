<?php

namespace Modules\EducatorFeedbackManagement\Intents\EducatorFeedback\DeleteEducatorFeedback;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\EducatorFeedbackManagement\Models\EduFb;
use Modules\LogManagement\Intents\StudentLog\CreateStudentLog\CreateStudentLogAction;

class DeleteEducatorFeedbackAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $deleteEducatorFeedbackUserDTO = DeleteEducatorFeedbackUserDTO::validate($payloadArray);

        // Find the feedback
        $feedback = EduFb::findOrFail($deleteEducatorFeedbackUserDTO['id']);

        // Load related data for logging before deletion
        $feedback->load([
            'student:id,full_name,admission_number',
            'category:id,name',
            'question_answers',
            'subcategories',
            'comments',
            'evaluations',
        ]);

        // Store feedback data for logging before deletion
        $feedbackData = [
            'id' => $feedback->id,
            'student_name' => $feedback->student->full_name ?? 'Unknown',
            'admission_number' => $feedback->student->admission_number ?? 'Unknown',
            'category_name' => $feedback->category->name ?? 'Unknown',
            'rating' => $feedback->rating,
            'question_answers_count' => $feedback->question_answers->count(),
            'subcategories_count' => $feedback->subcategories->count(),
            'comments_count' => $feedback->comments->count(),
            'evaluations_count' => $feedback->evaluations->count(),
        ];

        // Check if feedback has active evaluations that might affect workflow
        $hasActiveEvaluations = $feedback->evaluations()->where('is_active', true)->exists();

        // Use database transaction for safety
        return DB::transaction(function () use ($feedback, $feedbackData, $hasActiveEvaluations, $actionData) {

            // Delete related records in proper order (cascading delete)

            // 1. Delete question answers
            $feedback->question_answers()->delete();

            // 2. Delete subcategories
            $feedback->subcategories()->delete();

            // 3. Delete comments
            $feedback->comments()->delete();

            // 4. Delete evaluations (including active ones)
            $feedback->evaluations()->delete();

            // // 5. Delete backup record
            // $feedback->backup()->delete();

            // 6. Finally delete the main feedback record
            $feedback->delete();

            // Create comprehensive activity log
            if (array_key_exists('username', $actionData)) {
                $logData['description'] = '[STATUS: Successfully Deleted Educator Feedback, IP: '.$_SERVER['REMOTE_ADDR'].', USER: '.$actionData['username'].", FEEDBACK ID: {$feedbackData['id']}, STUDENT: {$feedbackData['student_name']} ({$feedbackData['admission_number']}), CATEGORY: {$feedbackData['category_name']}, RATING: {$feedbackData['rating']}, DELETED: Q&A({$feedbackData['question_answers_count']}), Subcategories({$feedbackData['subcategories_count']}), Comments({$feedbackData['comments_count']}), Evaluations({$feedbackData['evaluations_count']}), Had Active Evaluations: ".($hasActiveEvaluations ? 'Yes' : 'No').']';
                $logData['user_name'] = $actionData['username'];
                CreateStudentLogAction::run($logData, ['created_by' => $actionData['user_id']]);
            }

            return [
                'deleted_feedback' => [
                    'id' => $feedbackData['id'],
                    'student_name' => $feedbackData['student_name'],
                    'admission_number' => $feedbackData['admission_number'],
                    'category_name' => $feedbackData['category_name'],
                    'rating' => $feedbackData['rating'],
                    'deleted_relations' => [
                        'question_answers' => $feedbackData['question_answers_count'],
                        'subcategories' => $feedbackData['subcategories_count'],
                        'comments' => $feedbackData['comments_count'],
                        'evaluations' => $feedbackData['evaluations_count'],
                        'backup_record' => 1,
                    ],
                    'had_active_evaluations' => $hasActiveEvaluations,
                    'warning' => $hasActiveEvaluations ? 'This feedback had active evaluations which have been permanently removed.' : null,
                ],
            ];
        });
    }
}
