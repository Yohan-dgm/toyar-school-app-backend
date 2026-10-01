<?php

namespace Modules\CommunicationManagement\Intents\Chat\MarkChatAsRead;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MarkChatAsReadIntent
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

            $result = MarkChatAsReadAction::run($request->all(), ['user_id' => $user->id]);

            return response()->json([
                'success' => true,
                'message' => 'Chat marked as read',
                'data' => $result,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark chat as read: '.$e->getMessage(),
            ], 500);
        }
    }
}
