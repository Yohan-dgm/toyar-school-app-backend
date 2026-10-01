<?php

namespace Modules\CommunicationManagement\Intents\Chat\GetChatMessages;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetChatMessagesIntent
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

            $result = GetChatMessagesAction::run($request->all(), ['user_id' => $user->id]);

            return response()->json([
                'success' => true,
                'message' => 'Messages retrieved successfully',
                'data' => $result,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve messages: '.$e->getMessage(),
            ], 500);
        }
    }
}
