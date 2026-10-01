<?php

namespace Modules\UserManagement\Intents\UserPayment\GetCurrentUserPayments;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\UserManagement\Models\UserPayment;

class GetCurrentUserPaymentsAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $validatedData = GetCurrentUserPaymentsUserDTO::validate($payloadArray);
        
        // Get current user ID from action data
        $currentUserId = $actionData['user_id'];
        
        if (!$currentUserId) {
            throw new \Exception('User ID is required');
        }

        // Build base query for current user's payments
        $paymentsQuery = UserPayment::where('user_id', $currentUserId);

        // Mandatory filter: only show payments valid for current date
        $paymentsQuery->where('start_date', '<=', now()->toDateString())
                     ->where(function ($query) {
                         $query->where('end_date', '>=', now()->toDateString())
                               ->orWhereNull('end_date');
                     });

        // Apply active only filter
        if (isset($validatedData['active_only']) && $validatedData['active_only'] === true) {
            $paymentsQuery->where('is_active', true);
        }

        // Apply package type filter
        if (isset($validatedData['package_type'])) {
            $paymentsQuery->where('package_type', $validatedData['package_type']);
        }

        // Include relationships based on request
        $relationships = [];
        
        if (!isset($validatedData['include_students']) || $validatedData['include_students'] === true) {
            $relationships['user_payment_students'] = function (Builder $ups_query) {
                $ups_query->select("id", "user_payment_id", "student_id", "is_active", "start_date", "end_date", "access_level", "created_at")
                    ->with(['student' => function (Builder $student_query) {
                        $student_query->select("id", "full_name", "admission_number", "grade_level_id")
                            ->with(['grade_level' => function (Builder $grade_level_query) {
                                $grade_level_query->select("id", "name");
                            }]);
                    }]);
            };
        }

        // Always include basic user info
        $relationships['user'] = function (Builder $user_query) {
            $user_query->select("id", "full_name", "username", "email", "user_category");
        };

        $paymentsQuery->with($relationships);

        // Select specific columns for main query
        $paymentsQuery->select(
            "id",
            "user_id", 
            "package_type",
            "is_active",
            "start_date",
            "end_date",
            "amount",
            "currency",
            "payment_method",
            "transaction_reference",
            "notes",
            "created_at",
            "updated_at"
        );

        // Order by latest first
        $paymentsQuery->orderBy("created_at", "desc");

        // Get all payments (no pagination for current user)
        $payments = $paymentsQuery->get();

        // Transform payments to include computed fields
        $paymentsData = [];
        foreach ($payments as $payment) {
            $paymentData = [
                'id' => $payment->id,
                'package_type' => $payment->package_type,
                'package_type_display' => $payment->package_type_display,
                'is_active' => $payment->is_active,
                'start_date' => $payment->start_date,
                'end_date' => $payment->end_date,
                'amount' => $payment->amount,
                'currency' => $payment->currency,
                'payment_method' => $payment->payment_method,
                'transaction_reference' => $payment->transaction_reference,
                'notes' => $payment->notes,
                'status' => $payment->status,
                'is_currently_valid' => $payment->isCurrentlyValid(),
                'created_at' => $payment->created_at,
                'updated_at' => $payment->updated_at,
                'students' => [],
                'student_count' => 0,
                'active_student_count' => 0,
            ];

            // Add students if included
            if ((!isset($validatedData['include_students']) || $validatedData['include_students'] === true) && $payment->user_payment_students) {
                foreach ($payment->user_payment_students as $ups) {
                    if ($ups->student) {
                        $paymentData['students'][] = [
                            'id' => $ups->student->id,
                            'full_name' => $ups->student->full_name,
                            'admission_number' => $ups->student->admission_number,
                            'grade_level' => $ups->student->grade_level ? [
                                'id' => $ups->student->grade_level->id,
                                'name' => $ups->student->grade_level->name,
                            ] : null,
                            'access_level' => $ups->access_level,
                            'ups_start_date' => $ups->start_date,
                            'ups_end_date' => $ups->end_date,
                            'ups_is_active' => $ups->is_active,
                            'ups_status' => $ups->status,
                            'ups_is_currently_valid' => $ups->isCurrentlyValid(),
                        ];
                    }
                }
                
                $paymentData['student_count'] = $payment->user_payment_students->count();
                $paymentData['active_student_count'] = $payment->user_payment_students->where('is_active', true)->count();
            }

            $paymentsData[] = $paymentData;
        }

        // Return summary data
        return [
            'payments' => $paymentsData,
            'summary' => [
                'total_payments' => count($paymentsData),
                'active_payments' => collect($paymentsData)->where('is_active', true)->count(),
                'valid_payments' => collect($paymentsData)->where('is_currently_valid', true)->count(),
                'total_students' => collect($paymentsData)->sum('student_count'),
                'total_active_students' => collect($paymentsData)->sum('active_student_count'),
            ]
        ];
    }
}