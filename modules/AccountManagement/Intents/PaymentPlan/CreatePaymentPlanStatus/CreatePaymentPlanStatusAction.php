<?php

namespace Modules\AccountManagement\Intents\PaymentPlan\CreatePaymentPlanStatus;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\AcademicBill;
use Modules\AccountManagement\Models\AcademicBillItem;
use Modules\AccountManagement\Models\PaymentPlan;
use Modules\AccountManagement\Models\PaymentPlanStatus;

class CreatePaymentPlanStatusAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createPaymentPlanStatusUserDTO = CreatePaymentPlanStatusUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];
        // System Data Prep
        $system_data['created_by'] = $actionData['user_id'];
        $system_data['status_changed_by_id'] = $actionData['user_id'];
        $system_data['is_active'] = true;

        // System Data Validation
        $createPaymentPlanStatusSystemDTO = CreatePaymentPlanStatusSystemDTO::validate($system_data);

        // Final Data Validation
        $createPaymentPlanStatusDTO = CreatePaymentPlanStatusDTO::validate(array_merge($createPaymentPlanStatusUserDTO, $createPaymentPlanStatusSystemDTO));

        // Save In Database

        //Save PaymentPlanStatus
        $paymentPlanStatus = PaymentPlanStatus::create($createPaymentPlanStatusDTO);

        $academicBill = [];
        if ($createPaymentPlanStatusDTO['payment_plan_status_type_id'] == 2) { //Approved Complete
            //Save AcademicBill
            $academicBill['payment_plan_id'] = $createPaymentPlanStatusDTO['payment_plan_id'];
            $academicBill['created_by'] = $createPaymentPlanStatusDTO['created_by'];
            $academicBill['bill_type'] = 'Down Payment Bill';
            $academicBill['date'] = date('Y-m-d');

            $maxDigits = AcademicBill::where(function (Builder $receipt_query) {
                $serial_number_financial_year = (date('m') > 3) ? date('y').'-'.(date('y') + 1) : (date('y') - 1).'-'.date('y');
                $receipt_query->where('serial_number_financial_year', '=', $serial_number_financial_year);
            })->max('serial_number_digits');

            if ($maxDigits > 0) {
                $serial_number_digits = (int) $maxDigits + 1;
            } else {
                $serial_number_digits = 1;
            }

            $academicBill['serial_number_prefix'] = 'ACD-BILL';
            $academicBill['serial_number_digits'] = $serial_number_digits;
            $academicBill['serial_number_current_year'] = date('y');
            $academicBill['serial_number_financial_year'] = (date('m') > 3) ? date('y').'-'.(date('y') + 1) : (date('y') - 1).'-'.date('y');
            $academicBill['serial_number_suffix'] = '';
            if ($academicBill['serial_number_suffix'] == '') {
                $academicBill['serial_number'] = $academicBill['serial_number_prefix'].'/'.$academicBill['serial_number_current_year'].'/'.$academicBill['serial_number_financial_year'].'/'.$academicBill['serial_number_digits'];
            } else {
                $academicBill['serial_number'] = $academicBill['serial_number_prefix'].'/'.$academicBill['serial_number_current_year'].'/'.$academicBill['serial_number_financial_year'].'/'.$academicBill['serial_number_digits'].'/'.$academicBill['serial_number_suffix'];
            }

            $academicBill = AcademicBill::create($academicBill);

            // Save AcademicBillItem start
            $programPlanData = PaymentPlan::where(function (Builder $payment_plan_query) use ($createPaymentPlanStatusDTO) {
                $payment_plan_query->where('id', '=', $createPaymentPlanStatusDTO['payment_plan_id']);
            })->select('id', 'admission_down_payment', 'main_program_down_payment', 'refundable_deposit_down_payment', 'main_program_id')->get()->toArray();
            $sub_total = 0;
            if (count($programPlanData) > 0) {
                $bill_total = $programPlanData[0]['admission_down_payment'] + $programPlanData[0]['main_program_down_payment'] + $programPlanData[0]['refundable_deposit_down_payment'];
                $sub_total = $bill_total;
                $description = 'Down Payment for School Year Fee, Admission Fee and Refundable Deposit';

                $academicBillItemData['program_id'] = $programPlanData[0]['main_program_id'];
                $academicBillItemData['academic_bill_id'] = $academicBill['id'];
                $academicBillItemData['bill_item_type'] = 'Payment Plan Down Payment';
                $academicBillItemData['payment_plan_down_payment_amount'] = $bill_total;
                $academicBillItemData['payment_plan_installment_amount'] = 0;
                $academicBillItemData['payment_plan_late_charge_amount'] = 0;
                $academicBillItemData['description'] = $description;
                $academicBillItemData['sequential_order'] = 1;
                $academicBillItemData['created_by'] = $actionData['user_id'];

                AcademicBillItem::create($academicBillItemData);
            }

            // Save AcademicBillItem end
            //Update AcademicBill
            $academicBillUpdateData['subtotal'] = $sub_total;
            $academicBillUpdateData['total'] = $sub_total;
            AcademicBill::where('id', $academicBill['id'])->update($academicBillUpdateData);

            //Update PaymentPlan
            $paymentPlanUpdateData['is_first_down_payment_bill_generated'] = true;
            $paymentPlanUpdateData['first_down_payment_bill_id'] = $academicBill['id'];
            $paymentPlanUpdateData['updated_by'] = $actionData['user_id'];
            PaymentPlan::where('id', $createPaymentPlanStatusDTO['payment_plan_id'])->update($paymentPlanUpdateData);
        }

        return $paymentPlanStatus;
    }
}
