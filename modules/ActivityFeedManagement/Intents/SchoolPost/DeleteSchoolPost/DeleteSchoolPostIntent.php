<?php

namespace Modules\ActivityFeedManagement\Intents\SchoolPost\DeleteSchoolPost;

use Illuminate\Http\Request;

class DeleteSchoolPostIntent
{
    public function __invoke(Request $request)
    {
        $actionData = [
            'user_id' => $request->user()->id,
        ];

        $result = DeleteSchoolPostAction::run($request->all(), $actionData);

        return response()->json([
            'success' => true,
            'message' => 'School post deleted successfully',
            'data' => $result,
        ], 200);
    }
}
