<?php

namespace Modules\StudentManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Modules\EducatorManagement\Models\Educator;
use Modules\ProgramManagement\Models\Sport;
use Modules\SportManagement\Models\StudentSportHistory;

class StudentSport extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'student_sport';

    protected $fillable = [
        'student_id',
        'sport_id',
        'coach_id',
        'enrolled_date',
        'left_date',
        'is_active',
        'status',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    protected $casts = [
        'enrolled_date' => 'date',
        'left_date' => 'date',
        'is_active' => 'boolean',
        'status' => 'boolean',
    ];

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

    public function history(): HasMany
    {
        return $this->hasMany(StudentSportHistory::class, 'student_sport_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    public function scopeByStudent($query, $studentId)
    {
        return $query->where('student_id', $studentId);
    }

    public function scopeBySport($query, $sportId)
    {
        return $query->where('sport_id', $sportId);
    }

    public function scopeByCoach($query, $coachId)
    {
        return $query->where('coach_id', $coachId);
    }
}
