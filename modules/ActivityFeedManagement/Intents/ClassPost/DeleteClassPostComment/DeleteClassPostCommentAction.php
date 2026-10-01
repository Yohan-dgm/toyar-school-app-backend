<?php

namespace Modules\ActivityFeedManagement\Intents\ClassPost\DeleteClassPostComment;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ActivityFeedManagement\Models\ClassPost;
use Modules\ActivityFeedManagement\Models\ClassPostComment;

class DeleteClassPostCommentAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        if (! isset($payloadArray['id'])) {
            throw new \InvalidArgumentException('id is required');
        }

        $comment = ClassPostComment::findOrFail($payloadArray['id']);

        if ($comment->user_id !== $actionData['user_id']) {
            throw new \Exception('You are not authorized to delete this comment.');
        }

        return DB::transaction(function () use ($comment, $actionData) {
            $comment->is_active = false;
            $comment->updated_by = $actionData['user_id'];
            $comment->save();

            ClassPost::where('id', $comment->post_id)->decrement('comments_count');

            return [
                'id' => $comment->id,
                'deleted' => true,
            ];
        });
    }
}
