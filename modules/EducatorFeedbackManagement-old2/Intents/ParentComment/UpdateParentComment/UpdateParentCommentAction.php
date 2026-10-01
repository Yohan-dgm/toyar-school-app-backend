<?php

namespace Modules\EducatorFeedbackManagement\Intents\ParentComment\UpdateParentComment;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\EducatorFeedbackManagement\Models\EduFbParentComment;
use Modules\LogManagement\Intents\StudentLog\CreateStudentLog\CreateStudentLogAction;

class UpdateParentCommentAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateParentCommentUserDTO = UpdateParentCommentUserDTO::validate($payloadArray);

        // Use database transaction for data integrity
        return DB::transaction(function () use ($updateParentCommentUserDTO, $actionData) {
            // Find the comment
            $comment = EduFbParentComment::findOrFail($updateParentCommentUserDTO['id']);

            // Update the comment
            $comment->update([
                'comment' => $updateParentCommentUserDTO['comment'],
                'updated_by' => $actionData['user_id'],
                'edited_at' => now(), // Set edit timestamp
            ]);

            // Create activity log
            if (array_key_exists('username', $actionData)) {
                $logData['description'] = '[STATUS: Parent Comment Updated, IP: '.$_SERVER['REMOTE_ADDR'].', USER: '.$actionData['username'].', COMMENT_ID: '.$comment->id.', FEEDBACK_ID: '.$comment->edu_fb_id.']';
                $logData['user_name'] = $actionData['username'];
                CreateStudentLogAction::run($logData, ['created_by' => $actionData['user_id']]);
            }

            // Load relationships for response
            $comment->load([
                'createdBy:id,full_name,call_name_with_title',
                'updatedBy:id,full_name,call_name_with_title',
            ]);

            return $comment;
        });
    }
}
