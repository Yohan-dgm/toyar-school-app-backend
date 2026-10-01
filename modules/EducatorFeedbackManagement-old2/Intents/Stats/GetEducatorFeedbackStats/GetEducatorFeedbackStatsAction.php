<?php

namespace Modules\EducatorFeedbackManagement\Intents\Stats\GetEducatorFeedbackStats;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\EducatorFeedbackManagement\Models\EduFb;
use Modules\UserManagement\Models\User;

class GetEducatorFeedbackStatsAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        $validatedData = GetEducatorFeedbackStatsUserDTO::validate($payloadArray);

        // Build the date filter conditions
        $dateFilters = $this->buildDateFilters($validatedData);

        // Get all users with user_category 2 and 4 with their feedback counts
        $users = User::select('user.id', 'user.full_name', 'user.user_category')
            ->whereIn('user.user_category', [2, 4])
            ->where('user.is_active', true)
            ->leftJoin('edu_fb', function ($join) use ($dateFilters) {
                $join->on('user.id', '=', 'edu_fb.created_by');

                // Apply date filters if provided
                if (!empty($dateFilters)) {
                    foreach ($dateFilters as $filter) {
                        $join->whereRaw($filter);
                    }
                }
            })
            ->groupBy('user.id', 'user.full_name', 'user.user_category')
            ->selectRaw('COUNT(edu_fb.id) as feedback_count')
            ->orderBy('feedback_count', 'desc')
            ->orderBy('user.full_name', 'asc')
            ->get()
            ->map(function ($user) {
                return [
                    'user_id' => $user->id,
                    'full_name' => $user->full_name,
                    'user_category' => $user->user_category,
                    'feedback_count' => (int) $user->feedback_count,
                ];
            });

        // Calculate summary statistics
        $totalUsers = $users->count();
        $usersWithFeedback = $users->where('feedback_count', '>', 0)->count();
        $totalFeedbackCount = $users->sum('feedback_count');

        // Build filtered period string
        $filteredPeriod = $this->buildFilteredPeriodString($validatedData);

        // Build response data
        $responseData = [
            'summary' => [
                'total_users' => $totalUsers,
                'users_with_feedback' => $usersWithFeedback,
                'total_feedback_count' => $totalFeedbackCount,
                'filtered_period' => $filteredPeriod,
            ],
            'users' => $users->values()->toArray(),
        ];

        return $responseData;
    }

    /**
     * Build date filter conditions based on provided filters
     */
    private function buildDateFilters($validatedData): array
    {
        $filters = [];

        if (isset($validatedData['period'])) {
            $now = now();

            switch ($validatedData['period']) {
                case 'this_week':
                    // Get start of week (Monday) and end of week (Sunday)
                    $startOfWeek = $now->copy()->startOfWeek()->format('Y-m-d 00:00:00');
                    $endOfWeek = $now->copy()->endOfWeek()->format('Y-m-d 23:59:59');
                    $filters[] = "edu_fb.created_at BETWEEN '{$startOfWeek}' AND '{$endOfWeek}'";
                    break;

                case 'this_month':
                    // Get first day and last day of current month
                    $startOfMonth = $now->copy()->startOfMonth()->format('Y-m-d 00:00:00');
                    $endOfMonth = $now->copy()->endOfMonth()->format('Y-m-d 23:59:59');
                    $filters[] = "edu_fb.created_at BETWEEN '{$startOfMonth}' AND '{$endOfMonth}'";
                    break;

                case 'this_year':
                    // Get January 1 and December 31 of current year
                    $startOfYear = $now->copy()->startOfYear()->format('Y-m-d 00:00:00');
                    $endOfYear = $now->copy()->endOfYear()->format('Y-m-d 23:59:59');
                    $filters[] = "edu_fb.created_at BETWEEN '{$startOfYear}' AND '{$endOfYear}'";
                    break;
            }
        }

        return $filters;
    }

    /**
     * Build human-readable filtered period string
     */
    private function buildFilteredPeriodString($validatedData): string
    {
        if (isset($validatedData['period'])) {
            $now = now();

            switch ($validatedData['period']) {
                case 'this_week':
                    $startOfWeek = $now->copy()->startOfWeek()->format('M d');
                    $endOfWeek = $now->copy()->endOfWeek()->format('M d, Y');
                    return "This Week ({$startOfWeek} - {$endOfWeek})";

                case 'this_month':
                    $monthYear = $now->format('F Y');
                    return "This Month ({$monthYear})";

                case 'this_year':
                    $year = $now->format('Y');
                    return "This Year ({$year})";
            }
        }

        return 'All time';
    }
}
