<?php

namespace Modules\ExamManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Modules\ProgramManagement\Models\Program;

class SchedulingExaminationGrade extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'scheduling_examination_grade';

    protected $fillable = [
        'program_id',
        'scheduling_examination_id',
        'is_generate_student_exam_report',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }

    public function scheduling_examination(): BelongsTo
    {
        return $this->belongsTo(SchedulingExamination::class, 'scheduling_examination_id', 'id');
    }

    public function scheduling_examinations_grade_subject_list(): HasMany
    {
        return $this->hasMany(SchedulingExaminationGradeSubject::class, 'scheduling_examination_grade_id', 'id');
    }
}
