<?php

namespace Modules\ActivityFeedManagement\Intents\StudentPost\GetStudentPosts;

use Illuminate\Http\Request;

class GetStudentPostsIntent
{
    public function __invoke(Request $request)
    {
        $actionData = [
            'user_id' => $request->user()->id,
        ];

        $result = GetStudentPostsAction::run($request->all(), $actionData);

        return response()->json([
            'success' => true,
            'message' => 'Student posts retrieved successfully',
            'data' => $result,
        ], 200);
    }
}
