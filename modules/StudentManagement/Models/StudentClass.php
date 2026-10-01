<?php

namespace Modules\StudentManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Modules\ProgramManagement\Models\GradeLevelClass;
use Modules\SystemEntityManagement\Models\Term;

class StudentClass extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'student_class';

    protected $fillable = [
        'student_id',
        'term_id',
        'grade_level_class_id',
        'is_current_class',
        'class_joined_date',
        'garde_promotion_demotion_item_id',
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

    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class, 'term_id', 'id');
    }

    public function grade_level_class(): BelongsTo
    {
        return $this->belongsTo(GradeLevelClass::class, 'grade_level_class_id', 'id');
    }
}
