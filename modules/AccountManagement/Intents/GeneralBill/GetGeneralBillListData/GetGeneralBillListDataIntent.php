<?php

namespace Modules\AccountManagement\Intents\GeneralBill\GetGeneralBillListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\SchoolHouse;
use Modules\ProgramManagement\Models\GradeLevel;

class GetGeneralBillListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // GeneralBill Data Validation
            $getGeneralBillListDataUserDTO = GetGeneralBillListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $general_billListData = GetGeneralBillListDataAction::run($getGeneralBillListDataUserDTO, $actionData);
            $data['general_bill_count'] = DB::table('general_bill')->where('has_dropped_out', false)->count();
            $data['dropped_out_general_bill_count'] = DB::table('general_bill')->where('has_dropped_out', true)->count();
            $data['incomplete_general_bill_count'] = DB::table('general_bill')
                ->whereNull('father_full_name')
                ->whereNull('mother_full_name')
                ->whereNull('guardian_full_name')
                // ->where("has_dropped_out", false)
                ->count();
            $data['grade_level_general_bill_count'] = GradeLevel::select('id', 'name')->withCount(['general_bill_list' => function (Builder $general_bill_list_query) {
                return $general_bill_list_query->where('has_dropped_out', false);
            }])->orderBy('id', 'asc')->get();
            $data['school_house_general_bill_count'] = SchoolHouse::select('id', 'name')->withCount(['general_bill_list' => function (Builder $general_bill_list_query) {
                $general_bill_list_query->whereNotNull('school_house_id')->where('has_dropped_out', false);
            }])->orderBy('id', 'asc')->get();
            // After Intent

            // Return Response
            return array_merge($general_billListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetGeneralBillListDataResDTO = GetGeneralBillListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetGeneralBillListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
