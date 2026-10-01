<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class CashDeposit extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'cash_deposit';

    protected $fillable = [
        //user
        'bank_account_id',
        'cash_deposit_date',
        'total_amount',
        'received_by',
        'is_attached',

        //system
        'serial_number_prefix',
        'serial_number_digits',
        'serial_number_current_year',
        'serial_number_financial_year',
        'serial_number_suffix',
        'serial_number',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function bank_account(): BelongsTo
    {
        return $this->belongsTo(BankAccount::class, 'bank_account_id', 'id');
    }

    public function receipt_voucher(): HasMany
    {
        return $this->hasMany(CashDepositItem::class, 'cash_deposit_id', 'id');
    }

    public function cash_deposit_slip_attachment_list(): HasMany
    {
        return $this->hasMany(CashDepositSlipAttachment::class, 'cash_deposit_id', 'id');
    }
}
