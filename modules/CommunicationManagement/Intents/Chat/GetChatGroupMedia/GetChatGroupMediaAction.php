<?php

namespace Modules\CommunicationManagement\Intents\Chat\GetChatGroupMedia;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CommunicationManagement\Models\ChatGroup;
use Modules\CommunicationManagement\Models\ChatMessage;
use Illuminate\Validation\ValidationException;

// Read-only gallery feed for a chat's Media/Documents info screens. New,
// additive endpoint — does not touch GetChatMessagesAction or any other
// existing chat endpoint.
//
// Video/audio attachments aren't distinct DB `type` values (the column only
// allows text/image/file/system); like the rest of the chat feature they're
// stored as `type = 'file'` and distinguished by mime_type/extension. This
// mirrors the same detection the frontend already does for video bubbles.
class GetChatGroupMediaAction
{
    use AsAction;

    private const VIDEO_MIME_LIKE = 'video/%';
    private const VIDEO_EXT_REGEX = '\.(mp4|mov|avi|wmv|mkv)(\?.*)?$';
    private const AUDIO_MIME_LIKE = 'audio/%';
    private const AUDIO_EXT_REGEX = '\.(m4a|mp3|aac|wav|ogg)(\?.*)?$';

    public function handle(array $payloadArray, array $actionData): array
    {
        $chatGroupId = $payloadArray['chat_group_id'] ?? null;
        $userId = $actionData['user_id'];

        if (!$chatGroupId) {
            throw ValidationException::withMessages([
                'chat_group_id' => ['chat_group_id is required.'],
            ]);
        }

        $group = ChatGroup::findOrFail($chatGroupId);
        if (!$group->isMember($userId)) {
            throw ValidationException::withMessages([
                'chat_group_id' => ['You are not a member of this chat group.'],
            ]);
        }

        $category = $payloadArray['category'] ?? 'all'; // image|video|audio|document|all
        $page = (int)($payloadArray['page'] ?? 1);
        $perPage = min((int)($payloadArray['per_page'] ?? 30), 100);

        $query = ChatMessage::where('chat_group_id', $chatGroupId)
            ->whereNotNull('attachment_url');

        $this->applyCategoryFilter($query, $category);

        $paginated = $query->orderBy('created_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        $items = $paginated->getCollection()->map(fn (ChatMessage $message) => $this->formatMediaItem($message));

        return [
            'items' => $items->values()->toArray(),
            'pagination' => [
                'current_page' => $paginated->currentPage(),
                'last_page' => $paginated->lastPage(),
                'per_page' => $paginated->perPage(),
                'total' => $paginated->total(),
                'has_more' => $paginated->hasMorePages(),
            ],
        ];
    }

    private function applyCategoryFilter($query, string $category): void
    {
        if ($category === 'image') {
            $query->where('type', 'image');
            return;
        }

        $videoClause = "(metadata->>'mime_type' LIKE ? OR attachment_url ~* ?)";
        $audioClause = "(metadata->>'mime_type' LIKE ? OR attachment_url ~* ?)";

        if ($category === 'video') {
            $query->where('type', 'file')
                ->whereRaw($videoClause, [self::VIDEO_MIME_LIKE, self::VIDEO_EXT_REGEX]);
            return;
        }

        if ($category === 'audio') {
            $query->where('type', 'file')
                ->whereRaw($audioClause, [self::AUDIO_MIME_LIKE, self::AUDIO_EXT_REGEX]);
            return;
        }

        if ($category === 'document') {
            $query->where('type', 'file')
                ->whereRaw("NOT $videoClause", [self::VIDEO_MIME_LIKE, self::VIDEO_EXT_REGEX])
                ->whereRaw("NOT $audioClause", [self::AUDIO_MIME_LIKE, self::AUDIO_EXT_REGEX]);
            return;
        }

        // 'all' (or unrecognized) — no extra filter, just whereNotNull('attachment_url').
    }

    private function formatMediaItem(ChatMessage $message): array
    {
        $metadata = $message->metadata ?? [];
        $mimeType = $metadata['mime_type'] ?? '';
        $filename = $metadata['original_filename'] ?? '';
        $attachmentUrl = $message->attachment_url ?? '';

        return [
            'id' => (string)$message->id,
            'category' => $this->resolveCategory($message->type, $mimeType, $filename, $attachmentUrl),
            'attachment_url' => $attachmentUrl,
            'metadata' => $metadata,
            'sender_id' => (string)$message->user_id,
            'created_at' => optional($message->created_at)->toIso8601String(),
        ];
    }

    private function resolveCategory(string $type, string $mimeType, string $filename, string $attachmentUrl): string
    {
        if ($type === 'image') {
            return 'image';
        }

        $haystack = strtolower("$mimeType $filename $attachmentUrl");

        if (str_starts_with($mimeType, 'video/') || preg_match('/\.(mp4|mov|avi|wmv|mkv)(\?|$)/', $haystack)) {
            return 'video';
        }

        if (str_starts_with($mimeType, 'audio/') || preg_match('/\.(m4a|mp3|aac|wav|ogg)(\?|$)/', $haystack)) {
            return 'audio';
        }

        return 'document';
    }
}
