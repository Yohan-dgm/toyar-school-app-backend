<?php

namespace Modules\ActivityFeedManagement\Intents\SchoolPost\DeleteSchoolPost;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ActivityFeedManagement\Models\SchoolPost;

class DeleteSchoolPostAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $deleteSchoolPostUserDTO = DeleteSchoolPostUserDTO::validate($payloadArray);

        // System Data Prep
        $system_data = [];
        $system_data['user_id'] = $actionData['user_id'];

        // System Data Validation
        $deleteSchoolPostSystemDTO = DeleteSchoolPostSystemDTO::validate($system_data);

        // Final Data Validation
        $deleteSchoolPostDTO = DeleteSchoolPostDTO::validate(array_merge($deleteSchoolPostUserDTO, $deleteSchoolPostSystemDTO));

        // Find the post
        $post = SchoolPost::findOrFail($deleteSchoolPostDTO['id']);

        // Check if user has permission to delete this post
        if ($post->created_by !== $actionData['user_id']) {
            throw new \Exception("You are not authorized to delete this post.");
        }

        // Soft delete or hard delete the post
        $post->delete();

        return [
            'id' => $post->id,
            'deleted' => true,
        ];
    }
}
