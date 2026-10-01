<?php

namespace Modules\ActivityFeedManagement\Intents\ClassPost\DeleteClassPost;

use Illuminate\Http\Request;

class DeleteClassPostIntent
{
    public function __invoke(Request $request)
    {
        $actionData = [
            'user_id' => $request->user()->id,
        ];

        $result = DeleteClassPostAction::run($request->all(), $actionData);

        return response()->json([
            'success' => true,
            'message' => 'Class post deleted successfully',
            'data' => $result,
        ], 200);
    }
}
