<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class RequestDeleteReceiptVoucher extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'request_delete_receipt_voucher';

    protected $fillable = [
        //user
        'delete_reason',
        'receipt_voucher_id',
        'requested_by',
        'requested_date',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function receipt_voucher(): BelongsTo
    {
        return $this->belongsTo(ReceiptVoucher::class, 'receipt_voucher_id', 'id');
    }
}
