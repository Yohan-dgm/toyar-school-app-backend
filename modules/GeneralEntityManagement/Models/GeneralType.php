<?php

namespace Modules\GeneralEntityManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Modules\InventoryManagement\Models\MaterialItem;
use Modules\StudentManagement\Models\EducatorFeedback;

class GeneralType extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'general_type';

    protected $fillable = [
        'name',
        //
        'dependent_type_id',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function educator_feedback_type_list(): HasMany
    {
        return $this->hasMany(EducatorFeedback::class, 'educator_feedback_type_id', 'id');
    }
}
