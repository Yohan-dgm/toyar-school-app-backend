<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class ItemRateStatusType extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'item_rate_status_type';

    protected $fillable = [
        'name',
        'sequential_order',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations

    public function item_rate_list(): HasMany
    {
        return $this->hasMany(ItemRate::class, 'item_rate_status_type_id', 'id');
    }
}
