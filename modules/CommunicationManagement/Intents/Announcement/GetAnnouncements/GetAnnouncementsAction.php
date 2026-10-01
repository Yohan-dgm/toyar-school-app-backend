<?php

namespace Modules\CommunicationManagement\Intents\Announcement\GetAnnouncements;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CommunicationManagement\Models\Announcement;
use Modules\CommunicationManagement\Models\AnnouncementCategory;
use Modules\CommunicationManagement\Models\AnnouncementRecipient;

class GetAnnouncementsAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getAnnouncementsUserDTO = GetAnnouncementsUserDTO::validate($payloadArray);

        // System Data Prep
        $system_data = [];
        $system_data['user_id'] = $actionData['user_id'];

        // System Data Validation
        $getAnnouncementsSystemDTO = GetAnnouncementsSystemDTO::validate($system_data);

        // Final Data Validation
        $getAnnouncementsDTO = GetAnnouncementsDTO::validate(array_merge($getAnnouncementsUserDTO, $getAnnouncementsSystemDTO));

        // Set pagination defaults
        $page = $getAnnouncementsDTO['page'] ?? 1;
        $perPage = $getAnnouncementsDTO['per_page'] ?? 20;
        $userId = $getAnnouncementsDTO['user_id'];

        // Build query for announcements
        $query = Announcement::query()
            ->leftJoin('announcement_recipients as ar', function ($join) use ($userId) {
                $join->on('announcements.id', '=', 'ar.announcement_id')
                    ->where('ar.user_id', '=', $userId);
            })
            ->leftJoin('announcement_categories as ac', 'announcements.category_id', '=', 'ac.id')
            ->select([
                'announcements.*',
                'ar.is_read',
                'ar.is_liked',
                'ar.view_count as user_view_count',
                'ac.name as category_name',
                'ac.slug as category_slug',
                'ac.color as category_color',
                'ac.icon as category_icon',
            ]);

        // Apply filters
        $this->applyFilters($query, $getAnnouncementsDTO);

        // Apply sorting
        $this->applySorting($query, $getAnnouncementsDTO);

        // Get paginated results
        $results = $query->paginate($perPage, ['*'], 'page', $page);

        // Format announcements
        $announcements = $results->getCollection()->map(function ($item) {
            return GetAnnouncementsResDTO::formatAnnouncement(
                $item->toArray(),
                [
                    'is_read' => $item->is_read,
                    'is_liked' => $item->is_liked,
                    'view_count' => $item->user_view_count,
                ]
            );
        })->toArray();

        // Get categories for filtering UI
        $categories = AnnouncementCategory::active()
            ->orderBy('sort_order')
            ->select('id', 'name', 'slug', 'color', 'icon')
            ->get()
            ->toArray();

        // Get user stats
        $stats = $this->getUserAnnouncementStats($userId);

        // Prepare response
        $responseData = [
            'announcements' => $announcements,
            'categories' => $categories,
            'pagination' => [
                'current_page' => $results->currentPage(),
                'last_page' => $results->lastPage(),
                'per_page' => $results->perPage(),
                'total' => $results->total(),
                'from' => $results->firstItem(),
                'to' => $results->lastItem(),
                'has_next_page' => $results->hasMorePages(),
                'has_prev_page' => $results->currentPage() > 1,
            ],
            'stats' => $stats,
        ];

        return GetAnnouncementsResDTO::fromArray($responseData);
    }

    private function applyFilters($query, array $filters): void
    {
        if (!empty($filters['category_id'])) {
            $query->where('announcements.category_id', $filters['category_id']);
        }
        
        if (!empty($filters['priority_level'])) {
            $query->where('announcements.priority_level', $filters['priority_level']);
        }

        if (!empty($filters['status'])) {
            $query->where('announcements.status', $filters['status']);
        } else {
            // Default to show published announcements only
            $query->where('announcements.status', 'published');
        }

        if (!empty($filters['featured_only'])) {
            $query->where('announcements.is_featured', true);
        }

        if (!empty($filters['pinned_only'])) {
            $query->where('announcements.is_pinned', true);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('announcements.title', 'ILIKE', "%{$search}%")
                    ->orWhere('announcements.content', 'ILIKE', "%{$search}%")
                    ->orWhere('announcements.excerpt', 'ILIKE', "%{$search}%");
            });
        }

        if (!empty($filters['date_from'])) {
            $query->where('announcements.published_at', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->where('announcements.published_at', '<=', $filters['date_to']);
        }

        // Only show non-expired announcements
        $query->where(function ($q) {
            $q->whereNull('announcements.expires_at')
                ->orWhere('announcements.expires_at', '>=', now());
        });
    }

    private function applySorting($query, array $filters): void
    {
        $sortBy = $filters['sort_by'] ?? 'published_at';
        $sortOrder = $filters['sort_order'] ?? 'desc';

        switch ($sortBy) {
            case 'priority_level':
                $query->orderBy('announcements.is_pinned', 'desc')
                    ->orderBy('announcements.priority_level', 'desc')
                    ->orderBy('announcements.is_featured', 'desc');
                break;
            case 'view_count':
                $query->orderBy('announcements.view_count', $sortOrder);
                break;
            case 'title':
                $query->orderBy('announcements.title', $sortOrder);
                break;
            default:
                $query->orderBy('announcements.is_pinned', 'desc')
                    ->orderBy("announcements.{$sortBy}", $sortOrder);
                break;
        }
    }

    private function getUserAnnouncementStats(int $userId): array
    {
        $stats = AnnouncementRecipient::where('user_id', $userId)
            ->join('announcements', 'announcement_recipients.announcement_id', '=', 'announcements.id')
            ->where('announcements.status', 'published')
            ->selectRaw('
                COUNT(*) as total,
                SUM(CASE WHEN announcement_recipients.is_read = true THEN 1 ELSE 0 END) as read,
                SUM(CASE WHEN announcement_recipients.is_read = false THEN 1 ELSE 0 END) as unread,
                SUM(CASE WHEN announcement_recipients.is_liked = true THEN 1 ELSE 0 END) as liked,
                SUM(CASE WHEN announcements.priority_level = 3 AND announcement_recipients.is_read = false THEN 1 ELSE 0 END) as high_priority_unread
            ')
            ->first();

        return [
            'total' => (int) $stats->total,
            'read' => (int) $stats->read,
            'unread' => (int) $stats->unread,
            'liked' => (int) $stats->liked,
            'high_priority_unread' => (int) $stats->high_priority_unread,
        ];
    }
}
