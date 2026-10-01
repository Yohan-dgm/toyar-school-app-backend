<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Modules\AdmissionManagement\Models\Applicant;

class ApplicantProformaInvoice extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'applicant_proforma_invoice';

    protected $fillable = [
        'date',
        'applicant_id',
        'order_notes',
        'office_notes',
        'items_total',
        'service_charges_total',
        'subtotal_before_discount',
        'discount_total',
        'subtotal_after_discount',
        'tax_total',
        'bill_total',
        //
        'serial_number_prefix',
        'serial_number_digits',
        'serial_number_current_year',
        'serial_number_financial_year',
        'serial_number_suffix',
        'serial_number',
        'is_applicant_proforma_invoice_complete',
        'applicant_proforma_invoice_status_id',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    // public function applicant_proforma_invoice_status(): BelongsTo
    // {
    //     return $this->belongsTo(ApplicantProformaInvoiceStatus::class, 'applicant_proforma_invoice_id', 'id');
    // }

    public function applicant(): BelongsTo
    {
        return $this->belongsTo(Applicant::class, 'applicant_id', 'id');
    }

    public function applicant_proforma_invoice_item_list(): HasMany
    {
        return $this->hasMany(ApplicantProformaInvoiceItem::class, 'applicant_proforma_invoice_id', 'id');
    }

    public function receipt_voucher_list(): HasMany
    {
        return $this->hasMany(ReceiptVoucher::class, 'applicant_proforma_invoice_id', 'id');
    }
}
