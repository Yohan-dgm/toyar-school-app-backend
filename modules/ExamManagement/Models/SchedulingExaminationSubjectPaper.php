<?php

namespace Modules\ExamManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class SchedulingExaminationSubjectPaper extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'scheduling_examination_subject_paper';

    protected $fillable = [
        'scheduling_examination_grade_subject_id', // exam_quiz_item_id
        'paper_type',
        'name',
        'overall_mark',
        'duration_hours',
        'duration_minutes',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations

}
