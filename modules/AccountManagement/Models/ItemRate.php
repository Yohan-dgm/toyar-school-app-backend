<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Modules\ExamManagement\Models\ExamServiceCharge;
use Modules\ExamManagement\Models\ExamSubject;

class ItemRate extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'item_rate';

    protected $fillable = [
        //user
        'item_type',
        'school_fee_name',
        'material_item_id',
        'service_item_id',
        'program_id',
        'subject_id',
        'rate',
        'version',
        'item_rate_status_id',
        'exam_subject_id',
        'exam_subject_component_id',
        'exam_service_charge_id',
        'is_active',

        // system
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function item_rate_status_type(): BelongsTo
    {
        return $this->belongsTo(ItemRateStatusType::class, 'item_rate_status_type_id', 'id');
    }

    public function item_rate_status(): BelongsTo
    {
        return $this->belongsTo(ItemRateStatus::class, 'item_rate_id', 'id');
    }

    public function exam_subject(): BelongsTo
    {
        return $this->belongsTo(ExamSubject::class, 'exam_subject_id', 'id');
    }

    public function exam_service_charge(): BelongsTo
    {
        return $this->belongsTo(ExamServiceCharge::class, 'exam_service_charge_id', 'id');
    }
}
