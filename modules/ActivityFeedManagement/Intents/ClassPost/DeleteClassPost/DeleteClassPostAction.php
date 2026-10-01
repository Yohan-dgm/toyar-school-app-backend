<?php

namespace Modules\ActivityFeedManagement\Intents\ClassPost\DeleteClassPost;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ActivityFeedManagement\Models\ClassPost;

class DeleteClassPostAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // Find the post
        $post = ClassPost::findOrFail($payloadArray['id']);

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
