<?php

namespace Modules\CanteenManagement\Intents\CanteenOrder\GetCanteenOrderListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CanteenManagement\Models\CanteenOrder;

class GetCanteenOrderListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getCanteenOrderListDataUserDTO = GetCanteenOrderListDataUserDTO::validate($payloadArray);

        $query = CanteenOrder::with([
            'items',
            'student' => function (Builder $studentQuery) {
                $studentQuery->select('id', 'full_name', 'full_name_with_title', 'admission_number', 'grade_level_class_id')
                    ->with('grade_level_class:id,name');
            },
        ]);

        if (! empty($getCanteenOrderListDataUserDTO['status'])) {
            $query->where('status', $getCanteenOrderListDataUserDTO['status']);
        }

        if (! empty($getCanteenOrderListDataUserDTO['order_date'])) {
            $query->whereDate('order_date', $getCanteenOrderListDataUserDTO['order_date']);
        }

        if (! empty($getCanteenOrderListDataUserDTO['search_phrase'])) {
            $searchPhrase = $getCanteenOrderListDataUserDTO['search_phrase'];
            $query->whereHas('student', function (Builder $studentQuery) use ($searchPhrase) {
                $studentQuery->where('full_name', 'ILIKE', '%'.$searchPhrase.'%')
                    ->orWhere('admission_number', 'ILIKE', '%'.$searchPhrase.'%');
            });
        }

        return $query->orderBy('order_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(
                $perPage = $getCanteenOrderListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getCanteenOrderListDataUserDTO['page']
            );
    }
}
