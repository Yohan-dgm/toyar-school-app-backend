<?php

namespace Modules\EducatorFeedbackManagement\Intents\Comment\CreateComment;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\EducatorFeedbackManagement\Models\EduFb;
use Modules\EducatorFeedbackManagement\Models\EduFbComment;
use Modules\LogManagement\Intents\StudentLog\CreateStudentLog\CreateStudentLogAction;

class CreateCommentAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createCommentUserDTO = CreateCommentUserDTO::validate($payloadArray);

        // System Data Prep
        $system_data = [
            'created_by' => $actionData['user_id'],
            'updated_by' => null,
        ];

        // System Data Validation
        $createCommentSystemDTO = CreateCommentSystemDTO::validate($system_data);

        // Final Data Validation
        $createCommentDTO = CreateCommentDTO::validate(array_merge($createCommentUserDTO, $createCommentSystemDTO));

        // Use database transaction for data integrity
        return DB::transaction(function () use ($createCommentDTO, $actionData) {
            // Verify that the feedback exists
            $feedback = EduFb::find($createCommentDTO['edu_fb_id']);
            if (! $feedback) {
                throw new \Exception('Feedback not found');
            }

            // Deactivate all existing comments for this feedback (set is_active = false)
            $deactivatedCount = EduFbComment::where('edu_fb_id', $createCommentDTO['edu_fb_id'])
                ->update([
                    'is_active' => false,
                    'updated_by' => $createCommentDTO['created_by'],
                ]);

            // Create new comment (always with is_active = true)
            $comment = EduFbComment::create([
                'edu_fb_id' => $createCommentDTO['edu_fb_id'],
                'comment' => $createCommentDTO['comment'],
                'is_active' => true, // Always set to true for new comment
                'created_by' => $createCommentDTO['created_by'],
                'updated_by' => $createCommentDTO['updated_by'],
            ]);

            // Create activity log
            if (array_key_exists('username', $actionData)) {
                $statusDescription = $deactivatedCount > 0 ? "Successfully Created Comment (Deactivated {$deactivatedCount} Previous)" : 'Successfully Created New Comment';
                $logData['description'] = "[STATUS: {$statusDescription}, IP: ".$_SERVER['REMOTE_ADDR'].', USER: '.$actionData['username'].', FEEDBACK_ID: '.$feedback->id.', COMMENT_ID: '.$comment->id.']';
                $logData['user_name'] = $actionData['username'];
                CreateStudentLogAction::run($logData, ['created_by' => $actionData['user_id']]);
            }

            // Load relationships for response
            $comment->load([
                'created_by:id,call_name_with_title',
            ]);

            return $comment;
        });
    }
}
