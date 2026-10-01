<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class IncomeType extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'income_type';

    protected $fillable = [
        'name',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function income_category_list(): HasMany
    {
        return $this->hasMany(IncomeCategory::class, 'income_type_id', 'id');
    }

    public function income_note_list(): HasMany
    {
        return $this->hasMany(IncomeNote::class, 'income_type_id', 'id');
    }
}
