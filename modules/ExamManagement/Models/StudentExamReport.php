<?php

namespace Modules\ExamManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Modules\ProgramManagement\Models\GradeLevelClass;
use Modules\StudentManagement\Models\Student;

class StudentExamReport extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'student_exam_report';

    protected $fillable = [
        'student_id',
        'exam_quiz_id',
        'scheduling_examination_id',
        'class_teacher_comment',
        'class_rank',
        'student_average',
        'aggregate_of_mark',
        'grade_level_name',
        'grade_level_class_id',
        'class_average',

        'serial_number_prefix',
        'serial_number_digits',
        'serial_number_current_year',
        'serial_number_financial_year',
        'serial_number_suffix',
        'serial_number',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function exam_quiz(): BelongsTo
    {
        return $this->belongsTo(ExamQuiz::class, 'exam_quiz_id', 'id');
    }

    public function student_exam_report_item_list(): HasMany
    {
        return $this->hasMany(StudentExamReportItem::class, 'student_exam_report_id', 'id');
    }

    public function scheduling_examination(): BelongsTo
    {
        return $this->belongsTo(SchedulingExamination::class, 'scheduling_examination_id', 'id');
    }

    public function grade_level_class(): BelongsTo
    {
        return $this->belongsTo(GradeLevelClass::class, 'grade_level_class_id', 'id');
    }
}
