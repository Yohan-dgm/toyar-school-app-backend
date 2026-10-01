<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Modules\StudentManagement\Models\Student;

class RefundableDeposit extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'refundable_deposit';

    protected $fillable = [
        'date',
        'student_id',
        'order_notes',
        'office_notes',
        'items_total',
        'service_charges_total',
        'subtotal_before_discount',
        'discount_total',
        'subtotal_after_discount',
        'bill_total',
        //
        'serial_number_prefix',
        'serial_number_digits',
        'serial_number_current_year',
        'serial_number_financial_year',
        'serial_number_suffix',
        'serial_number',
        'is_refundable_deposit_complete',
        'is_refund',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function refundable_deposit_item_list(): HasMany
    {
        return $this->hasMany(RefundableDepositItem::class, 'refundable_deposit_id', 'id');
    }

    public function receipt_voucher_list(): HasMany
    {
        return $this->hasMany(ReceiptVoucher::class, 'refundable_deposit_id', 'id');
    }
}
