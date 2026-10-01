<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class ExpenseCategory extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'expense_category';

    protected $fillable = [
        'expense_type_id',
        'name',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function expense_type(): BelongsTo
    {
        return $this->belongsTo(ExpenseType::class, 'expense_type_id', 'id');
    }

    public function expense_note_list(): HasMany
    {
        return $this->hasMany(ExpenseNote::class, 'expense_category_id', 'id');
    }
}
