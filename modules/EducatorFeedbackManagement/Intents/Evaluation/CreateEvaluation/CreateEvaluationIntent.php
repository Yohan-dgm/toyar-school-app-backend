<?php

namespace Modules\EducatorFeedbackManagement\Intents\Evaluation\CreateEvaluation;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsController;

class CreateEvaluationIntent
{
    use AsController;

    public function asController(Request $request)
    {
        // Get user data from middleware
        $actionData = $request->all();
        $payloadArray = $request->all();
        $actionData['user_id'] = $request->user()->id;

        // Execute the action
        $result = CreateEvaluationAction::run($payloadArray, $actionData);

        return response()->json([
            'success' => true,
            'data' => $result,
            'message' => 'Evaluation created successfully',
        ], 201);
    }
}
