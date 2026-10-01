<?php

namespace Modules\EducatorFeedbackManagement\Intents\Category\UpdateCategory;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsController;

class UpdateCategoryIntent
{
    use AsController;

    public function asController(Request $request)
    {
        // Get user data from middleware
        $actionData = $request->all();
        $payloadArray = $request->all();

        // Execute the action
        $result = UpdateCategoryAction::run($payloadArray, $actionData);

        return response()->json([
            'success' => true,
            'data' => $result,
            'message' => 'Category updated successfully',
        ]);
    }
}
