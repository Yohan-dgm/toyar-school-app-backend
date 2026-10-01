<?php

namespace Modules\EducatorFeedbackManagement\Intents\Metadata\GetEducatorFeedbackMetadata;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsController;

class GetEducatorFeedbackMetadataIntent
{
    use AsController;

    public function asController(Request $request)
    {
        // Get user data from middleware
        $actionData = $request->all();
        $payloadArray = $request->all();

        // Execute the action
        $result = GetEducatorFeedbackMetadataAction::run($payloadArray, $actionData);

        return response()->json([
            'success' => true,
            'data' => $result,
            'message' => 'Educator feedback metadata retrieved successfully',
        ]);
    }
}
