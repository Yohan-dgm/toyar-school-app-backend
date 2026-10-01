<?php

namespace Modules\AccountManagement\Intents\ExamBill\CreateExamBill;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Modules\AccountManagement\Intents\ExamBillItem\CreateExamBillItem\CreateExamBillItemAction;
use Modules\AccountManagement\Intents\ExamBillItem\CreateExamBillItem\CreateExamBillItemUserDTO;
use Modules\AccountManagement\Models\ExamBill;
use Modules\AccountManagement\Models\ExamBillItem;
use Modules\AccountManagement\Models\ItemRate;
use Modules\LogManagement\Intents\InvoicesLog\CreateInvoicesLog\CreateInvoicesLogAction;

class CreateExamBillAction
{
    use \Lorisleiva\Actions\Concerns\AsAction;

    public function handle($payloadArray, $actionData)
    {
        $createExamBillUserDTO = CreateExamBillUserDTO::validate($payloadArray);

        if ($createExamBillUserDTO['bill_party'] == 'Student') {
            $createExamBillUserDTO['exam_private_candidate_id'] = null;
        }
        if ($createExamBillUserDTO['bill_party'] == 'Exam Private Candidate') {
            $createExamBillUserDTO['student_id'] = null;
        }

        $system_data['serial_number_prefix'] = 'NY/EXAM-BILL';
        $maxDigits = ExamBill::where(function (Builder $receipt_query) {
            $serial_number_financial_year = (date('m') > 3) ? date('y').'-'.(date('y') + 1) : (date('y') - 1).'-'.date('y');
            $receipt_query->where('serial_number_financial_year', '=', $serial_number_financial_year);
        })->max('serial_number_digits');

        if ($maxDigits > 0) {
            $serial_number_digits = (int) $maxDigits + 1;
        } else {
            $serial_number_digits = 1;
        }
        $system_data['serial_number_digits'] = $serial_number_digits;
        $system_data['serial_number_current_year'] = date('y');
        $system_data['serial_number_financial_year'] = (date('m') > 3) ? date('y').'-'.(date('y') + 1) : (date('y') - 1).'-'.date('y');
        $system_data['serial_number_suffix'] = '';
        if ($system_data['serial_number_suffix'] == '') {
            $system_data['serial_number'] = $system_data['serial_number_prefix'].'/'.$system_data['serial_number_current_year'].'/'.$system_data['serial_number_financial_year'].'/'.$system_data['serial_number_digits'];
        } else {
            $system_data['serial_number'] = $system_data['serial_number_prefix'].'/'.$system_data['serial_number_current_year'].'/'.$system_data['serial_number_financial_year'].'/'.$system_data['serial_number_digits'].'/'.$system_data['serial_number_suffix'];
        }
        $system_data['created_by'] = $actionData['created_by'];
        $system_data['exam_subjects_total'] = 0;
        $system_data['exam_service_charges_total'] = 0;
        $system_data['subtotal'] = 0;
        $system_data['total'] = 0;

        $createExamBillSystemDTO = CreateExamBillSystemDTO::validate($system_data);
        $createExamBillDTO = CreateExamBillDTO::validate(array_merge($createExamBillUserDTO, $createExamBillSystemDTO));
        $createdExamBill = ExamBill::create($createExamBillDTO);

        $examBillItemList = $createExamBillUserDTO['exam_bill_item_list'] ?? [];
        foreach ($examBillItemList as $item) {
            $item['exam_bill_id'] = $createdExamBill->id; // Assign exam_bill_id
            $createExamBillItemUserDTO = CreateExamBillItemUserDTO::validate($item);
            $ExamBillItemactionData = ['created_by' => $actionData['created_by']];
            CreateExamBillItemAction::run($createExamBillItemUserDTO, $ExamBillItemactionData);
        }

        //get total amount from exam bill item table
        $examBillItemList = ExamBillItem::where('exam_bill_id', $createdExamBill->id)->get();
        $updatable_data = [];

        $exam_service_charge_item_rate = ItemRate::where([
            ['exam_service_charge_id', 1],
            ['is_active', true],
        ])->first();
        $practical_component_service_charge_item_rate = ItemRate::where([
            ['exam_service_charge_id', 2],
            ['is_active', true],
        ])->first();
        $private_candidate_service_charge_item_rate = ItemRate::where([
            ['exam_service_charge_id', 3],
            ['is_active', true],
        ])->first();

        $examServiceChargeDataList = [];
        $updatable_data['exam_subjects_total'] = 0;
        $updatable_data['exam_service_charges_total'] = 0;
        $updatable_data['subtotal'] = 0;
        $updatable_data['total'] = 0;
        foreach ($examBillItemList as $examBillItem) {
            foreach ($examBillItem->exam_subject_list as $examSubject) {
                if ($createExamBillUserDTO['bill_party'] == 'Exam Private Candidate' && $examSubject->has_practical_component == true) {
                    $examServiceChargeDataList[2] = [
                        'exam_service_charge_rate_id' => $practical_component_service_charge_item_rate->id,
                        'exam_service_charge_rate' => $practical_component_service_charge_item_rate->rate,
                    ];
                    $updatable_data['exam_service_charges_total'] += $practical_component_service_charge_item_rate->rate;
                }
            }
            $updatable_data['exam_subjects_total'] += $examBillItem->total;
        }
        $examServiceChargeDataList[1] = [
            'exam_service_charge_rate_id' => $exam_service_charge_item_rate->id,
            'exam_service_charge_rate' => $exam_service_charge_item_rate->rate,
        ];
        $updatable_data['exam_service_charges_total'] += $exam_service_charge_item_rate->rate;
        if ($createdExamBill->bill_party == 'Exam Private Candidate') {
            $examServiceChargeDataList[3] = [
                'exam_service_charge_rate_id' => $private_candidate_service_charge_item_rate->id,
                'exam_service_charge_rate' => $private_candidate_service_charge_item_rate->rate,
            ];
            $updatable_data['exam_service_charges_total'] += $private_candidate_service_charge_item_rate->rate;
        }
        if ($createdExamBill->additional_service_charge > 0) {
            $updatable_data['exam_service_charges_total'] += $createdExamBill->additional_service_charge;
        }
        $updatable_data['subtotal'] = $updatable_data['exam_subjects_total'] + $updatable_data['exam_service_charges_total'];
        if ($createdExamBill->exam_bill_discount > 0) {
            $updatable_data['total'] = $updatable_data['subtotal'] - $createdExamBill->exam_bill_discount;
        } else {
            $updatable_data['total'] = $updatable_data['subtotal'] - 0;
        }

        ExamBill::where('id', $createdExamBill->id)->first()->exam_service_charge_list()->sync($examServiceChargeDataList);
        ExamBill::where('id', $createdExamBill->id)->update($updatable_data);

        $createdExamBill = ExamBill::find($createdExamBill->id);

        // create invoice log
        $logData['description'] = '[STATUS: Created Exam Bill, IP: '.$_SERVER['REMOTE_ADDR'].', INVOICE: .'.$createdExamBill->serial_number.', USER: '.$actionData['username'].'] ';
        $logData['user_name'] = $actionData['username'];
        $logData['type'] = 'Exam Bill';
        CreateInvoicesLogAction::run($logData, ['created_by' => $actionData['created_by']]);

        return $createdExamBill;
    }
}
