<?php

namespace Modules\ActivityFeedManagement\Intents\ClassPost\CreateClassPostComment;

use Illuminate\Http\Request;

class CreateClassPostCommentIntent
{
    public function __invoke(Request $request)
    {
        $actionData = [
            'user_id' => $request->user()->id,
        ];

        $result = CreateClassPostCommentAction::run($request->all(), $actionData);

        return response()->json([
            'success' => true,
            'message' => 'Comment added successfully',
            'data' => $result,
        ], 201);
    }
}
