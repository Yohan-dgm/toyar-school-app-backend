<?php

namespace Modules\ActivityFeedManagement\Intents\SchoolPost\CreateSchoolPost;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateSchoolPostIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        DB::beginTransaction();
        try {
            // 1. Authorization
            // TODO: Add authorization logic here

            // 2. User Data Validation
            $createSchoolPostUserDTO = CreateSchoolPostUserDTO::validate($request->all());

            // 3. Before Intent
            // TODO: Add any pre-processing logic here

            // 4. Business Rules Validation
            // TODO: Add business rules validation here

            // Action 1 - Create School Post
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $post = CreateSchoolPostAction::run($createSchoolPostUserDTO, $actionData);

            DB::commit();
            
            // After Intent
            // TODO: Add any post-processing logic here

            // Return Response
            return $post;
        } catch (\Throwable $th) {
            DB::rollback();
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
                    "message" => "School post created successfully",
                    "data" => $result,
                    "metadata" => null,
                ],
                201
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
