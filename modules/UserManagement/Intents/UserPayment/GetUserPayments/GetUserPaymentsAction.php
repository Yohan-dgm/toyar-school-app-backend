<?php

namespace Modules\UserManagement\Intents\UserPayment\GetUserPayments;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\UserManagement\Models\UserPayment;

class GetUserPaymentsAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $validatedData = GetUserPaymentsUserDTO::validate($payloadArray);

        // Build base query with comprehensive relationships
        $paymentsQuery = UserPayment::with([
            'user' => function (Builder $user_query) {
                $user_query->select("id", "full_name", "username", "email", "user_category");
            },
            'user_payment_students' => function (Builder $ups_query) {
                $ups_query->select("id", "user_payment_id", "student_id", "is_active", "start_date", "end_date", "access_level", "created_at")
                    ->with(['student' => function (Builder $student_query) {
                        $student_query->select("id", "full_name", "admission_number", "grade_level_id")
                            ->with(['grade_level' => function (Builder $grade_level_query) {
                                $grade_level_query->select("id", "name");
                            }]);
                    }]);
            },
            'created_by_user' => function (Builder $created_by_query) {
                $created_by_query->select("id", "call_name_with_title");
            },
        ]);

        // Apply user_id filter
        if (isset($validatedData['user_id'])) {
            $paymentsQuery->where('user_id', $validatedData['user_id']);
        }

        // Apply package_type filter
        if (isset($validatedData['package_type'])) {
            $paymentsQuery->where('package_type', $validatedData['package_type']);
        }

        // Apply is_active filter
        if (isset($validatedData['is_active'])) {
            $paymentsQuery->where('is_active', $validatedData['is_active']);
        }

        // Apply date filters
        if (isset($validatedData['date_from'])) {
            $paymentsQuery->whereDate('start_date', '>=', $validatedData['date_from']);
        }

        if (isset($validatedData['date_to'])) {
            $paymentsQuery->whereDate('start_date', '<=', $validatedData['date_to']);
        }

        // Apply search phrase filter
        if (isset($validatedData['search_phrase']) && !empty($validatedData['search_phrase'])) {
            $paymentsQuery->where(function (Builder $search_query) use ($validatedData) {
                $search_query->where('transaction_reference', 'ILIKE', '%' . $validatedData['search_phrase'] . '%')
                    ->orWhere('notes', 'ILIKE', '%' . $validatedData['search_phrase'] . '%')
                    ->orWhere('payment_method', 'ILIKE', '%' . $validatedData['search_phrase'] . '%')
                    ->orWhereHas('user', function (Builder $user_search) use ($validatedData) {
                        $user_search->where('full_name', 'ILIKE', '%' . $validatedData['search_phrase'] . '%')
                                   ->orWhere('username', 'ILIKE', '%' . $validatedData['search_phrase'] . '%')
                                   ->orWhere('email', 'ILIKE', '%' . $validatedData['search_phrase'] . '%');
                    });
            });
        }

        // Apply status filter (calculated field)
        if (isset($validatedData['status'])) {
            switch ($validatedData['status']) {
                case 'active':
                    $paymentsQuery->where('is_active', true)
                                 ->where('start_date', '<=', now()->toDateString())
                                 ->where(function ($q) {
                                     $q->where('end_date', '>=', now()->toDateString())
                                       ->orWhereNull('end_date');
                                 });
                    break;
                    
                case 'inactive':
                    $paymentsQuery->where('is_active', false);
                    break;
                    
                case 'pending':
                    $paymentsQuery->where('is_active', true)
                                 ->where('start_date', '>', now()->toDateString());
                    break;
                    
                case 'expired':
                    $paymentsQuery->where('is_active', true)
                                 ->where('end_date', '<', now()->toDateString())
                                 ->whereNotNull('end_date');
                    break;
            }
        }

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
            "created_by",
            "created_at",
            "updated_at"
        );

        // Order by latest first
        $paymentsQuery->orderBy("created_at", "desc");

        // Validate page size limits
        $pageSize = min(max($validatedData['page_size'], 1), 100); // Limit between 1 and 100

        // Execute paginated query
        $paymentsListData = $paymentsQuery->paginate(
            $perPage = $pageSize,
            $columns = ['*'],
            $pageName = 'page',
            $page = $validatedData['page']
        );

        // Add computed fields to each payment
        $paymentsListData->getCollection()->transform(function ($payment) {
            $payment->package_type_display = $payment->package_type_display;
            $payment->status = $payment->status;
            $payment->student_count = $payment->user_payment_students->count();
            $payment->active_student_count = $payment->user_payment_students->where('is_active', true)->count();
            return $payment;
        });

        return $paymentsListData;
    }
}