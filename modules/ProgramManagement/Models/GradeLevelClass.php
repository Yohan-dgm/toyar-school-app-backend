<?php

namespace Modules\ProgramManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\EducatorManagement\Models\Educator;
use Modules\ExamManagement\Models\StudentExamReport;
use Modules\StudentManagement\Models\ClassSection;
use Modules\StudentManagement\Models\EducatorFeedback;
use Modules\AcademicStaffManagement\Models\ClassTeacher;

class GradeLevelClass extends Model
{
    use HasFactory;

    protected $table = 'grade_level_class';

    protected $fillable = [
        'grade_level_id',
        'name',
        'class_section_id',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    public function grade_level(): BelongsTo
    {
        return $this->belongsTo(GradeLevel::class, 'grade_level_id', 'id');
    }

    public function class_section(): BelongsTo
    {
        return $this->belongsTo(ClassSection::class, 'class_section_id', 'id');
    }

    public function student_list(): HasMany
    {
        return $this->hasMany(Subject::class, 'grade_level_class_id', 'id');
    }

    public function educator_feedback_list(): HasMany
    {
        return $this->hasMany(EducatorFeedback::class, 'educator_id', 'id');
    }

    public function student_exam_report_list(): HasMany
    {
        return $this->hasMany(StudentExamReport::class, 'grade_level_class_id', 'id');
    }

    public function educator_list(): BelongsToMany
    {
        return $this->belongsToMany(Educator::class, 'educator_grade_level_class_pivot', 'grade_level_class_id', 'educator_id');
    }

    public function class_teacher_list(): HasMany
    {
        return $this->hasMany(ClassTeacher::class, 'grade_level_class_id', 'id');
    }

    // protected static function newFactory(): GradeLevelClassFactory
    // {
    //     return new GradeLevelClassFactory();
    // }
}
