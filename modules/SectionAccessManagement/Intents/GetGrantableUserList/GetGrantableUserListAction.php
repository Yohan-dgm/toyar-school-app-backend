<?php

namespace Modules\SectionAccessManagement\Intents\GetGrantableUserList;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\UserManagement\Models\User;

class GetGrantableUserListAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getGrantableUserListUserDTO = GetGrantableUserListUserDTO::validate($payloadArray);

        $query = User::select('id', 'full_name', 'username', 'user_category');

        if (! empty($getGrantableUserListUserDTO['search_phrase'])) {
            $searchPhrase = $getGrantableUserListUserDTO['search_phrase'];
            $query->where(function ($searchQuery) use ($searchPhrase) {
                $searchQuery->where('full_name', 'ILIKE', '%'.$searchPhrase.'%')
                    ->orWhere('username', 'ILIKE', '%'.$searchPhrase.'%')
                    ->orWhere('email', 'ILIKE', '%'.$searchPhrase.'%');
            });
        }

        return $query->orderBy('full_name')->limit(20)->get();
    }
}
