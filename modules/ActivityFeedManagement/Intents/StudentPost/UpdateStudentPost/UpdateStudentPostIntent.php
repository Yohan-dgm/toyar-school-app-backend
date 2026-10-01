<?php

namespace Modules\ActivityFeedManagement\Intents\StudentPost\UpdateStudentPost;

use Illuminate\Http\Request;

class UpdateStudentPostIntent
{
    public function __invoke(Request $request)
    {
        $actionData = [
            'user_id' => $request->user()->id,
        ];

        $result = UpdateStudentPostAction::run($request->all(), $actionData);

        return response()->json([
            'success' => true,
            'message' => 'Student post updated successfully',
            'data' => $result,
        ], 200);
    }
}
