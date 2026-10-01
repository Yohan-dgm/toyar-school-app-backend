<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class IncomeNote extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'income_note';

    protected $fillable = [
        'date',
        'income_party_id',
        'general_income_party_info',
        'income_type_id',
        'income_category_id',
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
        'serial_number',
        'is_income_note_complete',
        'income_note_status_id',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function income_party(): BelongsTo
    {
        return $this->belongsTo(IncomeParty::class, 'income_party_id', 'id');
    }

    public function income_type(): BelongsTo
    {
        return $this->belongsTo(IncomeType::class, 'income_type_id', 'id');
    }

    public function income_category(): BelongsTo
    {
        return $this->belongsTo(IncomeCategory::class, 'income_category_id', 'id');
    }
}
