<?php

namespace Modules\CommunicationManagement\Intents\Announcement\GetAnnouncements;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetAnnouncementsIntent
{
    public function __invoke(Request $request): JsonResponse
    {
        try {
            // Get user ID from authenticated user
            $userId = $request->user()->id;

            // Prepare action data
            $actionData = [
                'user_id' => $userId,
            ];

            // Execute action
            $result = GetAnnouncementsAction::run($request->all(), $actionData);

            return response()->json([
                'success' => true,
                'message' => 'Announcements retrieved successfully',
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
                'message' => 'Failed to retrieve announcements: '.$e->getMessage(),
            ], 500);
        }
    }
}
