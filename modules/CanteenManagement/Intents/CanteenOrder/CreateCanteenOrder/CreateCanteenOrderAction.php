<?php

namespace Modules\CanteenManagement\Intents\CanteenOrder\CreateCanteenOrder;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CanteenManagement\Models\CanteenMealPlan;
use Modules\CanteenManagement\Models\CanteenOrder;
use Modules\CanteenManagement\Models\CanteenOrderItem;
use Modules\CanteenManagement\Support\CanteenOrderNotifier;
use Modules\CanteenManagement\Support\StudentOwnershipChecker;
use Modules\StudentManagement\Models\Student;

class CreateCanteenOrderAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createCanteenOrderUserDTO = CreateCanteenOrderUserDTO::validate($payloadArray);

        $student = Student::find($createCanteenOrderUserDTO['student_id']);
        if (! $student) {
            throw new \Exception('Student not found');
        }

        if (! StudentOwnershipChecker::guardianOwnsStudent($actionData['user']->id, $createCanteenOrderUserDTO['student_id'])) {
            throw new \Exception('You do not have access to place canteen orders for this student');
        }

        $orderDate = Carbon::parse($createCanteenOrderUserDTO['order_date'])->startOfDay();
        if ($orderDate->lt(Carbon::today())) {
            throw new \Exception('order_date cannot be in the past');
        }

        return DB::transaction(function () use ($createCanteenOrderUserDTO, $actionData, $orderDate, $student) {
            $totalAmount = 0;
            $itemRows = [];

            foreach ($createCanteenOrderUserDTO['items'] as $item) {
                $mealPlan = CanteenMealPlan::where('id', $item['meal_plan_id'])->lockForUpdate()->first();
                if (! $mealPlan || ! $mealPlan->is_active) {
                    throw new \Exception('Meal plan '.$item['meal_plan_id'].' is not available');
                }
                if ($item['quantity'] > $mealPlan->quantity_available) {
                    throw new \Exception('Only '.$mealPlan->quantity_available.' left for "'.$mealPlan->title.'"');
                }

                $subtotal = round($mealPlan->price * $item['quantity'], 2);
                $totalAmount += $subtotal;

                $itemRows[] = [
                    'meal_plan' => $mealPlan,
                    'quantity' => $item['quantity'],
                    'subtotal' => $subtotal,
                ];
            }

            $order = CanteenOrder::create([
                'student_id' => $createCanteenOrderUserDTO['student_id'],
                'ordered_by' => $actionData['created_by'],
                'order_date' => $orderDate->toDateString(),
                'status' => 'Pending',
                'total_amount' => $totalAmount,
                'created_by' => $actionData['created_by'],
            ]);

            foreach ($itemRows as $row) {
                CanteenOrderItem::create([
                    'canteen_order_id' => $order->id,
                    'meal_plan_id' => $row['meal_plan']->id,
                    'meal_plan_title' => $row['meal_plan']->title,
                    'unit_price' => $row['meal_plan']->price,
                    'quantity' => $row['quantity'],
                    'subtotal' => $row['subtotal'],
                ]);

                $row['meal_plan']->decrement('quantity_available', $row['quantity']);
            }

            $freshOrder = $order->fresh('items');

            CanteenOrderNotifier::notify($freshOrder, $student);

            return $freshOrder;
        });
    }
}
