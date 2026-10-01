<?php

namespace Modules\CanteenManagement\Intents\CanteenOrder\UpdateCanteenOrderStatus;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CanteenManagement\Models\CanteenMealPlan;
use Modules\CanteenManagement\Models\CanteenOrder;

class UpdateCanteenOrderStatusAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateCanteenOrderStatusUserDTO = UpdateCanteenOrderStatusUserDTO::validate($payloadArray);

        $order = CanteenOrder::with('items')->find($updateCanteenOrderStatusUserDTO['id']);
        if (! $order) {
            throw new \Exception('Order not found');
        }

        $targetStatus = $updateCanteenOrderStatusUserDTO['status'];

        // Pending -> Completed/Cancelled is the normal flow; Completed -> Pending
        // lets an educator undo an accidental "Complete" tap. Cancelled orders
        // are final (their stock has already been returned to the catalog).
        $allowedTransitions = [
            'Pending' => ['Completed', 'Cancelled'],
            'Completed' => ['Pending'],
        ];
        if (empty($allowedTransitions[$order->status]) || ! in_array($targetStatus, $allowedTransitions[$order->status], true)) {
            throw new \Exception("Cannot change order from {$order->status} to {$targetStatus}");
        }

        return DB::transaction(function () use ($order, $targetStatus, $actionData) {
            // Cancelling releases the reserved stock back to the catalog,
            // same as a parent-initiated cancellation; completing an order
            // (or undoing that back to Pending) does not touch stock since
            // it was already deducted at order time.
            if ($targetStatus === 'Cancelled') {
                foreach ($order->items as $item) {
                    CanteenMealPlan::where('id', $item->meal_plan_id)->increment('quantity_available', $item->quantity);
                }
            }

            $order->update([
                'status' => $targetStatus,
                'updated_by' => $actionData['updated_by'],
            ]);

            return $order->fresh('items');
        });
    }
}
