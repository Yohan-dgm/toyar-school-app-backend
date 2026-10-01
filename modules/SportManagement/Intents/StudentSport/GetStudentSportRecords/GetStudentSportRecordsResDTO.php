<?php

namespace Modules\SportManagement\Intents\StudentSport\GetStudentSportRecords;

use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

class GetStudentSportRecordsResDTO extends Data
{
    public function __construct(
        public array $current_enrollments,
        public array $enrollment_history,
        public array $summary,
    ) {}

    public static function from(Collection $currentEnrollments, Collection $history, array $summary): self
    {
        return new self(
            current_enrollments: $currentEnrollments->map(function ($enrollment) {
                return [
                    'id' => $enrollment->id,
                    'sport' => [
                        'id' => $enrollment->sport->id,
                        'name' => $enrollment->sport->name,
                        'sport_code' => $enrollment->sport->sport_code,
                    ],
                    'coach' => $enrollment->coach ? [
                        'id' => $enrollment->coach->id,
                        'name' => $enrollment->coach->name ?? 'N/A',
                    ] : null,
                    'enrolled_date' => $enrollment->enrolled_date?->format('Y-m-d'),
                    'status' => $enrollment->is_active ? 'active' : 'inactive',
                    'enrollment_duration_days' => $enrollment->enrolled_date ?
                        now()->diffInDays($enrollment->enrolled_date) : null,
                ];
            })->toArray(),

            enrollment_history: $history->map(function ($record) {
                return [
                    'id' => $record->id,
                    'sport' => [
                        'id' => $record->sport->id,
                        'name' => $record->sport->name,
                        'sport_code' => $record->sport->sport_code,
                    ],
                    'coach' => $record->coach ? [
                        'id' => $record->coach->id,
                        'name' => $record->coach->name ?? 'N/A',
                    ] : null,
                    'action_type' => $record->action_type,
                    'enrolled_date' => $record->enrolled_date?->format('Y-m-d'),
                    'left_date' => $record->left_date?->format('Y-m-d'),
                    'duration_days' => $record->enrolled_date && $record->left_date ?
                        $record->enrolled_date->diffInDays($record->left_date) : null,
                    'reason' => $record->reason,
                    'notes' => $record->notes,
                    'created_at' => $record->created_at?->format('Y-m-d H:i:s'),
                ];
            })->toArray(),

            summary: $summary,
        );
    }
}
