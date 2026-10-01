<?php

namespace Modules\EducatorFeedbackManagement\Intents\CategoryPr\GetCategoryPrListData;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsController;

class GetCategoryPrListDataIntent
{
    use AsController;

    public function asController(Request $request)
    {
        // Get user data from middleware
        $actionData = $request->all();
        $payloadArray = $request->all();

        // Execute the action
        $result = GetCategoryPrListDataAction::run($payloadArray, $actionData);

        return response()->json([
            'success' => true,
            'data' => $result,
            'message' => 'Primary section category list retrieved successfully',
        ]);
    }
}