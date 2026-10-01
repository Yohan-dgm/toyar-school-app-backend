<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class CashDepositItem extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'cash_deposit_item';

    protected $fillable = [
        //user
        'cash_deposit_id',
        'receipt_voucher_id',
        'amount',

        //system
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function cash_deposit(): BelongsTo
    {
        return $this->belongsTo(CashDeposit::class, 'cash_deposit_id', 'id');
    }

    public function receipt_voucher(): BelongsTo
    {
        return $this->belongsTo(ReceiptVoucher::class, 'receipt_voucher_id', 'id');
    }
}
