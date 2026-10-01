<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class ExpenseType extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'expense_type';

    protected $fillable = [
        'name',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function expense_category_list(): HasMany
    {
        return $this->hasMany(ExpenseCategory::class, 'expense_type_id', 'id');
    }

    public function expense_note_list(): HasMany
    {
        return $this->hasMany(ExpenseNote::class, 'expense_type_id', 'id');
    }
}
