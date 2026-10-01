<?php

namespace Modules\UserManagement\Intents\User\GetCurrentUserData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Returns the authenticated user's own current data (profile image, student
 * list, active payments) — scoped via the auth token like every other
 * "current user" endpoint, so it always returns the requesting user's own
 * live data, never a stale or arbitrary record. Used by the app to refresh
 * the header after login without requiring the user to sign in again.
 */
class GetCurrentUserDataIntent extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $data = BuildUserSessionDataAction::run($request->user());

            return response()->json([
                'status' => 'successful',
                'message' => '',
                'data' => $data,
                'metadata' => null,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
                'data' => null,
                'metadata' => null,
            ], 500);
        }
    }
}
