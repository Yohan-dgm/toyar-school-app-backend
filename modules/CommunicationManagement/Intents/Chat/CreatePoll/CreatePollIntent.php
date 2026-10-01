<?php

namespace Modules\CommunicationManagement\Intents\Chat\CreatePoll;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CreatePollIntent
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

            $result = CreatePollAction::run($request->all(), ['user_id' => $user->id]);

            return response()->json([
                'success' => true,
                'message' => 'Poll created successfully',
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
                'message' => 'Failed to create poll: '.$e->getMessage(),
            ], 500);
        }
    }
}
