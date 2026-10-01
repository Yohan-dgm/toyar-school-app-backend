<?php

namespace Modules\EducatorFeedbackManagement\Intents\ParentComment\UpdateParentComment;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsController;

class UpdateParentCommentIntent
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
            $result = UpdateParentCommentAction::run($payloadArray, $actionData);

            return response()->json([
                'success' => true,
                'data' => $result,
                'message' => 'Parent comment updated successfully',
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
                'message' => 'Failed to update parent comment: '.$e->getMessage(),
            ], 500);
        }
    }
}
