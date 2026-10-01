<?php

namespace Modules\ServiceManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class ServiceItemType extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'service_item_type';

    protected $fillable = [
        'name',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function service_item_category_list(): HasMany
    {
        return $this->hasMany(ServiceItemCategory::class, 'service_item_type_id', 'id');
    }

    public function service_item_list(): HasMany
    {
        return $this->hasMany(ServiceItem::class, 'service_item_type_id', 'id');
    }
}
