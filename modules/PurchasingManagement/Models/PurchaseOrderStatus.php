<?php

namespace Modules\PurchasingManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class PurchaseOrderStatus extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'purchase_order_status';

    protected $fillable = [
        'purchase_order_id',
        'purchase_order_status_type_id',
        'notes',
        'status_changed_by_id',
        'is_active',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations

    public function purchase_order_list(): HasMany
    {
        return $this->hasMany(PurchaseOrder::class, 'purchase_order_status_type_id', 'id');
    }
}
