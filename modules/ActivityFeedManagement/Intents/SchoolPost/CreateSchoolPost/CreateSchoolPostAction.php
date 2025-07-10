<?php

namespace Modules\ActivityFeedManagement\Intents\SchoolPost\CreateSchoolPost;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ActivityFeedManagement\Models\ActivityFeedPost;
use Modules\ActivityFeedManagement\Models\ActivityFeedMedia;
use Modules\ActivityFeedManagement\Models\ActivityFeedHashtag;

class CreateSchoolPostAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createSchoolPostUserDTO = CreateSchoolPostUserDTO::validate($payloadArray);

        // System Data Prep
        $system_data = [];
        $system_data['author_id'] = $actionData['user_id'];
        $system_data['created_by'] = $actionData['user_id'];

        // System Data Validation
        $createSchoolPostSystemDTO = CreateSchoolPostSystemDTO::validate($system_data);

        // Final Data Validation
        $createSchoolPostDTO = CreateSchoolPostDTO::validate(array_merge($createSchoolPostUserDTO, $createSchoolPostSystemDTO));

        // Create the post
        $postData = [
            'type' => $createSchoolPostDTO['type'],
            'category' => $createSchoolPostDTO['category'],
            'title' => $createSchoolPostDTO['title'],
            'content' => $createSchoolPostDTO['content'],
            'author_id' => $createSchoolPostDTO['author_id'],
            'school_id' => $createSchoolPostDTO['school_id'],
            'class_id' => $createSchoolPostDTO['class_id'],
            'student_id' => $createSchoolPostDTO['student_id'],
            'likes_count' => 0,
            'comments_count' => 0,
            'is_active' => true,
            'created_by' => $createSchoolPostDTO['created_by'],
        ];

        $post = ActivityFeedPost::create($postData);

        // Create hashtags from content
        ActivityFeedHashtag::createHashtagsForPost($post->id, $createSchoolPostDTO['content']);

        // Create media attachments if provided
        if ($createSchoolPostDTO->media) {
            foreach ($createSchoolPostDTO->media as $index => $mediaItem) {
                ActivityFeedMedia::create([
                    'post_id' => $post->id,
                    'type' => $mediaItem['type'],
                    'url' => $mediaItem['url'],
                    'thumbnail_url' => $mediaItem['thumbnail_url'] ?? null,
                    'filename' => $mediaItem['filename'],
                    'size' => $mediaItem['size'],
                    'mime_type' => $mediaItem['mime_type'] ?? null,
                    'sort_order' => $index + 1,
                    'created_by' => $createSchoolPostDTO->created_by,
                ]);
            }
        }

        // Load relationships for response
        $post->load(['author', 'media', 'hashtags']);

        return $post;
    }
}
