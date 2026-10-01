<?php

namespace Modules\CommunicationManagement\Intents\Chat\GetChatThreads;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetChatThreadsIntent
{
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            
            // Check if user is authenticated
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized',
                ], 401);
            }

            $result = GetChatThreadsAction::run($request->all(), ['user_id' => $user->id]);

            return response()->json([
                'success' => true,
                'message' => 'Chat threads retrieved successfully',
                'data' => $result,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve chat threads: '.$e->getMessage(),
            ], 500);
        }
    }
}
