<?php

namespace Modules\GeneralEntityManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Modules\InventoryManagement\Models\MaterialItem;

class Unit extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'unit';

    protected $fillable = [
        'name',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function material_item_list(): HasMany
    {
        return $this->hasMany(MaterialItem::class, 'unit_id', 'id');
    }
}
