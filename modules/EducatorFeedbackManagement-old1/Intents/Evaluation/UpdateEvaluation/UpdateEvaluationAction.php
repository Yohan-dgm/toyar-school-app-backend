<?php

namespace Modules\EducatorFeedbackManagement\Intents\Evaluation\UpdateEvaluation;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\EducatorFeedbackManagement\Models\EduFb;
use Modules\EducatorFeedbackManagement\Models\EduFdEvaluation;
use Modules\EducatorFeedbackManagement\Models\EduFdEvaluationType;
use Modules\LogManagement\Intents\StudentLog\CreateStudentLog\CreateStudentLogAction;

class UpdateEvaluationAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateEvaluationUserDTO = UpdateEvaluationUserDTO::validate($payloadArray);

        // System Data Prep
        $system_data = [
            'updated_by' => $actionData['user_id'],
        ];

        // System Data Validation
        $updateEvaluationSystemDTO = UpdateEvaluationSystemDTO::validate($system_data);

        // Final Data Validation
        $updateEvaluationDTO = UpdateEvaluationDTO::validate(array_merge($updateEvaluationUserDTO, $updateEvaluationSystemDTO));

        // Find the evaluation to update
        $evaluation = EduFdEvaluation::findOrFail($updateEvaluationDTO['id']);

        // Verify evaluation type exists if provided
        if (! is_null($updateEvaluationDTO['edu_fd_evaluation_type_id'])) {
            EduFdEvaluationType::findOrFail($updateEvaluationDTO['edu_fd_evaluation_type_id']);
        }

        // Use database transaction
        return DB::transaction(function () use ($updateEvaluationDTO, $actionData, $evaluation) {
            // Prepare update data
            $updateData = [
                'updated_by' => $updateEvaluationDTO['updated_by'],
            ];

            // Add fields that are being updated
            if (! is_null($updateEvaluationDTO['edu_fd_evaluation_type_id'])) {
                $updateData['edu_fd_evaluation_type_id'] = $updateEvaluationDTO['edu_fd_evaluation_type_id'];
            }
            if (! is_null($updateEvaluationDTO['reviewer_feedback'])) {
                $updateData['reviewer_feedback'] = $updateEvaluationDTO['reviewer_feedback'];
            }
            if (! is_null($updateEvaluationDTO['decline_reason'])) {
                $updateData['decline_reason'] = $updateEvaluationDTO['decline_reason'];
            }
            if (! is_null($updateEvaluationDTO['is_parent_visible'])) {
                $updateData['is_parent_visible'] = $updateEvaluationDTO['is_parent_visible'];
            }
            if (! is_null($updateEvaluationDTO['is_active'])) {
                $updateData['is_active'] = $updateEvaluationDTO['is_active'];

                // If setting this evaluation to active, deactivate all others for the same feedback
                if ($updateEvaluationDTO['is_active'] === true) {
                    EduFdEvaluation::where('edu_fb_id', $evaluation->edu_fb_id)
                        ->where('id', '!=', $evaluation->id)
                        ->update(['is_active' => false]);
                }
            }

            // Update the evaluation
            $evaluation->update($updateData);

            // Update main feedback status if evaluation type changed
            if (! is_null($updateEvaluationDTO['edu_fd_evaluation_type_id'])) {
                $feedback = EduFb::find($evaluation->edu_fb_id);
                if ($feedback) {
                    $feedback->update([
                        'status' => $updateEvaluationDTO['edu_fd_evaluation_type_id'],
                        'updated_by' => $updateEvaluationDTO['updated_by'],
                    ]);
                }
            }

            // Create activity log
            if (array_key_exists('username', $actionData)) {
                $logData['description'] = '[STATUS: Updated Evaluation, IP: '.$_SERVER['REMOTE_ADDR'].', USER: '.$actionData['username'].', EVALUATION ID: '.$evaluation->id.', FEEDBACK ID: '.$evaluation->edu_fb_id.']';
                $logData['user_name'] = $actionData['username'];
                CreateStudentLogAction::run($logData, ['created_by' => $actionData['user_id']]);
            }

            // Load relationships for response
            $evaluation->load([
                'student:id,full_name,admission_number',
                'feedback:id,edu_fb_category_id',
                'evaluation_type:id,name,status_code,description',
            ]);

            return $evaluation;
        });
    }
}
