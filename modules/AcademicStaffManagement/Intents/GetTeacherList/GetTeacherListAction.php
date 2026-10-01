<?php

namespace Modules\AcademicStaffManagement\Intents\GetTeacherList;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\UserManagement\Models\User;

class GetTeacherListAction
{
    use AsAction;

    public function handle()
    {
        // Query teachers (user_category 2 = Educator, 4 = Principal)
        $teachers = User::where('is_active', true)
            ->whereIn('user_category', [2, 4])
            ->select('id', 'full_name')
            ->orderBy('full_name', 'asc')
            ->get();

        return $teachers;
    }
}
