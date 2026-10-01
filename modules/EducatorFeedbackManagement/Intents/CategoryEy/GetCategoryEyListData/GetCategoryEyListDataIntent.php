<?php

namespace Modules\EducatorFeedbackManagement\Intents\CategoryEy\GetCategoryEyListData;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsController;

class GetCategoryEyListDataIntent
{
    use AsController;

    public function asController(Request $request)
    {
        // Get user data from middleware
        $actionData = $request->all();
        $payloadArray = $request->all();

        // Execute the action
        $result = GetCategoryEyListDataAction::run($payloadArray, $actionData);

        return response()->json([
            'success' => true,
            'data' => $result,
            'message' => 'Early Years category list retrieved successfully',
        ]);
    }
}