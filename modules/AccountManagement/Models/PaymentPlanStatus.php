<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;

class PaymentPlanStatus extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'payment_plan_status';

    protected $fillable = [
        'payment_plan_id',
        'payment_plan_status_type_id',
        'notes',
        'status_changed_by_id',
        'is_active',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations

    public function payment_plan_status_type(): HasOne
    {
        return $this->hasOne(PaymentPlanStatusType::class, 'payment_plan_status_type_id', 'id');
    }

    public function payment_plan(): HasOne
    {
        return $this->hasOne(PaymentPlan::class, 'payment_plan_id', 'id');
    }
}
