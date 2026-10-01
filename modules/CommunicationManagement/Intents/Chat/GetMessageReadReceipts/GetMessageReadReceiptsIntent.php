<?php

namespace Modules\CommunicationManagement\Intents\Chat\GetMessageReadReceipts;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetMessageReadReceiptsIntent
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

            $result = GetMessageReadReceiptsAction::run($request->all(), ['user_id' => $user->id]);

            return response()->json([
                'success' => true,
                'message' => 'Message read receipts retrieved successfully',
                'data' => $result,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve read receipts: '.$e->getMessage(),
            ], 500);
        }
    }
}
