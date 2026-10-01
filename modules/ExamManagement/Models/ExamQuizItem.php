<?php

namespace Modules\ExamManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Modules\EducatorManagement\Models\Educator;
use Modules\ProgramManagement\Models\Subject;
use Modules\StudentManagement\Models\Student;

class ExamQuizItem extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'exam_quiz_item';

    protected $fillable = [
        'exam_quiz_id',
        'scheduling_examination_grade_id',
        'subject_id',
        'subject_start_date',
        'subject_end_date',
        'subject_start_time',
        'subject_end_time',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function student_list(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'exam_quiz_item_student_pivot', 'exam_quiz_item_id', 'student_id');
    }

    public function subject_list(): BelongsToMany
    {
        return $this->belongsToMany(Educator::class, 'educator_subject_pivot', 'educator_id', 'subject_id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    public function exam_quiz(): BelongsTo
    {
        return $this->belongsTo(ExamQuiz::class, 'exam_quiz_id', 'id');
    }

    public function student_exam_mark_list(): HasMany
    {
        return $this->hasMany(StudentExamMark::class, 'exam_quiz_item_id', 'id');
    }

    public function scheduling_examinations_subject_paper_list(): HasMany
    {
        return $this->hasMany(SchedulingExaminationSubjectPaper::class, 'scheduling_examination_grade_subject_id', 'id');
    }
}
