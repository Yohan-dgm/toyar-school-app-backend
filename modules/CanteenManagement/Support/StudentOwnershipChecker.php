<?php

namespace Modules\CanteenManagement\Support;

use Modules\UserManagement\Models\UserPaymentStudent;

class StudentOwnershipChecker
{
    /**
     * Whether $userId is the paying parent/guardian behind $studentId's
     * active access, i.e. safe to let them spend the student's canteen
     * stock or cancel/create orders on the student's behalf.
     */
    public static function guardianOwnsStudent(int $userId, int $studentId): bool
    {
        return UserPaymentStudent::where('student_id', $studentId)
            ->where('is_active', true)
            ->whereHas('user_payment', function ($query) use ($userId) {
                $query->where('user_id', $userId)->where('is_active', true);
            })
            ->exists();
    }
}
