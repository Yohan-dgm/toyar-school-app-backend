<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class BankAccount extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'bank_account';

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
        return $this->hasMany(ReceiptVoucher::class, 'bank_account_id', 'id');
    }
    // factory
    // protected static function newFactory(): BankAccountFactory
    // {
    //     return new BankAccountFactory();
    // }
}
