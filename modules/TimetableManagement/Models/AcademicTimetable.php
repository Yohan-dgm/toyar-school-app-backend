<?php

namespace Modules\TimetableManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\EducatorManagement\Models\Educator;
use Modules\ProgramManagement\Models\GradeLevelClass;
use Modules\ProgramManagement\Models\Subject;
use Modules\UserManagement\Models\User;

class AcademicTimetable extends Model
{
    use HasFactory;

    protected $table = 'academic_timetable';

    protected $fillable = [
        'created_by',
        'updated_by',
        'grade_level_class_id',
        'subject_id',
        'educator_id',
        'day_of_week',
        'start_time',
        'end_time',
        'room_number',
        'building',
        'semester',
        'academic_year',
        'is_active',
        'notes',
    ];

    public $timestamps = true;

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function grade_level_class(): BelongsTo
    {
        return $this->belongsTo(GradeLevelClass::class, 'grade_level_class_id', 'id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    public function educator(): BelongsTo
    {
        return $this->belongsTo(Educator::class, 'educator_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    // Helper methods for day of week
    public static function getDaysOfWeek()
    {
        return [
            'monday' => 'Monday',
            'tuesday' => 'Tuesday',
            'wednesday' => 'Wednesday',
            'thursday' => 'Thursday',
            'friday' => 'Friday',
            'saturday' => 'Saturday',
            'sunday' => 'Sunday',
        ];
    }

    public function getDayOfWeekNameAttribute()
    {
        $days = self::getDaysOfWeek();

        return $days[$this->day_of_week] ?? $this->day_of_week;
    }

    // protected static function newFactory(): AcademicTimetableFactory
    // {
    //     return new AcademicTimetableFactory();
    // }
}
