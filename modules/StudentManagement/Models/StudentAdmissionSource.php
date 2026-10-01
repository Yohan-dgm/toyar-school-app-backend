<?php

namespace Modules\StudentManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\ExamManagement\Models\ExamPrivateCandidate;

class StudentAdmissionSource extends Model
{
    protected $table = 'student_admission_source';

    protected $fillable = [

        'name',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    public function student_list(): HasMany
    {
        return $this->hasMany(Student::class, 'student_admission_source_id', 'id');
    }

    public function exam_private_candidate_list(): HasMany
    {
        return $this->hasMany(ExamPrivateCandidate::class, 'student_admission_source_id', 'id');
    }
}
