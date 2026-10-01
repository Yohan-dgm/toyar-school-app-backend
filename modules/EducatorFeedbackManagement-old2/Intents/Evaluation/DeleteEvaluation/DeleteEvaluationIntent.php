<?php

namespace Modules\EducatorFeedbackManagement\Intents\Evaluation\DeleteEvaluation;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsController;

class DeleteEvaluationIntent
{
    use AsController;

    public function asController(Request $request)
    {
        // Get user data from middleware
        $actionData = $request->all();
        $payloadArray = $request->all();
        $actionData['user_id'] = $request->user()->id;

        // Execute the action
        $result = DeleteEvaluationAction::run($payloadArray, $actionData);

        return response()->json([
            'success' => true,
            'data' => [
                'deleted_evaluation' => $result,
            ],
            'message' => 'Evaluation deleted successfully',
        ], 200);
    }
}
