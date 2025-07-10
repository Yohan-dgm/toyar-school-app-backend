<?php

namespace Modules\ActivityFeedManagement\Intents\SchoolPost\GetSchoolPosts;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ActivityFeedManagement\Models\ActivityFeedPost;
use Modules\UserManagement\Models\User;

class GetSchoolPostsAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getSchoolPostsUserDTO = GetSchoolPostsUserDTO::validate($payloadArray);

        // System Data Prep
        $system_data = [];
        $system_data['user_id'] = $actionData['user_id'];

        // System Data Validation
        $getSchoolPostsSystemDTO = GetSchoolPostsSystemDTO::validate($system_data);

        // Final Data Validation
        $getSchoolPostsDTO = GetSchoolPostsDTO::validate(array_merge($getSchoolPostsUserDTO, $getSchoolPostsSystemDTO));

        // Set pagination defaults
        $page = $getSchoolPostsDTO['page'] ?? 1;
        $perPage = $getSchoolPostsDTO['page_size'] ?? 10;
        $schoolId = $getSchoolPostsDTO['school_id'] ?? 1; // Default to school 1 if not provided

        // Build query with relationships
        $query = ActivityFeedPost::query()
            ->with(['author', 'media', 'hashtags'])
            ->active()
            ->bySchool($schoolId)
            ->schoolWide(); // Only school-wide posts (class_id and student_id are null)

        // Optional: Log basic query info for monitoring (remove in production if not needed)
        \Log::info('GetSchoolPosts request', [
            'user_id' => $actionData['user_id'],
            'school_id' => $schoolId,
            'page' => $page,
            'per_page' => $perPage,
            'search_phrase' => $getSchoolPostsDTO['search_phrase'] ?? null
        ]);

        // Apply search filter
        if ($getSchoolPostsDTO['search_phrase'] && !empty(trim($getSchoolPostsDTO['search_phrase']))) {
            $query->search($getSchoolPostsDTO['search_phrase']);
        }

        // Apply additional filters from search_filter_list if provided
        if ($getSchoolPostsDTO['search_filter_list'] && is_array($getSchoolPostsDTO['search_filter_list'])) {
            foreach ($getSchoolPostsDTO['search_filter_list'] as $filter) {
                if (isset($filter['type']) && isset($filter['value'])) {
                    switch ($filter['type']) {
                        case 'post_type':
                            $query->byType($filter['value']);
                            break;
                        case 'category':
                            $query->byCategory($filter['value']);
                            break;
                        case 'date_from':
                            $query->byDateRange($filter['value'], null);
                            break;
                        case 'date_to':
                            $query->byDateRange(null, $filter['value']);
                            break;
                        case 'hashtags':
                            if (is_array($filter['value'])) {
                                $query->withHashtags($filter['value']);
                            }
                            break;
                    }
                }
            }
        }

        // Order by creation date (newest first)
        $query->orderBy('created_at', 'desc');

        // Get total count for pagination
        $queryCount = $query->count();

        // Paginate
        $posts = $query->paginate($perPage, ['*'], 'page', $page);

        // Pagination completed

        // Transform posts to include additional data
        $transformedPosts = $posts->getCollection()->map(function ($post) use ($getSchoolPostsDTO) {
            return [
                'id' => $post->id,
                'type' => $post->type,
                'category' => $post->category,
                'title' => $post->title,
                'content' => $post->content,
                'author_name' => $post->author->full_name ?? $post->author->username ?? 'Unknown Author',
                'author_image' => '/default-avatar.png', // Add profile_image field to user table if needed
                'created_at' => $post->created_at->toISOString(),
                'updated_at' => $post->updated_at->toISOString(),
                'likes_count' => $post->likes_count,
                'comments_count' => $post->comments_count,
                'is_liked_by_user' => $post->isLikedByUser($getSchoolPostsDTO['user_id']),
                'media' => $post->media->map(function ($media) {
                    return [
                        'id' => $media->id,
                        'type' => $media->type,
                        'url' => $media->url,
                        'thumbnail_url' => $media->thumbnail_url,
                        'filename' => $media->filename,
                        'size' => $media->size,
                    ];
                })->toArray(),
                'hashtags' => $post->getHashtagsArray(),
                'school_id' => $post->school_id,
                'class_id' => $post->class_id,
                'student_id' => $post->student_id,
            ];
        });

        // Prepare pagination data
        $pagination = [
            'current_page' => $posts->currentPage(),
            'per_page' => $posts->perPage(),
            'total' => $posts->total(),
            'last_page' => $posts->lastPage(),
            'has_more' => $posts->hasMorePages(),
        ];

        return [
            'posts' => $transformedPosts,
            'pagination' => $pagination,
        ];
    }
}
