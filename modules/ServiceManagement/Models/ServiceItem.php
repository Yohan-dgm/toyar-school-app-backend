<?php

namespace Modules\ServiceManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Modules\GeneralEntityManagement\Models\Unit;

class ServiceItem extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'service_item';

    protected $fillable = [
        'name',
        'service_item_type_id',
        'service_item_category_id',
        'unit_id',
        'reorder_level',
        'is_expirable',
        //
        'serial_number_prefix',
        'serial_number_digits',
        'serial_number_current_year',
        'serial_number_suffix',
        'serial_number',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function service_item_type(): BelongsTo
    {
        return $this->belongsTo(ServiceItemType::class, 'service_item_type_id', 'id');
    }

    public function service_item_category(): BelongsTo
    {
        return $this->belongsTo(ServiceItemCategory::class, 'service_item_category_id', 'id');
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }
}
