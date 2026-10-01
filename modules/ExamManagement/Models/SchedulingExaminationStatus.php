<?php

namespace Modules\ExamManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class SchedulingExaminationStatus extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'scheduling_examination_status';

    protected $fillable = [
        'scheduling_examination_id',
        'scheduling_examination_status_type_id',

        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function scheduling_examination_status_type(): BelongsTo
    {
        return $this->belongsTo(SchedulingExaminationStatusType::class, 'scheduling_examination_status_type_id', 'id');
    }
}
