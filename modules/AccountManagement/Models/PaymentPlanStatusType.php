<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class PaymentPlanStatusType extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'payment_plan_status_type';

    protected $fillable = [
        'name',
        'sequential_order',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations

    public function payment_plan_status_list(): HasMany
    {
        return $this->hasMany(PaymentPlanStatus::class, 'payment_plan_status_type_id', 'id');
    }
}
