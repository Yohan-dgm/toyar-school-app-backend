<?php

namespace Modules\EducatorFeedbackManagement\Intents\Evaluation\CreateEvaluation;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\EducatorFeedbackManagement\Models\EduFb;
use Modules\EducatorFeedbackManagement\Models\EduFdEvaluation;
use Modules\EducatorFeedbackManagement\Models\EduFdEvaluationType;
use Modules\LogManagement\Intents\StudentLog\CreateStudentLog\CreateStudentLogAction;

class CreateEvaluationAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createEvaluationUserDTO = CreateEvaluationUserDTO::validate($payloadArray);

        // Verify feedback exists
        $feedback = EduFb::findOrFail($createEvaluationUserDTO['edu_fb_id']);

        // Verify evaluation type exists and get valid transitions
        $evaluationType = EduFdEvaluationType::findOrFail($createEvaluationUserDTO['edu_fd_evaluation_type_id']);

        // Note: No status transition validation - allow creating evaluation with any status

        // Use database transaction to ensure data integrity
        return DB::transaction(function () use ($createEvaluationUserDTO, $actionData, $feedback) {
            // CRITICAL: Deactivate ALL previous evaluations for this feedback
            EduFdEvaluation::where('edu_fb_id', $createEvaluationUserDTO['edu_fb_id'])
                ->update(['is_active' => false]);

            // Create new evaluation record (ONLY this one will be active)
            $newEvaluation = EduFdEvaluation::create([
                'student_id' => $feedback->student_id,
                'edu_fb_id' => $createEvaluationUserDTO['edu_fb_id'],
                'edu_fd_evaluation_type_id' => $createEvaluationUserDTO['edu_fd_evaluation_type_id'],
                'reviewer_feedback' => $createEvaluationUserDTO['reviewer_feedback'],
                // 'decline_reason' => $createEvaluationUserDTO['decline_reason'],
                'is_parent_visible' => $createEvaluationUserDTO['is_parent_visible'] ?? false,
                'is_active' => true, // ONLY the new evaluation is active
                'created_by' => $actionData['user_id'],
            ]);

            // Update main feedback status to reflect new evaluation
            $feedback->update([
                'status' => $createEvaluationUserDTO['edu_fd_evaluation_type_id'],
                'updated_by' => $actionData['user_id'],
            ]);

            // Create activity log
            if (array_key_exists('username', $actionData)) {
                $evaluationCount = EduFdEvaluation::where('edu_fb_id', $createEvaluationUserDTO['edu_fb_id'])->count();
                $logData['description'] = '[STATUS: Created New Evaluation, IP: '.$_SERVER['REMOTE_ADDR'].', USER: '.$actionData['username'].', FEEDBACK ID: '.$feedback->id.', NEW STATUS: '.$newEvaluation->evaluation_type->name.", TOTAL EVALUATIONS: {$evaluationCount}]";
                $logData['user_name'] = $actionData['username'];
                CreateStudentLogAction::run($logData, ['created_by' => $actionData['user_id']]);
            }

            // Load relationships for response
            // $newEvaluation=true;
            $newEvaluation->load([
                'student:id,full_name,admission_number',
                'feedback:id,edu_fb_category_id',
                'evaluation_type:id,name,status_code,description',
            ]);

            return $newEvaluation;
        });
    }
}
