<?php

namespace Modules\EducatorFeedbackManagement\Intents\ParentComment\GetParentCommentList;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsController;

class GetParentCommentListIntent
{
    use AsController;

    public function asController(Request $request)
    {
        try {
            // Get request data
            $payloadArray = $request->all();

            // Execute the action
            $comments = GetParentCommentListAction::run($payloadArray);

            return response()->json([
                'success' => true,
                'data' => $comments,
                'message' => 'Parent comments retrieved successfully',
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve parent comments: '.$e->getMessage(),
            ], 500);
        }
    }
}
