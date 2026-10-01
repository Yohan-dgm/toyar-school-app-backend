<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;

class BankReconcile extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'bank_reconciliation';

    protected $fillable = [
        'id',
        'bank_statement_id',
        'reconciled_date',
        'amount',
        'naration',
        'bank_account_id',
        'transaction_type', //Deposit, Withdrawal
        'reconciled_by',
        'running_balance',
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

    public function receipt_voucher_list(): BelongsToMany
    {
        return $this->belongsToMany(ReceiptVoucher::class, 'bank_reconciliation_receipt_voucher_pivot', 'bank_reconciliation_id', 'receipt_voucher_id');
    }

    public function payment_voucher_list(): BelongsToMany
    {
        return $this->belongsToMany(PaymentVoucher::class, 'bank_reconciliation_payment_voucher_pivot', 'bank_reconciliation_id', 'payment_voucher_id');
    }
}
