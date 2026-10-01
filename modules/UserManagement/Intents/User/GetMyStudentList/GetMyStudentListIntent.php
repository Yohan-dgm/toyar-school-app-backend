<?php

namespace Modules\UserManagement\Intents\User\GetMyStudentList;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\UserManagement\Intents\User\GetPublicStudentList\GetStudentListByUserAction;

class GetMyStudentListIntent extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            // Reuses the same "connected students" logic SignInIntent already
            // uses at login (UserPaymentStudent/UserPayment ownership chain),
            // but resolves the user from the authenticated request
            // ($request->user(), set by AuthGuard) instead of a client-supplied
            // user_id like GetPublicStudentListIntent does — the logged-in
            // guardian can only ever fetch their own children this way.
            $result = GetStudentListByUserAction::run($request->user());

            return response()->json([
                'status' => 'successful',
                'message' => '',
                'data' => $result,
                'metadata' => null,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
            ], 400);
        }
    }
}
