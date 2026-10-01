<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class BankStatement extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'bank_statement';

    protected $fillable = [
        'id',
        'bank_account_id',
        'transaction_date',
        'transaction_type', //Deposit, Withdrawal
        'amount',
        'transaction_reference_number',
        'transaction_details',
        'running_balance',
        'is_reconciled',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations

    public function bank_account(): BelongsTo
    {
        return $this->belongsTo(BankAccount::class, 'bank_account_id', 'id');
    }
}
