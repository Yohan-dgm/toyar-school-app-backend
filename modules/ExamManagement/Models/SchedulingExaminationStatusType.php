<?php

namespace Modules\ExamManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class SchedulingExaminationStatusType extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'scheduling_examination_status_type';

    protected $fillable = [
        'name',

        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function scheduling_examination_list(): HasMany
    {
        return $this->hasMany(SchedulingExamination::class, 'scheduling_examination_status_type_id', 'id');
    }
}
