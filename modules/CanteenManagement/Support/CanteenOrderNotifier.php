<?php

namespace Modules\CanteenManagement\Support;

use Illuminate\Support\Facades\Log;
use Modules\CanteenManagement\Models\CanteenOrder;
use Modules\CommunicationManagement\Services\NotificationService;
use Modules\SectionAccessManagement\Models\SectionAccess;
use Modules\StudentManagement\Models\Student;
use Modules\UserManagement\Models\User;

class CanteenOrderNotifier
{
    /**
     * Push-notify canteen staff that a new order has come in. Recipients are
     * every Canteen-category (12) account plus anyone individually granted
     * the "canteen_management" section-access key - the same set of people
     * who can see the Canteen Management screen.
     */
    public static function notify(CanteenOrder $order, Student $student): void
    {
        try {
            $canteenCategoryIds = User::where('user_category', 12)->pluck('id');
            $grantedStaffIds = SectionAccess::where('section_key', 'canteen_management')->pluck('user_id');
            $recipientUserIds = $canteenCategoryIds->merge($grantedStaffIds)->unique()->values()->toArray();

            if (empty($recipientUserIds)) {
                Log::info('CanteenOrderNotifier: no canteen staff accounts to notify, skipping', [
                    'canteen_order_id' => $order->id,
                ]);

                return;
            }

            $studentName = $student->full_name ?? 'A student';

            app(NotificationService::class)->sendModuleNotification(
                'New Canteen Order',
                "{$studentName} has a new canteen order for {$order->order_date->toFormattedDateString()} (Rs. {$order->total_amount}).",
                $recipientUserIds,
                'alert',
                'normal',
                "canteen-order?order_id={$order->id}"
            );
        } catch (\Throwable $e) {
            Log::error('CanteenOrderNotifier failed', [
                'canteen_order_id' => $order->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
