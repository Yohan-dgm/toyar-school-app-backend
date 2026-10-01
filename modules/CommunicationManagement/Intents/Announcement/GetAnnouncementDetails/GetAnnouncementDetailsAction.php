<?php

namespace Modules\CommunicationManagement\Intents\Announcement\GetAnnouncementDetails;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CommunicationManagement\Models\Announcement;
use Modules\CommunicationManagement\Models\AnnouncementRecipient;

class GetAnnouncementDetailsAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getAnnouncementDetailsUserDTO = GetAnnouncementDetailsUserDTO::validate($payloadArray);

        // System Data Prep
        $system_data = [];
        $system_data['user_id'] = $actionData['user_id'];

        // System Data Validation
        $getAnnouncementDetailsSystemDTO = GetAnnouncementDetailsSystemDTO::validate($system_data);

        // Final Data Validation
        $getAnnouncementDetailsDTO = GetAnnouncementDetailsDTO::validate(array_merge($getAnnouncementDetailsUserDTO, $getAnnouncementDetailsSystemDTO));

        $userId = $getAnnouncementDetailsDTO['user_id'];
        $announcementId = $getAnnouncementDetailsDTO['announcement_id'];

        // Get announcement with all related data
        $announcement = Announcement::with(['category', 'createdBy'])
            ->find($announcementId);

        if (! $announcement) {
            throw new \Exception('Announcement not found');
        }

        // Check if announcement is published (unless user is the creator)
        if ($announcement->status !== 'published' && $announcement->created_by !== $userId) {
            throw new \Exception('Announcement not accessible');
        }

        // Get or create recipient record
        $recipient = AnnouncementRecipient::getOrCreateForUser($announcementId, $userId);

        // Mark as viewed (this will also auto-mark as read)
        $recipient->markAsViewed();

        // Increment announcement view count
        $announcement->incrementViewCount();

        // Prepare response data
        $responseData = [
            'id' => $announcement->id,
            'title' => $announcement->title,
            'content' => $announcement->content,
            'excerpt' => $announcement->excerpt,
            'category' => [
                'id' => $announcement->category?->id,
                'name' => $announcement->category?->name,
                'slug' => $announcement->category?->slug,
                'color' => $announcement->category?->color,
                'icon' => $announcement->category?->icon,
            ],
            'priority_level' => $announcement->priority_level,
            'priority_label' => $announcement->priority_label,
            'priority_color' => $announcement->priority_color,
            'status' => $announcement->status,
            'status_label' => $announcement->status_label,
            'status_color' => $announcement->status_color,
            'target_type' => $announcement->target_type,
            'target_display' => $announcement->target_display,
            'target_data' => $announcement->target_data,
            'image_url' => $announcement->image_url,
            'attachment_urls' => $announcement->attachment_urls,
            'has_attachments' => $announcement->has_attachments,
            'attachment_count' => $announcement->attachment_count,
            'is_featured' => $announcement->is_featured,
            'is_pinned' => $announcement->is_pinned,
            'scheduled_at' => $announcement->scheduled_at?->toISOString(),
            'published_at' => $announcement->published_at?->toISOString(),
            'expires_at' => $announcement->expires_at?->toISOString(),
            'is_expired' => $announcement->is_expired,
            'view_count' => $announcement->view_count,
            'like_count' => $announcement->like_count,
            'tags_array' => $announcement->tags_array,
            'read_time' => $announcement->read_time,
            'user_interaction' => $recipient->getReadStatus(),
            'creator' => [
                'id' => $announcement->createdBy?->id,
                'name' => $announcement->createdBy?->full_name,
                'username' => $announcement->createdBy?->username,
            ],
            'created_at' => $announcement->created_at->toISOString(),
            'formatted_created_at' => $announcement->formatted_published_at ?: $announcement->created_at->format('M d, Y \a\t g:i A'),
            'time_ago' => $announcement->time_ago,
        ];

        return GetAnnouncementDetailsResDTO::fromArray($responseData);
    }
}
