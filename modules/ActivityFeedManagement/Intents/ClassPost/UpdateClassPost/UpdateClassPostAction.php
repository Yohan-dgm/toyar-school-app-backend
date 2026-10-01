<?php

namespace Modules\ActivityFeedManagement\Intents\ClassPost\UpdateClassPost;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ActivityFeedManagement\Models\ClassPost;
use Modules\ActivityFeedManagement\Models\ClassPostHashtag;
use Modules\ActivityFeedManagement\Models\ClassPostMedia;

class UpdateClassPostAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // Find the post
        $post = ClassPost::findOrFail($payloadArray['id']);

        // Prepare update data
        $updateData = [];

        if (isset($payloadArray['type'])) {
            $updateData['type'] = $payloadArray['type'];
        }

        if (isset($payloadArray['category'])) {
            $updateData['category'] = $payloadArray['category'];
        }

        if (isset($payloadArray['title'])) {
            $updateData['title'] = $payloadArray['title'];
        }

        if (isset($payloadArray['content'])) {
            $updateData['content'] = $payloadArray['content'];
        }

        $updateData['updated_by'] = $actionData['user_id'];

        // Update the post
        $post->update($updateData);

        // Update hashtags if content or hashtags array is being updated
        if (isset($payloadArray['content']) || isset($payloadArray['hashtags'])) {
            // Delete existing hashtags
            ClassPostHashtag::where('post_id', $post->id)->delete();

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
            if (isset($payloadArray['content']) && ! empty($payloadArray['content'])) {
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
        }

        // Update media if provided
        if (isset($payloadArray['media']) && is_array($payloadArray['media'])) {
            // Delete existing media
            ClassPostMedia::where('post_id', $post->id)->delete();

            // Create new media
            foreach ($payloadArray['media'] as $index => $mediaItem) {
                ClassPostMedia::create([
                    'post_id' => $post->id,
                    'type' => $mediaItem['type'],
                    'url' => $mediaItem['url'],
                    'thumbnail_url' => $mediaItem['thumbnail_url'] ?? null,
                    'filename' => $mediaItem['filename'],
                    'size' => $mediaItem['size'],
                    'mime_type' => $mediaItem['mime_type'] ?? null,
                    'sort_order' => $index + 1,
                    'created_by' => $actionData['user_id'],
                ]);
            }
        }

        // Refresh the post with relationships
        $post->refresh();
        $post->load(['author', 'media', 'hashtags']);

        return $post;
    }
}
