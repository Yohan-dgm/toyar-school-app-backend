<?php

namespace Modules\CommunicationManagement\Services;

use App\Services\MediaUploadService;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Modules\CommunicationManagement\Models\FileUpload;

class ChunkedUploadService
{
    private MediaUploadService $mediaUploadService;
    private const CHUNKS_DISK = 'local'; // Store active chunks in private storage

    public function __construct(MediaUploadService $mediaUploadService)
    {
        $this->mediaUploadService = $mediaUploadService;
    }

    /**
     * Initialize a new chunked upload session
     */
    public function initialize(int $userId, string $filename, int $totalSize, ?string $mimeType = null): FileUpload
    {
        // Basic validation
        if ($totalSize > 50 * 1024 * 1024) { // 50MB limit
            throw new Exception("File size exceeds 50MB limit.");
        }

        // Ensure chunks directory exists
        $disk = Storage::disk(self::CHUNKS_DISK);
        if (!$disk->exists('chunks')) {
            $disk->makeDirectory('chunks');
        }

        $fileUpload = FileUpload::create([
            'user_id' => $userId,
            'filename' => $filename,
            'mime_type' => $mimeType,
            'total_size' => $totalSize,
            'uploaded_size' => 0,
            'status' => 'pending',
            'storage_path' => "chunks/{$userId}_" . time() . "_" . uniqid(),
            'metadata' => [
                'original_filename' => $filename,
                'started_at' => now()->toIso8601String(),
            ],
        ]);

        return $fileUpload;
    }

    /**
     * Append a chunk to the upload
     */
    public function appendChunk(FileUpload $fileUpload, UploadedFile $chunk, int $offset): FileUpload
    {
        if ($fileUpload->status === 'completed') {
            throw new Exception("Upload already completed.");
        }

        // Validate offset
        if ($offset !== $fileUpload->uploaded_size) {
            throw new Exception("Invalid offset. Expected {$fileUpload->uploaded_size}, got {$offset}.");
        }

        $chunkPath = $fileUpload->storage_path;
        $disk = Storage::disk(self::CHUNKS_DISK);

        // Append content
        $stream = fopen($chunk->getRealPath(), 'r');
        if (!$disk->exists($chunkPath)) {
            $disk->put($chunkPath, $stream);
        } else {
            // Append to existing file
            // Laravel's Storage doesn't have a native append for streams easily across all drivers 
            // but for local driver we can use standard PHP
            $fullPath = $disk->path($chunkPath);
            File::append($fullPath, file_get_contents($chunk->getRealPath()));
        }
        fclose($stream);

        // Update progress
        $fileUpload->uploaded_size += $chunk->getSize();
        $fileUpload->status = 'uploading';
        $fileUpload->save();

        return $fileUpload;
    }

    /**
     * Finalize the upload, process the file, and move to permanent storage
     */
    public function finalize(FileUpload $fileUpload): array
    {
        if ($fileUpload->uploaded_size < $fileUpload->total_size) {
            throw new Exception("File upload incomplete. Uploaded {$fileUpload->uploaded_size}/{$fileUpload->total_size} bytes.");
        }

        $disk = Storage::disk(self::CHUNKS_DISK);
        $tempPath = $disk->path($fileUpload->storage_path);

        if (!file_exists($tempPath)) {
            throw new Exception("Temporary file not found.");
        }

        try {
            // Create a fake UploadedFile from the temporary file to reuse MediaUploadService logic
            // Note: MediaUploadService uses Storage::disk('public') for permanent storage
            $mimeType = $fileUpload->mime_type ?: File::mimeType($tempPath);
            $extension = pathinfo($fileUpload->filename, PATHINFO_EXTENSION);
            
            $uploadedFile = new UploadedFile(
                $tempPath,
                $fileUpload->filename,
                $mimeType,
                null,
                true // Test mode to allow non-POSTed file
            );

            // Use MediaUploadService to process and store permanently
            // We'll use 'chat-media' as the postType
            $result = $this->mediaUploadService->uploadMediaStandalone(
                $uploadedFile,
                'chat-media',
                $fileUpload->user_id
            );

            // Store old chunk path for cleanup
            $chunkPath = $fileUpload->storage_path;

            // Update status and save permanent path
            $fileUpload->status = 'completed';
            $fileUpload->storage_path = $result['storage_path'];
            $fileUpload->save();

            // Clean up temporary chunk using the saved path
            $disk->delete($chunkPath);

            return $result;

        } catch (Exception $e) {
            $fileUpload->status = 'failed';
            $fileUpload->save();
            Log::error("Failed to finalize chunked upload: " . $e->getMessage());
            throw $e;
        }
    }
}
