<?php

namespace Modules\CommunicationManagement\Intents\Chat\ToggleChatMessageReaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\CommunicationManagement\Intents\Chat\ToggleChatMessageReaction\ToggleChatMessageReactionAction;

class ToggleChatMessageReactionIntent extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'message_id' => 'required|integer',
            'emoji' => 'required|string',
        ]);

        $payload = $request->only(['message_id', 'emoji']);
        $actionData = [
            'user_id' => $request->user()->id,
        ];

        $result = ToggleChatMessageReactionAction::run($payload, $actionData);

        return response()->json($result);
    }
}
