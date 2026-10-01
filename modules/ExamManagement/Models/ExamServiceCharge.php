<?php

namespace Modules\ExamManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Modules\AccountManagement\Models\ExamBill;
use Modules\AccountManagement\Models\ItemRate;

class ExamServiceCharge extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'exam_service_charge';

    protected $fillable = [
        'name',
        'exam_service_charge_amount',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function exam_bill_list(): BelongsToMany
    {
        return $this->belongsToMany(ExamBill::class, 'exam_bill_exam_service_charge_pivot', 'exam_service_charge_id', 'exam_bill_id');
    }

    public function item_rate_list(): HasMany
    {
        return $this->hasMany(ItemRate::class, 'exam_service_charge_id', 'id');
    }
}
