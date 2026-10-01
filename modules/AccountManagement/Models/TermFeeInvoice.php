<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Modules\StudentManagement\Models\Student;
use Modules\SystemEntityManagement\Models\Term;

class TermFeeInvoice extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'term_fee_invoice';

    protected $fillable = [
        'date',
        'student_id',
        'term_id',
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
        'is_term_fee_invoice_complete',
        'term_fee_invoice_status_id',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class, 'term_id', 'id');
    }

    public function term_fee_invoice_item_list(): HasMany
    {
        return $this->hasMany(TermFeeInvoiceItem::class, 'term_fee_invoice_id', 'id');
    }

    public function receipt_voucher_list(): HasMany
    {
        return $this->hasMany(ReceiptVoucher::class, 'term_fee_invoice_id', 'id');
    }

    public function term_fee_payment_list(): HasMany
    {
        return $this->hasMany(TermFeePayment::class, 'term_fee_invoice_id', 'id');
    }
}
