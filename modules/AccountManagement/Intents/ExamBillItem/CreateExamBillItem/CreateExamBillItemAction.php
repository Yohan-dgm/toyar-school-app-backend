<?php

namespace Modules\AccountManagement\Intents\ExamBillItem\CreateExamBillItem;

use Modules\AccountManagement\Models\ExamBillItem;
use Modules\AccountManagement\Models\ItemRate;

class CreateExamBillItemAction
{
    use \Lorisleiva\Actions\Concerns\AsAction;

    public function handle($payloadArray, $actionData)
    {
        $createExamBillItemUserDTO = CreateExamBillItemUserDTO::validate($payloadArray);

        $rate_id_list = [];
        $rate_list = [];
        $subtotal = 0;
        $total = 0;
        $examSubjectDataList = [];
        foreach ($createExamBillItemUserDTO['exam_subject_list'] as $examSubject) {
            $itemRate = ItemRate::where([
                ['exam_subject_id', $examSubject['id']],
                ['is_active', true],
            ])->first();

            if (! $itemRate) {
                array_push($rate_id_list, 0);
                array_push($rate_list, 0);
                $subtotal = $subtotal + 0;
                $total = $total + 0;
            } else {
                array_push($rate_id_list, $itemRate->id);
                array_push($rate_list, $itemRate->rate);
                $subtotal = $subtotal + $itemRate->rate;
                $total = $total + $itemRate->rate;
            }
            $examSubjectDataList[$examSubject['id']] = [
                'exam_subject_rate_id' => $itemRate->id,
                'exam_subject_rate' => $itemRate->rate,
            ];
        }
        $system_data = [
            'created_by' => $actionData['created_by'],
            'rate_id_list' => implode(', ', $rate_id_list),
            'rate_list' => implode(', ', $rate_list),
            'subtotal' => $subtotal,
            'total' => $total,
        ];

        $createExamBillItemSystemDTO = CreateExamBillItemSystemDTO::validate($system_data);
        $createExamBillItemDTO = CreateExamBillItemDTO::validate(array_merge($createExamBillItemUserDTO, $createExamBillItemSystemDTO));
        $examBillItem = ExamBillItem::create($createExamBillItemDTO);
        $examBillItem->exam_subject_list()->sync($examSubjectDataList);
        $examBillItem = ExamBillItem::find($examBillItem->id);

        return $examBillItem;
    }
}
