<?php

namespace Modules\PurchasingManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Modules\GeneralEntityManagement\Models\Country;
use Modules\GeneralEntityManagement\Models\PersonTitle;

class Supplier extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'supplier';

    protected $fillable = [

        'name',
        'supplier_type',
        'person_title_id',
        'phone',
        'email',
        'full_address',
        'country_id',

        //
        'name_with_title',
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
    public function person_title(): BelongsTo
    {
        return $this->belongsTo(PersonTitle::class, 'person_title_id', 'id');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function purchase_order_list(): HasMany
    {
        return $this->hasMany(PurchaseOrder::class, 'supplier_id', 'id');
    }
}
