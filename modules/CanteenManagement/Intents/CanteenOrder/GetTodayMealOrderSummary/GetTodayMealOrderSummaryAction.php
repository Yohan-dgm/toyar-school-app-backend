<?php

namespace Modules\CanteenManagement\Intents\CanteenOrder\GetTodayMealOrderSummary;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CanteenManagement\Models\CanteenOrderItem;

class GetTodayMealOrderSummaryAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getTodayMealOrderSummaryUserDTO = GetTodayMealOrderSummaryUserDTO::validate($payloadArray);

        $date = ! empty($getTodayMealOrderSummaryUserDTO['date'])
            ? Carbon::parse($getTodayMealOrderSummaryUserDTO['date'])->toDateString()
            : Carbon::today()->toDateString();

        // Cancelled orders don't need to be prepared, so they're excluded
        // from kitchen-facing demand totals.
        return CanteenOrderItem::join('canteen_order', 'canteen_order_item.canteen_order_id', '=', 'canteen_order.id')
            ->whereDate('canteen_order.order_date', $date)
            ->where('canteen_order.status', '!=', 'Cancelled')
            ->select(
                'canteen_order_item.meal_plan_id',
                'canteen_order_item.meal_plan_title',
                DB::raw('SUM(canteen_order_item.quantity) as total_quantity'),
                DB::raw('COUNT(DISTINCT canteen_order.id) as order_count')
            )
            ->groupBy('canteen_order_item.meal_plan_id', 'canteen_order_item.meal_plan_title')
            ->orderByDesc('total_quantity')
            ->get();
    }
}
