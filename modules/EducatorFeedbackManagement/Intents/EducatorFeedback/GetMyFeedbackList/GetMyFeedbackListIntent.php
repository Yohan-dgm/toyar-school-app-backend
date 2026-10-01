<?php

namespace Modules\EducatorFeedbackManagement\Intents\EducatorFeedback\GetMyFeedbackList;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsController;

class GetMyFeedbackListIntent
{
    use AsController;

    public function asController(Request $request)
    {
        // Get user data from middleware
        $actionData = $request->all();
        $payloadArray = $request->all();
        $actionData['user_id'] = $request->user()->id;

        // Execute the action
        $result = GetMyFeedbackListAction::run($payloadArray, $actionData);

        return response()->json([
            'success' => true,
            'data' => $result,
        ], 200);
    }
}
