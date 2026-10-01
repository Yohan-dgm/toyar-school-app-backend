<?php

namespace Modules\StudentManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Modules\ProgramManagement\Models\GradeLevelClass;

class GradePromotionDemotion extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'grade_promotion_demotion';

    protected $fillable = [
        'type',
        'class_joined_date',
        'promotion_or_demotion_grade_level_class_id',
        'is_approved',
        'approved_by',
        'reason',
        'approved_at',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function grade_promotion_demotion_item_list(): HasMany
    {
        return $this->hasMany(GradePromotionDemotionItem::class, 'grade_promotion_demotion_id', 'id');
    }

    public function promotion_or_demotion_grade_level_class(): BelongsTo
    {
        return $this->belongsTo(GradeLevelClass::class, 'promotion_or_demotion_grade_level_class_id', 'id');
    }
}
