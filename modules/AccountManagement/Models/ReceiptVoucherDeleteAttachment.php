<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class ReceiptVoucherDeleteAttachment extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'receipt_voucher_attachment';

    protected $fillable = [
        'receipt_voucher_id',
        'file_name',
        'original_file_name',
        'mime_type',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function receipt_voucher(): BelongsTo
    {
        return $this->belongsTo(ReceiptVoucher::class, 'receipt_voucher_id', 'id');
    }
    // factory
    // protected static function newFactory(): BankAccountFactory
    // {
    //     return new BankAccountFactory();
    // }
}
