<?php

namespace Modules\ActivityFeedManagement\Intents\ClassPost\DeleteClassPostComment;

use Illuminate\Http\Request;

class DeleteClassPostCommentIntent
{
    public function __invoke(Request $request)
    {
        $actionData = [
            'user_id' => $request->user()->id,
        ];

        $result = DeleteClassPostCommentAction::run($request->all(), $actionData);

        return response()->json([
            'success' => true,
            'message' => 'Comment deleted successfully',
            'data' => $result,
        ], 200);
    }
}
