<?php

namespace Modules\ExamManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Modules\StudentManagement\Models\Student;

class StudentExamMark extends Model
{
use HasFactory, Notifiable;

protected $table = 'student_exam_mark';

protected $fillable = [
'scheduling_examination_grade_subject_id',
'exam_quiz_item_id',
'student_id',
'subject_total_mark',
'subject_overall_mark_percentage',
'subject_comment',
'present_type',
'grading',
'mark_added_by',
'is_active',
'is_mark_added',
//
'created_by',
'updated_by',
];

public $timestamps = true;

// relations
public function exam_quiz_item(): BelongsTo
{
return $this->belongsTo(ExamQuizItem::class, 'exam_quiz_item_id', 'id');
}

public function scheduling_examination_grade_subject_item(): BelongsTo
{
return $this->belongsTo(SchedulingExaminationGradeSubject::class, 'scheduling_examination_grade_subject_id', 'id');
}

public function student(): BelongsTo
{
return $this->belongsTo(Student::class, 'student_id', 'id');
}

public function student_subject_mark_list(): HasMany
{
return $this->hasMany(StudentSubjectMark::class, 'student_exam_mark_id', 'id');
}
}