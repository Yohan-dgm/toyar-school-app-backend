<?php

namespace Modules\ActivityFeedManagement\Intents\StudentPost\CreateStudentPost;

use Illuminate\Http\Request;

class CreateStudentPostIntent
{
    public function __invoke(Request $request)
    {
        $actionData = [
            'user_id' => $request->user()->id,
        ];

        $result = CreateStudentPostAction::run($request->all(), $actionData);

        return response()->json([
            'success' => true,
            'message' => 'Student post created successfully',
            'data' => $result,
        ], 201);
    }
}
