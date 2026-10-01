<?php

namespace Modules\EducatorFeedbackManagement\Intents\Category\CreateCategory;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsController;

class CreateCategoryIntent
{
    use AsController;

    public function asController(Request $request)
    {
        // Get user data from middleware
        $actionData = $request->all();
        $payloadArray = $request->all();
        $actionData['user_id'] = $request->user()->id;

        // Execute the action
        $result = CreateCategoryAction::run($payloadArray, $actionData);

        return response()->json([
            'success' => true,
            'data' => $result,
            'message' => 'Category created successfully',
        ], 201);
    }
}
