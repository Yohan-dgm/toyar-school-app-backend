<?php

namespace Modules\ActivityFeedManagement\Intents\ClassPost\CreateClassPost;

use Illuminate\Http\Request;

class CreateClassPostIntent
{
    public function __invoke(Request $request)
    {
        $actionData = [
            'user_id' => $request->user()->id,
        ];

        $result = CreateClassPostAction::run($request->all(), $actionData);

        return response()->json([
            'success' => true,
            'message' => 'Class post created successfully',
            'data' => $result,
        ], 201);
    }
}
