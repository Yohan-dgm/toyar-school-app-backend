<?php

namespace Modules\AcademicStaffManagement\Intents\SectionalHead\CreateSectionalHead;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateSectionalHeadIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        DB::beginTransaction();
        try {
            // 1. Authorization
            // TODO: Add authorization check if needed

            // 2. User Data Validation
            $createSectionalHeadUserDTO = CreateSectionalHeadUserDTO::validate($request->all());

            // 3. Before Intent
            // Add any pre-processing logic here

            // 4. Business Rules Validation
            // Add any business rules validation here

            // 5. Action
            $actionData = [];
            $actionData['created_by'] = $request->user()->id;
            $sectionalHead = CreateSectionalHeadAction::run($createSectionalHeadUserDTO, $actionData);

            DB::commit();

            // 6. After Intent
            // Add any post-processing logic here

            // 7. Return Response
            return $sectionalHead;
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            if ($result) {
                return response()->json(
                    [
                        'status' => 'successful',
                        'message' => 'Sectional head assigned successfully',
                        'data' => $result,
                        'metadata' => null,
                    ],
                    201
                );
            } else {
                return response()->json(
                    [
                        'status' => 'failed',
                        'message' => 'Failed to assign sectional head',
                        'data' => null,
                        'metadata' => null,
                    ],
                    500
                );
            }
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => $th->getMessage(),
                    'data' => null,
                    'metadata' => null,
                ],
                500
            );
        }
    }
}
