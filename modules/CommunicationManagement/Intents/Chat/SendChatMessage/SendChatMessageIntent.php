<?php

namespace Modules\CommunicationManagement\Intents\Chat\SendChatMessage;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SendChatMessageIntent
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

            // Merge request files if any
            $payload = $request->all();
            if ($request->hasFile('attachment')) {
                $payload['attachment'] = $request->file('attachment');
            }

            $result = SendChatMessageAction::run($payload, ['user_id' => $user->id]);

            return response()->json([
                'success' => true,
                'message' => 'Message sent successfully',
                'data' => $result,
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
                'message' => 'Failed to send message: '.$e->getMessage(),
            ], 500);
        }
    }
}
