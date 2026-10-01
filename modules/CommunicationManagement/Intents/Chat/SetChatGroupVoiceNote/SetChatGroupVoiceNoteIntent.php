<?php

namespace Modules\CommunicationManagement\Intents\Chat\SetChatGroupVoiceNote;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SetChatGroupVoiceNoteIntent
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

            $result = SetChatGroupVoiceNoteAction::run($request->all(), ['user_id' => $user->id]);

            return response()->json([
                'success' => true,
                'message' => 'Voice note setting updated successfully',
                'data' => $result,
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update voice note setting: '.$e->getMessage(),
            ], 500);
        }
    }
}
