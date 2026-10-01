<?php

namespace Modules\EducatorFeedbackManagement\Intents\ParentComment\CreateParentComment;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\EducatorFeedbackManagement\Models\EduFb;
use Modules\EducatorFeedbackManagement\Models\EduFbParentComment;
use Modules\LogManagement\Intents\StudentLog\CreateStudentLog\CreateStudentLogAction;

class CreateParentCommentAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createParentCommentUserDTO = CreateParentCommentUserDTO::validate($payloadArray);

        // System Data Prep
        $system_data = [
            'created_by' => $actionData['user_id'],
            'updated_by' => null,
        ];

        // System Data Validation
        $createParentCommentSystemDTO = CreateParentCommentSystemDTO::validate($system_data);

        // Final Data Validation
        $createParentCommentDTO = CreateParentCommentDTO::validate(array_merge($createParentCommentUserDTO, $createParentCommentSystemDTO));

        // Use database transaction for data integrity
        return DB::transaction(function () use ($createParentCommentDTO, $actionData) {
            // Verify that the educator feedback exists
            $feedback = EduFb::find($createParentCommentDTO['edu_fb_id']);
            if (! $feedback) {
                throw new \Exception('Educator feedback not found');
            }

            // Create new parent comment
            $comment = EduFbParentComment::create([
                'edu_fb_id' => $createParentCommentDTO['edu_fb_id'],
                'comment' => $createParentCommentDTO['comment'],
                'is_active' => true,
                'created_by' => $createParentCommentDTO['created_by'],
                'updated_by' => $createParentCommentDTO['updated_by'],
            ]);

            // Create activity log
            if (array_key_exists('username', $actionData)) {
                $logData['description'] = '[STATUS: Parent Comment Created, IP: '.$_SERVER['REMOTE_ADDR'].', USER: '.$actionData['username'].', FEEDBACK_ID: '.$feedback->id.', COMMENT_ID: '.$comment->id.']';
                $logData['user_name'] = $actionData['username'];
                CreateStudentLogAction::run($logData, ['created_by' => $actionData['user_id']]);
            }

            // Load relationships for response
            $comment->load([
                'createdBy:id,full_name,call_name_with_title',
            ]);

            return $comment;
        });
    }
}
