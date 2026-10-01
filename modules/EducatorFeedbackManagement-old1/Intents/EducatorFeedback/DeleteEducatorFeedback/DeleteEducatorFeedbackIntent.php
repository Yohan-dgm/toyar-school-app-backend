<?php

namespace Modules\EducatorFeedbackManagement\Intents\EducatorFeedback\DeleteEducatorFeedback;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsController;

class DeleteEducatorFeedbackIntent
{
    use AsController;

    public function asController(Request $request)
    {
        // Get user data from middleware
        $actionData = $request->all();
        $payloadArray = $request->all();

        // Execute the action
        $result = DeleteEducatorFeedbackAction::run($payloadArray, $actionData);

        return response()->json([
            'success' => true,
            'data' => $result,
            'message' => 'Educator feedback deleted successfully',
        ]);
    }
}
