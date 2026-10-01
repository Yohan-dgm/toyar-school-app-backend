<?php

namespace Modules\EducatorFeedbackManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Modules\StudentManagement\Models\Student;
use Modules\UserManagement\Models\User;

class EduFdEvaluation extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'edu_fd_evaluation';

    protected $fillable = [
        'student_id',
        'edu_fb_id',
        'edu_fd_evaluation_type_id',
        'reviewer_feedback',
        'decline_reason',
        'is_parent_visible',
        'is_active',

        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public $timestamps = true;

    // Relations
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function feedback(): BelongsTo
    {
        return $this->belongsTo(EduFb::class, 'edu_fb_id', 'id');
    }

    public function evaluation_type(): BelongsTo
    {
        return $this->belongsTo(EduFdEvaluationType::class, 'edu_fd_evaluation_type_id', 'id');
    }

    public function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updated_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
