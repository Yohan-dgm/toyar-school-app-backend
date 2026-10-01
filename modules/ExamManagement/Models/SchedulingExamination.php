<?php

namespace Modules\ExamManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Modules\SystemEntityManagement\Models\Term;

class SchedulingExamination extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'scheduling_examination';

    protected $fillable = [
        'exam_type',
        'exam_title',
        'exam_start_time',
        'exam_start_date',
        'exam_end_time',
        'exam_end_date',
        'description',
        'term_id',
        'scheduling_examination_status_id',
        'scheduling_examination_status_type_id',
        'approved_by',
        'is_generate_student_exam_report',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function scheduling_examinations_grade_list(): HasMany
    {
        return $this->hasMany(SchedulingExaminationGrade::class, 'scheduling_examination_id', 'id');
    }

    public function student_exam_report_list(): HasMany
    {
        return $this->hasMany(StudentExamReport::class, 'scheduling_examination_id', 'id');
    }

    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class, 'term_id', 'id');
    }

    public function scheduling_examination_status_type(): BelongsTo
    {
        return $this->belongsTo(SchedulingExaminationStatusType::class, 'scheduling_examination_status_type_id', 'id');
    }
}
