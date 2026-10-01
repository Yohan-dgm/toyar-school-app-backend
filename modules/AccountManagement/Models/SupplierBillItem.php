<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Modules\PurchasingManagement\Models\PurchaseOrderItem;

class SupplierBillItem extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'supplier_bill_item';

    protected $fillable = [
        'supplier_bill_id',
        'item_type',
        'purchase_order_id',
        'purchase_order_item_id',
        'ordered_quantity',
        'item_unit',
        'unit_price',
        'billed_quantity',
        'item_total',
        'is_supplier_bill_item_complete',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function supplier_bill(): BelongsTo
    {
        return $this->belongsTo(SupplierBill::class, 'supplier_bill_id', 'id');
    }

    public function purchase_order_item(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrderItem::class, 'purchase_order_item_id', 'id');
    }
}
