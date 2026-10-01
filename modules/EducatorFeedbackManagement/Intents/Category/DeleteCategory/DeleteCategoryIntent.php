<?php

namespace Modules\EducatorFeedbackManagement\Intents\Category\DeleteCategory;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsController;

class DeleteCategoryIntent
{
    use AsController;

    public function asController(Request $request)
    {
        // Get user data from middleware
        $actionData = $request->all();
        $payloadArray = $request->all();

        // Execute the action
        $result = DeleteCategoryAction::run($payloadArray, $actionData);

        return response()->json([
            'success' => true,
            'data' => $result,
            'message' => 'Category deleted successfully',
        ]);
    }
}
