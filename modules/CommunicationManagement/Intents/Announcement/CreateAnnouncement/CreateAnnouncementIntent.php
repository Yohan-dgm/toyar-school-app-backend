<?php

namespace Modules\CommunicationManagement\Intents\Announcement\CreateAnnouncement;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CreateAnnouncementIntent
{
    public function __invoke(Request $request): JsonResponse
    {
        try {
            // Get user ID from authenticated user (or use default for testing)
            $userId = $request->user() ? $request->user()->id : 1;

            // Prepare action data
            $actionData = [
                'created_by' => $userId,
            ];

            // Execute action
            $result = CreateAnnouncementAction::run($request->all(), $actionData);

            return response()->json([
                'success' => true,
                'message' => 'Announcement created successfully',
                'data' => $result,
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create announcement: '.$e->getMessage(),
            ], 500);
        }
    }
}
