<?php

namespace Modules\TimetableManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\EmployeeManagement\Models\Employee;
use Modules\ProgramManagement\Models\GradeLevelClass;
use Modules\ProgramManagement\Models\Sport;
use Modules\UserManagement\Models\User;

class SportTimetable extends Model
{
    use HasFactory;

    protected $table = 'sport_timetable';

    protected $fillable = [
        'created_by',
        'updated_by',
        'sport_id',
        'grade_level_class_id',
        'coach_id',
        'day_of_week',
        'start_time',
        'end_time',
        'venue',
        'facility',
        'season',
        'academic_year',
        'is_active',
        'notes',
        'team_id',
        'max_participants',
        'age_group',
        'skill_level',
    ];

    public $timestamps = true;

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'is_active' => 'boolean',
        'max_participants' => 'integer',
    ];

    public function sport(): BelongsTo
    {
        return $this->belongsTo(Sport::class, 'sport_id', 'id');
    }

    public function grade_level_class(): BelongsTo
    {
        return $this->belongsTo(GradeLevelClass::class, 'grade_level_class_id', 'id');
    }

    public function coach(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'coach_id', 'id');
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

    // Helper methods for seasons
    public static function getSeasons()
    {
        return [
            'spring' => 'Spring',
            'summer' => 'Summer',
            'autumn' => 'Autumn',
            'winter' => 'Winter',
            'all_year' => 'All Year',
        ];
    }

    public function getSeasonNameAttribute()
    {
        $seasons = self::getSeasons();

        return $seasons[$this->season] ?? $this->season;
    }

    // Helper methods for skill levels
    public static function getSkillLevels()
    {
        return [
            'beginner' => 'Beginner',
            'intermediate' => 'Intermediate',
            'advanced' => 'Advanced',
            'expert' => 'Expert',
        ];
    }

    public function getSkillLevelNameAttribute()
    {
        $skillLevels = self::getSkillLevels();

        return $skillLevels[$this->skill_level] ?? $this->skill_level;
    }

    // protected static function newFactory(): SportTimetableFactory
    // {
    //     return new SportTimetableFactory();
    // }
}
