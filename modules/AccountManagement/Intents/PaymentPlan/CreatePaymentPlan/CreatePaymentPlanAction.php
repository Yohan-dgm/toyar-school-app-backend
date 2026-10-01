<?php

namespace Modules\AccountManagement\Intents\PaymentPlan\CreatePaymentPlan;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\ItemRate;
use Modules\AccountManagement\Models\PaymentPlan;
use Modules\ProgramManagement\Models\GradeLevel;

class CreatePaymentPlanAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createPaymentPlanUserDTO = CreatePaymentPlanUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $mainProgramRate = ItemRate::where(function (Builder $item_rate_query) use ($createPaymentPlanUserDTO) {
            $item_rate_query->where('item_type', '=', 'Program')
                ->where('is_active', '=', true)
                ->where('program_id', '=', $createPaymentPlanUserDTO['main_program_id']);
        })->get()->select('rate', 'id')->first();

        $admissionRate = ItemRate::where(function (Builder $admission_rate_query) {
            $admission_rate_query->where('item_type', '=', 'School Fee')
                ->where('is_active', '=', true)
                ->where('school_fee_name', '=', 'Admission Fee');
        })->get()->select('rate', 'id')->first();

        $gradeLevel = GradeLevel::where('id', '=', $createPaymentPlanUserDTO['grade_level_id'])->first();

        $refundableDepositRate = ItemRate::where(function (Builder $refundable_deposit_rate_query) use ($gradeLevel) {
            $refundable_deposit_rate_query->where('item_type', '=', 'School Fee')
                ->where('is_active', '=', true)
                ->where('school_fee_name', '=', 'Refundable Deposit - '.$gradeLevel->name);
        })->get()->select('rate', 'id')->first();

        $system_data = [];
        $subtotal = 0;
        if ($mainProgramRate['rate'] != null) {
            $system_data['main_program_rate_id'] = $mainProgramRate['id'];
            $system_data['main_program_rate'] = $mainProgramRate['rate'];
            $subtotal += $mainProgramRate['rate'];
        }
        if ($admissionRate['rate'] != null) {
            $system_data['admission_rate_id'] = $admissionRate['id'];
            $system_data['admission_rate'] = $admissionRate['rate'];
            $subtotal += $admissionRate['rate'];
        }

        if ($refundableDepositRate['rate'] != null) {
            $system_data['refundable_deposit_rate_id'] = $refundableDepositRate['id'];
            $system_data['refundable_deposit_rate'] = $refundableDepositRate['rate'];
            $subtotal += $refundableDepositRate['rate'];
        }

        $system_data['created_by'] = $actionData['created_by'];
        $system_data['subtotal'] = $subtotal;
        $system_data['subtotal_after_discount'] = $subtotal - $createPaymentPlanUserDTO['discount'];
        $system_data['total'] = $system_data['subtotal_after_discount'];

        $system_data['is_first_down_payment_bill_generated'] = false;
        $system_data['is_active'] = true;

        // System Data Validation
        $createPaymentPlanSystemDTO = CreatePaymentPlanSystemDTO::validate($system_data);
        // Final Data Validation
        $createPaymentPlanDTO = CreatePaymentPlanDTO::validate(array_merge($createPaymentPlanUserDTO, $createPaymentPlanSystemDTO));

        // Save In Database
        $paymentPlan = PaymentPlan::create($createPaymentPlanDTO);

        return $paymentPlan;
    }
}
