<?php

namespace Modules\CommunicationManagement\Intents\Chat\RemoveChatGroupMember;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RemoveChatGroupMemberIntent
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

            $result = RemoveChatGroupMemberAction::run($request->all(), ['user_id' => $user->id]);

            return response()->json([
                'success' => true,
                'message' => 'Member removed successfully',
                'data' => $result,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove member: '.$e->getMessage(),
            ], 500);
        }
    }
}
