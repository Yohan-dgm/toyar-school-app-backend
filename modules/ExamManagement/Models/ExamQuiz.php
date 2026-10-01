<?php

namespace Modules\ExamManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Modules\ProgramManagement\Models\Program;

class ExamQuiz extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'exam_quiz';

    protected $fillable = [
        'exam_type',
        'program_id',
        // 'subject_id',
        'exam_start_date',
        'exam_end_date',
        'exam_start_time',
        'exam_end_time',
        'exam_title',
        'description',
        'is_active',
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

    public function exam_quiz_item_list(): HasMany
    {
        return $this->hasMany(ExamQuizItem::class, 'exam_quiz_id', 'id');
    }
}
