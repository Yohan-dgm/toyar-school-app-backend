<?php

namespace Modules\EducatorFeedbackManagement\Intents\Evaluation\UpdateEvaluationStatus;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\EducatorFeedbackManagement\Models\EduFb;
use Modules\EducatorFeedbackManagement\Models\EduFdEvaluation;
use Modules\EducatorFeedbackManagement\Models\EduFdEvaluationType;
use Modules\LogManagement\Intents\StudentLog\CreateStudentLog\CreateStudentLogAction;

class UpdateEvaluationStatusAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateEvaluationStatusUserDTO = UpdateEvaluationStatusUserDTO::validate($payloadArray);

        // Verify feedback exists
        $feedback = EduFb::findOrFail($updateEvaluationStatusUserDTO['edu_fb_id']);

        // Verify evaluation type exists and get valid transitions
        $evaluationType = EduFdEvaluationType::findOrFail($updateEvaluationStatusUserDTO['edu_fd_evaluation_type_id']);

        // Get current evaluation
        $currentEvaluation = EduFdEvaluation::where('edu_fb_id', $updateEvaluationStatusUserDTO['edu_fb_id'])
            ->where('is_active', true)
            ->latest()
            ->first();

        // Validate status transition (1->2->3->4->5->6 workflow)
        if ($currentEvaluation) {
            $currentStatusCode = $currentEvaluation->evaluation_type->status_code;
            $newStatusCode = $evaluationType->status_code;

            // Allow valid transitions only
            $validTransitions = [
                1 => [2, 3, 4, 5, 6], // Under Observation can go to any status
                2 => [4, 5, 6], // Accept can go to parent awareness, counselor, or correction
                3 => [4, 5, 6], // Decline can go to parent awareness, counselor, or correction
                4 => [5, 6], // Parent aware can go to counselor or correction
                5 => [6], // Counselor assigned can go to correction
                6 => [2, 3], // Correction required can go back to accept/decline
            ];

            if (! isset($validTransitions[$currentStatusCode]) ||
                ! in_array($newStatusCode, $validTransitions[$currentStatusCode])) {
                throw new \Exception("Invalid status transition from {$currentStatusCode} to {$newStatusCode}");
            }
        }

        // Use database transaction
        return DB::transaction(function () use ($updateEvaluationStatusUserDTO, $actionData, $feedback, $currentEvaluation) {
            // Deactivate current evaluation if exists
            if ($currentEvaluation) {
                $currentEvaluation->update(['is_active' => false]);
            }

            // Create new evaluation record
            $newEvaluation = EduFdEvaluation::create([
                'student_id' => $feedback->student_id,
                'edu_fb_id' => $updateEvaluationStatusUserDTO['edu_fb_id'],
                'edu_fd_evaluation_type_id' => $updateEvaluationStatusUserDTO['edu_fd_evaluation_type_id'],
                'reviewer_feedback' => $updateEvaluationStatusUserDTO['reviewer_feedback'],
                'decline_reason' => $updateEvaluationStatusUserDTO['decline_reason'],
                'is_parent_visible' => $updateEvaluationStatusUserDTO['is_parent_visible'] ?? false,
                'is_active' => true,
                'created_by' => $actionData['user_id'],
            ]);

            // Update main feedback status if needed
            $feedback->update([
                'status' => $updateEvaluationStatusUserDTO['edu_fd_evaluation_type_id'],
                'updated_by' => $actionData['user_id'],
            ]);

            // Create activity log
            if (array_key_exists('username', $actionData)) {
                $logData['description'] = '[STATUS: Updated Evaluation Status, IP: '.$_SERVER['REMOTE_ADDR'].', USER: '.$actionData['username'].', FEEDBACK ID: '.$feedback->id.', NEW STATUS: '.$newEvaluation->evaluation_type->name.']';
                $logData['user_name'] = $actionData['username'];
                CreateStudentLogAction::run($logData, ['created_by' => $actionData['user_id']]);
            }

            // Load relationships for response
            $newEvaluation->load([
                'student:id,full_name,admission_number',
                'feedback:id,edu_fb_category_id',
                'evaluation_type:id,name,status_code,description',
            ]);

            return $newEvaluation;
        });
    }
}
