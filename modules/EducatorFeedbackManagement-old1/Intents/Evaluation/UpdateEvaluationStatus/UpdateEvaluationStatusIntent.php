<?php

namespace Modules\EducatorFeedbackManagement\Intents\Evaluation\UpdateEvaluationStatus;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsController;

class UpdateEvaluationStatusIntent
{
    use AsController;

    public function asController(Request $request)
    {
        // Get user data from middleware
        $actionData = $request->all();
        $payloadArray = $request->all();

        // Execute the action
        $result = UpdateEvaluationStatusAction::run($payloadArray, $actionData);

        return response()->json([
            'success' => true,
            'data' => $result,
            'message' => 'Evaluation status updated successfully',
        ]);
    }
}
