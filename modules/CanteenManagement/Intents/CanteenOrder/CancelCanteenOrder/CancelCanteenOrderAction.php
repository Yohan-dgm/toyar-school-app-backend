<?php

namespace Modules\CanteenManagement\Intents\CanteenOrder\CancelCanteenOrder;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CanteenManagement\Models\CanteenMealPlan;
use Modules\CanteenManagement\Models\CanteenOrder;
use Modules\CanteenManagement\Support\StudentOwnershipChecker;

class CancelCanteenOrderAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $cancelCanteenOrderUserDTO = CancelCanteenOrderUserDTO::validate($payloadArray);

        $order = CanteenOrder::with('items')->find($cancelCanteenOrderUserDTO['id']);
        if (! $order) {
            throw new \Exception('Order not found');
        }
        if ($order->status !== 'Pending') {
            throw new \Exception('Only Pending orders can be cancelled');
        }
        if (! StudentOwnershipChecker::guardianOwnsStudent($actionData['user']->id, $order->student_id)) {
            throw new \Exception('You do not have access to cancel this order');
        }

        return DB::transaction(function () use ($order, $actionData) {
            foreach ($order->items as $item) {
                CanteenMealPlan::where('id', $item->meal_plan_id)->increment('quantity_available', $item->quantity);
            }

            $order->update([
                'status' => 'Cancelled',
                'updated_by' => $actionData['updated_by'],
            ]);

            return $order->fresh('items');
        });
    }
}
