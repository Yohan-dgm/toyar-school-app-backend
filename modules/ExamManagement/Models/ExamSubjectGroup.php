<?php

namespace Modules\ExamManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;

class ExamSubjectGroup extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'exam_subject_group';

    protected $fillable = [
        'name',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function exam_subject_list(): BelongsToMany
    {
        return $this->belongsToMany(ExamSubject::class, 'exam_subject_exam_subject_group_pivot', 'exam_subject_group_id', 'exam_subject_id');
    }
}
