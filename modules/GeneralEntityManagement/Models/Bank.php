<?php

namespace Modules\GeneralEntityManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Modules\AccountManagement\Models\ReceiptVoucher;

class Bank extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'bank';

    protected $fillable = [
        'name',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function receipt_voucher_list_for_check_bank(): HasMany
    {
        return $this->hasMany(ReceiptVoucher::class, 'check_bank_id', 'id');
    }

    // factory
    // protected static function newFactory(): BankFactory
    // {
    //     return new BankFactory();
    // }
}
