<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Modules\AdmissionManagement\Models\Applicant;
use Modules\StudentManagement\Models\Student;

class AdmissionFeeInvoice extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'admission_fee_invoice';

    protected $fillable = [
        'date',
        'applicant_id',
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
        'is_admission_fee_invoice_complete',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function applicant(): BelongsTo
    {
        return $this->belongsTo(Applicant::class, 'applicant_id', 'id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function admission_fee_invoice_item_list(): HasMany
    {
        return $this->hasMany(AdmissionFeeInvoiceItem::class, 'admission_fee_invoice_id', 'id');
    }

    public function receipt_voucher_list(): HasMany
    {
        return $this->hasMany(ReceiptVoucher::class, 'admission_fee_invoice_id', 'id');
    }
}
