<?php

namespace Modules\AccountManagement\Intents\ItemRateStatus\CreateItemRateStatus;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\ItemRate;
use Modules\AccountManagement\Models\ItemRateStatus;

class CreateItemRateStatusAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createItemRateStatusUserDTO = CreateItemRateStatusUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];
        // System Data Prep
        $system_data['created_by'] = $actionData['created_by'];
        $system_data['status_changed_by_id'] = $actionData['status_changed_by_id'];
        $system_data['is_active'] = true;

        // System Data Validation
        $createItemRateStatusSystemDTO = CreateItemRateStatusSystemDTO::validate($system_data);

        // Final Data Validation
        $createItemRateStatusDTO = CreateItemRateStatusDTO::validate(array_merge($createItemRateStatusUserDTO, $createItemRateStatusSystemDTO));

        // Save In Database
        $itemRateStatusList = ItemRateStatus::where('item_rate_id', $createItemRateStatusDTO['item_rate_id'])->get();

        // make other statuses inactive
        if (! is_null($itemRateStatusList)) {
            foreach ($itemRateStatusList as $itemRateStatus) {
                $data = [];
                $data['is_active'] = false;
                ItemRateStatus::where('id', $itemRateStatus->id)->update($data);
            }
        }

        // create new ItemRateStatus
        $itemRateStatus = ItemRateStatus::create($createItemRateStatusDTO);

        // update ItemRate
        $data = [];
        $data['item_rate_status_id'] = $itemRateStatus->id;
        if ($itemRateStatus->item_rate_status_type_id == 2) {
            $data['is_active'] = true;
        }
        ItemRate::where('id', $itemRateStatus->item_rate_id)->update($data);

        $itemRate = ItemRate::where('id', $itemRateStatus->item_rate_id)->with([
            'item_rate_status.item_rate_status_type' => function (Builder $query) {
                $query->select('id', 'name');
            },
        ])->get();

        return $itemRate;
    }
}
