<?php

namespace Modules\CommunicationManagement\Intents\Chat\UploadVoiceNote;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UploadVoiceNoteIntent
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

            $result = UploadVoiceNoteAction::run($request->all(), ['user_id' => $user->id]);

            return response()->json([
                'success' => true,
                'message' => 'Voice note uploaded successfully',
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
                'message' => 'Failed to upload voice note: '.$e->getMessage(),
            ], 500);
        }
    }
}
