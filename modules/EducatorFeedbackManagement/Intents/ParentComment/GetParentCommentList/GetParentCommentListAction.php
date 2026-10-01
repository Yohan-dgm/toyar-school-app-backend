<?php

namespace Modules\EducatorFeedbackManagement\Intents\ParentComment\GetParentCommentList;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\EducatorFeedbackManagement\Models\EduFbParentComment;

class GetParentCommentListAction
{
    use AsAction;

    public function handle($payloadArray)
    {
        // User Data Validation
        $getParentCommentListUserDTO = GetParentCommentListUserDTO::validate($payloadArray);

        // Query parent comments for the given educator feedback
        $comments = EduFbParentComment::where('edu_fb_id', $getParentCommentListUserDTO['edu_fb_id'])
            ->where('is_active', true)
            ->with([
                'createdBy:id,full_name,call_name_with_title',
                'updatedBy:id,full_name,call_name_with_title',
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        return $comments;
    }
}
