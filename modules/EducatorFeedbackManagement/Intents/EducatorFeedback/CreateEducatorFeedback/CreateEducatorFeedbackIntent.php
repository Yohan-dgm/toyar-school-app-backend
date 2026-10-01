<?php

namespace Modules\EducatorFeedbackManagement\Intents\EducatorFeedback\CreateEducatorFeedback;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsController;

class CreateEducatorFeedbackIntent
{
    use AsController;

    public function asController(Request $request)
    {
        // Get user data from middleware
        $actionData = $request->all();
        $payloadArray = $request->all();
        $actionData['user_id'] = $request->user()->id;

        // Execute the action
        $result = CreateEducatorFeedbackAction::run($payloadArray, $actionData);

        return response()->json([
            'success' => true,
            'data' => $result,
            'message' => 'Educator feedback created successfully',
        ], 201);
    }
}
