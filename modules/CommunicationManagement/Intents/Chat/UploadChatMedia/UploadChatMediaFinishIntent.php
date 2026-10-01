<?php

namespace Modules\CommunicationManagement\Intents\Chat\UploadChatMedia;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UploadChatMediaFinishIntent
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

            $result = UploadChatMediaFinishAction::run($request->all(), ['user_id' => $user->id]);

            return response()->json([
                'success' => true,
                'message' => 'Upload finalized successfully',
                'data' => $result,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to finalize upload: '.$e->getMessage(),
            ], 500);
        }
    }
}
