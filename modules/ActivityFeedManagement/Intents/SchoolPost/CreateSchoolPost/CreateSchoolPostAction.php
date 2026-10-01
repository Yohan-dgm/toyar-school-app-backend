<?php

namespace Modules\ActivityFeedManagement\Intents\SchoolPost\CreateSchoolPost;

use App\Jobs\DispatchActivityFeedPostNotificationJob;
use App\Services\MediaUploadService;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ActivityFeedManagement\Models\SchoolPost;
use Modules\ActivityFeedManagement\Models\SchoolPostHashtag;
use Modules\ActivityFeedManagement\Models\SchoolPostMedia;

class CreateSchoolPostAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        $result = DB::transaction(function () use ($payloadArray, $actionData) {
            // Check for idempotency
            if (isset($payloadArray['idempotency_key']) && $payloadArray['idempotency_key']) {
                $existingPost = SchoolPost::where('idempotency_key', $payloadArray['idempotency_key'])
                    ->where('author_id', $payloadArray['author_id'] ?? $actionData['user_id'])
                    ->first();

                if ($existingPost) {
                    Log::info('Duplicate school post detected via idempotency key', [
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

            // Handle New FormData Structure (Profile Upload Pattern)
            $mediaCount = intval($payloadArray['media_count'] ?? 0);
            $uploadedFiles = [];

            if ($mediaCount > 0) {
                Log::info('Processing new FormData structure', ['media_count' => $mediaCount]);

                for ($i = 0; $i < $mediaCount; $i++) {
                    $mediaKey = "media_{$i}";
                    $typeKey = "media_{$i}_type";
                    $sizeKey = "media_{$i}_size";

                    if (isset($payloadArray[$mediaKey]) && is_array($payloadArray[$mediaKey])) {
                        $mediaObject = $payloadArray[$mediaKey];

                        // Handle file object structure {uri, type, name}
                        if (isset($mediaObject['uri']) && file_exists($mediaObject['uri'])) {
                            try {
                                // Create UploadedFile from local file path (similar to profile upload)
                                $uploadedFile = new UploadedFile(
                                    $mediaObject['uri'],
                                    $mediaObject['name'] ?? 'file_'.$i,
                                    $mediaObject['type'] ?? null,
                                    null,
                                    true // test mode
                                );

                                $uploadedFiles[] = $uploadedFile;

                                Log::info('Processed indexed FormData file', [
                                    'index' => $i,
                                    'filename' => $mediaObject['name'] ?? 'unknown',
                                    'uri' => $mediaObject['uri'],
                                    'type' => $mediaObject['type'] ?? 'unknown',
                                    'media_type' => $payloadArray[$typeKey] ?? 'unknown',
                                    'size' => $payloadArray[$sizeKey] ?? 'unknown',
                                ]);

                            } catch (Exception $e) {
                                Log::warning('Failed to process indexed media file', [
                                    'index' => $i,
                                    'media_object' => $mediaObject,
                                    'error' => $e->getMessage(),
                                ]);
                            }
                        }
                    }
                }
            }

            // Legacy: Handle FormData file uploads - map media[] to media_files for processing
            if (isset($payloadArray['media']) && is_array($payloadArray['media']) && $mediaCount === 0) {
                Log::info('Processing legacy FormData structure');
                foreach ($payloadArray['media'] as $index => $file) {
                    if ($file instanceof UploadedFile) {
                        $uploadedFiles[] = $file;
                        Log::info('Legacy FormData file detected', [
                            'index' => $index,
                            'filename' => $file->getClientOriginalName(),
                            'size' => $file->getSize(),
                            'mime_type' => $file->getMimeType(),
                        ]);
                    }
                }
            }

            if (! empty($uploadedFiles)) {
                $payloadArray['media_files'] = $uploadedFiles;
                Log::info('Mapped files to media_files', [
                    'count' => count($uploadedFiles),
                    'processing_type' => $mediaCount > 0 ? 'indexed' : 'legacy',
                ]);
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

            // Handle hashtags - support both new indexed format and legacy formats
            if (isset($payloadArray['hashtags'])) {
                if (is_array($payloadArray['hashtags'])) {
                    // Check if it's indexed format (hashtags[0], hashtags[1], etc.)
                    $isIndexedFormat = array_keys($payloadArray['hashtags']) === range(0, count($payloadArray['hashtags']) - 1);

                    if ($isIndexedFormat) {
                        // New indexed format - already properly structured
                        $payloadArray['hashtags'] = array_values(array_filter($payloadArray['hashtags'], 'is_string'));
                        Log::info('Processed indexed hashtags', ['hashtags' => $payloadArray['hashtags']]);
                    } else {
                        // Legacy array format
                        $payloadArray['hashtags'] = array_values(array_filter($payloadArray['hashtags'], 'is_string'));
                        Log::info('Processed legacy array hashtags', ['hashtags' => $payloadArray['hashtags']]);
                    }
                } elseif (is_string($payloadArray['hashtags'])) {
                    // Try to parse as JSON first, then fall back to comma-separated
                    $hashtags = json_decode($payloadArray['hashtags'], true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($hashtags)) {
                        $payloadArray['hashtags'] = $hashtags;
                        Log::info('Processed JSON string hashtags', ['hashtags' => $payloadArray['hashtags']]);
                    } else {
                        // Fall back to comma-separated string
                        $payloadArray['hashtags'] = array_map('trim', explode(',', $payloadArray['hashtags']));
                        Log::info('Processed comma-separated hashtags', ['hashtags' => $payloadArray['hashtags']]);
                    }
                }
            }

            // User Data Validation
            $createSchoolPostUserDTO = CreateSchoolPostUserDTO::validate($payloadArray);

            // System Data Prep - Use author_id from FormData if provided, otherwise use user_id
            $system_data = [];
            $system_data['author_id'] = $payloadArray['author_id'] ?? $actionData['user_id'];
            $system_data['created_by'] = $actionData['user_id'];

            Log::info('Author ID assignment', [
                'formdata_author_id' => $payloadArray['author_id'] ?? null,
                'middleware_user_id' => $actionData['user_id'],
                'final_author_id' => $system_data['author_id'],
            ]);

            // System Data Validation
            $createSchoolPostSystemDTO = CreateSchoolPostSystemDTO::validate($system_data);

            // Final Data Validation
            $createSchoolPostDTO = CreateSchoolPostDTO::validate(array_merge($createSchoolPostUserDTO, $createSchoolPostSystemDTO));

            // Create the post
            $postData = [
                'type' => $createSchoolPostDTO['type'] ?? 'post',
                'category' => $createSchoolPostDTO['category'],
                'title' => $createSchoolPostDTO['title'],
                'content' => $createSchoolPostDTO['content'],
                'author_id' => $createSchoolPostDTO['author_id'],
                'school_id' => $createSchoolPostDTO['school_id'] ?? 1,
                'comments_count' => 0,
                'is_active' => true,
                'created_by' => $createSchoolPostDTO['created_by'],
                'idempotency_key' => $payloadArray['idempotency_key'] ?? null,
            ];

            $post = SchoolPost::create($postData);

            // Create hashtags from request
            if (! empty($createSchoolPostDTO['hashtags'])) {
                foreach ($createSchoolPostDTO['hashtags'] as $hashtag) {
                    SchoolPostHashtag::create([
                        'post_id' => $post->id,
                        'hashtag' => trim($hashtag),
                        'is_active' => true,
                        'created_by' => $createSchoolPostDTO['created_by'],
                    ]);
                }
            }

            // Also extract hashtags from content if any exist
            if (! empty($createSchoolPostDTO['content'])) {
                preg_match_all('/#([a-zA-Z0-9_]+)/', $createSchoolPostDTO['content'], $matches);

                if (! empty($matches[1])) {
                    foreach (array_unique($matches[1]) as $hashtag) {
                        // Check if hashtag already exists to avoid duplicates
                        $exists = SchoolPostHashtag::where('post_id', $post->id)
                            ->where('hashtag', $hashtag)
                            ->exists();

                        if (! $exists) {
                            SchoolPostHashtag::create([
                                'post_id' => $post->id,
                                'hashtag' => $hashtag,
                                'is_active' => true,
                                'created_by' => $createSchoolPostDTO['created_by'],
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
                                'school-posts',
                                $post->id,
                                $actionData['user_id']
                            );

                            // Create media record with actual file data
                            SchoolPostMedia::create([
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
                            Log::error('Media upload failed for school post', [
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
            if (isset($createSchoolPostDTO['media']) && $createSchoolPostDTO['media']) {
                foreach ($createSchoolPostDTO['media'] as $index => $mediaItem) {
                    SchoolPostMedia::create([
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
                        'created_by' => $createSchoolPostDTO['created_by'],
                    ]);
                }
            }

            // Load relationships for response
            $post->load(['author', 'media', 'hashtags']);

            return ['post' => $post, 'is_new' => true];
        });

        if ($result['is_new']) {
            DispatchActivityFeedPostNotificationJob::dispatch('school_post', $result['post']->id);
        }

        return $result['post'];
    }
}
