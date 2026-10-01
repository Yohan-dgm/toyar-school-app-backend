<?php

namespace Modules\CommunicationManagement\Intents\Chat\SearchChatUsers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchChatUsersIntent
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

            $dto = SearchChatUsersDTO::validate($request->all());
            $result = SearchChatUsersAction::run($dto, ['user_id' => $user->id]);

            return response()->json([
                'success' => true,
                'message' => 'Users fetched successfully',
                'data' => $result,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to search users: '.$e->getMessage(),
            ], 500);
        }
    }
}
