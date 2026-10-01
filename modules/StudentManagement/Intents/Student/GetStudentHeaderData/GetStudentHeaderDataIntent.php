<?php

namespace Modules\StudentManagement\Intents\Student\GetStudentHeaderData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class GetStudentHeaderDataIntent extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $payloadArray = $request->all();
            $actionData = [
                'request' => $request,
                'user' => $request->user(),
            ];

            $result = GetStudentHeaderDataAction::run($payloadArray, $actionData);

            return response()->json([
                'status' => 'success',
                'data' => $result,
            ]);
        } catch (HttpException $e) {
            // Preserves 403 (not linked to this guardian) / 404 (student not
            // found) instead of flattening every failure to a generic code —
            // this endpoint's whole purpose is the ownership check.
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], $e->getStatusCode());
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
