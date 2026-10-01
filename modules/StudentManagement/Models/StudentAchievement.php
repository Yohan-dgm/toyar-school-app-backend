<?php

namespace Modules\StudentManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class StudentAchievement extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'student_achievement';

    protected $fillable = [
        'student_id',
        'achievement_type',
        'title',
        'description',
        'is_active',
        'start_date',
        'end_date',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public $timestamps = true;

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }
}
