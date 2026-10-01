<?php

namespace Modules\ExamManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Modules\ProgramManagement\Models\Subject;

class StudentExamReportItem extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'student_exam_report_item';

    protected $fillable = [
        'student_exam_report_id',
        'exam_quiz_item_id',
        'scheduling_examination_grade_subject_id',
        'subject_overall_mark_percentage',
        'grading',
        'student_exam_mark_id',
        'present_type',
        'subject_mark',
        'subject_id',
        'subject_name',
        'subject_remark',
        'subject_position',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function student_exam_report(): BelongsTo
    {
        return $this->belongsTo(StudentExamReport::class, 'student_exam_report_id', 'id');
    }

    public function exam_quiz_item(): BelongsTo
    {
        return $this->belongsTo(ExamQuizItem::class, 'exam_quiz_item_id', 'id');
    }

    public function student_exam_mark(): BelongsTo
    {
        return $this->belongsTo(StudentExamMark::class, 'student_exam_mark_id', 'id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }
}
