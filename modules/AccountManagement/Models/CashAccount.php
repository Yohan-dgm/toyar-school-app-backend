<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class CashAccount extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'cash_account';

    protected $fillable = [
        'name',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function receipt_voucher_list(): HasMany
    {
        return $this->hasMany(ReceiptVoucher::class, 'cash_account_id', 'id');
    }
    // factory
    // protected static function newFactory(): CashAccountFactory
    // {
    //     return new CashAccountFactory();
    // }
}
