<?php

namespace Modules\StudentManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class VisibilityType extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'visibility_type';

    protected $fillable = [
        'name',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    // public function educator_feedback_list(): HasMany
    // {
    //     return $this->hasMany(EducatorFeedback::class, 'visibility_type_id', 'id');
    // }

    public function educator_feedback_evolution_process_list(): HasMany
    {
        return $this->hasMany(EducatorFeedbackEvolutionProcess::class, 'visibility_type_id', 'id');
    }
}
