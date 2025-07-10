<?php

namespace Modules\ActivityFeedManagement\Intents\SchoolPost\GetSchoolPosts;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class GetSchoolPostsIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // 1. Authorization
            // TODO: Add authorization logic here

            // 2. User Data Validation
            $getSchoolPostsUserDTO = GetSchoolPostsUserDTO::validate($request->all());

            // 3. Before Intent
            // TODO: Add any pre-processing logic here

            // 4. Business Rules Validation
            // TODO: Add business rules validation here

            // Action 1 - Get School Posts
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $result = GetSchoolPostsAction::run($getSchoolPostsUserDTO, $actionData);

            // After Intent
            // TODO: Add any post-processing logic here

            // Return Response
            return $result;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            
            return response()->json(
                [
                    "status" => "successful",
                    "message" => "School posts retrieved successfully",
                    "data" => $result,
                    "metadata" => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "status" => "error",
                    "message" => $th->getMessage(),
                    "data" => null,
                    "metadata" => null,
                ],
                500
            );
        }
    }
}
