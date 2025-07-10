<?php

namespace Modules\ActivityFeedManagement\Intents\SchoolPost\ToggleLike;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ActivityFeedManagement\Models\ActivityFeedLike;
use Modules\ActivityFeedManagement\Models\ActivityFeedPost;

class ToggleLikeAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $toggleLikeUserDTO = ToggleLikeUserDTO::validate($payloadArray);

        // System Data Prep
        $system_data = [];
        $system_data['user_id'] = $actionData['user_id'];

        // System Data Validation
        $toggleLikeSystemDTO = ToggleLikeSystemDTO::validate($system_data);

        // Final Data Validation
        $toggleLikeDTO = ToggleLikeDTO::validate(array_merge($toggleLikeUserDTO, $toggleLikeSystemDTO));

        // Verify post exists
        $post = ActivityFeedPost::findOrFail($toggleLikeDTO['post_id']);

        // Toggle the like
        $result = ActivityFeedLike::toggleLike($toggleLikeDTO['post_id'], $toggleLikeDTO['user_id']);

        return [
            'post_id' => $toggleLikeDTO['post_id'],
            'is_liked' => $result['is_liked'],
            'likes_count' => $result['likes_count'],
        ];
    }
}
