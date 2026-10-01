<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Modules\ProgramManagement\Models\Program;

class AcademicBillItem extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'academic_bill_item';

    protected $fillable = [
        'program_id',
        'academic_bill_id',
        'bill_item_type',
        'payment_plan_down_payment_amount',
        'payment_plan_installment_amount',
        'payment_plan_late_charge_amount',
        'sequential_order',
        'description',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }

    public function academic_bill(): BelongsTo
    {
        return $this->belongsTo(AcademicBill::class, 'academic_bill_id', 'id');
    }
}
