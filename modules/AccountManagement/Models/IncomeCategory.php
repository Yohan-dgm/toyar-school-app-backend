<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class IncomeCategory extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'income_category';

    protected $fillable = [
        'income_type_id',
        'name',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function income_type(): BelongsTo
    {
        return $this->belongsTo(IncomeType::class, 'income_type_id', 'id');
    }

    public function income_note_list(): HasMany
    {
        return $this->hasMany(IncomeNote::class, 'income_category_id', 'id');
    }
}
