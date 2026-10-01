<?php

namespace Modules\ActivityFeedManagement\Intents\ClassPost\UpdateClassPost;

use Illuminate\Http\Request;

class UpdateClassPostIntent
{
    public function __invoke(Request $request)
    {
        $actionData = [
            'user_id' => $request->user()->id,
        ];

        $result = UpdateClassPostAction::run($request->all(), $actionData);

        return response()->json([
            'success' => true,
            'message' => 'Class post updated successfully',
            'data' => $result,
        ], 200);
    }
}
