<?php

namespace Modules\DisciplineManagement\Support;

use Illuminate\Support\Facades\Log;
use Modules\CommunicationManagement\Services\NotificationService;
use Modules\DisciplineManagement\Models\DisciplineRecord;
use Modules\StudentManagement\Models\Student;

class DisciplineParentNotifier
{
    /**
     * Push-notify a student's parent(s) that an approved discipline record
     * now exists for them. Only ever called once a record's status is
     * 'Approved' - pending/rejected records are never surfaced to parents.
     */
    public static function notify(DisciplineRecord $record): void
    {
        try {
            $student = Student::with(['father', 'mother', 'guardian'])->find($record->student_id);
            if (! $student) {
                return;
            }

            $recipientUserIds = collect([
                $student->father?->user_id,
                $student->mother?->user_id,
                $student->guardian?->user_id,
            ])->filter()->unique()->values()->toArray();

            if (empty($recipientUserIds)) {
                Log::info('DisciplineParentNotifier: no linked parent user accounts, skipping', [
                    'discipline_record_id' => $record->id,
                    'student_id' => $record->student_id,
                ]);

                return;
            }

            $studentName = $student->full_name ?? 'Your child';

            app(NotificationService::class)->sendModuleNotification(
                "Discipline Record Update",
                "{$studentName}'s discipline record was updated: {$record->offence} (-{$record->marks_deducted} marks).",
                $recipientUserIds,
                "alert",
                "normal",
                "discipline-record?student_id={$record->student_id}"
            );
        } catch (\Throwable $e) {
            Log::error("DisciplineParentNotifier failed", [
                "discipline_record_id" => $record->id,
                "error" => $e->getMessage(),
            ]);
        }
    }
}
