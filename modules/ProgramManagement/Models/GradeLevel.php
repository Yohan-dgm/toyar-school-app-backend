<?php

namespace Modules\ProgramManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\AccountManagement\Models\SchoolFee;
use Modules\AdmissionManagement\Models\Applicant;
use Modules\EducatorManagement\Models\Educator;
use Modules\StudentManagement\Models\EducatorFeedback;
use Modules\StudentManagement\Models\Student;
use Modules\AcademicStaffManagement\Models\SectionalHead;

class GradeLevel extends Model
{
    use HasFactory;

    protected $table = 'grade_level';

    protected $fillable = [
        'name',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    public function program_list(): HasMany
    {
        return $this->hasMany(Program::class, 'grade_level_id', 'id');
    }

    public function grade_level_class_list(): HasMany
    {
        return $this->hasMany(GradeLevelClass::class, 'grade_level_id', 'id');
    }

    public function applicant_list(): HasMany
    {
        return $this->hasMany(Applicant::class, 'grade_level_id', 'id');
    }

    public function student_list(): HasMany
    {
        return $this->hasMany(Student::class, 'grade_level_id', 'id');
    }

    public function school_fee_list(): HasMany
    {
        return $this->hasMany(SchoolFee::class, 'grade_level_id', 'id');
    }

    public function educator_feedback_list(): HasMany
    {
        return $this->hasMany(EducatorFeedback::class, 'grade_level_id', 'id');
    }

    public function educator_list(): BelongsToMany
    {
        return $this->belongsToMany(Educator::class, 'educator_grade_level_pivot', 'grade_level_id', 'educator_id');
    }

    public function sectional_head_list(): HasMany
    {
        return $this->hasMany(SectionalHead::class, 'grade_level_id', 'id');
    }
}
