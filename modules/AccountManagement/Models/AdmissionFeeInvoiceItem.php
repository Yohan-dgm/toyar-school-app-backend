<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class AdmissionFeeInvoiceItem extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'admission_fee_invoice_item';

    protected $fillable = [
        'admission_fee_invoice_id',
        'school_fee_id',
        'description',
        'is_admission_fee_invoice_item_complete',
        'item_total',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations

    public function admission_fee_invoice(): BelongsTo
    {
        return $this->belongsTo(AdmissionFeeInvoice::class, 'admission_fee_invoice_id', 'id');
    }
}
