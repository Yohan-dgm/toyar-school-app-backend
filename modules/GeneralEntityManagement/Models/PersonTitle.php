<?php

namespace Modules\GeneralEntityManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\GeneralEntityManagement\Models\Employee;
use Modules\PurchasingManagement\Models\Supplier;

class PersonTitle extends Model
{
    use HasFactory;

    protected $table = 'person_title';

    protected $fillable = [
        'name',
        'sequential_order',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relationships
    public function supplier_list(): HasMany
    {
        return $this->hasMany(Supplier::class, 'person_title_id', 'id');
    }
}
