<?php

namespace Modules\ActivityFeedManagement\Intents\ClassPost\CreateClassPostComment;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ActivityFeedManagement\Models\ClassPost;
use Modules\ActivityFeedManagement\Models\ClassPostComment;

class CreateClassPostCommentAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        if (! isset($payloadArray['post_id'])) {
            throw new \InvalidArgumentException('post_id is required');
        }

        $content = trim($payloadArray['content'] ?? '');
        if ($content === '') {
            throw new \InvalidArgumentException('content is required');
        }

        $post = ClassPost::findOrFail($payloadArray['post_id']);
        $userId = $actionData['user_id'];

        return DB::transaction(function () use ($post, $userId, $content) {
            $comment = ClassPostComment::create([
                'post_id' => $post->id,
                'user_id' => $userId,
                'content' => $content,
                'created_by' => $userId,
            ]);

            $post->increment('comments_count');

            $comment->load('user');

            return [
                'id' => $comment->id,
                'post_id' => $comment->post_id,
                'user_id' => $comment->user_id,
                'user_name' => $comment->user->full_name ?? $comment->user->username ?? 'Unknown User',
                'content' => $comment->content,
                'created_at' => $comment->created_at->toISOString(),
                'is_own' => true,
            ];
        });
    }
}
