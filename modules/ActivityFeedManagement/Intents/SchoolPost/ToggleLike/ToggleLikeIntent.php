<?php

namespace Modules\ActivityFeedManagement\Intents\SchoolPost\ToggleLike;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class ToggleLikeIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        DB::beginTransaction();
        try {
            // 1. Authorization
            // TODO: Add authorization logic here

            // 2. User Data Validation
            $toggleLikeUserDTO = ToggleLikeUserDTO::validate($request->all());

            // 3. Before Intent
            // TODO: Add any pre-processing logic here

            // 4. Business Rules Validation
            // TODO: Add business rules validation here

            // Action 1 - Toggle Like
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $result = ToggleLikeAction::run($toggleLikeUserDTO, $actionData);

            DB::commit();

            // After Intent
            // TODO: Add any post-processing logic here

            // Return Response
            return $result;
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);

            // Determine message based on action
            $action = $request->input('action', 'like');
            $message = $action === 'like' ? 'Post liked successfully' : 'Post unliked successfully';

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => $message,
                    'data' => $result,
                ],
                200
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Post not found or user not authorized',
                    'data' => null,
                ],
                404
            );
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Validation failed: '.$e->getMessage(),
                    'data' => null,
                ],
                422
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => $th->getMessage(),
                    'data' => null,
                ],
                500
            );
        }
    }
}
