<?php

namespace Modules\CommunicationManagement\Intents\Chat\SetChatFocus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SetChatFocusIntent extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'chat_group_id' => 'nullable|integer|exists:chat_groups,id',
        ]);

        $payload = $request->only(['chat_group_id']);
        $actionData = [
            'user_id' => $request->user()->id,
        ];

        $result = SetChatFocusAction::run($payload, $actionData);

        return response()->json($result);
    }
}
