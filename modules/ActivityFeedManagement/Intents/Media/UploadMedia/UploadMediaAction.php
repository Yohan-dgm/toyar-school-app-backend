<?php

namespace Modules\ActivityFeedManagement\Intents\Media\UploadMedia;

use App\Services\MediaUploadService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Lorisleiva\Actions\Concerns\AsAction;

class UploadMediaAction
{
    use AsAction;

    private MediaUploadService $mediaUploadService;

    public function __construct()
    {
        $this->mediaUploadService = new MediaUploadService;
    }

    public function handle($payloadArray, $actionData)
    {
        return DB::transaction(function () use ($payloadArray, $actionData) {
            Log::info('Media upload started', [
                'user_id' => $actionData['user_id'],
                'post_type' => $payloadArray['post_type'] ?? 'general',
                'request_data_keys' => array_keys($payloadArray),
            ]);

            $uploadedFiles = [];
            $errors = [];
            $fileCount = 0;

            // Process indexed files: file_0, file_1, file_2, etc.
            for ($i = 0; $i < 10; $i++) { // Max 10 files
                $fileKey = "file_{$i}";

                if (isset($payloadArray[$fileKey]) && $payloadArray[$fileKey] instanceof \Illuminate\Http\UploadedFile) {
                    $file = $payloadArray[$fileKey];
                    $fileCount++;

                    Log::info('Processing indexed file', [
                        'index' => $i,
                        'filename' => $file->getClientOriginalName(),
                        'size' => $file->getSize(),
                        'mime_type' => $file->getMimeType(),
                    ]);

                    try {
                        // Upload file using standalone method
                        $mediaData = $this->mediaUploadService->uploadMediaStandalone(
                            $file,
                            $payloadArray['post_type'] ?? 'temp-uploads',
                            $actionData['user_id']
                        );

                        // Add file index and unique ID for tracking
                        $mediaData['file_index'] = $i;
                        $mediaData['file_id'] = $this->generateFileId($mediaData, $actionData['user_id']);

                        $uploadedFiles[] = $mediaData;

                        Log::info('File uploaded successfully', [
                            'index' => $i,
                            'file_id' => $mediaData['file_id'],
                            'filename' => $mediaData['filename'],
                            'type' => $mediaData['type'],
                            'size' => $mediaData['size'],
                        ]);

                    } catch (Exception $e) {
                        $error = [
                            'file_index' => $i,
                            'filename' => $file->getClientOriginalName(),
                            'error' => $e->getMessage(),
                        ];

                        $errors[] = $error;

                        Log::error('File upload failed', [
                            'index' => $i,
                            'filename' => $file->getClientOriginalName(),
                            'error' => $e->getMessage(),
                            'user_id' => $actionData['user_id'],
                        ]);
                    }
                }
            }

            // Validate results
            if (empty($uploadedFiles) && empty($errors)) {
                throw new Exception('No files were provided for upload.');
            }

            if (! empty($errors) && empty($uploadedFiles)) {
                throw new Exception('All file uploads failed: '.json_encode($errors));
            }

            $response = [
                'uploaded_files' => $uploadedFiles,
                'upload_count' => count($uploadedFiles),
                'error_count' => count($errors),
                'temp_storage' => true,
                'post_type' => $payloadArray['post_type'] ?? 'temp-uploads',
            ];

            // Include errors if any occurred
            if (! empty($errors)) {
                $response['errors'] = $errors;
            }

            Log::info('Media upload completed', [
                'user_id' => $actionData['user_id'],
                'total_files_processed' => $fileCount,
                'successful_uploads' => count($uploadedFiles),
                'failed_uploads' => count($errors),
                'post_type' => $payloadArray['post_type'] ?? 'temp-uploads',
            ]);

            return $response;
        });
    }

    /**
     * Generate unique file ID for tracking
     */
    private function generateFileId(array $mediaData, int $userId): string
    {
        $timestamp = time();
        $filename = pathinfo($mediaData['filename'], PATHINFO_FILENAME);
        $hash = substr(md5($mediaData['url'].$userId.$timestamp), 0, 8);

        return "file_{$userId}_{$timestamp}_{$hash}";
    }
}
