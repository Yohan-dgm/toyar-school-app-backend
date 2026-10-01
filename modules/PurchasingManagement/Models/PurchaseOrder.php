<?php

namespace Modules\PurchasingManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Modules\AccountManagement\Models\PaymentVoucher;
use Modules\AccountManagement\Models\SupplierBill;
use Modules\InventoryManagement\Models\GoodsReceivedNote;

class PurchaseOrder extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'purchase_order';

    protected $fillable = [
        'date',
        'supplier_id',
        'general_supplier_info',
        'order_notes',
        'office_notes',

        //
        'serial_number_prefix',
        'serial_number_digits',
        'serial_number_current_year',
        'serial_number_financial_year',
        'serial_number_suffix',
        'serial_number',
        'is_purchase_order_complete',
        'purchase_order_status_id',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function purchase_order_status(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrderStatus::class, 'purchase_order_id', 'id');
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function purchase_order_item_list(): HasMany
    {
        return $this->hasMany(PurchaseOrderItem::class, 'purchase_order_id', 'id');
    }

    public function goods_received_note_list(): HasMany
    {
        return $this->hasMany(GoodsReceivedNote::class, 'purchase_order_id', 'id');
    }

    public function services_received_note_list(): HasMany
    {
        return $this->hasMany(ServicesReceivedNote::class, 'purchase_order_id', 'id');
    }

    public function supplier_bill_list(): HasMany
    {
        return $this->hasMany(SupplierBill::class, 'purchase_order_id', 'id');
    }

    public function payment_voucher_list(): HasMany
    {
        return $this->hasMany(PaymentVoucher::class, 'purchase_order_id', 'id');
    }
}
