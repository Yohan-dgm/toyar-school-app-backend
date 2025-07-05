<?php

namespace Modules\GeneralEntityManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\GeneralEntityManagement\Models\Employee;
use Modules\PurchasingManagement\Models\Supplier;

class Religion extends Model
{
    use HasFactory;

    protected $table = 'religion';

    protected $fillable = [
        'name',
        'short_code',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    public function supplier_list(): HasMany
    {
        return $this->hasMany(Supplier::class, 'religion_id', 'id');
    }
}
