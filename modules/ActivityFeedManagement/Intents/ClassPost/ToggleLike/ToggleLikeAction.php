<?php

namespace Modules\ActivityFeedManagement\Intents\ClassPost\ToggleLike;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ActivityFeedManagement\Models\ClassPost;
use Modules\ActivityFeedManagement\Models\ClassPostLike;

class ToggleLikeAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // Temporary bypass of DTOs due to cache table issue
        // TODO: Re-enable DTOs once cache table is created

        // Basic validation
        if (! isset($payloadArray['post_id']) || ! isset($payloadArray['action'])) {
            throw new \InvalidArgumentException('post_id and action are required');
        }

        if (! isset($actionData['user_id'])) {
            throw new \InvalidArgumentException('user_id is required');
        }

        if (! in_array($payloadArray['action'], ['like', 'unlike'])) {
            throw new \InvalidArgumentException('action must be like or unlike');
        }

        $postId = $payloadArray['post_id'];
        $userId = $actionData['user_id'];
        $action = $payloadArray['action'];

        // Verify post exists
        $post = ClassPost::findOrFail($postId);

        // Handle like/unlike with atomic transaction
        return DB::transaction(function () use ($postId, $userId, $action, $post) {

            // Check if user already liked the post
            $existingLike = ClassPostLike::where('post_id', $postId)
                ->where('user_id', $userId)
                ->first();

            $isLiked = false;
            $likesCount = 0;

            if ($action === 'like') {
                if (! $existingLike) {
                    // Create new like
                    ClassPostLike::create([
                        'post_id' => $postId,
                        'user_id' => $userId,
                    ]);

                    // Increment likes_count in posts table
                    $post->increment('likes_count');
                    $isLiked = true;
                } else {
                    // User already liked this post
                    $isLiked = true;
                }
            } elseif ($action === 'unlike') {
                if ($existingLike) {
                    // Remove like
                    $existingLike->delete();

                    // Decrement likes_count in posts table
                    $post->decrement('likes_count');
                    $isLiked = false;
                } else {
                    // User hasn't liked this post
                    $isLiked = false;
                }
            }

            // Get updated likes count from the post
            $post->refresh();
            $likesCount = $post->likes_count;

            return [
                'post_id' => $postId,
                'is_liked_by_user' => $isLiked,
                'likes_count' => $likesCount,
            ];
        });
    }
}
