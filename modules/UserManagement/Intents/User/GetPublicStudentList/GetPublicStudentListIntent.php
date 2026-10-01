<?php

namespace Modules\UserManagement\Intents\User\GetPublicStudentList;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\UserManagement\Models\User;

class GetPublicStudentListIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // 1. User Data Validation
            $dto = GetPublicStudentListDTO::validate($request->all());

            // 2. Resolve User
            $user = User::findOrFail($dto->user_id);

            // 3. Action: Get comprehensive student data
            $result = GetStudentListByUserAction::run($user);

            return $result;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            
            return response()->json([
                'status' => 'successful',
                'message' => 'Student list retrieved successfully',
                'data' => $result,
                'metadata' => null,
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
