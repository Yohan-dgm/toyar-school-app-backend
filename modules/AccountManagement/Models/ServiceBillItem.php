<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Modules\ServiceManagement\Models\ServiceItem;

class ServiceBillItem extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'service_bill_item';

    protected $fillable = [
        'service_item_id',
        'service_bill_id',
        'description',
        'quantity',
        'rate_id',
        'rate',
        'subtotal',
        'total',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations

    public function service_bill(): BelongsTo
    {
        return $this->belongsTo(ServiceBill::class, 'service_bill_id', 'id');
    }

    public function service_item(): BelongsTo
    {
        return $this->belongsTo(ServiceItem::class, 'service_item_id', 'id');
    }
}
