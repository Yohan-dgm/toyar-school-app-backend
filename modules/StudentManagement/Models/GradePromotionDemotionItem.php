<?php

namespace Modules\StudentManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Modules\ProgramManagement\Models\GradeLevelClass;

class GradePromotionDemotionItem extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'grade_promotion_demotion_item';

    protected $fillable = [
        'student_id',
        'grade_promotion_demotion_id',
        'current_grade_level_class_id',

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

    public function grade_promotion_demotion(): BelongsTo
    {
        return $this->belongsTo(GradePromotionDemotion::class, 'grade_promotion_demotion_id', 'id');
    }

    public function current_grade_level_class(): BelongsTo
    {
        return $this->belongsTo(GradeLevelClass::class, 'current_grade_level_class_id', 'id');
    }
}
