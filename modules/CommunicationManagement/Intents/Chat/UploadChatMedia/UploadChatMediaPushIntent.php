<?php

namespace Modules\CommunicationManagement\Intents\Chat\UploadChatMedia;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UploadChatMediaPushIntent
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

            $payload = $request->all();
            if ($request->hasFile('chunk')) {
                $payload['chunk'] = $request->file('chunk');
            }

            $result = UploadChatMediaPushAction::run($payload, ['user_id' => $user->id]);

            return response()->json([
                'success' => true,
                'message' => 'Chunk uploaded successfully',
                'data' => $result,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload chunk: '.$e->getMessage(),
            ], 500);
        }
    }
}
