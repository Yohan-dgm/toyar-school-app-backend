<?php

namespace Modules\EducatorFeedbackManagement\Intents\Category\GetCategoryListData;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsController;

class GetCategoryListDataIntent
{
    use AsController;

    public function asController(Request $request)
    {
        // Get user data from middleware
        $actionData = $request->all();
        $payloadArray = $request->all();

        // Execute the action
        $result = GetCategoryListDataAction::run($payloadArray, $actionData);

        return response()->json([
            'success' => true,
            'data' => $result,
            'message' => 'Category list retrieved successfully',
        ]);
    }
}
