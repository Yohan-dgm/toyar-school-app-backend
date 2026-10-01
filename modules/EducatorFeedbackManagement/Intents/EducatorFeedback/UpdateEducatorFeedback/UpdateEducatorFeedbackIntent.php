<?php

namespace Modules\EducatorFeedbackManagement\Intents\EducatorFeedback\UpdateEducatorFeedback;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsController;

class UpdateEducatorFeedbackIntent
{
    use AsController;

    public function asController(Request $request)
    {
        // Get user data from middleware
        $actionData = $request->all();
        $payloadArray = $request->all();

        // Execute the action
        $result = UpdateEducatorFeedbackAction::run($payloadArray, $actionData);

        return response()->json([
            'success' => true,
            'data' => $result,
            'message' => 'Educator feedback updated successfully',
        ]);
    }
}
