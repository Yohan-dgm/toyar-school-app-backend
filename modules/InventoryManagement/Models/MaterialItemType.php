<?php

namespace Modules\InventoryManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class MaterialItemType extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'material_item_type';

    protected $fillable = [
        'name',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function material_item_category_list(): HasMany
    {
        return $this->hasMany(MaterialItemCategory::class, 'material_item_type_id', 'id');
    }

    public function material_item_list(): HasMany
    {
        return $this->hasMany(MaterialItem::class, 'material_item_type_id', 'id');
    }
}
