<?php

namespace Modules\EducatorFeedbackManagement\Intents\Comment\CreateComment;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsController;

class CreateCommentIntent
{
    use AsController;

    public function asController(Request $request)
    {
        // Get user data from middleware
        $actionData = $request->all();
        $payloadArray = $request->all();
        $actionData['user_id'] = $request->user()->id;
        $actionData['username'] = $request->user()->username ?? $request->user()->email ?? 'Unknown';

        // Execute the action
        $result = CreateCommentAction::run($payloadArray, $actionData);

        return response()->json([
            'success' => true,
            'data' => $result,
            'message' => 'Comment created successfully',
        ], 201);
    }
}
