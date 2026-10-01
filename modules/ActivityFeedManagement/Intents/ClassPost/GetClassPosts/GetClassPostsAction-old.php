<?php

namespace Modules\ActivityFeedManagement\Intents\ClassPost\GetClassPosts;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ActivityFeedManagement\Models\ClassPost;

class GetClassPostsAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // Set pagination defaults
        $page = $payloadArray['page'] ?? 1;
        $perPage = $payloadArray['page_size'] ?? 10;
        $schoolId = $payloadArray['school_id'] ?? 1;
        $classId = $payloadArray['class_id'] ?? null;
        $gradeLevelClassId = $payloadArray['grade_level_class_id'] ?? null;

        // Build query with relationships and likes count
        $query = ClassPost::query()
            ->select('class_posts.*')
            ->selectRaw('COALESCE(likes_count.count, 0) as likes_count')
            ->leftJoin(DB::raw('(SELECT post_id, COUNT(*) as count FROM class_post_likes WHERE is_active = true GROUP BY post_id) as likes_count'),
                'class_posts.id', '=', 'likes_count.post_id')
            ->with(['author', 'media', 'hashtags'])
            ->active()
            ->bySchool($schoolId);

        // Filter by class if provided
        if ($classId) {
            $query->byClass($classId);
        }

        // Filter by grade level class if provided
        if ($gradeLevelClassId) {
            $query->byGradeLevelClass($gradeLevelClassId);
        }

        // Apply search filter
        if (isset($payloadArray['search_phrase']) && ! empty(trim($payloadArray['search_phrase']))) {
            $query->search($payloadArray['search_phrase']);
        }

        // Order by creation date
        $query->orderBy('created_at', 'desc');

        // Paginate
        $posts = $query->paginate($perPage, ['*'], 'page', $page);

        // Transform posts to include additional data
        $transformedPosts = $posts->getCollection()->map(function ($post) use ($actionData) {
            return [
                'id' => $post->id,
                'type' => $post->type,
                'category' => $post->category,
                'title' => $post->title,
                'content' => $post->content,
                'author_name' => $post->author->full_name ?? $post->author->username ?? 'Unknown Author',
                'created_at' => $post->created_at->toISOString(),
                'updated_at' => $post->updated_at->toISOString(),
                'likes_count' => $post->likes_count,
                'comments_count' => $post->comments_count,
                'is_liked_by_user' => $post->isLikedByUser($actionData['user_id']),
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
                'grade_level_class_id' => $post->grade_level_class_id,
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
