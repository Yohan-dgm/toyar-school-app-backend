<?php

namespace Modules\CommunicationManagement\Intents\Chat\GetChatGroupMembers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetChatGroupMembersIntent
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

            $result = GetChatGroupMembersAction::run($request->all(), ['user_id' => $user->id]);

            return response()->json([
                'success' => true,
                'message' => 'Members fetched successfully',
                'data' => $result,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch members: '.$e->getMessage(),
            ], 500);
        }
    }
}
