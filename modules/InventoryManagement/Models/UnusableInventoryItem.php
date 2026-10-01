<?php

namespace Modules\InventoryManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UnusableInventoryItem extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'unusable_inventory_item';

    protected $fillable = [
        'inventory_item_id',
        'unusable_quantity',
        'unusable_reason',
        'unusable_marked_date',
        'unusable_marked_by',
        'unusable_inventory_item_status_type_id',

        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations

}
