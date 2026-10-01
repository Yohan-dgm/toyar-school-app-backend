<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class CashDepositSlipAttachment extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'cash_deposit_slip_attachment';

    protected $fillable = [
        'cash_deposit_id',
        'file_name',
        'original_file_name',
        'mime_type',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function cash_deposit(): BelongsTo
    {
        return $this->belongsTo(CashDeposit::class, 'cash_deposit_id', 'id');
    }
}
