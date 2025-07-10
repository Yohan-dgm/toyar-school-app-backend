<?php

namespace Modules\ActivityFeedManagement\Intents\SchoolPost\UpdateSchoolPost;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ActivityFeedManagement\Models\ActivityFeedPost;
use Modules\ActivityFeedManagement\Models\ActivityFeedMedia;
use Modules\ActivityFeedManagement\Models\ActivityFeedHashtag;

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
        $post = ActivityFeedPost::findOrFail($updateSchoolPostDTO['id']);

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

            // Update hashtags if content is being updated
            ActivityFeedHashtag::updateHashtagsForPost($post->id, $updateSchoolPostDTO['content']);
        }

        $updateData['updated_by'] = $updateSchoolPostDTO['updated_by'];

        // Update the post
        $post->update($updateData);

        // Update media if provided
        if ($updateSchoolPostDTO['media'] !== null) {
            // Delete existing media
            ActivityFeedMedia::where('post_id', $post->id)->delete();

            // Create new media
            foreach ($updateSchoolPostDTO['media'] as $index => $mediaItem) {
                ActivityFeedMedia::create([
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
