<?php

namespace Modules\SportManagement\Intents\StudentSport\GetStudentSportRecords;

use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\SportManagement\Models\StudentSportHistory;
use Modules\StudentManagement\Models\StudentSport;

class GetStudentSportRecordsAction
{
    use AsAction;

    public function handle(GetStudentSportRecordsUserDTO $userDTO): GetStudentSportRecordsResDTO
    {
        // Get current enrollments
        $currentEnrollments = $this->getCurrentEnrollments($userDTO);

        // Get enrollment history
        $history = $this->getEnrollmentHistory($userDTO);

        // Generate summary
        $summary = $this->generateSummary($userDTO, $currentEnrollments, $history);

        return GetStudentSportRecordsResDTO::from($currentEnrollments, $history, $summary);
    }

    private function getCurrentEnrollments(GetStudentSportRecordsUserDTO $userDTO): Collection
    {
        $query = StudentSport::with(['sport', 'coach'])
            ->where('student_id', $userDTO->student_id);

        if ($userDTO->sport_id) {
            $query->where('sport_id', $userDTO->sport_id);
        }

        if ($userDTO->include_active_only) {
            $query->where('is_active', true);
        }

        return $query->get();
    }

    private function getEnrollmentHistory(GetStudentSportRecordsUserDTO $userDTO): Collection
    {
        $query = StudentSportHistory::with(['sport', 'coach'])
            ->where('student_id', $userDTO->student_id)
            ->orderBy('created_at', 'desc');

        if ($userDTO->sport_id) {
            $query->where('sport_id', $userDTO->sport_id);
        }

        if ($userDTO->action_type) {
            $query->where('action_type', $userDTO->action_type);
        }

        if ($userDTO->from_date) {
            $query->whereDate('created_at', '>=', $userDTO->from_date);
        }

        if ($userDTO->to_date) {
            $query->whereDate('created_at', '<=', $userDTO->to_date);
        }

        return $query->get();
    }

    private function generateSummary(
        GetStudentSportRecordsUserDTO $userDTO,
        Collection $currentEnrollments,
        Collection $history
    ): array {
        return [
            'student_id' => $userDTO->student_id,
            'total_current_enrollments' => $currentEnrollments->count(),
            'active_enrollments' => $currentEnrollments->where('is_active', true)->count(),
            'inactive_enrollments' => $currentEnrollments->where('is_active', false)->count(),
            'total_sports_participated' => $currentEnrollments->pluck('sport_id')->unique()->count(),
            'total_history_records' => $history->count(),
            'history_by_action' => [
                'enrolled' => $history->where('action_type', 'enrolled')->count(),
                'left' => $history->where('action_type', 'left')->count(),
                'coach_changed' => $history->where('action_type', 'coach_changed')->count(),
                'reactivated' => $history->where('action_type', 'reactivated')->count(),
            ],
            'longest_enrollment_days' => $this->calculateLongestEnrollment($currentEnrollments, $history),
            'most_recent_activity' => $history->first()?->created_at?->format('Y-m-d H:i:s'),
        ];
    }

    private function calculateLongestEnrollment(Collection $currentEnrollments, Collection $history): ?int
    {
        $maxDays = null;

        // Check current active enrollments
        foreach ($currentEnrollments->where('is_active', true) as $enrollment) {
            if ($enrollment->enrolled_date) {
                $days = now()->diffInDays($enrollment->enrolled_date);
                $maxDays = max($maxDays ?? 0, $days);
            }
        }

        // Check historical data for completed enrollments
        foreach ($history->where('action_type', 'left') as $record) {
            if ($record->enrolled_date && $record->left_date) {
                $days = $record->enrolled_date->diffInDays($record->left_date);
                $maxDays = max($maxDays ?? 0, $days);
            }
        }

        return $maxDays;
    }
}
