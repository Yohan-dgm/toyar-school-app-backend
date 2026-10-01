<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class ExpenseNote extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'expense_note';

    protected $fillable = [
        'date',
        'expense_party_id',
        'general_expense_party_info',
        'expense_type_id',
        'expense_category_id',
        'amount',
        'office_notes',
        //
        'serial_number_prefix',
        'serial_number_digits',
        'serial_number_current_year',
        'serial_number_financial_year',
        'serial_number_suffix',
        'serial_number',
        //
        'is_active',
        'serial_number',
        'is_expense_note_complete',
        'expense_note_status_id',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function expense_party(): BelongsTo
    {
        return $this->belongsTo(ExpenseParty::class, 'expense_party_id', 'id');
    }

    public function expense_type(): BelongsTo
    {
        return $this->belongsTo(ExpenseType::class, 'expense_type_id', 'id');
    }

    public function expense_category(): BelongsTo
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id', 'id');
    }

    public function payment_voucher_list(): HasMany
    {
        return $this->hasMany(PaymentVoucher::class, 'expense_note_id', 'id');
    }
}
