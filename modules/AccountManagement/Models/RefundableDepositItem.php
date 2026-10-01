<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class RefundableDepositItem extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'refundable_deposit_item';

    protected $fillable = [
        'refundable_deposit_id',
        'school_fee_id',
        'description',
        'is_refundable_deposit_item_complete',
        'item_total',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations

    public function refundable_deposit(): BelongsTo
    {
        return $this->belongsTo(RefundableDeposit::class, 'refundable_deposit_id', 'id');
    }
}
