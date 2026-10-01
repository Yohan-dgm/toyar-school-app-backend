<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class AcademicBill extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'academic_bill';

    protected $fillable = [
        //user
        'payment_plan_id',
        'bill_type',
        'date',
        'subtotal',
        'total',
        'serial_number_prefix',
        'serial_number_digits',
        'serial_number_current_year',
        'serial_number_financial_year',
        'serial_number_suffix',
        'serial_number',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations

    public function academic_bill_item_list(): HasMany
    {
        return $this->hasMany(AcademicBillItem::class, 'academic_bill_id', 'id');
    }

    public function payment_plan(): BelongsTo
    {
        return $this->belongsTo(PaymentPlan::class, 'payment_plan_id', 'id');
    }
}
