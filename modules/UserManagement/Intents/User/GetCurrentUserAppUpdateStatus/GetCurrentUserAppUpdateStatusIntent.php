<?php

namespace Modules\UserManagement\Intents\User\GetCurrentUserAppUpdateStatus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GetCurrentUserAppUpdateStatusIntent extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $payloadArray = $request->all();
            $actionData = [
                'request' => $request,
                'user' => $request->user(),
            ];

            $result = GetCurrentUserAppUpdateStatusAction::run($payloadArray, $actionData);

            $resDTO = GetCurrentUserAppUpdateStatusResDTO::fromArray($result);

            return response()->json([
                'status' => 'success',
                'data' => $resDTO->toArray(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 401);
        }
    }
}