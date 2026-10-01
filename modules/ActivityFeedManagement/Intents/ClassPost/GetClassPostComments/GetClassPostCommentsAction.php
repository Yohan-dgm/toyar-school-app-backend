<?php

namespace Modules\ActivityFeedManagement\Intents\ClassPost\GetClassPostComments;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ActivityFeedManagement\Models\ClassPostComment;

class GetClassPostCommentsAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        if (! isset($payloadArray['post_id'])) {
            throw new \InvalidArgumentException('post_id is required');
        }

        $page = $payloadArray['page'] ?? 1;
        $perPage = $payloadArray['page_size'] ?? 10;
        $order = strtolower($payloadArray['order'] ?? 'asc') === 'desc' ? 'desc' : 'asc';
        $userId = $actionData['user_id'];

        $comments = ClassPostComment::where('post_id', $payloadArray['post_id'])
            ->active()
            ->with('user')
            ->orderBy('created_at', $order)
            ->paginate($perPage, ['*'], 'page', $page);

        $transformedComments = $comments->getCollection()->map(function ($comment) use ($userId) {
            return [
                'id' => $comment->id,
                'post_id' => $comment->post_id,
                'user_id' => $comment->user_id,
                'user_name' => $comment->user->full_name ?? $comment->user->username ?? 'Unknown User',
                'content' => $comment->content,
                'created_at' => $comment->created_at->toISOString(),
                'is_own' => $comment->user_id === $userId,
            ];
        });

        return [
            'comments' => $transformedComments,
            'pagination' => [
                'current_page' => $comments->currentPage(),
                'per_page' => $comments->perPage(),
                'total' => $comments->total(),
                'last_page' => $comments->lastPage(),
                'has_more' => $comments->hasMorePages(),
            ],
        ];
    }
}
