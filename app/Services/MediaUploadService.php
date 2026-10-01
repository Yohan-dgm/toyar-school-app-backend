<?php

namespace App\Services;

use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class MediaUploadService
{
    // Configuration constants
    private const BASE_PATH = 'nexis-college/yakkala';

    private const MAX_FILE_SIZE = 50 * 1024 * 1024; // 50MB

    private const IMAGE_MAX_DIMENSION = 1920; // Max width/height for images

    private const THUMBNAIL_SIZE = 300; // Thumbnail dimensions

    private const VIDEO_THUMBNAIL_TIME = 3; // Extract thumbnail at 3 seconds

    // Allowed file types
    private const ALLOWED_IMAGE_TYPES = ['jpg', 'jpeg', 'png', 'webp'];

    private const ALLOWED_VIDEO_TYPES = ['mp4', 'mov', 'avi'];

    private const ALLOWED_PDF_TYPES = ['pdf'];

    private const ALLOWED_MIME_TYPES = [
        'image/jpeg',
        'image/jpg',
        'image/png',
        'image/webp',
        'video/mp4',
        'video/quicktime',
        'video/x-msvideo',
        'application/pdf',
    ];

    /**
     * Upload media file for standalone upload (before post creation)
     *
     * @param  string  $postType  - 'school-posts', 'class-posts', 'student-posts', 'temp-uploads'
     */
    public function uploadMediaStandalone(UploadedFile $file, string $postType, int $userId): array
    {
        try {
            // Validate file
            $this->validateFile($file);

            // Determine media type and get storage path
            $mediaType = $this->getMediaType($file);

            // Use temp storage for standalone uploads
            $storagePath = $this->getStandaloneStoragePath($postType, $mediaType);

            // Generate unique filename for standalone uploads
            $filename = $this->generateStandaloneFilename($file, $userId);
            $fullPath = $storagePath.'/'.$filename;

            Log::info('MediaUploadService: Starting standalone file upload', [
                'original_filename' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'post_type' => $postType,
                'media_type' => $mediaType,
                'storage_path' => $fullPath,
                'user_id' => $userId,
            ]);

            // Process and store file based on type
            $processedData = $this->processAndStoreFile($file, $fullPath, $mediaType);

            // Update fullPath if it was changed during processing
            if (isset($processedData['updated_path'])) {
                $fullPath = $processedData['updated_path'];
                $filename = basename($fullPath);
            }

            // Generate thumbnail if needed
            $thumbnailUrl = null;
            if ($mediaType === 'images' || $mediaType === 'videos') {
                $thumbnailUrl = $this->generateStandaloneThumbnail($fullPath, $mediaType, $postType);
            }

            // Return media metadata for standalone upload
            return [
                'type' => $this->getMediaTypeForDatabase($mediaType),
                'url' => '/storage/'.$fullPath,
                'thumbnail_url' => $thumbnailUrl ? '/storage/'.$thumbnailUrl : null,
                'filename' => $filename,
                'original_filename' => $file->getClientOriginalName(),
                'size' => $processedData['size'],
                'mime_type' => $processedData['mime_type'],
                'width' => $processedData['width'] ?? null,
                'height' => $processedData['height'] ?? null,
                'duration' => $processedData['duration'] ?? null,
                'storage_path' => $fullPath,
                'is_temp' => true,
                'uploaded_at' => now()->toISOString(),
            ];

        } catch (Exception $e) {
            Log::error('MediaUploadService: Standalone upload failed', [
                'error' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'error_file' => $e->getFile().':'.$e->getLine(),
                'original_filename' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'post_type' => $postType,
                'user_id' => $userId,
                'trace' => $e->getTraceAsString(),
            ]);

            // Provide more user-friendly error messages
            $userMessage = match (true) {
                str_contains($e->getMessage(), 'File size exceeds') => 'File size too large. Maximum allowed size is 50MB.',
                str_contains($e->getMessage(), 'File type not allowed') => 'File type not supported. Please use JPG, PNG, MP4, or PDF files.',
                str_contains($e->getMessage(), 'Invalid file upload') => 'File upload is corrupted. Please try again.',
                str_contains($e->getMessage(), 'Storage') => 'Storage error. Please contact administrator.',
                default => 'File upload failed. Please try again or contact support.'
            };

            throw new Exception($userMessage, $e->getCode(), $e);
        }
    }

    /**
     * Upload media file with organized storage (original method for post context)
     *
     * @param  string  $postType  - 'school-posts', 'class-posts', 'student-posts'
     */
    public function uploadMedia(UploadedFile $file, string $postType, int $postId, int $userId): array
    {
        try {
            // Validate file
            $this->validateFile($file);

            // Determine media type and get storage path
            $mediaType = $this->getMediaType($file);
            $storagePath = $this->getStoragePath($postType, $mediaType);

            // Generate unique filename
            $filename = $this->generateUniqueFilename($file, $postId, $userId);
            $fullPath = $storagePath.'/'.$filename;

            Log::info('MediaUploadService: Starting file upload', [
                'original_filename' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'post_type' => $postType,
                'media_type' => $mediaType,
                'storage_path' => $fullPath,
            ]);

            // Process and store file based on type
            $processedData = $this->processAndStoreFile($file, $fullPath, $mediaType);

            // Update fullPath if it was changed during processing (e.g., PNG converted to JPG)
            if (isset($processedData['updated_path'])) {
                $fullPath = $processedData['updated_path'];
                $filename = basename($fullPath);
            }

            // Generate thumbnail if needed
            $thumbnailUrl = null;
            if ($mediaType === 'images' || $mediaType === 'videos') {
                $thumbnailUrl = $this->generateThumbnail($fullPath, $mediaType, $postType, $postId);
            }

            // Return media metadata for database storage
            return [
                'type' => $this->getMediaTypeForDatabase($mediaType),
                'url' => '/storage/'.$fullPath,
                'thumbnail_url' => $thumbnailUrl ? '/storage/'.$thumbnailUrl : null,
                'filename' => $filename,
                'original_filename' => $file->getClientOriginalName(),
                'size' => $processedData['size'],
                'mime_type' => $processedData['mime_type'],
                'width' => $processedData['width'] ?? null,
                'height' => $processedData['height'] ?? null,
                'duration' => $processedData['duration'] ?? null,
            ];

        } catch (Exception $e) {
            Log::error('MediaUploadService: Upload failed', [
                'error' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'error_file' => $e->getFile().':'.$e->getLine(),
                'original_filename' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'post_type' => $postType,
                'post_id' => $postId,
                'user_id' => $userId,
                'storage_path' => $storagePath ?? 'unknown',
                'trace' => $e->getTraceAsString(),
            ]);

            // Provide more user-friendly error messages
            $userMessage = match (true) {
                str_contains($e->getMessage(), 'File size exceeds') => 'File size too large. Maximum allowed size is 50MB.',
                str_contains($e->getMessage(), 'File type not allowed') => 'File type not supported. Please use JPG, PNG, MP4, or PDF files.',
                str_contains($e->getMessage(), 'Invalid file upload') => 'File upload is corrupted. Please try again.',
                str_contains($e->getMessage(), 'Storage') => 'Storage error. Please contact administrator.',
                default => 'File upload failed. Please try again or contact support.'
            };

            throw new Exception($userMessage, $e->getCode(), $e);
        }
    }

    /**
     * Validate uploaded file
     */
    private function validateFile(UploadedFile $file): void
    {
        if (! $file->isValid()) {
            throw new Exception('Invalid file upload');
        }

        if ($file->getSize() > self::MAX_FILE_SIZE) {
            throw new Exception('File size exceeds maximum limit of '.(self::MAX_FILE_SIZE / 1024 / 1024).'MB');
        }

        $mimeType = $file->getMimeType();
        if (! in_array($mimeType, self::ALLOWED_MIME_TYPES)) {
            throw new Exception('File type not allowed: '.$mimeType);
        }

        $extension = strtolower($file->getClientOriginalExtension());
        $allowedExtensions = array_merge(
            self::ALLOWED_IMAGE_TYPES,
            self::ALLOWED_VIDEO_TYPES,
            self::ALLOWED_PDF_TYPES
        );

        if (! in_array($extension, $allowedExtensions)) {
            throw new Exception('File extension not allowed: '.$extension);
        }
    }

    /**
     * Determine media type from file
     */
    private function getMediaType(UploadedFile $file): string
    {
        $extension = strtolower($file->getClientOriginalExtension());

        if (in_array($extension, self::ALLOWED_IMAGE_TYPES)) {
            return 'images';
        } elseif (in_array($extension, self::ALLOWED_VIDEO_TYPES)) {
            return 'videos';
        } elseif (in_array($extension, self::ALLOWED_PDF_TYPES)) {
            return 'pdf';
        }

        throw new Exception('Unable to determine media type for extension: '.$extension);
    }

    /**
     * Get media type for database storage
     */
    private function getMediaTypeForDatabase(string $mediaType): string
    {
        return match ($mediaType) {
            'images' => 'image',
            'videos' => 'video',
            'pdf' => 'pdf',
            default => $mediaType
        };
    }

    /**
     * Get storage path for media type and post type
     */
    private function getStoragePath(string $postType, string $mediaType): string
    {
        // Validate post type and map to correct storage path with media type subdirectories
        $storagePath = match ($postType) {
            'school-posts' => self::BASE_PATH.'/school-posts/'.$mediaType,
            'class-posts' => self::BASE_PATH.'/class-posts/'.$mediaType,
            'student-posts' => self::BASE_PATH.'/student-posts/'.$mediaType,
            default => throw new Exception("Invalid post type: {$postType}")
        };

        return $storagePath;
    }

    /**
     * Get storage path for standalone uploads (temp storage)
     */
    private function getStandaloneStoragePath(string $postType, string $mediaType): string
    {
        if ($postType === 'chat-media') {
            return self::BASE_PATH.'/chat/media/'.$mediaType;
        }

        // For all standalone uploads, organize by media type only under temp-uploads
        return self::BASE_PATH.'/temp-uploads/'.$mediaType;
    }

    /**
     * Generate unique filename
     */
    private function generateUniqueFilename(UploadedFile $file, int $postId, int $userId): string
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $timestamp = time();
        $random = substr(md5(random_bytes(16)), 0, 8);

        return "post-{$postId}-user-{$userId}-{$timestamp}-{$random}.{$extension}";
    }

    /**
     * Generate unique filename for standalone uploads
     */
    private function generateStandaloneFilename(UploadedFile $file, int $userId): string
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $timestamp = time();
        $microtime = (int) (microtime(true) * 1000); // Include microseconds for uniqueness
        $random = substr(md5(random_bytes(16)), 0, 8);

        return "temp-{$userId}-{$timestamp}-{$microtime}-{$random}.{$extension}";
    }

    /**
     * Process and store file based on type
     */
    private function processAndStoreFile(UploadedFile $file, string $fullPath, string $mediaType): array
    {
        $processedData = [
            'size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
        ];

        if ($mediaType === 'images') {
            // Process and optimize image
            $processedData = array_merge($processedData, $this->processImage($file, $fullPath));
        } else {
            // Store file as-is for videos and PDFs
            Storage::disk('public')->putFileAs(
                dirname($fullPath),
                $file,
                basename($fullPath)
            );

            if ($mediaType === 'videos') {
                // Try to get video dimensions and duration
                $videoInfo = $this->getVideoInfo(Storage::disk('public')->path($fullPath));
                $processedData = array_merge($processedData, $videoInfo);
            }
        }

        return $processedData;
    }

    /**
     * Process and optimize image
     */
    private function processImage(UploadedFile $file, string $fullPath): array
    {
        try {
            $manager = new ImageManager(new Driver);
            $image = $manager->read($file->getPathname());

            $originalWidth = $image->width();
            $originalHeight = $image->height();

            // Resize if image is too large
            if ($originalWidth > self::IMAGE_MAX_DIMENSION || $originalHeight > self::IMAGE_MAX_DIMENSION) {
                $image->scaleDown(width: self::IMAGE_MAX_DIMENSION, height: self::IMAGE_MAX_DIMENSION);
            }

            // Convert to JPEG for consistency and better compression
            $encodedImage = $image->toJpeg(quality: 85);

            // Store processed image
            Storage::disk('public')->put($fullPath, (string) $encodedImage);

            // Update filename extension to .jpg if it was converted
            $updatedPath = $fullPath;
            if (! str_ends_with($fullPath, '.jpg') && ! str_ends_with($fullPath, '.jpeg')) {
                $newPath = preg_replace('/\.[^.]+$/', '.jpg', $fullPath);
                Storage::disk('public')->move($fullPath, $newPath);
                $updatedPath = $newPath;
            }

            return [
                'width' => $image->width(),
                'height' => $image->height(),
                'size' => Storage::disk('public')->size($updatedPath),
                'mime_type' => 'image/jpeg',
                'updated_path' => $updatedPath,
            ];

        } catch (Exception $e) {
            Log::error('Image processing failed, storing original', ['error' => $e->getMessage()]);

            // Fallback: store original file
            Storage::disk('public')->putFileAs(
                dirname($fullPath),
                $file,
                basename($fullPath)
            );

            return [
                'width' => null,
                'height' => null,
            ];
        }
    }

    /**
     * Generate thumbnail for images and videos
     */
    private function generateThumbnail(string $filePath, string $mediaType, string $postType, int $postId): ?string
    {
        try {
            $thumbnailPath = $this->getThumbnailPath($postType, $filePath, $postId);

            if ($mediaType === 'images') {
                return $this->generateImageThumbnail($filePath, $thumbnailPath);
            } elseif ($mediaType === 'videos') {
                return $this->generateVideoThumbnail($filePath, $thumbnailPath);
            }

        } catch (Exception $e) {
            Log::error('Thumbnail generation failed', [
                'error' => $e->getMessage(),
                'file_path' => $filePath,
                'media_type' => $mediaType,
            ]);
        }

        return null;
    }

    /**
     * Generate thumbnail for standalone uploads
     */
    private function generateStandaloneThumbnail(string $filePath, string $mediaType, string $postType): ?string
    {
        try {
            $thumbnailPath = $this->getStandaloneThumbnailPath($postType, $filePath);

            if ($mediaType === 'images') {
                return $this->generateImageThumbnail($filePath, $thumbnailPath);
            } elseif ($mediaType === 'videos') {
                return $this->generateVideoThumbnail($filePath, $thumbnailPath);
            }

        } catch (Exception $e) {
            Log::error('Standalone thumbnail generation failed', [
                'error' => $e->getMessage(),
                'file_path' => $filePath,
                'media_type' => $mediaType,
                'post_type' => $postType,
            ]);
        }

        return null;
    }

    /**
     * Get thumbnail storage path
     */
    private function getThumbnailPath(string $postType, string $originalPath, int $postId): string
    {
        $filename = pathinfo($originalPath, PATHINFO_FILENAME);

        // Map post types to correct thumbnail storage paths (thumbnails stored at post type level)
        $thumbnailDir = match ($postType) {
            'school-posts' => self::BASE_PATH.'/school-posts/thumbnails',
            'class-posts' => self::BASE_PATH.'/class-posts/thumbnails',
            'student-posts' => self::BASE_PATH.'/student-posts/thumbnails',
            default => self::BASE_PATH.'/'.$postType.'/thumbnails'
        };

        return $thumbnailDir.'/thumb-'.$filename.'.jpg';
    }

    /**
     * Get thumbnail storage path for standalone uploads
     */
    private function getStandaloneThumbnailPath(string $postType, string $originalPath): string
    {
        $filename = pathinfo($originalPath, PATHINFO_FILENAME);

        if ($postType === 'chat-media') {
            $thumbnailDir = self::BASE_PATH.'/chat/thumbnails';
        } else {
            // For all standalone uploads, thumbnails are stored in temp-uploads/thumbnails
            $thumbnailDir = self::BASE_PATH.'/temp-uploads/thumbnails';
        }

        return $thumbnailDir.'/thumb-'.$filename.'.jpg';
    }

    /**
     * Generate image thumbnail
     */
    private function generateImageThumbnail(string $imagePath, string $thumbnailPath): ?string
    {
        try {
            $fullImagePath = Storage::disk('public')->path($imagePath);

            $manager = new ImageManager(new Driver);
            $image = $manager->read($fullImagePath);

            // Create thumbnail
            $thumbnail = $image->coverDown(self::THUMBNAIL_SIZE, self::THUMBNAIL_SIZE);
            $encodedThumbnail = $thumbnail->toJpeg(quality: 80);

            // Store thumbnail
            Storage::disk('public')->put($thumbnailPath, (string) $encodedThumbnail);

            return $thumbnailPath;

        } catch (Exception $e) {
            Log::error('Image thumbnail generation failed', ['error' => $e->getMessage()]);

            return null;
        }
    }

    /**
     * Generate video thumbnail using FFmpeg (3-second frame)
     */
    private function generateVideoThumbnail(string $videoPath, string $thumbnailPath): ?string
    {
        try {
            $fullVideoPath = Storage::disk('public')->path($videoPath);
            $fullThumbnailPath = Storage::disk('public')->path($thumbnailPath);

            // Create thumbnail directory if it doesn't exist
            $thumbnailDir = dirname($fullThumbnailPath);
            if (! is_dir($thumbnailDir)) {
                mkdir($thumbnailDir, 0755, true);
            }

            // Use FFmpeg to extract frame at 3 seconds
            $command = sprintf(
                'ffmpeg -i %s -ss 00:00:03 -vframes 1 -y %s 2>/dev/null',
                escapeshellarg($fullVideoPath),
                escapeshellarg($fullThumbnailPath)
            );

            exec($command, $output, $returnCode);

            if ($returnCode === 0 && file_exists($fullThumbnailPath)) {
                Log::info('Video thumbnail generated successfully', [
                    'video_path' => $videoPath,
                    'thumbnail_path' => $thumbnailPath,
                ]);

                return $thumbnailPath;
            }

            // Fallback: create a placeholder thumbnail
            return $this->createVideoPlaceholder($thumbnailPath);

        } catch (Exception $e) {
            Log::error('Video thumbnail generation failed', ['error' => $e->getMessage()]);

            return $this->createVideoPlaceholder($thumbnailPath);
        }
    }

    /**
     * Create placeholder thumbnail for videos
     */
    private function createVideoPlaceholder(string $thumbnailPath): string
    {
        try {
            $manager = new ImageManager(new Driver);

            // Create a simple placeholder image
            $placeholder = $manager->create(self::THUMBNAIL_SIZE, self::THUMBNAIL_SIZE)
                ->fill('#2563eb'); // Blue background

            // Add play icon or text (simple approach)
            $encoded = $placeholder->toJpeg(quality: 80);
            Storage::disk('public')->put($thumbnailPath, (string) $encoded);

            return $thumbnailPath;

        } catch (Exception $e) {
            Log::error('Video placeholder creation failed', ['error' => $e->getMessage()]);

            return null;
        }
    }

    /**
     * Get video information (dimensions, duration)
     */
    private function getVideoInfo(string $videoPath): array
    {
        try {
            $command = sprintf('ffprobe -v quiet -print_format json -show_format -show_streams %s', escapeshellarg($videoPath));
            $output = shell_exec($command);

            if ($output) {
                $info = json_decode($output, true);

                $width = null;
                $height = null;
                $duration = null;

                // Extract video stream info
                if (isset($info['streams'])) {
                    foreach ($info['streams'] as $stream) {
                        if ($stream['codec_type'] === 'video') {
                            $width = $stream['width'] ?? null;
                            $height = $stream['height'] ?? null;
                            break;
                        }
                    }
                }

                // Extract duration
                if (isset($info['format']['duration'])) {
                    $duration = (float) $info['format']['duration'];
                }

                return [
                    'width' => $width,
                    'height' => $height,
                    'duration' => $duration,
                ];
            }

        } catch (Exception $e) {
            Log::error('Video info extraction failed', ['error' => $e->getMessage()]);
        }

        return ['width' => null, 'height' => null, 'duration' => null];
    }

    /**
     * Delete media file and its thumbnail
     */
    public function deleteMedia(string $filePath, ?string $thumbnailPath = null): bool
    {
        try {
            $deleted = true;

            // Delete main file
            if (Storage::disk('public')->exists($filePath)) {
                $deleted = Storage::disk('public')->delete($filePath) && $deleted;
            }

            // Delete thumbnail
            if ($thumbnailPath && Storage::disk('public')->exists($thumbnailPath)) {
                $deleted = Storage::disk('public')->delete($thumbnailPath) && $deleted;
            }

            return $deleted;

        } catch (Exception $e) {
            Log::error('Media deletion failed', ['error' => $e->getMessage()]);

            return false;
        }
    }

    /**
     * Get file URL for serving
     */
    public static function getFileUrl(string $path): string
    {
        return url('/storage/'.ltrim($path, '/'));
    }
}
