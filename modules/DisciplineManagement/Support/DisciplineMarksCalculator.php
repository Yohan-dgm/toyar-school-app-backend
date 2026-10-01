<?php

namespace Modules\DisciplineManagement\Support;

use Carbon\Carbon;
use Modules\DisciplineManagement\Models\DisciplineRecord;

class DisciplineMarksCalculator
{
    public const BASELINE_MARKS = 100;

    /**
     * Academic year runs Sep 1 -> Aug 31 of the following year, e.g. "2025-2026".
     */
    public static function academicYearForDate(Carbon $date): string
    {
        $startYear = $date->month >= 9 ? $date->year : $date->year - 1;

        return $startYear.'-'.($startYear + 1);
    }

    public static function currentAcademicYear(): string
    {
        return self::academicYearForDate(Carbon::now());
    }

    /**
     * remaining marks = 100 - SUM(marks_deducted for APPROVED records in that academic year), floored at 0.
     */
    public static function remainingMarks(int $studentId, string $academicYear): int
    {
        $deducted = (int) DisciplineRecord::where('student_id', $studentId)
            ->where('academic_year', $academicYear)
            ->where('status', 'Approved')
            ->where('is_active', true)
            ->sum('marks_deducted');

        return max(0, self::BASELINE_MARKS - $deducted);
    }

    public static function conductRating(int $remainingMarks): string
    {
        return match (true) {
            $remainingMarks >= 95 => 'Outstanding Conduct',
            $remainingMarks >= 90 => 'Very Good Conduct',
            $remainingMarks >= 80 => 'Good Conduct',
            $remainingMarks >= 70 => 'Satisfactory Conduct',
            $remainingMarks >= 60 => 'Improvement Required',
            default => 'Serious Improvement Required',
        };
    }
}
