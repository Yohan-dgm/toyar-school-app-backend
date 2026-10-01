<?php

namespace Modules\PurchasingManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class PurchaseOrderStatusType extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'purchase_order_status_type';

    protected $fillable = [
        'name',
        'sequential_order',
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
