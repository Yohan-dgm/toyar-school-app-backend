<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Modules\PurchasingManagement\Models\PurchaseOrder;

class SupplierBill extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'supplier_bill';

    protected $fillable = [
        'purchase_order_id',
        'date',
        'bill_reference_number',
        'items_total',
        'transport_charges_total',
        'service_charges_total',
        'subtotal_before_discount',
        'discount_total',
        'subtotal_after_discount',
        'tax_total',
        'bill_total',
        'office_notes',
        //
        'serial_number_prefix',
        'serial_number_digits',
        'serial_number_current_year',
        'serial_number_financial_year',
        'serial_number_suffix',
        'serial_number',
        //
        'is_supplier_bill_complete',
        'supplier_bill_status_id',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function purchase_order(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id', 'id');
    }

    public function supplier_bill_item_list(): HasMany
    {
        return $this->hasMany(SupplierBillItem::class, 'supplier_bill_id', 'id');
    }

    public function supplier_bill_attachment_list(): HasMany
    {
        return $this->hasMany(SupplierBillAttachment::class, 'supplier_bill_id', 'id');
    }

    public function supplier_bill_status(): BelongsTo
    {
        return $this->belongsTo(SupplierBillStatus::class, 'supplier_bill_status_id', 'id');
    }
}
