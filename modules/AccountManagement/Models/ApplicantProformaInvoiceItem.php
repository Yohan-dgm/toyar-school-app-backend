<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class ApplicantProformaInvoiceItem extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'applicant_proforma_invoice_item';

    protected $fillable = [
        'applicant_proforma_invoice_id',
        'invoice_type',
        'print_invoice_type',
        'print_amount',
        'amount',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations

    public function applicant_proforma_invoice(): BelongsTo
    {
        return $this->belongsTo(ApplicantProformaInvoice::class, 'applicant_proforma_invoice_id', 'id');
    }
}
