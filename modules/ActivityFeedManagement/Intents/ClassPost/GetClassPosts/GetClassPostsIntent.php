<?php

namespace Modules\ActivityFeedManagement\Intents\ClassPost\GetClassPosts;

use Illuminate\Http\Request;

class GetClassPostsIntent
{
    public function __invoke(Request $request)
    {
        $actionData = [
            'user_id' => $request->user()->id,
        ];

        $result = GetClassPostsAction::run($request->all(), $actionData);

        return response()->json([
            'success' => true,
            'message' => 'Class posts retrieved successfully',
            'data' => $result,
        ], 200);
    }
}
