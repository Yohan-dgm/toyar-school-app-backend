<?php

use Illuminate\Support\Facades\Broadcast;

// User-specific chat channels (for global notifications while outside specific chat)
Broadcast::channel('chat.user.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

// Group-specific chat channels (for real-time chat updates inside ChatView - Presence)
Broadcast::channel('chat.group.{groupId}', function ($user, $groupId) {
    \Illuminate\Support\Facades\Log::info("Presence Channel Auth Attempt", [
        'user_id' => $user->id,
        'group_id' => $groupId
    ]);

    $isMember = \Modules\CommunicationManagement\Models\ChatGroup::where('id', $groupId)
        ->whereHas('members', function ($query) use ($user) {
            $query->where('user_id', $user->id)->where('is_active', true);
        })->exists();
    
    if ($isMember) {
        \Illuminate\Support\Facades\Log::info("Presence Channel Auth: SUCCESS", ['user_id' => $user->id]);
        return ['id' => $user->id, 'name' => $user->full_name];
    }
    
    \Illuminate\Support\Facades\Log::warning("Presence Channel Auth: FAILED - Not a member", ['user_id' => $user->id, 'group_id' => $groupId]);
    return false;
});

// User-specific notification channels
Broadcast::channel('user.{userId}.notifications', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

// User-specific notification stats channels
Broadcast::channel('user.{userId}.notification-stats', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});
