<?php

namespace Modules\ActivityFeedManagement\Intents\Media\UploadMedia;

use Illuminate\Http\Request;

class UploadMediaIntent
{
    public function __invoke(Request $request)
    {
        try {
            // Validate user input
            $uploadMediaUserDTO = UploadMediaUserDTO::validate($request->all());

            $actionData = [
                'user_id' => $request->user()->id,
            ];

            // Process file uploads
            $result = UploadMediaAction::run($request->all(), $actionData);

            // Determine response status based on results
            $hasErrors = isset($result['errors']) && ! empty($result['errors']);
            $hasUploads = isset($result['uploaded_files']) && ! empty($result['uploaded_files']);

            if ($hasUploads && ! $hasErrors) {
                // All files uploaded successfully
                return response()->json([
                    'success' => true,
                    'message' => 'All files uploaded successfully',
                    'data' => $result,
                ], 200);
            } elseif ($hasUploads && $hasErrors) {
                // Partial success - some files uploaded, some failed
                return response()->json([
                    'success' => true,
                    'message' => 'Some files uploaded successfully, others failed',
                    'data' => $result,
                ], 207); // 207 Multi-Status
            } else {
                // All uploads failed
                return response()->json([
                    'success' => false,
                    'message' => 'All file uploads failed',
                    'data' => $result,
                ], 400);
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Media upload intent failed', [
                'error' => $e->getMessage(),
                'user_id' => $request->user()->id ?? 'unknown',
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'File upload failed: '.$e->getMessage(),
                'data' => null,
            ], 500);
        }
    }
}
