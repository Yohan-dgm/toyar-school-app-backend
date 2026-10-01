<?php

namespace Modules\EducatorFeedbackManagement\Intents\ParentComment\DeleteParentComment;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\EducatorFeedbackManagement\Models\EduFbParentComment;
use Modules\LogManagement\Intents\StudentLog\CreateStudentLog\CreateStudentLogAction;

class DeleteParentCommentAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $deleteParentCommentUserDTO = DeleteParentCommentUserDTO::validate($payloadArray);

        // Use database transaction for data integrity
        return DB::transaction(function () use ($deleteParentCommentUserDTO, $actionData) {
            // Find the comment
            $comment = EduFbParentComment::findOrFail($deleteParentCommentUserDTO['id']);

            // Store info for logging before deletion
            $commentId = $comment->id;
            $feedbackId = $comment->edu_fb_id;

            // Soft delete: Set is_active to false
            $comment->update([
                'is_active' => false,
                'updated_by' => $actionData['user_id'],
            ]);

            // Create activity log
            if (array_key_exists('username', $actionData)) {
                $logData['description'] = '[STATUS: Parent Comment Deleted (Soft), IP: '.$_SERVER['REMOTE_ADDR'].', USER: '.$actionData['username'].', COMMENT_ID: '.$commentId.', FEEDBACK_ID: '.$feedbackId.']';
                $logData['user_name'] = $actionData['username'];
                CreateStudentLogAction::run($logData, ['created_by' => $actionData['user_id']]);
            }

            return [
                'success' => true,
                'message' => 'Parent comment deleted successfully',
            ];
        });
    }
}
