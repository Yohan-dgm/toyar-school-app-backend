<?php

namespace Modules\ActivityFeedManagement\Intents\ClassPost\GetClassPostComments;

use Illuminate\Http\Request;

class GetClassPostCommentsIntent
{
    public function __invoke(Request $request)
    {
        $actionData = [
            'user_id' => $request->user()->id,
        ];

        $result = GetClassPostCommentsAction::run($request->all(), $actionData);

        return response()->json([
            'success' => true,
            'message' => 'Comments retrieved successfully',
            'data' => $result,
        ], 200);
    }
}
