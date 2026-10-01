<?php

namespace Modules\CanteenManagement\Intents\MealPlan\GetMealPlanListData;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CanteenManagement\Models\CanteenMealPlan;

class GetMealPlanListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getMealPlanListDataUserDTO = GetMealPlanListDataUserDTO::validate($payloadArray);

        $query = CanteenMealPlan::query();

        if (! empty($getMealPlanListDataUserDTO['search_phrase'])) {
            $query->where('title', 'ILIKE', '%'.$getMealPlanListDataUserDTO['search_phrase'].'%');
        }

        return $query->orderBy('created_at', 'desc')
            ->paginate(
                $perPage = $getMealPlanListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getMealPlanListDataUserDTO['page']
            );
    }
}
