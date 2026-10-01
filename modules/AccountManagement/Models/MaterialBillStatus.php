<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class MaterialBillStatus extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'material_bill_status';

    protected $fillable = [
        'material_bill_id',
        'material_bill_status_type_id',
        'notes',
        'status_changed_by_id',
        'is_active',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations

    public function material_bill_list(): HasMany
    {
        return $this->hasMany(MaterialBill::class, 'material_bill_status_type_id', 'id');
    }
}
