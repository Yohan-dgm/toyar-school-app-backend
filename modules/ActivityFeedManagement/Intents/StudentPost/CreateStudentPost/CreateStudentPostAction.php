<?php

namespace Modules\ActivityFeedManagement\Intents\StudentPost\CreateStudentPost;

use App\Jobs\DispatchActivityFeedPostNotificationJob;
use App\Services\MediaUploadService;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ActivityFeedManagement\Models\StudentPost;
use Modules\ActivityFeedManagement\Models\StudentPostHashtag;
use Modules\ActivityFeedManagement\Models\StudentPostMedia;

class CreateStudentPostAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        $transactionResult = DB::transaction(function () use ($payloadArray, $actionData) {
            // Check for idempotency
            if (isset($payloadArray['idempotency_key']) && $payloadArray['idempotency_key']) {
                $existingPosts = StudentPost::where('idempotency_key', $payloadArray['idempotency_key'])
                    ->where('author_id', $payloadArray['author_id'] ?? $actionData['user_id'])
                    ->get();

                if ($existingPosts->isNotEmpty()) {
                    Log::info('Duplicate student post(s) detected via idempotency key', [
                        'idempotency_key' => $payloadArray['idempotency_key'],
                        'count' => $existingPosts->count()
                    ]);
                    $existingPosts->load(['author', 'media', 'hashtags']);

                    return ['posts' => $existingPosts->all(), 'is_new' => false];
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

            // Determine student IDs (support both single and multiple)
            $studentIds = [];
            if (isset($payloadArray['student_ids']) && is_array($payloadArray['student_ids'])) {
                $studentIds = $payloadArray['student_ids'];
            } elseif (isset($payloadArray['student_id'])) {
                $studentIds = [$payloadArray['student_id']];
            }

            if (empty($studentIds)) {
                throw new Exception('No student IDs provided');
            }

            // Process media once before the loop if provided as files
            $processedMediaData = [];
            if (isset($payloadArray['media_files']) && !empty($payloadArray['media_files'])) {
                $mediaUploadService = new MediaUploadService;
                foreach ($payloadArray['media_files'] as $index => $uploadedFile) {
                    if ($uploadedFile instanceof UploadedFile) {
                        try {
                            $mediaData = $mediaUploadService->uploadMedia(
                                $uploadedFile,
                                'student-posts',
                                null, // Temporarily null, will associate with each post later
                                $actionData['user_id']
                            );
                            $processedMediaData[] = $mediaData;
                        } catch (Exception $e) {
                            Log::error('Media pre-upload failed for student post', [
                                'file_name' => $uploadedFile->getClientOriginalName(),
                                'error' => $e->getMessage(),
                            ]);
                        }
                    }
                }
            }

            // Also handle pre-uploaded media metadata (two-step process)
            if (isset($payloadArray['media']) && is_array($payloadArray['media'])) {
                foreach ($payloadArray['media'] as $mediaItem) {
                    $processedMediaData[] = $mediaItem;
                }
            }

            $createdPosts = [];

            foreach ($studentIds as $studentId) {
                // Create the post
                $postData = [
                    'type' => $payloadArray['type'] ?? 'post',
                    'category' => $payloadArray['category'] ?? null,
                    'title' => $payloadArray['title'],
                    'content' => $payloadArray['content'] ?? '',
                    'author_id' => $payloadArray['author_id'] ?? $actionData['user_id'],
                    'school_id' => $payloadArray['school_id'],
                    'class_id' => $payloadArray['class_id'] ?? null,
                    'student_id' => $studentId,
                    'comments_count' => 0,
                    'is_active' => true,
                    'created_by' => $actionData['user_id'],
                    'idempotency_key' => $payloadArray['idempotency_key'] ?? null,
                ];

                $post = StudentPost::create($postData);

                // Create hashtags
                if (isset($payloadArray['hashtags']) && is_array($payloadArray['hashtags'])) {
                    foreach ($payloadArray['hashtags'] as $hashtag) {
                        StudentPostHashtag::create([
                            'post_id' => $post->id,
                            'hashtag' => trim($hashtag),
                            'is_active' => true,
                            'created_by' => $actionData['user_id'],
                        ]);
                    }
                }

                // Extract hashtags from content
                if (! empty($payloadArray['content'])) {
                    preg_match_all('/#([a-zA-Z0-9_]+)/', $payloadArray['content'], $matches);
                    if (! empty($matches[1])) {
                        foreach (array_unique($matches[1]) as $hashtag) {
                            $exists = StudentPostHashtag::where('post_id', $post->id)
                                ->where('hashtag', $hashtag)
                                ->exists();

                            if (! $exists) {
                                StudentPostHashtag::create([
                                    'post_id' => $post->id,
                                    'hashtag' => $hashtag,
                                    'is_active' => true,
                                    'created_by' => $actionData['user_id'],
                                ]);
                            }
                        }
                    }
                }

                // Associate media
                foreach ($processedMediaData as $index => $mediaData) {
                    StudentPostMedia::create([
                        'post_id' => $post->id,
                        'type' => $mediaData['type'],
                        'url' => $mediaData['url'],
                        'thumbnail_url' => $mediaData['thumbnail_url'] ?? null,
                        'filename' => $mediaData['filename'],
                        'original_filename' => $mediaData['original_filename'] ?? $mediaData['filename'],
                        'size' => $mediaData['size'],
                        'mime_type' => $mediaData['mime_type'] ?? null,
                        'width' => $mediaData['width'] ?? null,
                        'height' => $mediaData['height'] ?? null,
                        'duration' => $mediaData['duration'] ?? null,
                        'sort_order' => $index + 1,
                        'is_active' => true,
                        'created_by' => $actionData['user_id'],
                    ]);
                }

                $post->load(['author', 'media', 'hashtags']);
                $createdPosts[] = $post;
            }

            return ['posts' => $createdPosts, 'is_new' => true];
        });

        if ($transactionResult['is_new']) {
            foreach ($transactionResult['posts'] as $post) {
                DispatchActivityFeedPostNotificationJob::dispatch('student_post', $post->id);
            }
        }

        $posts = $transactionResult['posts'];

        return count($posts) === 1 ? $posts[0] : [
            'posts' => $posts,
            'count' => count($posts)
        ];
    }
}
