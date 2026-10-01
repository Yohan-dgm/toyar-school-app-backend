<?php

namespace Modules\AccountManagement\Intents\ExamBill\UpdateExamBill;

use Illuminate\Support\Facades\DB;
use Modules\AccountManagement\Intents\ExamBillItem\CreateExamBillItem\CreateExamBillItemAction;
use Modules\AccountManagement\Intents\ExamBillItem\CreateExamBillItem\CreateExamBillItemUserDTO;
use Modules\AccountManagement\Models\ExamBill;
use Modules\AccountManagement\Models\ExamBillItem;
use Modules\AccountManagement\Models\ItemRate;
use Modules\LogManagement\Intents\InvoicesLog\CreateInvoicesLog\CreateInvoicesLogAction;

class UpdateExamBillAction
{
    use \Lorisleiva\Actions\Concerns\AsAction;

    public function handle($payloadArray, $actionData)
    {
        $updateExamBillUserDTO = UpdateExamBillUserDTO::validate($payloadArray);

        if ($updateExamBillUserDTO['bill_party'] == 'Student') {
            $updateExamBillUserDTO['exam_private_candidate_id'] = null;
        }
        if ($updateExamBillUserDTO['bill_party'] == 'Exam Private Candidate') {
            $updateExamBillUserDTO['student_id'] = null;
        }

        $system_data = [];
        $system_data['updated_by'] = $actionData['updated_by'];
        $system_data['exam_subjects_total'] = 0;
        $system_data['exam_service_charges_total'] = 0;
        $system_data['subtotal'] = 0;
        $system_data['total'] = 0;

        $updateExamBillSystemDTO = UpdateExamBillSystemDTO::validate($system_data);
        $updateExamBillDTO = UpdateExamBillDTO::validate(array_merge($updateExamBillUserDTO, $updateExamBillSystemDTO));
        ExamBill::where('id', $updateExamBillUserDTO['id'])->update($updateExamBillDTO);

        $examBillItemList = $updateExamBillUserDTO['exam_bill_item_list'] ?? [];
        foreach ($examBillItemList as $item) {
            // delete exam subjects for existing bill items
            if (! str_contains(strval($item['id']), '-')) {
                // ExamBillItem::where("id", intval($item['id']))->first()->exam_subject_list()->delete();
                DB::table('exam_bill_item_exam_subject_pivot')->where('exam_bill_item_id', intval($item['id']))->delete();
            }
        }
        // delete existing bill items
        ExamBill::where('id', $updateExamBillUserDTO['id'])->first()->exam_bill_item_list()->delete();
        // create new bill items
        foreach ($examBillItemList as $item) {
            $item['exam_bill_id'] = $updateExamBillUserDTO['id']; // Assign exam_bill_id
            $updateExamBillItemUserDTO = CreateExamBillItemUserDTO::validate($item);
            $ExamBillItemactionData = ['created_by' => $actionData['updated_by']];
            CreateExamBillItemAction::run($updateExamBillItemUserDTO, $ExamBillItemactionData);
        }

        //get total amount from exam bill item table
        // $examBillItemList = ExamBillItem::where('exam_bill_id', $updateExamBillUserDTO['id'])->get();
        // $subtotal = 0;
        // $total = 0;
        // foreach ($examBillItemList as $examBillItem) {
        //     $subtotal += $examBillItem->total;
        // }
        // $system_data['subtotal'] = $subtotal;
        // $system_data['total'] = $subtotal;

        // $updateExamBillSystemDTO = UpdateExamBillSystemDTO::validate($system_data);
        // $updateExamBillDTO = UpdateExamBillDTO::validate(array_merge($updateExamBillUserDTO, $updateExamBillSystemDTO));
        // ExamBill::where("id", $updateExamBillUserDTO['id'])->update($updateExamBillDTO);

        // $updatedExamBill = ExamBill::where("id", $updateExamBillUserDTO['id'])->get();
        // return $updatedExamBill;

        $examBillItemList = ExamBillItem::where('exam_bill_id', $updateExamBillUserDTO['id'])->get();
        $updatedExamBill = ExamBill::where('id', $updateExamBillUserDTO['id'])->first();

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
                if ($updateExamBillUserDTO['bill_party'] == 'Exam Private Candidate' && $examSubject->has_practical_component == true) {
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
        if ($updatedExamBill->bill_party == 'Exam Private Candidate') {
            $examServiceChargeDataList[3] = [
                'exam_service_charge_rate_id' => $private_candidate_service_charge_item_rate->id,
                'exam_service_charge_rate' => $private_candidate_service_charge_item_rate->rate,
            ];
            $updatable_data['exam_service_charges_total'] += $private_candidate_service_charge_item_rate->rate;
        }
        if ($updatedExamBill->additional_service_charge > 0) {
            $updatable_data['exam_service_charges_total'] += $updatedExamBill->additional_service_charge;
        }
        $updatable_data['subtotal'] = $updatable_data['exam_subjects_total'] + $updatable_data['exam_service_charges_total'];
        if ($updatedExamBill->exam_bill_discount > 0) {
            $updatable_data['total'] = $updatable_data['subtotal'] - $updatedExamBill->exam_bill_discount;
        } else {
            $updatable_data['total'] = $updatable_data['subtotal'] - 0;
        }

        ExamBill::where('id', $updatedExamBill->id)->first()->exam_service_charge_list()->sync($examServiceChargeDataList);
        ExamBill::where('id', $updatedExamBill->id)->update($updatable_data);

        $updatedExamBill = ExamBill::find($updatedExamBill->id);

        // create invoice log
        $logData['description'] = '[STATUS: Updated Exam Bill, IP: '.$_SERVER['REMOTE_ADDR'].', INVOICE: .'.$updatedExamBill->serial_number.', USER: '.$actionData['username'].'] ';
        $logData['user_name'] = $actionData['username'];
        $logData['type'] = 'Exam Bill';
        CreateInvoicesLogAction::run($logData, ['created_by' => $actionData['updated_by']]);

        return $updatedExamBill;
    }
}
