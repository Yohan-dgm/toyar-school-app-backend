<?php

namespace Modules\ActivityFeedManagement\Intents\Media\ChunkedUpload;

use Illuminate\Http\Request;
use Modules\ActivityFeedManagement\Intents\Media\UploadMediaInitAction;

class InitChunkedUploadIntent
{
    public function __invoke(Request $request)
    {
        try {
            $actionData = [
                'user_id' => $request->user()->id,
            ];

            $result = UploadMediaInitAction::run($request->all(), $actionData);

            return response()->json($result, 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
