<?php

namespace Modules\EducatorFeedbackManagement\Intents\EducatorFeedback\GetEducatorFeedbackListData;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsController;

class GetEducatorFeedbackListDataIntent
{
    use AsController;

    public function asController(Request $request)
    {
        // Get user data from middleware
        $actionData = $request->all();
        $payloadArray = $request->all();

        // Execute the action
        $result = GetEducatorFeedbackListDataAction::run($payloadArray, $actionData);

        return response()->json([
            'success' => true,
            'data' => $result,
            'message' => 'Educator feedback list retrieved successfully',
        ]);
    }
}
