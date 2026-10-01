<?php

namespace Modules\ActivityFeedManagement\Intents\ClassPost\CreateClassPost;

use App\Jobs\DispatchActivityFeedPostNotificationJob;
use App\Services\MediaUploadService;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ActivityFeedManagement\Models\ClassPost;
use Modules\ActivityFeedManagement\Models\ClassPostHashtag;
use Modules\ActivityFeedManagement\Models\ClassPostMedia;

class CreateClassPostAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        $result = DB::transaction(function () use ($payloadArray, $actionData) {
            // Check for idempotency
            if (isset($payloadArray['idempotency_key']) && $payloadArray['idempotency_key']) {
                $existingPost = ClassPost::where('idempotency_key', $payloadArray['idempotency_key'])
                    ->where('author_id', $payloadArray['author_id'] ?? $actionData['user_id'])
                    ->first();

                if ($existingPost) {
                    Log::info('Duplicate class post detected via idempotency key', [
                        'idempotency_key' => $payloadArray['idempotency_key'],
                        'post_id' => $existingPost->id
                    ]);
                    $existingPost->load(['author', 'media', 'hashtags']);
                    return ['post' => $existingPost, 'is_new' => false];
                }
            }

            // Set default values before validation
            if (! isset($payloadArray['school_id']) || $payloadArray['school_id'] === null) {
                $payloadArray['school_id'] = 1;
            }
            if (! isset($payloadArray['type']) || $payloadArray['type'] === null) {
                $payloadArray['type'] = 'post';
            }

            // Handle FormData file uploads - map media[] to media_files for processing
            if (isset($payloadArray['media']) && is_array($payloadArray['media'])) {
                $uploadedFiles = [];
                foreach ($payloadArray['media'] as $index => $file) {
                    if ($file instanceof UploadedFile) {
                        $uploadedFiles[] = $file;
                        Log::info('FormData file detected', [
                            'index' => $index,
                            'filename' => $file->getClientOriginalName(),
                            'size' => $file->getSize(),
                            'mime_type' => $file->getMimeType(),
                        ]);
                    }
                }

                if (! empty($uploadedFiles)) {
                    $payloadArray['media_files'] = $uploadedFiles;
                    Log::info('Mapped media[] to media_files', ['count' => count($uploadedFiles)]);
                }
            }

            // Parse JSON metadata if provided as string (from FormData)
            if (isset($payloadArray['metadata']) && is_string($payloadArray['metadata'])) {
                try {
                    $metadata = json_decode($payloadArray['metadata'], true);
                    if (json_last_error() === JSON_ERROR_NONE) {
                        // Merge metadata into main payload
                        $payloadArray = array_merge($payloadArray, $metadata);
                        Log::info('Parsed FormData metadata', ['metadata_keys' => array_keys($metadata)]);
                    }
                } catch (Exception $e) {
                    Log::warning('Failed to parse FormData metadata', ['error' => $e->getMessage()]);
                }
            }

            // Handle hashtags from FormData (they might come as indexed array)
            if (isset($payloadArray['hashtags'])) {
                if (is_array($payloadArray['hashtags'])) {
                    // Already an array, ensure it's a simple array of strings
                    $payloadArray['hashtags'] = array_values(array_filter($payloadArray['hashtags'], 'is_string'));
                } elseif (is_string($payloadArray['hashtags'])) {
                    // Try to parse as JSON first, then fall back to comma-separated
                    $hashtags = json_decode($payloadArray['hashtags'], true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($hashtags)) {
                        $payloadArray['hashtags'] = $hashtags;
                    } else {
                        // Fall back to comma-separated string
                        $payloadArray['hashtags'] = array_map('trim', explode(',', $payloadArray['hashtags']));
                    }
                }

                Log::info('Processed hashtags', ['hashtags' => $payloadArray['hashtags']]);
            }

            // Create the post
            $postData = [
                'type' => $payloadArray['type'] ?? 'post',
                'category' => $payloadArray['category'] ?? null,
                'title' => $payloadArray['title'],
                'content' => $payloadArray['content'] ?? '',
                'author_id' => $payloadArray['author_id'] ?? $actionData['user_id'],
                'school_id' => $payloadArray['school_id'] ?? 1,
                'class_id' => $payloadArray['class_id'],
                // 'grade_level_class_id' => $payloadArray['grade_level_class_id'] ?? null,
                'comments_count' => 0,
                'is_active' => true,
                'created_by' => $actionData['user_id'],
                'idempotency_key' => $payloadArray['idempotency_key'] ?? null,
            ];

            Log::info('Class post author ID assignment', [
                'formdata_author_id' => $payloadArray['author_id'] ?? null,
                'middleware_user_id' => $actionData['user_id'],
                'final_author_id' => $payloadArray['author_id'] ?? $actionData['user_id'],
            ]);

            $post = ClassPost::create($postData);

            // Create hashtags from request array
            if (isset($payloadArray['hashtags']) && is_array($payloadArray['hashtags'])) {
                foreach ($payloadArray['hashtags'] as $hashtag) {
                    ClassPostHashtag::create([
                        'post_id' => $post->id,
                        'hashtag' => trim($hashtag),
                        'is_active' => true,
                        'created_by' => $actionData['user_id'],
                    ]);
                }
            }

            // Also extract hashtags from content if any exist
            if (! empty($payloadArray['content'])) {
                preg_match_all('/#([a-zA-Z0-9_]+)/', $payloadArray['content'], $matches);

                if (! empty($matches[1])) {
                    foreach (array_unique($matches[1]) as $hashtag) {
                        // Check if hashtag already exists to avoid duplicates
                        $exists = ClassPostHashtag::where('post_id', $post->id)
                            ->where('hashtag', $hashtag)
                            ->exists();

                        if (! $exists) {
                            ClassPostHashtag::create([
                                'post_id' => $post->id,
                                'hashtag' => $hashtag,
                                'is_active' => true,
                                'created_by' => $actionData['user_id'],
                            ]);
                        }
                    }
                }
            }

            // Handle media file uploads if provided
            if (isset($payloadArray['media_files']) && $payloadArray['media_files']) {
                $mediaUploadService = new MediaUploadService;

                foreach ($payloadArray['media_files'] as $index => $uploadedFile) {
                    if ($uploadedFile instanceof UploadedFile) {
                        try {
                            // Upload file and get metadata
                            $mediaData = $mediaUploadService->uploadMedia(
                                $uploadedFile,
                                'class-posts',
                                $post->id,
                                $actionData['user_id']
                            );

                            // Create media record with actual file data
                            ClassPostMedia::create([
                                'post_id' => $post->id,
                                'type' => $mediaData['type'],
                                'url' => $mediaData['url'],
                                'thumbnail_url' => $mediaData['thumbnail_url'],
                                'filename' => $mediaData['filename'],
                                'original_filename' => $mediaData['original_filename'],
                                'size' => $mediaData['size'],
                                'mime_type' => $mediaData['mime_type'],
                                'width' => $mediaData['width'],
                                'height' => $mediaData['height'],
                                'duration' => $mediaData['duration'],
                                'sort_order' => $index + 1,
                                'is_active' => true,
                                'created_by' => $actionData['user_id'],
                            ]);

                        } catch (Exception $e) {
                            // Log detailed error but continue processing other files
                            Log::error('Media upload failed for class post', [
                                'post_id' => $post->id,
                                'file_name' => $uploadedFile->getClientOriginalName(),
                                'file_size' => $uploadedFile->getSize(),
                                'mime_type' => $uploadedFile->getMimeType(),
                                'error' => $e->getMessage(),
                                'error_code' => $e->getCode(),
                                'user_id' => $actionData['user_id'],
                                'context' => 'FormData upload processing',
                            ]);

                            // You could optionally collect errors to return to frontend
                            // For now, continue processing other files
                        }
                    }
                }
            }

            // Handle legacy media metadata (for backward compatibility)
            if (isset($payloadArray['media']) && is_array($payloadArray['media'])) {
                foreach ($payloadArray['media'] as $index => $mediaItem) {
                    ClassPostMedia::create([
                        'post_id' => $post->id,
                        'type' => $mediaItem['type'],
                        'url' => $mediaItem['url'],
                        'thumbnail_url' => $mediaItem['thumbnail_url'] ?? null,
                        'filename' => $mediaItem['filename'],
                        'original_filename' => $mediaItem['original_filename'] ?? $mediaItem['filename'],
                        'size' => $mediaItem['size'],
                        'mime_type' => $mediaItem['mime_type'] ?? null,
                        'width' => $mediaItem['width'] ?? null,
                        'height' => $mediaItem['height'] ?? null,
                        'duration' => $mediaItem['duration'] ?? null,
                        'sort_order' => $index + 1,
                        'is_active' => true,
                        'created_by' => $actionData['user_id'],
                    ]);
                }
            }

            // Load relationships for response
            $post->load(['author', 'media', 'hashtags']);

            return ['post' => $post, 'is_new' => true];
        });

        if ($result['is_new']) {
            DispatchActivityFeedPostNotificationJob::dispatch('class_post', $result['post']->id);
        }

        return $result['post'];
    }
}
