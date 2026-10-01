<?php

namespace Modules\CommunicationManagement\Intents\Chat\UpdateChatMessage;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\CommunicationManagement\Intents\Chat\SendChatMessage\SendChatMessageResDTO;

class UpdateChatMessageIntent
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

            $result = UpdateChatMessageAction::run($request->all(), ['user_id' => $user->id]);

            return response()->json([
                'success' => true,
                'message' => 'Message updated successfully',
                'data' => [
                    'message' => SendChatMessageResDTO::formatMessage(array_merge($result->toArray(), [
                        'sender_name' => $user->full_name ?? 'Someone',
                        'sender_avatar' => $user->profile_image_url ?? null,
                    ])),
                ],
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
                'message' => 'Failed to update message: '.$e->getMessage(),
            ], 500);
        }
    }
}
