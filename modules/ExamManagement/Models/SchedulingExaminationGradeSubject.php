<?php

namespace Modules\ExamManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Modules\ProgramManagement\Models\Subject;

class SchedulingExaminationGradeSubject extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'scheduling_examination_grade_subject';

    protected $fillable = [
        'scheduling_examination_grade_id',
        'subject_id',
        'subject_start_date',
        'subject_end_date',
        'subject_start_time',
        'subject_end_time',
        'is_all_marks_confirmed',
        'confirmed_by',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    public function scheduling_examination_grade(): BelongsTo
    {
        return $this->belongsTo(SchedulingExaminationGrade::class, 'scheduling_examination_grade_id', 'id');
    }

    public function student_exam_mark_list(): HasMany
    {
        return $this->hasMany(StudentExamMark::class, 'scheduling_examination_grade_subject_id', 'id');
    }

    public function scheduling_examinations_subject_paper_list(): HasMany
    {
        return $this->hasMany(SchedulingExaminationSubjectPaper::class, 'scheduling_examination_grade_subject_id', 'id');
    }
}
