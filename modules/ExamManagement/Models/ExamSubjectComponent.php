<?php

namespace Modules\ExamManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class ExamSubjectComponent extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'exam_subject_component';

    protected $fillable = [
        'exam_subject_component_type_id',
        'exam_subject_id',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function exam_subject(): BelongsTo
    {
        return $this->belongsTo(ExamSubject::class, 'exam_subject_id', 'id');
    }

    public function exam_subject_component_type(): BelongsTo
    {
        return $this->belongsTo(ExamSubjectComponentType::class, 'exam_subject_component_type_id', 'id');
    }
}
