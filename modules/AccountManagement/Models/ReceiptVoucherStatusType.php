<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class ReceiptVoucherStatusType extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'receipt_voucher_status_type';

    protected $fillable = [
        'name',
        'sequential_order',
        'created_by',
        'updated_by'
    ];

    public $timestamps = true;

    // relations

    public function receipt_voucher_list(): HasMany
    {
        return $this->hasMany(ReceiptVoucher::class, 'receipt_voucher_status_type_id', 'id');
    }


    // factory
    // protected static function newFactory(): ReceiptVoucherStatusFactory
    // {
    //     return new ReceiptVoucherStatusFactory();
    // }
}
