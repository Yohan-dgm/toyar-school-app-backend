<?php

namespace Modules\CanteenManagement\Intents\CanteenOrder\CompleteAllPendingCanteenOrders;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CanteenManagement\Models\CanteenOrder;

class CompleteAllPendingCanteenOrdersAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $completeAllPendingCanteenOrdersUserDTO = CompleteAllPendingCanteenOrdersUserDTO::validate($payloadArray);

        $query = CanteenOrder::where('status', 'Pending');

        if (! empty($completeAllPendingCanteenOrdersUserDTO['order_date'])) {
            $query->whereDate('order_date', $completeAllPendingCanteenOrdersUserDTO['order_date']);
        }

        if (! empty($completeAllPendingCanteenOrdersUserDTO['search_phrase'])) {
            $searchPhrase = $completeAllPendingCanteenOrdersUserDTO['search_phrase'];
            $query->whereHas('student', function (Builder $studentQuery) use ($searchPhrase) {
                $studentQuery->where('full_name', 'ILIKE', '%'.$searchPhrase.'%')
                    ->orWhere('admission_number', 'ILIKE', '%'.$searchPhrase.'%');
            });
        }

        return DB::transaction(function () use ($query, $actionData) {
            // Completing doesn't touch meal-plan stock (it was already
            // deducted at order-creation time), so this is a plain bulk
            // status update - safe to do in one query rather than looping.
            $updatedCount = $query->count();
            $query->update([
                'status' => 'Completed',
                'updated_by' => $actionData['updated_by'],
            ]);

            return ['updated_count' => $updatedCount];
        });
    }
}
