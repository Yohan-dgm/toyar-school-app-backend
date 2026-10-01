<?php

namespace Modules\EducatorFeedbackManagement\Intents\CategorySc\GetCategoryScListData;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsController;

class GetCategoryScListDataIntent
{
    use AsController;

    public function asController(Request $request)
    {
        // Get user data from middleware
        $actionData = $request->all();
        $payloadArray = $request->all();

        // Execute the action
        $result = GetCategoryScListDataAction::run($payloadArray, $actionData);

        return response()->json([
            'success' => true,
            'data' => $result,
            'message' => 'Secondary section category list retrieved successfully',
        ]);
    }
}