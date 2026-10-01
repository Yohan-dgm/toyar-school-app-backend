<?php

namespace Modules\ExamManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class ExamSubjectComponentType extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'exam_subject_component_type';

    protected $fillable = [
        'name',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function grade_level_class_list(): BelongsToMany
    {
        return $this->belongsToMany(ExamSubject::class, 'exam_subject_exam_subject_group_pivot', 'exam_subject_group_id', 'exam_subject_id');
    }

    public function exam_subject_component_list(): HasMany
    {
        return $this->hasMany(ExamSubjectComponent::class, 'exam_subject_component_type_id', 'id');
    }
}
