<?php

namespace Modules\CommunicationManagement\Intents\Chat\SendChatMessage;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CommunicationManagement\Models\ChatGroup;
use Modules\CommunicationManagement\Models\ChatGroupMember;
use Modules\CommunicationManagement\Models\ChatMessage;
use App\Jobs\SendChatPushNotificationJob;
use App\Services\MediaUploadService;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class SendChatMessageAction
{
    use AsAction;

    public function handle(array $payloadArray, array $actionData): SendChatMessageResDTO
    {
        \Illuminate\Support\Facades\Log::info('SendChatMessageAction: Incoming payload', [
            'payload' => $payloadArray,
            'action_data' => $actionData
        ]);

        // Validation
        $userDTO = SendChatMessageUserDTO::validate($payloadArray);
        $systemDTO = SendChatMessageSystemDTO::validate($actionData);
        $dto = SendChatMessageDTO::validate(array_merge($userDTO, $systemDTO));

        \Illuminate\Support\Facades\Log::info('SendChatMessageAction: Validated DTO', ['dto' => $dto]);

        $userId = $dto['user_id'];
        $chatGroupId = $dto['chat_group_id'];

        // Verify membership
        $group = ChatGroup::active()->findOrFail($chatGroupId);
        if (!$group->isMember($userId)) {
            throw ValidationException::withMessages([
                'chat_group_id' => ['You are not a member of this chat group.'],
            ]);
        }

        if ($group->is_disabled) {
            throw ValidationException::withMessages([
                'chat_group_id' => ['This chat group has been disabled by an administrator. Nobody can send messages.'],
            ]);
        }

        if ($group->only_admins_can_message && !$group->isAdmin($userId)) {
            throw ValidationException::withMessages([
                'chat_group_id' => ['Only administrators can send messages to this group.'],
            ]);
        }

        return DB::transaction(function () use ($dto, $userId, $chatGroupId, $group) {
            $attachmentUrl = null;
            $metadata = $dto['metadata'] ?? [];

            // Handle file upload
            if (isset($dto['attachment_url'])) {
                $attachmentUrl = $dto['attachment_url'];
                // Metadata should already be present in $dto['metadata'] from chunked upload finish
            } elseif (isset($dto['attachment']) && $dto['type'] !== 'text') {
                $uploadService = new MediaUploadService();
                $uploadResult = $uploadService->uploadMediaStandalone(
                    $dto['attachment'],
                    'chat-media', // Standardizing on chat-media folder
                    $userId
                );
                
                $attachmentUrl = $uploadResult['url'];
                $metadata = array_merge($metadata, [
                    'original_filename' => $uploadResult['original_filename'],
                    'size' => $uploadResult['size'],
                    'mime_type' => $uploadResult['mime_type'],
                    'width' => $uploadResult['width'] ?? null,
                    'height' => $uploadResult['height'] ?? null,
                ]);
            }

            // Create message
            $message = ChatMessage::create([
                'chat_group_id' => $chatGroupId,
                'user_id' => $userId,
                'type' => $dto['type'],
                'content' => $dto['content'] ?? null,
                'attachment_url' => $attachmentUrl,
                'metadata' => $metadata,
            ]);

            // Update sender's last_read_at
            ChatGroupMember::where('chat_group_id', $chatGroupId)
                ->where('user_id', $userId)
                ->update(['last_read_at' => now()]);

            // Trigger Dedicated Chat Push Notifications for other members
            SendChatPushNotificationJob::dispatch($group, $message, $userId);

            // Fetch sender info and role for real-time
            $sender = DB::table('user')->where('id', $userId)->first();
            $member = ChatGroupMember::where('chat_group_id', $chatGroupId)
                ->where('user_id', $userId)
                ->first();
                
            $formattedMessage = SendChatMessageResDTO::formatMessage(array_merge($message->toArray(), [
                'sender_name' => $sender->full_name ?? 'Someone',
                'sender_avatar' => $sender->profile_image_url ?? null,
                'sender_role' => $member->role ?? 'member',
            ]));

            // Real-time broadcast to the group channel (Efficient for active chatters)
            broadcast(new \App\Events\MessageSentToGroup((int)$chatGroupId, (int)$userId, $formattedMessage));

            // Real-time broadcast to individual members (For global notifications/unread counters)
            $memberIds = ChatGroupMember::where('chat_group_id', $chatGroupId)
                ->where('is_active', true)
                ->where('user_id', '!=', $userId) // Don't notify sender on user channel
                ->pluck('user_id')
                ->toArray();

            foreach ($memberIds as $memberId) {
                broadcast(new \App\Events\MessageSent((int)$memberId, (int)$userId, $formattedMessage));
            }

            \Illuminate\Support\Facades\Log::info('SendChatMessageAction: Broadcasts dispatched successfully', [
                'chat_group_id' => $chatGroupId,
                'sender_id' => $userId,
                'recipients_count' => count($memberIds)
            ]);

            return SendChatMessageResDTO::fromArray([
                'message' => $formattedMessage,
            ]);
        });
    }
}
