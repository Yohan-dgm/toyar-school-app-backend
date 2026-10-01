<?php

namespace Modules\EducatorFeedbackManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Modules\ProgramManagement\Models\GradeLevel;
use Modules\ProgramManagement\Models\GradeLevelClass;
use Modules\StudentManagement\Models\Student;
use Modules\UserManagement\Models\User;

class EduFb extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'edu_fb';

    protected $fillable = [
        'student_id',
        'grade_level_id',
        'grade_level_class_id',
        'edu_fb_category_id',
        'rating',
        'decline_reason',
        'status',
        'created_by_designation',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'rating' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public $timestamps = true;

    // Relations
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function grade_level(): BelongsTo
    {
        return $this->belongsTo(GradeLevel::class, 'grade_level_id', 'id');
    }

    public function grade_level_class(): BelongsTo
    {
        return $this->belongsTo(GradeLevelClass::class, 'grade_level_class_id', 'id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(EduFbCategory::class, 'edu_fb_category_id', 'id');
    }

    public function subcategories(): HasMany
    {
        return $this->hasMany(EduFbSubcategory::class, 'edu_fb_id', 'id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(EduFbComment::class, 'edu_fb_id', 'id');
    }

    public function question_answers(): HasMany
    {
        return $this->hasMany(EduFbQuestionAnswer::class, 'edu_fb_id', 'id');
    }

    public function evaluations(): HasMany
    {
        return $this->hasMany(EduFdEvaluation::class, 'edu_fb_id', 'id');
    }

    public function backup(): HasOne
    {
        return $this->hasOne(EduFbBackup::class, 'edu_fb_id', 'id');
    }

    public function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updated_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function parent_comments(): HasMany
    {
        return $this->hasMany(EduFbParentComment::class, 'edu_fb_id', 'id');
    }
}
