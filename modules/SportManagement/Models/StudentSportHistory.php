<?php

namespace Modules\SportManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\EducatorManagement\Models\Educator;
use Modules\ProgramManagement\Models\Sport;
use Modules\StudentManagement\Models\Student;
use Modules\StudentManagement\Models\StudentSport;

class StudentSportHistory extends Model
{
    use HasFactory;

    protected $table = 'student_sport_history';

    protected $fillable = [
        'student_sport_id',
        'student_id',
        'sport_id',
        'coach_id',
        'action_type',
        'enrolled_date',
        'left_date',
        'reason',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'enrolled_date' => 'date',
        'left_date' => 'date',
        'created_at' => 'datetime',
    ];

    public $timestamps = false;

    const ACTION_ENROLLED = 'enrolled';

    const ACTION_LEFT = 'left';

    const ACTION_COACH_CHANGED = 'coach_changed';

    const ACTION_REACTIVATED = 'reactivated';

    public function studentSport(): BelongsTo
    {
        return $this->belongsTo(StudentSport::class, 'student_sport_id', 'id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function sport(): BelongsTo
    {
        return $this->belongsTo(Sport::class, 'sport_id', 'id');
    }

    public function coach(): BelongsTo
    {
        return $this->belongsTo(Educator::class, 'coach_id', 'id');
    }

    public function scopeByStudent($query, $studentId)
    {
        return $query->where('student_id', $studentId);
    }

    public function scopeBySport($query, $sportId)
    {
        return $query->where('sport_id', $sportId);
    }

    public function scopeByAction($query, $actionType)
    {
        return $query->where('action_type', $actionType);
    }

    public function scopeEnrollments($query)
    {
        return $query->where('action_type', self::ACTION_ENROLLED);
    }

    public function scopeLeavings($query)
    {
        return $query->where('action_type', self::ACTION_LEFT);
    }
}
