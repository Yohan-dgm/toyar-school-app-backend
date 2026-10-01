<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Modules\StudentManagement\Models\Student;

class TermFeePayment extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'term_fee_payment';

    protected $fillable = [
        'school_year',
        'term',
        'term_id',
        'paid_amount',
        'receipt_voucher_id',
        'receipt_voucher_serial_number',
        'student_id',
        'student_admission_number',
        'term_fee_invoice_id',
        //
    ];

    public $timestamps = true;

    // relations
    public function term_fee_invoice(): BelongsTo
    {
        return $this->belongsTo(TermFeeInvoice::class, 'term_fee_invoice_id', 'id');
    }

    public function receipt_voucher(): BelongsTo
    {
        return $this->belongsTo(ReceiptVoucher::class, 'receipt_voucher_id', 'id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }
}
