<?php

namespace Modules\CanteenManagement\Intents\CanteenOrder\GetMyCanteenOrderListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CanteenManagement\Models\CanteenOrder;

class GetMyCanteenOrderListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getMyCanteenOrderListDataUserDTO = GetMyCanteenOrderListDataUserDTO::validate($payloadArray);

        // Scoped to the requesting parent (ordered_by), not a single student -
        // a parent sees every order they've placed, across all their children.
        $query = CanteenOrder::where('ordered_by', $actionData['user_id']);

        if (! empty($getMyCanteenOrderListDataUserDTO['status'])) {
            $query->where('status', $getMyCanteenOrderListDataUserDTO['status']);
        }

        return $query
            ->with([
                'items',
                'student' => function (Builder $studentQuery) {
                    $studentQuery->select('id', 'full_name', 'full_name_with_title', 'admission_number', 'grade_level_class_id')
                        ->with('grade_level_class:id,name');
                },
            ])
            ->orderBy('order_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(
                $perPage = $getMyCanteenOrderListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getMyCanteenOrderListDataUserDTO['page']
            );
    }
}
