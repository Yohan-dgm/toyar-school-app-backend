<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class SupplierBillStatusType extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'supplier_bill_status_type';

    protected $fillable = [
        'name',
        'sequential_order',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations

    public function supplier_bill_list(): HasMany
    {
        return $this->hasMany(SupplierBill::class, 'supplier_bill_status_type_id', 'id');
    }
}
