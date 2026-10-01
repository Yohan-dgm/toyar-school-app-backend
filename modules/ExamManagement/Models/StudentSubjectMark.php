<?php

namespace Modules\ExamManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class StudentSubjectMark extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'student_subject_mark';

    protected $fillable = [
        'student_exam_mark_id',
        'mark_type',
        'mark',
        'name',
        'overall_mark',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function student_exam_mark(): BelongsTo
    {
        return $this->belongsTo(StudentExamMark::class, 'student_exam_mark_id', 'id');
    }
}
