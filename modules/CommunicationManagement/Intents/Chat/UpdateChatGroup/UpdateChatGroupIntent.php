<?php

namespace Modules\CommunicationManagement\Intents\Chat\UpdateChatGroup;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UpdateChatGroupIntent
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

            $result = UpdateChatGroupAction::run($request->all(), ['user_id' => $user->id]);

            return response()->json([
                'success' => true,
                'message' => 'Chat group updated successfully',
                'data' => $result,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update chat group: '.$e->getMessage(),
            ], 500);
        }
    }
}
