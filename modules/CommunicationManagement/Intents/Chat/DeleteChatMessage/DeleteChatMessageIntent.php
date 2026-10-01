<?php

namespace Modules\CommunicationManagement\Intents\Chat\DeleteChatMessage;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeleteChatMessageIntent
{
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized',
                ], 401);
            }

            DeleteChatMessageAction::run($request->all(), ['user_id' => $user->id]);

            return response()->json([
                'success' => true,
                'message' => 'Message deleted successfully',
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete message: '.$e->getMessage(),
            ], 500);
        }
    }
}
