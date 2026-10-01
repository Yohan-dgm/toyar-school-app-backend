<?php

namespace Modules\CommunicationManagement\Intents\Chat\ToggleChatFocus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\JsonResponse;

class ToggleChatFocusIntent extends Controller
{
    /**
     * Set or clear the user's focus on a specific chat group.
     * This is used to suppress push notifications when the user is actively viewing the chat.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'chat_group_id' => 'nullable|integer',
        ]);

        $userId = $request->user()->id;
        $chatGroupId = $request->input('chat_group_id');
        
        $cacheKey = "user_chat_focus_{$userId}";

        if ($chatGroupId) {
            // Set focus with a short TTL (1 minute)
            // The frontend should send a heartbeat every 30 seconds
            Cache::put($cacheKey, (int)$chatGroupId, 60);
        } else {
            // Clear focus
            Cache::forget($cacheKey);
        }

        return response()->json([
            'success' => true,
            'focused_group_id' => $chatGroupId,
        ]);
    }
}
