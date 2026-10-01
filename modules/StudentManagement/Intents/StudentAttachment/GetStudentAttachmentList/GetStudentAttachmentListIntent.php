<?php

namespace Modules\StudentManagement\Intents\StudentAttachment\GetStudentAttachmentList;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GetStudentAttachmentListIntent extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $payloadArray = $request->all();
            $actionData = [
                'request' => $request,
                'user' => $request->user(),
            ];

            $result = GetStudentAttachmentListAction::run($payloadArray, $actionData);

            $resDTO = GetStudentAttachmentListResDTO::fromArray($result);

            return response()->json([
                'status' => 'success',
                'data' => $resDTO->toArray(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
