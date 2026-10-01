<?php

namespace Modules\ActivityFeedManagement\Intents\StudentPost\GetStudentPosts;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ActivityFeedManagement\Models\StudentPost;

class GetStudentPostsAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // Set pagination defaults
        $page = $payloadArray['page'] ?? 1;
        $perPage = $payloadArray['page_size'] ?? 10;
        $schoolId = $payloadArray['school_id'] ?? 1;
        $studentId = $payloadArray['student_id'] ?? null;
        $createdByMe = $payloadArray['created_by_me'] ?? false;

        // Build query with relationships and likes count
        $query = StudentPost::query()
            ->select('student_posts.*')
            ->selectRaw('COALESCE(likes_count.count, 0) as likes_count')
            ->leftJoin(DB::raw('(SELECT post_id, COUNT(*) as count FROM student_post_likes WHERE is_active = true GROUP BY post_id) as likes_count'),
                'student_posts.id', '=', 'likes_count.post_id')
            ->with(['author', 'student', 'media', 'hashtags'])
            ->active()
            ->bySchool($schoolId);

        // Apply filters
        if ($createdByMe) {
            $query->where('created_by', $actionData['user_id']);
        } elseif ($studentId) {
            $query->byStudent($studentId);
        }

        // Apply search filter
        if (isset($payloadArray['search_phrase']) && ! empty(trim($payloadArray['search_phrase']))) {
            $query->search($payloadArray['search_phrase']);
        }

        // Apply additional filters from search_filter_list if provided
        if (isset($payloadArray['search_filter_list']) && is_array($payloadArray['search_filter_list'])) {
            foreach ($payloadArray['search_filter_list'] as $filter) {
                if (isset($filter['type']) && isset($filter['value'])) {
                    switch ($filter['type']) {
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
                'student_name' => $post->student?->full_name ?? $post->student?->student_calling_name ?? 'Unknown Student',
                'student_admission_number' => $post->student?->admission_number ?? 'N/A',
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
                'student_id' => $post->student_id,
                'created_by' => $post->created_by,
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
