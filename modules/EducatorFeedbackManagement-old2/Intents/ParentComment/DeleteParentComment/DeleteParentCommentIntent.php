<?php

namespace Modules\EducatorFeedbackManagement\Intents\ParentComment\DeleteParentComment;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsController;

class DeleteParentCommentIntent
{
    use AsController;

    public function asController(Request $request)
    {
        try {
            // Get user data from middleware
            $actionData = $request->all();
            $payloadArray = $request->all();
            $actionData['user_id'] = $request->user()->id;
            $actionData['username'] = $request->user()->username ?? $request->user()->email ?? 'Unknown';

            // Execute the action
            $result = DeleteParentCommentAction::run($payloadArray, $actionData);

            return response()->json([
                'success' => true,
                'data' => $result,
                'message' => 'Parent comment deleted successfully',
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
                'message' => 'Failed to delete parent comment: '.$e->getMessage(),
            ], 500);
        }
    }
}
