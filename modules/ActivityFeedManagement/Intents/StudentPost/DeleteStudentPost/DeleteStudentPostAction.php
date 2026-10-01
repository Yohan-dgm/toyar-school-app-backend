<?php

namespace Modules\ActivityFeedManagement\Intents\StudentPost\DeleteStudentPost;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ActivityFeedManagement\Models\StudentPost;

class DeleteStudentPostAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // Find the post
        $post = StudentPost::findOrFail($payloadArray['id']);

        // Check if user has permission to delete this post
        if ($post->created_by !== $actionData['user_id']) {
            throw new \Exception("You are not authorized to delete this post.");
        }

        // Delete the post
        $post->delete();

        return [
            'id' => $post->id,
            'deleted' => true,
        ];
    }
}
