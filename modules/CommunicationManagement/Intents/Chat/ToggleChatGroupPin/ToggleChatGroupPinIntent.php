<?php

namespace Modules\CommunicationManagement\Intents\Chat\ToggleChatGroupPin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ToggleChatGroupPinIntent
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

            $request->validate([
                'chat_group_id' => 'required|integer',
            ]);

            $result = ToggleChatGroupPinAction::run(
                $user->id,
                $request->input('chat_group_id')
            );

            return response()->json($result);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to toggle pin: '.$e->getMessage(),
            ], 500);
        }
    }
}
