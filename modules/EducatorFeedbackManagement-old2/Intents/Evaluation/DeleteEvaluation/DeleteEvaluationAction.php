<?php

namespace Modules\EducatorFeedbackManagement\Intents\Evaluation\DeleteEvaluation;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\EducatorFeedbackManagement\Models\EduFdEvaluation;
use Modules\LogManagement\Intents\StudentLog\CreateStudentLog\CreateStudentLogAction;

class DeleteEvaluationAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $deleteEvaluationUserDTO = DeleteEvaluationUserDTO::validate($payloadArray);

        // Find the evaluation to delete
        $evaluation = EduFdEvaluation::with(['student:id,full_name,admission_number', 'feedback:id,edu_fb_category_id', 'evaluation_type:id,name,status_code'])
            ->findOrFail($deleteEvaluationUserDTO['id']);

        // Store evaluation info for response
        $evaluationInfo = [
            'id' => $evaluation->id,
            'edu_fb_id' => $evaluation->edu_fb_id,
            'student_name' => $evaluation->student->full_name ?? 'Unknown',
            'admission_number' => $evaluation->student->admission_number ?? 'N/A',
            'evaluation_type' => $evaluation->evaluation_type->name ?? 'Unknown',
            'status_code' => $evaluation->evaluation_type->status_code ?? 0,
            'reviewer_feedback' => $evaluation->reviewer_feedback,
            'was_active' => $evaluation->is_active,
        ];

        // Use database transaction
        return DB::transaction(function () use ($evaluation, $actionData, $evaluationInfo) {
            // Delete the evaluation
            $evaluation->delete();

            // If this was the active evaluation, we should activate the most recent remaining evaluation
            if ($evaluationInfo['was_active']) {
                $latestEvaluation = EduFdEvaluation::where('edu_fb_id', $evaluationInfo['edu_fb_id'])
                    ->orderBy('created_at', 'desc')
                    ->first();

                if ($latestEvaluation) {
                    $latestEvaluation->update(['is_active' => true]);
                    $evaluationInfo['activated_evaluation_id'] = $latestEvaluation->id;
                    $evaluationInfo['activated_status'] = $latestEvaluation->evaluation_type->name ?? 'Unknown';
                } else {
                    $evaluationInfo['activated_evaluation_id'] = null;
                    $evaluationInfo['activated_status'] = 'No remaining evaluations';
                }
            } else {
                $evaluationInfo['activated_evaluation_id'] = null;
                $evaluationInfo['activated_status'] = 'No activation needed (was not active)';
            }

            // Create activity log
            if (array_key_exists('username', $actionData)) {
                $logData['description'] = '[STATUS: Deleted Evaluation, IP: '.$_SERVER['REMOTE_ADDR'].', USER: '.$actionData['username'].', EVALUATION ID: '.$evaluationInfo['id'].', STUDENT: '.$evaluationInfo['student_name'].', STATUS: '.$evaluationInfo['evaluation_type'].']';
                $logData['user_name'] = $actionData['username'];
                CreateStudentLogAction::run($logData, ['created_by' => $actionData['user_id']]);
            }

            return $evaluationInfo;
        });
    }
}
