<?php

namespace Modules\ActivityFeedManagement\Intents\SchoolPost\UpdateSchoolPost;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ActivityFeedManagement\Models\SchoolPost;
use Modules\ActivityFeedManagement\Models\SchoolPostHashtag;
use Modules\ActivityFeedManagement\Models\SchoolPostMedia;

class UpdateSchoolPostAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateSchoolPostUserDTO = UpdateSchoolPostUserDTO::validate($payloadArray);

        // System Data Prep
        $system_data = [];
        $system_data['updated_by'] = $actionData['user_id'];

        // System Data Validation
        $updateSchoolPostSystemDTO = UpdateSchoolPostSystemDTO::validate($system_data);

        // Final Data Validation
        $updateSchoolPostDTO = UpdateSchoolPostDTO::validate(array_merge($updateSchoolPostUserDTO, $updateSchoolPostSystemDTO));

        // Find the post
        $post = SchoolPost::findOrFail($updateSchoolPostDTO['id']);

        // Prepare update data (only include non-null values)
        $updateData = [];

        if ($updateSchoolPostDTO['type'] !== null) {
            $updateData['type'] = $updateSchoolPostDTO['type'];
        }

        if ($updateSchoolPostDTO['category'] !== null) {
            $updateData['category'] = $updateSchoolPostDTO['category'];
        }

        if ($updateSchoolPostDTO['title'] !== null) {
            $updateData['title'] = $updateSchoolPostDTO['title'];
        }

        if ($updateSchoolPostDTO['content'] !== null) {
            $updateData['content'] = $updateSchoolPostDTO['content'];
        }

        $updateData['updated_by'] = $updateSchoolPostDTO['updated_by'];

        // Update the post
        $post->update($updateData);

        // Update hashtags if content or hashtags array is being updated
        if ($updateSchoolPostDTO['content'] !== null || ($updateSchoolPostDTO['hashtags'] ?? null) !== null) {
            // Delete existing hashtags
            SchoolPostHashtag::where('post_id', $post->id)->delete();

            // Create hashtags from request array
            if (isset($updateSchoolPostDTO['hashtags']) && is_array($updateSchoolPostDTO['hashtags'])) {
                foreach ($updateSchoolPostDTO['hashtags'] as $hashtag) {
                    SchoolPostHashtag::create([
                        'post_id' => $post->id,
                        'hashtag' => trim($hashtag),
                        'is_active' => true,
                        'created_by' => $updateSchoolPostDTO['updated_by'],
                    ]);
                }
            }

            // Also extract hashtags from content if any exist
            if ($updateSchoolPostDTO['content'] !== null && ! empty($updateSchoolPostDTO['content'])) {
                preg_match_all('/#([a-zA-Z0-9_]+)/', $updateSchoolPostDTO['content'], $matches);

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
                                'created_by' => $updateSchoolPostDTO['updated_by'],
                            ]);
                        }
                    }
                }
            }
        }

        // Update media if provided
        if ($updateSchoolPostDTO['media'] !== null) {
            // Delete existing media
            SchoolPostMedia::where('post_id', $post->id)->delete();

            // Create new media
            foreach ($updateSchoolPostDTO['media'] as $index => $mediaItem) {
                SchoolPostMedia::create([
                    'post_id' => $post->id,
                    'type' => $mediaItem['type'],
                    'url' => $mediaItem['url'],
                    'thumbnail_url' => $mediaItem['thumbnail_url'] ?? null,
                    'filename' => $mediaItem['filename'],
                    'size' => $mediaItem['size'],
                    'mime_type' => $mediaItem['mime_type'] ?? null,
                    'sort_order' => $index + 1,
                    'created_by' => $updateSchoolPostDTO['updated_by'],
                ]);
            }
        }

        // Refresh the post with relationships
        $post->refresh();
        $post->load(['author', 'media', 'hashtags']);

        return $post;
    }
}
