<?php

namespace Modules\ActivityFeedManagement\Intents\StudentPost\DeleteStudentPost;

use Illuminate\Http\Request;

class DeleteStudentPostIntent
{
    public function __invoke(Request $request)
    {
        $actionData = [
            'user_id' => $request->user()->id,
        ];

        $result = DeleteStudentPostAction::run($request->all(), $actionData);

        return response()->json([
            'success' => true,
            'message' => 'Student post deleted successfully',
            'data' => $result,
        ], 200);
    }
}
