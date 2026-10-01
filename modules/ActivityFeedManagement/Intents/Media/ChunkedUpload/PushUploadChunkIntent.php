<?php

namespace Modules\ActivityFeedManagement\Intents\Media\ChunkedUpload;

use Illuminate\Http\Request;
use Modules\ActivityFeedManagement\Intents\Media\UploadMediaPushAction;

class PushUploadChunkIntent
{
    public function __invoke(Request $request)
    {
        try {
            $actionData = [
                'user_id' => $request->user()->id,
            ];

            // Note: UploadMediaPushAction needs 'chunk' which is a file
            $payload = array_merge($request->all(), [
                'chunk' => $request->file('chunk')
            ]);

            $result = UploadMediaPushAction::run($payload, $actionData);

            return response()->json($result, 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
